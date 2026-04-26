<!DOCTYPE html>
<?php $rr_language_attributes = str_replace( 'lang="en-US"', 'lang="en-IE"', get_language_attributes() ); ?>
<html <?php echo $rr_language_attributes; ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php wp_head(); ?>
</head>
<body <?php body_class( 'page-wrapper' ); ?>>

<?php wp_body_open(); ?>

<!-- Skip to content -->
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'rolling-reno' ); ?></a>

<!-- ── Site Navigation ──────────────────────────────────────────────────── -->
<?php $rr_nav_classes = 'site-nav' . ( is_front_page() ? ' site-nav--home' : ' site-nav--solid' ); ?>
<header class="<?php echo esc_attr( $rr_nav_classes ); ?>" id="site-nav" role="banner">
    <div class="site-nav__inner container">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-nav__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . __( 'home', 'rolling-reno' ) ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="site-nav__logo-text"><?php bloginfo( 'name' ); ?></span>
            <?php endif; ?>
        </a>

        <!-- Desktop navigation -->
        <nav class="site-nav__links" aria-label="<?php esc_attr_e( 'Main navigation', 'rolling-reno' ); ?>">
            <?php
            rr_primary_nav_fallback();
            ?>
        </nav>

        <!-- Utility area -->
        <div class="site-nav__utility">
            <!-- Search button -->
            <button class="site-nav__search-btn" aria-label="<?php esc_attr_e( 'Open search', 'rolling-reno' ); ?>" type="button">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="8.5" cy="8.5" r="5.75" stroke="currentColor" stroke-width="1.5"/>
                    <line x1="13.07" y1="13.07" x2="17.5" y2="17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>

            <!-- CTA pill — hide on mobile (shown in mobile menu) -->
            <a href="<?php echo esc_url( home_url( '/#newsletter' ) ); ?>" class="btn btn--nav-cta hide-mobile">
                <?php esc_html_e( 'Free Guide →', 'rolling-reno' ); ?>
            </a>

            <!-- Mobile hamburger -->
            <button
                class="site-nav__hamburger"
                aria-label="<?php esc_attr_e( 'Open menu', 'rolling-reno' ); ?>"
                aria-expanded="false"
                aria-controls="mobile-menu"
                type="button"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <!-- Mobile menu drawer -->
    <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
        <nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'rolling-reno' ); ?>">
            <?php
            rr_mobile_nav_fallback();
            ?>
        </nav>
        <a href="<?php echo esc_url( home_url( '/#newsletter' ) ); ?>" class="btn btn--primary" style="margin-top: 24px; display:block; text-align:center;">
            <?php esc_html_e( 'Get the Free Guide →', 'rolling-reno' ); ?>
        </a>
    </div>
</header>

<!-- Search drawer -->
<div class="site-search" id="site-search" aria-hidden="true">
    <form class="site-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="sr-only" for="site-search-input"><?php esc_html_e( 'Search Rolling Reno', 'rolling-reno' ); ?></label>
        <input id="site-search-input" class="site-search__input" type="search" name="s" placeholder="<?php esc_attr_e( 'Search guides, gear, insurance…', 'rolling-reno' ); ?>" autocomplete="off">
        <button class="site-search__submit" type="submit"><?php esc_html_e( 'Search', 'rolling-reno' ); ?></button>
        <button class="site-search__close" type="button" aria-label="<?php esc_attr_e( 'Close search', 'rolling-reno' ); ?>">×</button>
    </form>
</div>

<!-- ── /Site Navigation ─────────────────────────────────────────────────── -->

<?php // Nav walkers defined in functions.php — loaded before header.php ?>
