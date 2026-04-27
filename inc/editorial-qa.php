<?php
/**
 * Rolling Reno editorial QA gate.
 *
 * Allows production drafting, but prevents posts from going live until the
 * minimum launch checklist is complete.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const RR_EDITORIAL_QA_META = '_rr_editorial_qa';
const RR_EDITORIAL_QA_NOTICE_TRANSIENT = 'rr_editorial_qa_blocked_notice_';

/**
 * Editorial QA checklist fields.
 *
 * @return array<string, string>
 */
function rr_editorial_qa_fields() {
    return array(
        'qa_passed'            => __( 'Content QA passed — accuracy, formatting, links, disclosure, and mobile preview checked.', 'rolling-reno' ),
        'affiliate_considered' => __( 'Affiliate links were included where relevant, or marked not applicable for this post.', 'rolling-reno' ),
        'internal_considered'  => __( 'Relevant internal links to existing Rolling Reno posts/hubs were added, or marked not applicable.', 'rolling-reno' ),
    );
}

/**
 * Register the editorial QA post meta.
 */
function rr_register_editorial_qa_meta() {
    register_post_meta(
        'post',
        RR_EDITORIAL_QA_META,
        array(
            'type'              => 'object',
            'single'            => true,
            'show_in_rest'      => array(
                'schema' => array(
                    'type'                 => 'object',
                    'properties'           => array(
                        'qa_passed'            => array( 'type' => 'boolean' ),
                        'affiliate_considered' => array( 'type' => 'boolean' ),
                        'internal_considered'  => array( 'type' => 'boolean' ),
                    ),
                    'additionalProperties' => false,
                ),
            ),
            'sanitize_callback' => 'rr_sanitize_editorial_qa_meta',
            'auth_callback'     => static function() {
                return current_user_can( 'edit_posts' );
            },
            'default'           => array(),
        )
    );
}
add_action( 'init', 'rr_register_editorial_qa_meta' );

/**
 * Sanitize QA meta.
 *
 * @param mixed $value Raw meta value.
 * @return array<string, bool>
 */
function rr_sanitize_editorial_qa_meta( $value ) {
    $value = is_array( $value ) ? $value : array();
    $clean = array();

    foreach ( array_keys( rr_editorial_qa_fields() ) as $key ) {
        $clean[ $key ] = ! empty( $value[ $key ] );
    }

    return $clean;
}

/**
 * Add the editorial QA meta box.
 */
function rr_add_editorial_qa_metabox() {
    add_meta_box(
        'rr-editorial-qa',
        __( 'Rolling Reno Publishing QA', 'rolling-reno' ),
        'rr_render_editorial_qa_metabox',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rr_add_editorial_qa_metabox' );

/**
 * Render the editorial QA meta box.
 *
 * @param WP_Post $post Post object.
 */
function rr_render_editorial_qa_metabox( $post ) {
    wp_nonce_field( 'rr_editorial_qa_save', 'rr_editorial_qa_nonce' );

    $meta = rr_get_editorial_qa_meta( $post->ID );
    ?>
    <p><strong><?php esc_html_e( 'Required before publish:', 'rolling-reno' ); ?></strong></p>
    <ul style="margin-left: 1em; list-style: disc;">
        <li><?php esc_html_e( 'Featured image set', 'rolling-reno' ); ?></li>
        <li><?php esc_html_e( 'Content QA passed', 'rolling-reno' ); ?></li>
        <li><?php esc_html_e( 'Affiliate links considered', 'rolling-reno' ); ?></li>
        <li><?php esc_html_e( 'Internal links considered', 'rolling-reno' ); ?></li>
    </ul>
    <?php foreach ( rr_editorial_qa_fields() as $key => $label ) : ?>
        <p>
            <label>
                <input type="checkbox" name="rr_editorial_qa[<?php echo esc_attr( $key ); ?>]" value="1" <?php checked( ! empty( $meta[ $key ] ) ); ?>>
                <?php echo esc_html( $label ); ?>
            </label>
        </p>
    <?php endforeach; ?>
    <p style="color:#8a6d3b;">
        <?php esc_html_e( 'If any item is incomplete, keep the post as Draft. Attempts to publish without the gate complete are automatically returned to Draft.', 'rolling-reno' ); ?>
    </p>
    <?php
}

/**
 * Get editorial QA meta with defaults.
 *
 * @param int $post_id Post ID.
 * @return array<string, bool>
 */
function rr_get_editorial_qa_meta( $post_id ) {
    $saved = get_post_meta( $post_id, RR_EDITORIAL_QA_META, true );
    $saved = is_array( $saved ) ? $saved : array();
    $meta  = array();

    foreach ( array_keys( rr_editorial_qa_fields() ) as $key ) {
        $meta[ $key ] = ! empty( $saved[ $key ] );
    }

    return $meta;
}

/**
 * Save editorial QA fields from the classic editor/meta box.
 *
 * @param int $post_id Post ID.
 */
function rr_save_editorial_qa_metabox( $post_id ) {
    if ( ! isset( $_POST['rr_editorial_qa_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rr_editorial_qa_nonce'] ) ), 'rr_editorial_qa_save' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $raw = isset( $_POST['rr_editorial_qa'] ) && is_array( $_POST['rr_editorial_qa'] )
        ? wp_unslash( $_POST['rr_editorial_qa'] )
        : array();

    update_post_meta( $post_id, RR_EDITORIAL_QA_META, rr_sanitize_editorial_qa_meta( $raw ) );
}
add_action( 'save_post_post', 'rr_save_editorial_qa_metabox' );

/**
 * Determine whether a post has, or is being saved with, a featured image.
 *
 * @param int   $post_id Post ID.
 * @param array $postarr Raw post array passed to wp_insert_post().
 * @return bool
 */
function rr_post_has_featured_image_for_gate( $post_id, $postarr ) {
    if ( ! empty( $postarr['_thumbnail_id'] ) && intval( $postarr['_thumbnail_id'] ) > 0 ) {
        return true;
    }

    if ( ! empty( $postarr['featured_media'] ) && intval( $postarr['featured_media'] ) > 0 ) {
        return true;
    }

    if ( isset( $_POST['_thumbnail_id'] ) && intval( $_POST['_thumbnail_id'] ) > 0 ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        return true;
    }

    return $post_id > 0 && has_post_thumbnail( $post_id );
}


/**
 * Resolve current and submitted editorial QA meta for the publish gate.
 *
 * @param int   $post_id Post ID.
 * @param array $postarr Raw post array passed to wp_insert_post().
 * @return array<string, bool>
 */
function rr_editorial_qa_meta_for_gate( $post_id, $postarr = array() ) {
    $meta = rr_get_editorial_qa_meta( $post_id );

    if ( isset( $postarr['meta_input'][ RR_EDITORIAL_QA_META ] ) && is_array( $postarr['meta_input'][ RR_EDITORIAL_QA_META ] ) ) {
        $meta = array_merge( $meta, rr_sanitize_editorial_qa_meta( $postarr['meta_input'][ RR_EDITORIAL_QA_META ] ) );
    }

    if ( isset( $_POST['rr_editorial_qa'] ) && is_array( $_POST['rr_editorial_qa'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $meta = array_merge( $meta, rr_sanitize_editorial_qa_meta( wp_unslash( $_POST['rr_editorial_qa'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
    }

    return $meta;
}

/**
 * Build a list of publishing blockers for a post.
 *
 * @param int   $post_id Post ID.
 * @param array $postarr Raw post array passed to wp_insert_post().
 * @return string[]
 */
function rr_editorial_qa_publish_blockers( $post_id, $postarr = array() ) {
    $blockers = array();

    if ( ! rr_post_has_featured_image_for_gate( $post_id, $postarr ) ) {
        $blockers[] = __( 'Featured image is required before publish.', 'rolling-reno' );
    }

    $meta = rr_editorial_qa_meta_for_gate( $post_id, $postarr );
    foreach ( rr_editorial_qa_fields() as $key => $label ) {
        if ( empty( $meta[ $key ] ) ) {
            $blockers[] = $label;
        }
    }

    return $blockers;
}

/**
 * Force posts back to draft if they are missing launch QA requirements.
 *
 * @param array $data    Sanitized post data.
 * @param array $postarr Raw post data.
 * @return array
 */
function rr_enforce_editorial_qa_before_publish( $data, $postarr ) {
    if ( 'post' !== ( $data['post_type'] ?? '' ) ) {
        return $data;
    }

    if ( ! in_array( $data['post_status'] ?? '', array( 'publish', 'future' ), true ) ) {
        return $data;
    }

    $post_id  = isset( $postarr['ID'] ) ? absint( $postarr['ID'] ) : 0;
    $blockers = rr_editorial_qa_publish_blockers( $post_id, $postarr );

    if ( empty( $blockers ) ) {
        return $data;
    }

    $data['post_status'] = 'draft';
    rr_store_editorial_qa_notice( $post_id, $blockers );

    return $data;
}
add_filter( 'wp_insert_post_data', 'rr_enforce_editorial_qa_before_publish', 20, 2 );

/**
 * Store an admin notice when a publish attempt is blocked.
 *
 * @param int      $post_id  Post ID.
 * @param string[] $blockers Blocker messages.
 */
function rr_store_editorial_qa_notice( $post_id, $blockers ) {
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return;
    }

    set_transient(
        RR_EDITORIAL_QA_NOTICE_TRANSIENT . $user_id,
        array(
            'post_id'  => $post_id,
            'blockers' => array_values( $blockers ),
        ),
        MINUTE_IN_SECONDS * 5
    );
}

/**
 * Display publish-blocked admin notices.
 */
function rr_editorial_qa_admin_notice() {
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        return;
    }

    $key    = RR_EDITORIAL_QA_NOTICE_TRANSIENT . $user_id;
    $notice = get_transient( $key );
    if ( empty( $notice['blockers'] ) || ! is_array( $notice['blockers'] ) ) {
        return;
    }

    delete_transient( $key );
    ?>
    <div class="notice notice-error is-dismissible">
        <p><strong><?php esc_html_e( 'Rolling Reno post kept as Draft — publishing QA is incomplete.', 'rolling-reno' ); ?></strong></p>
        <ul style="margin-left: 1em; list-style: disc;">
            <?php foreach ( $notice['blockers'] as $blocker ) : ?>
                <li><?php echo esc_html( $blocker ); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}
add_action( 'admin_notices', 'rr_editorial_qa_admin_notice' );
