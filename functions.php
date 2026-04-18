<?php
/**
 * Rolling Reno Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ROLLING_RENO_VERSION', '0.1.0' );

function rolling_reno_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'align-wide' );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'rolling-reno' ),
        'footer'  => __( 'Footer Menu', 'rolling-reno' ),
    ) );
}
add_action( 'after_setup_theme', 'rolling_reno_setup' );

function rolling_reno_enqueue_scripts() {
    wp_enqueue_style(
        'rolling-reno-fonts',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Inter:wght@400;500;600&family=Lora:ital,wght@0,400;1,400&display=swap',
        array(),
        null
    );
    wp_enqueue_style( 'rolling-reno-style', get_stylesheet_uri(), array(), ROLLING_RENO_VERSION );
}
add_action( 'wp_enqueue_scripts', 'rolling_reno_enqueue_scripts' );
