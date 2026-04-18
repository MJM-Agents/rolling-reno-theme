<?php
/**
 * Rolling Reno v2 — functions.php
 * Theme setup, enqueue, menus, widget areas, theme support
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RR_VERSION', '2.0.0' );
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

    // Design system CSS
    wp_enqueue_style(
        'rr-design-system',
        RR_THEME_URI . '/assets/css/design-system.css',
        array( 'rr-google-fonts' ),
        RR_VERSION
    );

    // Main CSS
    wp_enqueue_style(
        'rr-main',
        RR_THEME_URI . '/assets/css/main.css',
        array( 'rr-design-system' ),
        RR_VERSION
    );

    // Theme stylesheet (style.css — required by WP, minimal content)
    wp_enqueue_style(
        'rr-theme',
        get_stylesheet_uri(),
        array( 'rr-main' ),
        RR_VERSION
    );

    // Main JS — deferred, no render blocking
    wp_enqueue_script(
        'rr-main',
        RR_THEME_URI . '/assets/js/main.js',
        array(),
        RR_VERSION,
        array( 'in_footer' => true, 'strategy' => 'defer' )
    );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'rr_scripts' );

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

    // Preload hero image on homepage/front page
    if ( is_front_page() ) {
        $hero_img = get_theme_mod( 'rr_hero_image', '' );
        if ( $hero_img ) {
            echo '<link rel="preload" as="image" href="' . esc_url( $hero_img ) . '">' . "\n";
        }
    }

    // Preload hero image on single posts (featured image)
    if ( is_single() && has_post_thumbnail() ) {
        $img_src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
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

    // Newsletter
    $wp_customize->add_section( 'rr_newsletter', array(
        'title'    => __( 'Newsletter / Lead Magnet', 'rolling-reno' ),
        'priority' => 45,
    ) );
    $wp_customize->add_setting( 'rr_newsletter_action', array(
        'default'           => '/subscribe',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'rr_newsletter_action', array(
        'label'   => __( 'Form Action URL', 'rolling-reno' ),
        'section' => 'rr_newsletter',
        'type'    => 'url',
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

function rr_social_links() {
    $platforms = array(
        'instagram' => array( 'label' => 'Instagram', 'icon' => '📷' ),
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

// ─── Newsletter form action helper ───────────────────────────────────────────

function rr_newsletter_action() {
    return esc_url( get_theme_mod( 'rr_newsletter_action', '/subscribe' ) );
}



// ─── Nav Walkers (must be defined before header.php uses them) ───────────────

if ( ! class_exists( 'RR_Nav_Walker' ) ) :
class RR_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $is_active = in_array( 'current-menu-item', $classes ) || in_array( 'current-page-ancestor', $classes );
        $aria_current = $is_active ? ' aria-current="page"' : '';
        $url   = ! empty( $item->url ) ? $item->url : '#';
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '<a href="' . esc_url( $url ) . '" class="site-nav__link"' . $aria_current . '>' . esc_html( $title ) . '</a>';
    }
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
}
endif;

if ( ! class_exists( 'RR_Mobile_Nav_Walker' ) ) :
class RR_Mobile_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item  = $data_object;
        $url   = ! empty( $item->url ) ? $item->url : '#';
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '<a href="' . esc_url( $url ) . '" class="mobile-menu__link">' . esc_html( $title ) . '</a>';
    }
    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
}
endif;

if ( ! function_exists( 'rr_primary_nav_fallback' ) ) :
function rr_primary_nav_fallback() {
    $pages = array(
        array( 'url' => home_url('/'),           'label' => 'Home' ),
        array( 'url' => home_url('/start-here'), 'label' => 'Start Here' ),
        array( 'url' => home_url('/van-life'),   'label' => 'Van Life' ),
        array( 'url' => home_url('/rv-life'),    'label' => 'RV Life' ),
        array( 'url' => home_url('/gear'),       'label' => 'Gear' ),
        array( 'url' => home_url('/about'),      'label' => 'About Mara' ),
    );
    foreach ( $pages as $page ) {
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
        array( 'url' => home_url('/van-life'),   'label' => 'Van Life' ),
        array( 'url' => home_url('/rv-life'),    'label' => 'RV Life' ),
        array( 'url' => home_url('/gear'),       'label' => 'Gear' ),
        array( 'url' => home_url('/about'),      'label' => 'About Mara' ),
    );
    foreach ( $pages as $page ) {
        echo '<a href="' . esc_url( $page['url'] ) . '" class="mobile-menu__link">' . esc_html( $page['label'] ) . '</a>';
    }
}
endif;
