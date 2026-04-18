<?php
/**
 * Rolling Reno v2 — template-parts/author-bio.php
 * Mara Collins author bio block (hardcoded for now; swap to ACF/meta when available)
 */

$avatar_url = get_theme_mod( 'rr_mara_avatar', '' );
?>

<div class="author-bio">

    <?php if ( $avatar_url ) : ?>
        <img
            class="author-bio__avatar"
            src="<?php echo esc_url( $avatar_url ); ?>"
            alt="<?php esc_attr_e( 'Mara Collins — van life blogger and DIY converter', 'rolling-reno' ); ?>"
            width="96"
            height="96"
            loading="lazy"
        >
    <?php else : ?>
        <img
            class="author-bio__avatar"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/mara-avatar.png"
            alt="<?php esc_attr_e( 'Mara Collins — van life blogger and DIY converter', 'rolling-reno' ); ?>"
            width="96"
            height="96"
            loading="lazy"
        >
    <?php endif; ?>

    <div class="author-bio__content">
        <p class="author-bio__name">Mara Collins</p>
        <p class="author-bio__tagline label-text">
            <?php esc_html_e( 'Van Life · DIY Conversions · Ireland', 'rolling-reno' ); ?>
        </p>
        <p class="author-bio__desc">
            <?php esc_html_e( 'Irish van lifer, three-time converter, and the person who will save you €2,000 in beginner mistakes. Writing from wherever the road took me last.', 'rolling-reno' ); ?>
        </p>
        <div class="author-bio__links">
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="author-bio__link">
                <?php esc_html_e( 'More about Mara →', 'rolling-reno' ); ?>
            </a>
            <a href="https://instagram.com/maracollins" class="author-bio__link" rel="noopener noreferrer" target="_blank">
                @maracollins
            </a>
        </div>
    </div>

</div>
