<?php
/**
 * Rolling Reno v2 — footer.php
 * 4-column footer: Brand / Explore / Connect / Resources
 */
?>

<!-- ── Site Footer ──────────────────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
    <div class="container">

        <div class="site-footer__grid">

            <!-- Column 1: Brand -->
            <div class="site-footer__col site-footer__brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">
                    <?php bloginfo( 'name' ); ?>
                </a>
                <p class="site-footer__tagline">
                    <?php esc_html_e( 'Irish van life. Real builds. Open roads.', 'rolling-reno' ); ?>
                </p>
                <div class="site-footer__social" aria-label="<?php esc_attr_e( 'Social links', 'rolling-reno' ); ?>">
                    <?php echo rr_social_links(); ?>
                    <?php // Fallback if no social links set in customizer ?>
                    <?php if ( ! get_theme_mod( 'rr_social_instagram' ) ) : ?>
                        <a href="https://www.instagram.com/rollingreno/" class="site-footer__social-icon" rel="noopener noreferrer" target="_blank" aria-label="<?php esc_attr_e( 'Follow Rolling Reno on Instagram', 'rolling-reno' ); ?>"><?php echo rr_social_instagram_svg(); ?></a>
                        <a href="https://www.pinterest.com/rolling_reno/" class="site-footer__social-icon" rel="noopener noreferrer" target="_blank" aria-label="<?php esc_attr_e( 'Follow Rolling Reno on Pinterest', 'rolling-reno' ); ?>">📌</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Column 2: Explore -->
            <div class="site-footer__col">
                <p class="site-footer__col-title"><?php esc_html_e( 'Explore', 'rolling-reno' ); ?></p>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-2',
                    'container'      => 'nav',
                    'container_attr' => array( 'aria-label' => __( 'Footer Explore navigation', 'rolling-reno' ) ),
                    'items_wrap'     => '<nav>%3$s</nav>',
                    'item_spacing'   => 'discard',
                    'fallback_cb'    => 'rr_footer_explore_fallback',
                ) );
                ?>
            </div>

            <!-- Column 3: Connect -->
            <div class="site-footer__col">
                <p class="site-footer__col-title"><?php esc_html_e( 'Connect', 'rolling-reno' ); ?></p>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-3',
                    'container'      => 'nav',
                    'items_wrap'     => '<nav>%3$s</nav>',
                    'item_spacing'   => 'discard',
                    'fallback_cb'    => 'rr_footer_connect_fallback',
                ) );
                ?>
            </div>

            <!-- Column 4: Resources -->
            <div class="site-footer__col">
                <p class="site-footer__col-title"><?php esc_html_e( 'Resources', 'rolling-reno' ); ?></p>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-4',
                    'container'      => 'nav',
                    'items_wrap'     => '<nav>%3$s</nav>',
                    'item_spacing'   => 'discard',
                    'fallback_cb'    => 'rr_footer_resources_fallback',
                ) );
                ?>
            </div>

        </div><!-- /.site-footer__grid -->

        <!-- Bottom bar -->
        <div class="site-footer__bottom">
            <p>
                &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                <?php bloginfo( 'name' ); ?> &middot;
                <?php esc_html_e( 'All rights reserved', 'rolling-reno' ); ?> &middot;
                <?php esc_html_e( 'Built in Ireland', 'rolling-reno' ); ?> 🇮🇪
            </p>
        </div>

    </div><!-- /.container -->
</footer>
<!-- ── /Site Footer ─────────────────────────────────────────────────────── -->

<?php wp_footer(); ?>
</body>
</html>

<?php
// ─── Footer Nav Fallbacks ─────────────────────────────────────────────────────

function rr_footer_explore_fallback() {
    $links = array(
        array( home_url( '/start-here' ), __( 'Start Here',  'rolling-reno' ) ),
        array( rr_topic_url( 'van-life' ), __( 'Van Life',    'rolling-reno' ) ),
        array( rr_topic_url( 'rv-life' ),  __( 'RV Life',     'rolling-reno' ) ),
        array( home_url( '/gear' ),       __( 'Gear & Kit',  'rolling-reno' ) ),
        array( rr_topic_url( 'van-life' ), __( 'Van Life Guides', 'rolling-reno' ) ),
    );
    echo '<nav aria-label="' . esc_attr__( 'Footer Explore', 'rolling-reno' ) . '">';
    foreach ( $links as $l ) {
        echo '<a href="' . esc_url( $l[0] ) . '">' . esc_html( $l[1] ) . '</a>';
    }
    echo '</nav>';
}

function rr_footer_connect_fallback() {
    $links = array(
        array( home_url( '/about' ),       __( 'About Mara',     'rolling-reno' ) ),
        array( home_url( '/#newsletter' ),  __( 'Newsletter',      'rolling-reno' ) ),
        array( home_url( '/work-with-me' ),__( 'Work With Me',   'rolling-reno' ) ),
        array( home_url( '/contact' ),     __( 'Contact',        'rolling-reno' ) ),
    );
    echo '<nav aria-label="' . esc_attr__( 'Footer Connect', 'rolling-reno' ) . '">';
    foreach ( $links as $l ) {
        echo '<a href="' . esc_url( $l[0] ) . '">' . esc_html( $l[1] ) . '</a>';
    }
    echo '</nav>';
}

function rr_footer_resources_fallback() {
    $links = array(
        array( home_url( '/free-guide' ),            __( 'Free Build Starter Kit', 'rolling-reno' ) ),
        array( home_url( '/affiliate-disclosure/' ), __( 'Affiliate Disclosure', 'rolling-reno' ) ),
        array( home_url( '/privacy-policy' ),        __( 'Privacy Policy',        'rolling-reno' ) ),
        array( home_url( '/sitemap.xml' ),           __( 'Sitemap',               'rolling-reno' ) ),
    );
    echo '<nav aria-label="' . esc_attr__( 'Footer Resources', 'rolling-reno' ) . '">';
    foreach ( $links as $l ) {
        echo '<a href="' . esc_url( $l[0] ) . '">' . esc_html( $l[1] ) . '</a>';
    }
    echo '</nav>';
}
