<?php
/**
 * Rolling Reno v2 — functions.php
 * Theme setup, enqueue, menus, widget areas, theme support
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RR_VERSION', '2.0.1' );
define( 'RR_THEME_DIR', get_template_directory() );
define( 'RR_THEME_URI', get_template_directory_uri() );

// ─── Theme Setup ────────────────────────────────────────────────────────────

function rr_setup() {
    load_theme_textdomain( 'rolling-reno', RR_THEME_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery',
    ) );

    // Editor colour palette matching design-system-v2
    add_theme_support( 'editor-color-palette', array(
        array( 'name' => 'Forest',      'slug' => 'forest',      'color' => '#3D5A47' ),
        array( 'name' => 'Terracotta',  'slug' => 'terracotta',  'color' => '#C4714A' ),
        array( 'name' => 'Sand',        'slug' => 'sand',        'color' => '#E8DFD0' ),
        array( 'name' => 'Near Black',  'slug' => 'near-black',  'color' => '#1C1C1A' ),
        array( 'name' => 'Warm White',  'slug' => 'warm-white',  'color' => '#FAFAF8' ),
        array( 'name' => 'Warm Grey',   'slug' => 'warm-grey',   'color' => '#8C8984' ),
    ) );

    add_theme_support( 'editor-font-sizes', array(
        array( 'name' => 'Small',   'shortName' => 'S',  'size' => 14, 'slug' => 'small' ),
        array( 'name' => 'Regular', 'shortName' => 'M',  'size' => 18, 'slug' => 'regular' ),
        array( 'name' => 'Large',   'shortName' => 'L',  'size' => 24, 'slug' => 'large' ),
        array( 'name' => 'Huge',    'shortName' => 'XL', 'size' => 36, 'slug' => 'huge' ),
    ) );

    // Wide + full alignment support for blocks
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );

    // Register nav menus
    register_nav_menus( array(
        'primary'  => __( 'Primary Navigation', 'rolling-reno' ),
        'footer'   => __( 'Footer Navigation',  'rolling-reno' ),
        'footer-2' => __( 'Footer Explore',     'rolling-reno' ),
        'footer-3' => __( 'Footer Connect',     'rolling-reno' ),
        'footer-4' => __( 'Footer Resources',   'rolling-reno' ),
    ) );

    // Content width
    if ( ! isset( $content_width ) ) {
        $content_width = 760;
    }
}
add_action( 'after_setup_theme', 'rr_setup' );

// ─── Widget Areas ────────────────────────────────────────────────────────────

function rr_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'rolling-reno' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Optional sidebar (v2 theme is sidebar-free by default).', 'rolling-reno' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Widget Area', 'rolling-reno' ),
        'id'            => 'footer-1',
        'description'   => __( 'Footer widget area.', 'rolling-reno' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'rr_widgets_init' );

// ─── Enqueue Scripts & Styles ────────────────────────────────────────────────

function rr_scripts() {
    // Google Fonts (preconnect in header.php; this covers stylesheet)
    wp_enqueue_style(
        'rr-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400&display=swap',
        array(),
        null
    );

    // Design system (typography, colors, spacing)
    wp_enqueue_style(
        'rr-design-system',
        RR_THEME_URI . '/assets/css/design-system.css',
        array( 'rr-google-fonts' ),
        RR_VERSION
    );

    // Main stylesheet (layout, components, responsive)
    wp_enqueue_style(
        'rr-main',
        RR_THEME_URI . '/assets/css/main.css',
        array( 'rr-design-system' ),
        RR_VERSION
    );

    // Theme stylesheet (WordPress requirement + overrides)
    wp_enqueue_style(
        'rr-theme',
        get_stylesheet_uri(),
        array( 'rr-main' ),
        RR_VERSION
    );

    wp_enqueue_script(
        'rolling-reno-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        RR_VERSION,
        true
    );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'rr_scripts' );



/** Redirect the legacy About duplicate to the canonical Mara About page. */
function rr_redirect_legacy_about_page() {
    if ( is_page( 'about-2' ) ) {
        wp_safe_redirect( home_url( '/about/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'rr_redirect_legacy_about_page' );

/**
 * Return the site-specific duplicate About page ID if it still exists.
 */
function rr_get_legacy_about_page_id() {
    $page = get_page_by_path( 'about-2', OBJECT, 'page' );

    return $page instanceof WP_Post ? (int) $page->ID : 0;
}

/**
 * Normalize legacy About menu items to the canonical /about/ URL.
 */
function rr_normalize_legacy_about_menu_items( $items ) {
    $legacy_urls = array(
        untrailingslashit( home_url( '/about-2' ) ),
        untrailingslashit( home_url( '/about-2/' ) ),
    );
    $canonical_url = trailingslashit( home_url( '/about' ) );
    $legacy_id     = rr_get_legacy_about_page_id();
    $about_page    = get_page_by_path( 'about', OBJECT, 'page' );
    $about_page_id = $about_page instanceof WP_Post ? (int) $about_page->ID : 0;

    foreach ( $items as $item ) {
        if ( ! isset( $item->url ) ) {
            continue;
        }

        $item_url = untrailingslashit( $item->url );
        $matches_legacy_url = in_array( $item_url, $legacy_urls, true );
        $matches_legacy_id  = $legacy_id && isset( $item->object_id ) && (int) $item->object_id === $legacy_id;

        if ( ! $matches_legacy_url && ! $matches_legacy_id ) {
            continue;
        }

        $item->url = $canonical_url;

        if ( $about_page_id ) {
            $item->object_id = $about_page_id;
        }

        if ( is_page( 'about' ) ) {
            $item->current      = true;
            $item->current_item_ancestor = false;
            $item->classes[]    = 'current-menu-item';
            $item->classes[]    = 'current_page_item';
            $item->classes      = array_values( array_unique( array_filter( $item->classes ) ) );
        }
    }

    return $items;
}
add_filter( 'wp_nav_menu_objects', 'rr_normalize_legacy_about_menu_items' );

/**
 * Keep the legacy duplicate out of the Yoast XML sitemap.
 */
function rr_exclude_legacy_about_from_sitemap( $excluded_post_ids ) {
    $legacy_id = rr_get_legacy_about_page_id();

    if ( $legacy_id ) {
        $excluded_post_ids[] = $legacy_id;
    }

    return array_values( array_unique( array_map( 'intval', $excluded_post_ids ) ) );
}
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'rr_exclude_legacy_about_from_sitemap' );

// ─── Image fallbacks ─────────────────────────────────────────────────────────

/**
 * Return a post image URL, falling back to a curated local asset by slug.
 * This prevents blank/emoji placeholders when WordPress featured media is
 * missing while still preferring real assigned featured images.
 */
function rr_get_post_image_url( $post_id = null, $size = 'full' ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $thumb   = get_the_post_thumbnail_url( $post_id, $size );
    if ( $thumb ) {
        return $thumb;
    }

    $slug = get_post_field( 'post_name', $post_id );
    $fallbacks = array(
        'full-time-rv-insurance' => 'assets/images/featured/full-time-rv-insurance.jpg',
    );

    if ( isset( $fallbacks[ $slug ] ) ) {
        return get_template_directory_uri() . '/' . $fallbacks[ $slug ];
    }

    return '';
}

// ─── Preconnect & Preload (Google Fonts, hero image) ────────────────────────

function rr_preconnect_fonts( $output, $rel, $url ) {
    if ( 'preconnect' === $rel ) {
        return $output; // handled in header.php directly
    }
    return $output;
}

function rr_head_resources() {
    // Preconnect for Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Preload hero image on homepage/front page when a custom hero image is configured.
    if ( is_front_page() ) {
        $hero_img = get_theme_mod( 'rr_hero_image', '' );
        if ( $hero_img ) {
            echo '<link rel="preload" as="image" href="' . esc_url( $hero_img ) . '">' . "\n";
        }
    }

    // Preload hero image on single posts (featured image)
    if ( is_single() ) {
        $img_src = rr_get_post_image_url( get_the_ID(), 'full' );
        if ( $img_src ) {
            echo '<link rel="preload" as="image" href="' . esc_url( $img_src ) . '">' . "\n";
        }
    }
}
add_action( 'wp_head', 'rr_head_resources', 1 );

// ─── Theme Customizer ────────────────────────────────────────────────────────

function rr_customize_register( $wp_customize ) {
    // Hero Section
    $wp_customize->add_section( 'rr_hero', array(
        'title'    => __( 'Homepage Hero', 'rolling-reno' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'rr_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rr_hero_image', array(
        'label'   => __( 'Hero Background Image', 'rolling-reno' ),
        'section' => 'rr_hero',
    ) ) );

    $wp_customize->add_setting( 'rr_hero_title', array(
        'default'           => "The open road is calling.\nI'm Mara — and I'll show\nyou how to answer it.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'rr_hero_title', array(
        'label'   => __( 'Hero Title', 'rolling-reno' ),
        'section' => 'rr_hero',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'rr_hero_sub', array(
        'default'           => 'DIY conversions, van life adventures, and gear I actually trust.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rr_hero_sub', array(
        'label'   => __( 'Hero Subheading', 'rolling-reno' ),
        'section' => 'rr_hero',
        'type'    => 'text',
    ) );

    // Mara Profile
    $wp_customize->add_section( 'rr_mara', array(
        'title'    => __( 'Mara Collins Profile', 'rolling-reno' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'rr_mara_avatar', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rr_mara_avatar', array(
        'label'   => __( 'Mara Avatar Image', 'rolling-reno' ),
        'section' => 'rr_mara',
    ) ) );

    $wp_customize->add_setting( 'rr_mara_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rr_mara_about_image', array(
        'label'   => __( 'About Teaser Image (3:4 portrait)', 'rolling-reno' ),
        'section' => 'rr_mara',
    ) ) );

    // Social Links
    $wp_customize->add_section( 'rr_social', array(
        'title'    => __( 'Social Links', 'rolling-reno' ),
        'priority' => 40,
    ) );

    foreach ( array( 'instagram', 'pinterest', 'youtube', 'tiktok' ) as $platform ) {
        $wp_customize->add_setting( 'rr_social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( 'rr_social_' . $platform, array(
            'label'   => __( ucfirst( $platform ) . ' URL', 'rolling-reno' ),
            'section' => 'rr_social',
            'type'    => 'url',
        ) );
    }

    // Instagram Feed
    $wp_customize->add_section( 'rr_instagram', array(
        'title'    => __( 'Instagram Feed', 'rolling-reno' ),
        'priority' => 42,
    ) );
    $wp_customize->add_setting( 'rr_instagram_handle', array(
        'default'           => 'maracollins',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rr_instagram_handle', array(
        'label'       => __( 'Instagram Handle', 'rolling-reno' ),
        'description' => __( 'Your Instagram username (without @).', 'rolling-reno' ),
        'section'     => 'rr_instagram',
        'type'        => 'text',
    ) );
    $wp_customize->add_setting( 'rr_lightwidget_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rr_lightwidget_id', array(
        'label'       => __( 'LightWidget Widget ID', 'rolling-reno' ),
        'description' => __( 'Paste the widget ID from lightwidget.com (used if Smash Balloon is not active).', 'rolling-reno' ),
        'section'     => 'rr_instagram',
        'type'        => 'text',
    ) );

    // Newsletter / ConvertKit
    $wp_customize->add_section( 'rr_newsletter', array(
        'title'    => __( 'Newsletter / ConvertKit', 'rolling-reno' ),
        'priority' => 45,
    ) );
    $wp_customize->add_setting( 'rr_ck_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rr_ck_api_key', array(
        'label'       => __( 'ConvertKit API Key', 'rolling-reno' ),
        'description' => __( 'From Kit dashboard → Settings → Developer API', 'rolling-reno' ),
        'section'     => 'rr_newsletter',
        'type'        => 'text',
    ) );
    $wp_customize->add_setting( 'rr_ck_form_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'rr_ck_form_id', array(
        'label'       => __( 'ConvertKit Form ID', 'rolling-reno' ),
        'description' => __( 'From Kit dashboard → Forms → (your form) → ID in URL', 'rolling-reno' ),
        'section'     => 'rr_newsletter',
        'type'        => 'text',
    ) );
    // Legacy direct-post URL (fallback if AJAX not configured)
    $wp_customize->add_setting( 'rr_newsletter_action', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'rr_newsletter_action', array(
        'label'       => __( 'Direct Form Action URL (legacy fallback)', 'rolling-reno' ),
        'description' => __( 'Leave blank to use the AJAX/ConvertKit API handler above.', 'rolling-reno' ),
        'section'     => 'rr_newsletter',
        'type'        => 'url',
    ) );
}
add_action( 'customize_register', 'rr_customize_register' );

// ─── Helper: Read Time ───────────────────────────────────────────────────────

function rr_read_time( $post_id = null ) {
    $post = get_post( $post_id );
    if ( ! $post ) return '';
    $word_count   = str_word_count( wp_strip_all_tags( $post->post_content ) );
    $reading_time = max( 1, (int) ceil( $word_count / 200 ) );
    return $reading_time . ' min read';
}

// ─── Helper: Category Badge ──────────────────────────────────────────────────

function rr_category_badge( $post_id = null ) {
    $cats = get_the_category( $post_id );
    if ( empty( $cats ) ) return '';
    $cat  = $cats[0];
    $slug = $cat->slug;
    $class = 'badge--category';
    if ( str_contains( $slug, 'van-life' ) )  $class = 'badge--van-life';
    if ( str_contains( $slug, 'rv-life' ) )   $class = 'badge--rv-life';
    if ( str_contains( $slug, 'gear' ) )       $class = 'badge--gear';
    return '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" class="badge ' . esc_attr( $class ) . '">' . esc_html( $cat->name ) . '</a>';
}

// ─── Helper: Excerpt ────────────────────────────────────────────────────────

function rr_excerpt( $post_id = null, $length = 20 ) {
    $post = get_post( $post_id );
    if ( ! $post ) return '';
    if ( $post->post_excerpt ) return wp_trim_words( $post->post_excerpt, $length );
    return wp_trim_words( strip_shortcodes( wp_strip_all_tags( $post->post_content ) ), $length );
}

// ─── Remove Emoji Scripts (perf) ────────────────────────────────────────────

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// ─── Remove Gutenberg Block CSS if not needed ────────────────────────────────

add_filter( 'should_load_separate_core_block_assets', '__return_false' );

// ─── Add defer to scripts ────────────────────────────────────────────────────

function rr_add_defer( $tag, $handle ) {
    $defer_scripts = array( 'rr-main' );
    if ( in_array( $handle, $defer_scripts ) ) {
        if ( ! str_contains( $tag, 'defer' ) ) {
            $tag = str_replace( ' src=', ' defer src=', $tag );
        }
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'rr_add_defer', 10, 2 );

// ─── Post thumbnail sizes ────────────────────────────────────────────────────

add_image_size( 'rr-hero',    1920, 1080, true );
add_image_size( 'rr-card',     800,  600, true );
add_image_size( 'rr-card-sm',  480,  360, true );
add_image_size( 'rr-portrait', 600,  900, true );
add_image_size( 'rr-wide',    1440,  540, true );

// ─── Breadcrumb helper ───────────────────────────────────────────────────────

function rr_breadcrumb() {
    echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'rolling-reno' ) . '">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'rolling-reno' ) . '</a>';

    if ( is_category() ) {
        $cat = get_queried_object();
        echo '<span class="breadcrumb__separator" aria-hidden="true">›</span>';
        echo '<span class="breadcrumb__current">' . esc_html( $cat->name ) . '</span>';
    } elseif ( is_single() ) {
        $cats = get_the_category();
        if ( $cats ) {
            $cat = $cats[0];
            echo '<span class="breadcrumb__separator" aria-hidden="true">›</span>';
            echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
        }
        echo '<span class="breadcrumb__separator" aria-hidden="true">›</span>';
        echo '<span class="breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_page() ) {
        echo '<span class="breadcrumb__separator" aria-hidden="true">›</span>';
        echo '<span class="breadcrumb__current">' . esc_html( get_the_title() ) . '</span>';
    }

    echo '</nav>';
}

// ─── Social links helper ─────────────────────────────────────────────────────

function rr_social_instagram_svg() {
    return '<svg class="site-footer__social-icon-svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="18" height="18" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor"/></svg>';
}

function rr_social_links() {
    $platforms = array(
        'instagram' => array( 'label' => 'Instagram', 'icon' => rr_social_instagram_svg() ),
        'pinterest' => array( 'label' => 'Pinterest',  'icon' => '📌' ),
        'youtube'   => array( 'label' => 'YouTube',    'icon' => '▶️' ),
        'tiktok'    => array( 'label' => 'TikTok',     'icon' => '🎵' ),
    );
    $output = '';
    foreach ( $platforms as $key => $data ) {
        $url = get_theme_mod( 'rr_social_' . $key, '' );
        if ( $url ) {
            $output .= '<a href="' . esc_url( $url ) . '" class="site-footer__social-icon" rel="noopener noreferrer" target="_blank" aria-label="' . esc_attr( sprintf( __( 'Follow Mara on %s', 'rolling-reno' ), $data['label'] ) ) . '">' . $data['icon'] . '</a>';
        }
    }
    return $output;
}

// ─── ConvertKit Integration ─────────────────────────────────────────────────

/**
 * Return the form action URL for newsletter forms.
 * Uses WP AJAX endpoint when ConvertKit API key is configured;
 * falls back to the legacy direct-post URL (customizer setting) otherwise.
 */
function rr_newsletter_action() {
    $ck_api_key = get_theme_mod( 'rr_ck_api_key', '' );
    $ck_form_id = get_theme_mod( 'rr_ck_form_id', '' );

    // If CK is configured, use the WP AJAX handler
    if ( $ck_api_key && $ck_form_id ) {
        return esc_url( admin_url( 'admin-ajax.php' ) );
    }

    // Fallback to legacy direct URL
    $legacy = get_theme_mod( 'rr_newsletter_action', '' );
    return $legacy ? esc_url( $legacy ) : '#newsletter-not-configured';
}

/**
 * Output hidden inputs needed by the AJAX newsletter handler.
 * Include this inside any newsletter <form> element.
 */
function rr_newsletter_hidden_fields() {
    $ck_api_key = get_theme_mod( 'rr_ck_api_key', '' );
    $ck_form_id = get_theme_mod( 'rr_ck_form_id', '' );
    if ( $ck_api_key && $ck_form_id ) {
        echo '<input type="hidden" name="action" value="rr_newsletter_subscribe">';
    }
}

/**
 * AJAX handler — subscribes an email to ConvertKit via API v3.
 * Handles both logged-in and non-logged-in users (nopriv).
 */
function rr_newsletter_subscribe_handler() {
    // Verify nonce
    if ( ! isset( $_POST['rr_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rr_nonce'] ) ), 'rr_newsletter' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid request.' ), 400 );
        return;
    }

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ), 400 );
        return;
    }

    $api_key = get_theme_mod( 'rr_ck_api_key', '' );
    $form_id = get_theme_mod( 'rr_ck_form_id', '' );

    if ( ! $api_key || ! $form_id ) {
        wp_send_json_error( array( 'message' => 'Newsletter not configured. Contact the site admin.' ), 500 );
        return;
    }

    // Subscribe via ConvertKit API v3
    $ck_url = "https://api.convertkit.com/v3/forms/{$form_id}/subscribe";
    $response = wp_remote_post( $ck_url, array(
        'timeout'     => 15,
        'headers'     => array( 'Content-Type' => 'application/json; charset=utf-8' ),
        'body'        => wp_json_encode( array(
            'api_key' => $api_key,
            'email'   => $email,
        ) ),
    ) );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( array( 'message' => 'Could not reach the newsletter service. Try again.' ), 502 );
        return;
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code === 200 && ! empty( $body['subscription'] ) ) {
        wp_send_json_success( array( 'message' => "You're in! Check your inbox for the starter kit." ) );
    } else {
        $msg = ! empty( $body['message'] ) ? $body['message'] : 'Subscription failed. Please try again.';
        wp_send_json_error( array( 'message' => $msg ), $code );
    }
}
add_action( 'wp_ajax_rr_newsletter_subscribe',        'rr_newsletter_subscribe_handler' );
add_action( 'wp_ajax_nopriv_rr_newsletter_subscribe', 'rr_newsletter_subscribe_handler' );

/**
 * Inline JS to turn newsletter forms into AJAX-powered forms.
 * Appended to footer when CK is configured.
 */
function rr_newsletter_js() {
    $ck_api_key = get_theme_mod( 'rr_ck_api_key', '' );
    $ck_form_id = get_theme_mod( 'rr_ck_form_id', '' );
    if ( ! $ck_api_key || ! $ck_form_id ) return;
    ?>
    <script>
    (function() {
        var forms = document.querySelectorAll('.cta-banner__form, .mid-post-optin__form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var data = new FormData(form);
                var btn  = form.querySelector('button[type=submit]');
                var orig = btn ? btn.textContent : null;
                if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

                fetch(form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: data
                })
                .then(function(r) { return r.json(); })
                .then(function(json) {
                    if (json.success) {
                        form.innerHTML = '<p class="subscribe-success" style="color:#3D5A47;font-weight:600;">' + json.data.message + '</p>';
                    } else {
                        var msg = (json.data && json.data.message) ? json.data.message : 'Something went wrong. Please try again.';
                        var err = form.querySelector('.subscribe-error');
                        if (!err) {
                            err = document.createElement('p');
                            err.className = 'subscribe-error';
                            err.style.cssText = 'color:#C4714A;margin-top:0.5rem;font-size:0.875rem;';
                            form.appendChild(err);
                        }
                        err.textContent = msg;
                        if (btn) { btn.disabled = false; btn.textContent = orig; }
                    }
                })
                .catch(function() {
                    if (btn) { btn.disabled = false; btn.textContent = orig; }
                });
            });
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'rr_newsletter_js' );




/**
 * Blog IA helpers for the lightweight hub/filter model from MJM-235/MJM-237.
 */
function rr_blog_nav_topics() {
    return array(
        array( 'label' => __( 'Start Here & Planning', 'rolling-reno' ), 'slug' => 'start-here-planning' ),
        array( 'label' => __( 'Vehicle Guides', 'rolling-reno' ), 'slug' => 'vehicle-guides' ),
        array( 'label' => __( 'Systems & Off-Grid', 'rolling-reno' ), 'slug' => 'systems-off-grid' ),
        array( 'label' => __( 'Interior Build & Layouts', 'rolling-reno' ), 'slug' => 'interior-build-layouts' ),
        array( 'label' => __( 'Van Life', 'rolling-reno' ), 'slug' => 'van-life' ),
        array( 'label' => __( 'RV Life', 'rolling-reno' ), 'slug' => 'rv-life' ),
    );
}

function rr_blog_index_url() {
    $posts_page = (int) get_option( 'page_for_posts' );
    return $posts_page ? get_permalink( $posts_page ) : home_url( '/blog/' );
}

function rr_blog_topic_term( $slug ) {
    $slug = sanitize_title( $slug );
    return $slug ? get_category_by_slug( $slug ) : false;
}

function rr_blog_topic_url( $slug ) {
    $term = rr_blog_topic_term( $slug );
    return $term ? add_query_arg( 'category', $term->slug, rr_blog_index_url() ) : '';
}

function rr_blog_active_category_slug() {
    $queried = get_queried_object();
    if ( $queried instanceof WP_Term && 'category' === $queried->taxonomy ) {
        return $queried->slug;
    }

    $category = isset( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
    return rr_blog_topic_term( $category ) ? $category : '';
}

function rr_is_blog_index_request() {
    $request_path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
    $blog_path    = (string) wp_parse_url( rr_blog_index_url(), PHP_URL_PATH );

    return untrailingslashit( $request_path ) === untrailingslashit( $blog_path );
}


function rr_blog_hub_cards() {
    return array(
        'start-here-planning' => array(
            'eyebrow' => __( 'Start here', 'rolling-reno' ),
            'text'    => __( 'Inspection, budgeting, renovation order, and first decisions before you buy materials.', 'rolling-reno' ),
        ),
        'vehicle-guides' => array(
            'eyebrow' => __( 'Choose the rig', 'rolling-reno' ),
            'text'    => __( 'Compare vans, RVs, older rigs, and buyer trade-offs before committing.', 'rolling-reno' ),
        ),
        'systems-off-grid' => array(
            'eyebrow' => __( 'Plan the systems', 'rolling-reno' ),
            'text'    => __( 'Solar, electrical, plumbing, water, heat, and ventilation explained clearly.', 'rolling-reno' ),
        ),
        'interior-build-layouts' => array(
            'eyebrow' => __( 'Build the interior', 'rolling-reno' ),
            'text'    => __( 'Layouts, storage, kitchens, beds, flooring, paint, and materials for real road use.', 'rolling-reno' ),
        ),
        'van-life' => array(
            'eyebrow' => __( 'Live in the van', 'rolling-reno' ),
            'text'    => __( 'Domicile, routines, mental load, work, and practical full-time van decisions.', 'rolling-reno' ),
        ),
        'rv-life' => array(
            'eyebrow' => __( 'Live in the RV', 'rolling-reno' ),
            'text'    => __( 'Insurance, healthcare, ownership costs, and full-time RV logistics.', 'rolling-reno' ),
        ),
    );
}

function rr_blog_archive_document_title( $title ) {
    if ( is_home() || rr_is_blog_index_request() ) {
        $title['title'] = __( 'Rolling Reno Blog: RV Renovation, Van Life & Off-Grid Guides', 'rolling-reno' );
        $title['site']  = get_bloginfo( 'name' );
    }

    return $title;
}
add_filter( 'document_title_parts', 'rr_blog_archive_document_title' );

function rr_blog_archive_meta_description() {
    if ( ! ( is_home() || rr_is_blog_index_request() ) ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr__( 'Browse Rolling Reno guides by starting point: RV renovation planning, vehicle choices, off-grid systems, interior layouts, van life, and full-time RV life.', 'rolling-reno' ) . '">' . "\n";
}
add_action( 'wp_head', 'rr_blog_archive_meta_description', 2 );

/**
 * Keep /blog/?category=<slug>&s=<term> crawlable and non-JS friendly.
 */
function rr_filter_blog_index_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ( ! $query->is_home() && ! rr_is_blog_index_request() ) ) {
        return;
    }

    if ( rr_is_blog_index_request() ) {
        $query->set( 'post_type', 'post' );
    }

    $category = isset( $_GET['category'] ) ? sanitize_title( wp_unslash( $_GET['category'] ) ) : '';
    if ( $category && rr_blog_topic_term( $category ) ) {
        $query->set( 'category_name', $category );
    }
}
add_action( 'pre_get_posts', 'rr_filter_blog_index_query' );

function rr_use_blog_template_for_blog_search( $template ) {
    if ( is_search() && rr_is_blog_index_request() ) {
        $blog_template = locate_template( 'home.php' );
        if ( $blog_template ) {
            return $blog_template;
        }
    }

    return $template;
}
add_filter( 'template_include', 'rr_use_blog_template_for_blog_search' );

/** Add a compact Blog submenu to the primary menu when editors have not added one. */
function rr_add_blog_submenu_items( $items, $args ) {
    if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $items;
    }

    $blog_item = null;
    foreach ( $items as $item ) {
        $url = isset( $item->url ) ? untrailingslashit( $item->url ) : '';
        if ( 0 === strcasecmp( $item->title, 'Blog' ) || $url === untrailingslashit( rr_blog_index_url() ) ) {
            $blog_item = $item;
            break;
        }
    }

    if ( ! $blog_item ) {
        return $items;
    }

    foreach ( $items as $item ) {
        if ( (int) $item->menu_item_parent === (int) $blog_item->ID ) {
            return $items;
        }
    }

    $next_id = -23700;
    foreach ( rr_blog_nav_topics() as $topic ) {
        $topic_url = rr_blog_topic_url( $topic['slug'] );
        if ( ! $topic_url ) {
            continue;
        }

        $child = clone $blog_item;
        $child->ID               = $next_id--;
        $child->db_id            = $child->ID;
        $child->object_id        = 0;
        $child->menu_item_parent = (string) $blog_item->ID;
        $child->title            = $topic['label'];
        $child->url              = $topic_url;
        $child->classes          = array( 'menu-item', 'menu-item-type-custom', 'rr-blog-submenu-item' );
        $items[] = $child;
    }

    $search = clone $blog_item;
    $search->ID               = $next_id--;
    $search->db_id            = $search->ID;
    $search->object_id        = 0;
    $search->menu_item_parent = (string) $blog_item->ID;
    $search->title            = __( 'Search / All Posts', 'rolling-reno' );
    $search->url              = rr_blog_index_url();
    $search->classes          = array( 'menu-item', 'menu-item-type-custom', 'rr-blog-submenu-item' );
    $items[] = $search;

    return $items;
}
add_filter( 'wp_nav_menu_objects', 'rr_add_blog_submenu_items', 20, 2 );

// ─── Nav Walkers (must be defined before header.php uses them) ───────────────

if ( ! class_exists( 'RR_Nav_Walker' ) ) :
class RR_Nav_Walker extends Walker_Nav_Menu {
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( $element && ! empty( $children_elements[ $element->ID ] ) ) {
            $element->classes[] = 'menu-item-has-children';
        }
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $is_active = in_array( 'current-menu-item', $classes, true ) || in_array( 'current-page-ancestor', $classes, true );
        $has_children = 0 === $depth && in_array( 'menu-item-has-children', $classes, true );
        $aria_current = $is_active ? ' aria-current="page"' : '';
        $url   = ! empty( $item->url ) ? $item->url : '#';
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        if ( 0 === $depth && $has_children ) {
            $output .= '<div class="site-nav__item site-nav__item--has-menu">';
        }

        $class = 0 === $depth ? 'site-nav__link' : 'site-nav__submenu-link';
        $output .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '"' . $aria_current . '>' . esc_html( $title ) . '</a>';
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $classes = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
        if ( 0 === $depth && in_array( 'menu-item-has-children', $classes, true ) ) {
            $output .= '</div>';
        }
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( 0 === $depth ) {
            $output .= '<div class="site-nav__submenu" aria-label="' . esc_attr__( 'Blog sections', 'rolling-reno' ) . '">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( 0 === $depth ) {
            $output .= '</div>';
        }
    }
}
endif;

if ( ! class_exists( 'RR_Mobile_Nav_Walker' ) ) :
class RR_Mobile_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item  = $data_object;
        $url   = ! empty( $item->url ) ? $item->url : '#';
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $class = 0 === $depth ? 'mobile-menu__link' : 'mobile-menu__link mobile-menu__link--child';
        $output .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $title ) . '</a>';
    }
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
}
endif;


function rr_primary_nav_fallback_blog_submenu() {
    echo '<div class="site-nav__item site-nav__item--has-menu">';
    echo '<a href="' . esc_url( rr_blog_index_url() ) . '" class="site-nav__link">' . esc_html__( 'Blog', 'rolling-reno' ) . '</a>';
    echo '<div class="site-nav__submenu" aria-label="' . esc_attr__( 'Blog sections', 'rolling-reno' ) . '">';
    foreach ( rr_blog_nav_topics() as $topic ) {
        $topic_url = rr_blog_topic_url( $topic['slug'] );
        if ( ! $topic_url ) {
            continue;
        }
        echo '<a href="' . esc_url( $topic_url ) . '" class="site-nav__submenu-link">' . esc_html( $topic['label'] ) . '</a>';
    }
    echo '<a href="' . esc_url( rr_blog_index_url() ) . '" class="site-nav__submenu-link">' . esc_html__( 'Search / All Posts', 'rolling-reno' ) . '</a>';
    echo '</div></div>';
}

if ( ! function_exists( 'rr_primary_nav_fallback' ) ) :
function rr_primary_nav_fallback() {
    $pages = array(
        array( 'url' => home_url('/'),           'label' => 'Home' ),
        array( 'url' => home_url('/start-here'), 'label' => 'Start Here' ),
        array( 'url' => rr_blog_index_url(),     'label' => 'Blog', 'submenu' => true ),
        array( 'url' => home_url('/van-life'),   'label' => 'Van Life' ),
        array( 'url' => home_url('/rv-life'),    'label' => 'RV Life' ),
        array( 'url' => home_url('/gear'),       'label' => 'Gear' ),
        array( 'url' => home_url('/about'),      'label' => 'About Mara' ),
    );
    foreach ( $pages as $page ) {
        if ( ! empty( $page['submenu'] ) ) {
            rr_primary_nav_fallback_blog_submenu();
            continue;
        }
        $active = ( untrailingslashit( home_url( add_query_arg( null, null ) ) ) === untrailingslashit( $page['url'] ) )
            ? ' aria-current="page"' : '';
        echo '<a href="' . esc_url( $page['url'] ) . '" class="site-nav__link"' . $active . '>' . esc_html( $page['label'] ) . '</a>';
    }
}
endif;

if ( ! function_exists( 'rr_mobile_nav_fallback' ) ) :
function rr_mobile_nav_fallback() {
    $pages = array(
        array( 'url' => home_url('/'),           'label' => 'Home' ),
        array( 'url' => home_url('/start-here'), 'label' => 'Start Here' ),
        array( 'url' => rr_blog_index_url(),     'label' => 'Blog', 'submenu' => true ),
        array( 'url' => home_url('/van-life'),   'label' => 'Van Life' ),
        array( 'url' => home_url('/rv-life'),    'label' => 'RV Life' ),
        array( 'url' => home_url('/gear'),       'label' => 'Gear' ),
        array( 'url' => home_url('/about'),      'label' => 'About Mara' ),
    );
    foreach ( $pages as $page ) {
        echo '<a href="' . esc_url( $page['url'] ) . '" class="mobile-menu__link">' . esc_html( $page['label'] ) . '</a>';
        if ( ! empty( $page['submenu'] ) ) {
            foreach ( rr_blog_nav_topics() as $topic ) {
                $topic_url = rr_blog_topic_url( $topic['slug'] );
                if ( ! $topic_url ) {
                    continue;
                }
                echo '<a href="' . esc_url( $topic_url ) . '" class="mobile-menu__link mobile-menu__link--child">' . esc_html( $topic['label'] ) . '</a>';
            }
        }
    }
}
endif;


// ═══════════════════════════════════════════════════════════════════════════
// AFFILIATE PRODUCT CARDS (MJM-137)
// Metabox for adding product recommendations + shortcode for inline embeds
// ═══════════════════════════════════════════════════════════════════════════

define( 'RR_AMAZON_ASSOCIATE_ID', 'rollingreno-20' );

/**
 * Register metabox for affiliate products on posts.
 */
function rr_affiliate_products_metabox() {
    add_meta_box(
        'rr_affiliate_products',
        __( 'Affiliate Products', 'rolling-reno' ),
        'rr_affiliate_products_callback',
        'post',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'rr_affiliate_products_metabox' );

/**
 * Render the affiliate products metabox.
 */
function rr_affiliate_products_callback( $post ) {
    wp_nonce_field( 'rr_affiliate_products_nonce', 'rr_affiliate_products_nonce_field' );
    $products = get_post_meta( $post->ID, '_rr_affiliate_products', true );
    $products = is_array( $products ) ? $products : array();
    ?>
    <div id="rr-affiliate-products-wrap">
        <p class="description"><?php esc_html_e( 'Add affiliate product recommendations for this post. These will appear after the post content.', 'rolling-reno' ); ?></p>
        
        <div id="rr-affiliate-products-list">
            <?php
            if ( ! empty( $products ) ) :
                foreach ( $products as $index => $product ) :
                    rr_affiliate_product_row( $index, $product );
                endforeach;
            endif;
            ?>
        </div>
        
        <button type="button" id="rr-add-affiliate-product" class="button">
            <?php esc_html_e( '+ Add Product', 'rolling-reno' ); ?>
        </button>
        
        <script type="text/html" id="tmpl-rr-affiliate-product-row">
            <?php rr_affiliate_product_row( '{{index}}', array() ); ?>
        </script>
    </div>
    
    <style>
        .rr-affiliate-product-row {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 10px 0;
        }
        .rr-affiliate-product-row .field-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .rr-affiliate-product-row .field-row label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 12px;
        }
        .rr-affiliate-product-row .field-row .field {
            flex: 1;
        }
        .rr-affiliate-product-row input[type="text"],
        .rr-affiliate-product-row input[type="url"],
        .rr-affiliate-product-row textarea {
            width: 100%;
        }
        .rr-affiliate-product-row textarea {
            height: 60px;
        }
        .rr-affiliate-product-row .remove-row {
            color: #b32d2e;
            cursor: pointer;
            text-decoration: none;
        }
        .rr-affiliate-product-row .remove-row:hover {
            text-decoration: underline;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var index = <?php echo count( $products ); ?>;
        
        $('#rr-add-affiliate-product').on('click', function(e) {
            e.preventDefault();
            var template = $('#tmpl-rr-affiliate-product-row').html();
            template = template.replace(/\{\{index\}\}/g, index);
            $('#rr-affiliate-products-list').append(template);
            index++;
        });
        
        $(document).on('click', '.rr-remove-product', function(e) {
            e.preventDefault();
            $(this).closest('.rr-affiliate-product-row').remove();
        });
    });
    </script>
    <?php
}

/**
 * Output a single product row in the metabox.
 */
function rr_affiliate_product_row( $index, $product ) {
    $name      = isset( $product['name'] )      ? $product['name']      : '';
    $image_url = isset( $product['image_url'] ) ? $product['image_url'] : '';
    $shop_url  = isset( $product['shop_url'] )  ? $product['shop_url']  : '';
    $verdict   = isset( $product['verdict'] )   ? $product['verdict']   : '';
    $stars     = isset( $product['stars'] )     ? $product['stars']     : '5';
    ?>
    <div class="rr-affiliate-product-row">
        <div class="field-row">
            <div class="field">
                <label><?php esc_html_e( 'Product Name', 'rolling-reno' ); ?></label>
                <input type="text" name="rr_products[<?php echo esc_attr( $index ); ?>][name]" value="<?php echo esc_attr( $name ); ?>" placeholder="Renogy 200W Solar Starter Kit">
            </div>
            <div class="field">
                <label><?php esc_html_e( 'Stars (1-5)', 'rolling-reno' ); ?></label>
                <input type="text" name="rr_products[<?php echo esc_attr( $index ); ?>][stars]" value="<?php echo esc_attr( $stars ); ?>" placeholder="5" style="width: 60px;">
            </div>
            <a href="#" class="rr-remove-product remove-row"><?php esc_html_e( 'Remove', 'rolling-reno' ); ?></a>
        </div>
        <div class="field-row">
            <div class="field">
                <label><?php esc_html_e( 'Image URL', 'rolling-reno' ); ?></label>
                <input type="url" name="rr_products[<?php echo esc_attr( $index ); ?>][image_url]" value="<?php echo esc_url( $image_url ); ?>" placeholder="https://...">
            </div>
            <div class="field">
                <label><?php esc_html_e( 'Amazon URL', 'rolling-reno' ); ?></label>
                <input type="url" name="rr_products[<?php echo esc_attr( $index ); ?>][shop_url]" value="<?php echo esc_url( $shop_url ); ?>" placeholder="https://amazon.com/dp/...">
            </div>
        </div>
        <div class="field-row">
            <div class="field">
                <label><?php esc_html_e( 'Verdict / Quote', 'rolling-reno' ); ?></label>
                <textarea name="rr_products[<?php echo esc_attr( $index ); ?>][verdict]" placeholder="&quot;Used on Build #2 — it's held up for 3 years on the road.&quot;"><?php echo esc_textarea( $verdict ); ?></textarea>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Save affiliate products meta.
 */
function rr_save_affiliate_products( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['rr_affiliate_products_nonce_field'] ) || 
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rr_affiliate_products_nonce_field'] ) ), 'rr_affiliate_products_nonce' ) ) {
        return;
    }
    
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Sanitize and save
    $products = array();
    if ( isset( $_POST['rr_products'] ) && is_array( $_POST['rr_products'] ) ) {
        foreach ( $_POST['rr_products'] as $product ) {
            if ( empty( $product['name'] ) && empty( $product['shop_url'] ) ) {
                continue; // Skip empty rows
            }
            $products[] = array(
                'name'      => sanitize_text_field( $product['name'] ),
                'image_url' => esc_url_raw( $product['image_url'] ),
                'shop_url'  => esc_url_raw( $product['shop_url'] ),
                'verdict'   => sanitize_textarea_field( $product['verdict'] ),
                'stars'     => absint( $product['stars'] ),
            );
        }
    }
    
    update_post_meta( $post_id, '_rr_affiliate_products', $products );
}
add_action( 'save_post', 'rr_save_affiliate_products' );

/**
 * Add Amazon Associate tag to affiliate URLs.
 *
 * @param string $url The Amazon product URL.
 * @return string URL with Associate ID appended.
 */
function rr_affiliate_url( $url ) {
    if ( empty( $url ) ) {
        return $url;
    }
    
    // Only modify full amazon.com URLs — amzn.to short links do not support
    // query parameters so appending a tag would break the redirect.
    if ( strpos( $url, 'amazon.com' ) === false ) {
        return $url;
    }

    // Check if tag already exists
    if ( strpos( $url, 'tag=' ) !== false ) {
        // Ensure it's our tag; replace a foreign tag with ours.
        if ( strpos( $url, 'tag=' . RR_AMAZON_ASSOCIATE_ID ) !== false ) {
            return $url;
        }
        return preg_replace( '/([?&]tag=)[^&]+/', '$1' . RR_AMAZON_ASSOCIATE_ID, $url );
    }

    // Add tag parameter
    $separator = ( strpos( $url, '?' ) !== false ) ? '&' : '?';
    return $url . $separator . 'tag=' . RR_AMAZON_ASSOCIATE_ID;
}

/**
 * Convert numeric stars (1-5) to star emoji string.
 *
 * @param int $stars Number of stars (1-5).
 * @return string Star emoji representation.
 */
function rr_stars_to_emoji( $stars ) {
    $stars = max( 1, min( 5, intval( $stars ) ) );
    $full  = str_repeat( '★', $stars );
    $empty = str_repeat( '☆', 5 - $stars );
    return $full . $empty;
}

/**
 * Render affiliate products for a post.
 *
 * @param int $post_id The post ID.
 * @return string HTML output.
 */
function rr_render_affiliate_products( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $products = get_post_meta( $post_id, '_rr_affiliate_products', true );
    if ( empty( $products ) || ! is_array( $products ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <section class="affiliate-products-section" aria-label="<?php esc_attr_e( 'Recommended products', 'rolling-reno' ); ?>">
        <h2 class="affiliate-products-section__title"><?php esc_html_e( 'Gear Mentioned in This Post', 'rolling-reno' ); ?></h2>
        <p class="affiliate-products-section__disclosure">
            <?php
            printf(
                /* translators: %s: link to affiliate disclosure page */
                wp_kses(
                    __( '<strong>Heads up:</strong> Some links below are affiliate links. If you buy through them, Rolling Reno earns a small commission at no extra cost to you. See our <a href="%s">affiliate disclosure</a> for details.', 'rolling-reno' ),
                    array(
                        'strong' => array(),
                        'a'      => array( 'href' => array() ),
                    )
                ),
                esc_url( home_url( '/affiliate-disclosure/' ) )
            );
            ?>
        </p>
        <div class="affiliate-products-section__grid">
            <?php
            foreach ( $products as $product ) :
                $stars_num   = isset( $product['stars'] ) ? intval( $product['stars'] ) : 5;
                $stars_emoji = rr_stars_to_emoji( $stars_num );
                $stars_label = sprintf( __( '%d out of 5 stars', 'rolling-reno' ), $stars_num );
                $shop_url    = rr_affiliate_url( $product['shop_url'] );
                
                get_template_part( 'template-parts/affiliate-card', null, array(
                    'image_url'   => $product['image_url'],
                    'image_alt'   => $product['name'],
                    'name'        => $product['name'],
                    'verdict'     => $product['verdict'],
                    'stars'       => $stars_emoji,
                    'stars_label' => $stars_label,
                    'shop_url'    => $shop_url,
                    'shop_label'  => __( 'Shop on Amazon →', 'rolling-reno' ),
                ) );
            endforeach;
            ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode to embed a single affiliate product card inline.
 *
 * Usage: [rr_product name="Product Name" url="https://amazon.com/..." image="https://..." verdict="Quote" stars="5"]
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function rr_product_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name'    => '',
        'url'     => '',
        'image'   => '',
        'verdict' => '',
        'stars'   => '5',
    ), $atts, 'rr_product' );
    
    if ( empty( $atts['name'] ) ) {
        return '';
    }
    
    $stars_num   = max( 1, min( 5, intval( $atts['stars'] ) ) );
    $stars_emoji = rr_stars_to_emoji( $stars_num );
    $stars_label = sprintf( __( '%d out of 5 stars', 'rolling-reno' ), $stars_num );
    $shop_url    = rr_affiliate_url( $atts['url'] );
    
    ob_start();
    get_template_part( 'template-parts/affiliate-card', null, array(
        'image_url'   => $atts['image'],
        'image_alt'   => $atts['name'],
        'name'        => $atts['name'],
        'verdict'     => $atts['verdict'],
        'stars'       => $stars_emoji,
        'stars_label' => $stars_label,
        'shop_url'    => $shop_url,
        'shop_label'  => __( 'Shop on Amazon →', 'rolling-reno' ),
    ) );
    return ob_get_clean();
}
add_shortcode( 'rr_product', 'rr_product_shortcode' );
