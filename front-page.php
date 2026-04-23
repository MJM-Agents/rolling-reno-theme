<?php
/**
 * Rolling Reno v2 — home.php
 * Homepage template — 11 sections per homepage-v2.md spec
 */

get_header();

$hero_img      = get_theme_mod( 'rr_hero_image', '' );
$hero_title    = get_theme_mod( 'rr_hero_title', "The open road is calling.\nI'm Mara — and I'll show\nyou how to answer it." );
$hero_sub      = get_theme_mod( 'rr_hero_sub', 'DIY conversions, van life adventures, and gear I actually trust.' );
$mara_about_img = get_theme_mod( 'rr_mara_about_image', '' );
?>

<!-- ── Section 1: Nav (in header.php) ──────────────────────────────────── -->

<!-- ── Section 2: Hero ──────────────────────────────────────────────────── -->
<section class="hero" aria-label="<?php esc_attr_e( 'Hero — welcome', 'rolling-reno' ); ?>" id="main" role="main">

    <?php if ( $hero_img ) : ?>
        <img
            class="hero__image"
            src="<?php echo esc_url( $hero_img ); ?>"
            alt="<?php esc_attr_e( 'Mara Collins with her converted van in the Irish countryside', 'rolling-reno' ); ?>"
            width="1920"
            height="1080"
            loading="eager"
            fetchpriority="high"
        >
    <?php else : ?>
        <img
            class="hero__image"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/mara-hero.jpg"
            alt="<?php esc_attr_e( 'Mara Collins with her converted van in the Irish countryside', 'rolling-reno' ); ?>"
            width="1920"
            height="1080"
            loading="eager"
            fetchpriority="high"
        >
    <?php endif; ?>

    <div class="hero__overlay" aria-hidden="true"></div>

    <div class="hero__content container">
        <p class="hero__eyebrow">
            <?php esc_html_e( 'Van Life · Ireland · Living Free', 'rolling-reno' ); ?>
        </p>
        <h1 class="hero__title">
            <?php echo nl2br( esc_html( $hero_title ) ); ?>
        </h1>
        <p class="hero__sub">
            <?php echo esc_html( $hero_sub ); ?>
        </p>
        <div class="hero__ctas">
            <a href="<?php echo esc_url( home_url( '/start-here' ) ); ?>" class="btn btn--primary btn--lg">
                <?php esc_html_e( 'Start Here →', 'rolling-reno' ); ?>
            </a>
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn--outline-inverse btn--lg">
                <?php esc_html_e( 'About Mara', 'rolling-reno' ); ?>
            </a>
        </div>
    </div>

    <span class="hero__scroll-indicator" aria-hidden="true">↓</span>

</section>

<!-- ── Section 3: Value Strip ───────────────────────────────────────────── -->
<section class="value-strip" aria-label="<?php esc_attr_e( 'What Rolling Reno covers', 'rolling-reno' ); ?>">
    <div class="container">
        <div class="value-strip__grid">
            <div class="value-strip__item">
                <span class="value-strip__icon" aria-hidden="true">🚐</span>
                <h2 class="value-strip__title"><?php esc_html_e( 'Van Life & RV', 'rolling-reno' ); ?></h2>
                <p class="value-strip__sub"><?php esc_html_e( 'Guides & stories', 'rolling-reno' ); ?></p>
            </div>
            <div class="value-strip__item">
                <span class="value-strip__icon" aria-hidden="true">🔧</span>
                <h2 class="value-strip__title"><?php esc_html_e( 'DIY Conversions', 'rolling-reno' ); ?></h2>
                <p class="value-strip__sub"><?php esc_html_e( 'Step-by-step builds', 'rolling-reno' ); ?></p>
            </div>
            <div class="value-strip__item">
                <span class="value-strip__icon" aria-hidden="true">🗺️</span>
                <h2 class="value-strip__title"><?php esc_html_e( 'Life on the Road', 'rolling-reno' ); ?></h2>
                <p class="value-strip__sub"><?php esc_html_e( 'Ireland + beyond', 'rolling-reno' ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ── Section 4: Featured Story ────────────────────────────────────────── -->
<section class="featured-story" aria-label="<?php esc_attr_e( 'Featured story', 'rolling-reno' ); ?>">
    <div class="container">
        <header class="section-header">
            <h2 class="section-header__title"><?php esc_html_e( 'From the Road', 'rolling-reno' ); ?></h2>
            <p class="section-header__sub"><?php esc_html_e( 'The story worth starting with', 'rolling-reno' ); ?></p>
        </header>

        <?php
        // Query the sticky/featured post, or fall back to latest
        $featured_query = new WP_Query( array(
            'posts_per_page' => 1,
            'meta_key'       => '_rr_featured',
            'meta_value'     => '1',
        ) );

        if ( ! $featured_query->have_posts() ) {
            $featured_query = new WP_Query( array( 'posts_per_page' => 1 ) );
        }

        if ( $featured_query->have_posts() ) :
            $featured_query->the_post();
            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card' );
        ?>
        <article class="featured-card" aria-labelledby="featured-title-home">
            <div class="featured-card__image-wrap">
                <?php if ( $thumb ) : ?>
                    <img
                        src="<?php echo esc_url( $thumb ); ?>"
                        alt="<?php the_title_attribute(); ?>"
                        width="900"
                        height="600"
                        loading="eager"
                        class="featured-card__image"
                    >
                <?php else : ?>
                    <div class="featured-card__image-placeholder" aria-hidden="true">🚐</div>
                <?php endif; ?>
            </div>
            <div class="featured-card__body">
                <div class="featured-card__meta">
                    <?php echo rr_category_badge(); ?>
                    <span class="badge badge--featured"><?php esc_html_e( 'Featured', 'rolling-reno' ); ?></span>
                    <span class="label-text"><?php echo esc_html( rr_read_time() ); ?></span>
                </div>
                <h3 class="featured-card__title" id="featured-title-home">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p class="featured-card__excerpt"><?php echo esc_html( rr_excerpt( null, 25 ) ); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn btn--primary">
                    <?php esc_html_e( 'Read the guide →', 'rolling-reno' ); ?>
                </a>
            </div>
        </article>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<!-- ── Section 5: By Category Grid ─────────────────────────────────────── -->
<section class="category-grid" aria-label="<?php esc_attr_e( 'Explore by topic', 'rolling-reno' ); ?>">
    <div class="container">
        <header class="section-header">
            <h2 class="section-header__title"><?php esc_html_e( 'Explore by Topic', 'rolling-reno' ); ?></h2>
        </header>
        <div class="category-grid__tiles">

            <?php
            $tiles = array(
                array(
                    'label'  => __( 'Van Life', 'rolling-reno' ),
                    'url'    => home_url( '/van-life' ),
                    'class'  => 'category-tile__placeholder--van-life',
                    'emoji'  => '🚐',
                    'aria'   => __( 'Browse Van Life posts', 'rolling-reno' ),
                    'img_key'=> 'rr_cat_img_van_life',
                ),
                array(
                    'label'  => __( 'RV Life', 'rolling-reno' ),
                    'url'    => home_url( '/rv-life' ),
                    'class'  => 'category-tile__placeholder--rv-life',
                    'emoji'  => '🏕️',
                    'aria'   => __( 'Browse RV Life posts', 'rolling-reno' ),
                    'img_key'=> 'rr_cat_img_rv_life',
                ),
                array(
                    'label'  => __( 'Gear & Kit', 'rolling-reno' ),
                    'url'    => home_url( '/gear' ),
                    'class'  => 'category-tile__placeholder--gear',
                    'emoji'  => '🔧',
                    'aria'   => __( 'Browse Gear & Kit posts', 'rolling-reno' ),
                    'img_key'=> 'rr_cat_img_gear',
                ),
                array(
                    'label'  => __( "Mara's Rig", 'rolling-reno' ),
                    'url'    => home_url( '/van-life/maras-rig' ),
                    'class'  => 'category-tile__placeholder--maras-rig',
                    'emoji'  => '🌿',
                    'aria'   => __( "Browse Mara's Rig posts", 'rolling-reno' ),
                    'img_key'=> 'rr_cat_img_maras_rig',
                ),
            );

            foreach ( $tiles as $tile ) :
                $tile_img = get_theme_mod( $tile['img_key'], '' );
            ?>
            <a href="<?php echo esc_url( $tile['url'] ); ?>" class="category-tile" aria-label="<?php echo esc_attr( $tile['aria'] ); ?>">
                <?php if ( $tile_img ) : ?>
                    <img
                        src="<?php echo esc_url( $tile_img ); ?>"
                        alt=""
                        class="category-tile__image"
                        width="600"
                        height="600"
                        loading="lazy"
                        aria-hidden="true"
                    >
                <?php else : ?>
                    <div class="category-tile__placeholder <?php echo esc_attr( $tile['class'] ); ?>" aria-hidden="true">
                        <?php echo $tile['emoji']; ?>
                    </div>
                <?php endif; ?>
                <div class="category-tile__overlay" aria-hidden="true"></div>
                <span class="category-tile__label"><?php echo esc_html( $tile['label'] ); ?></span>
            </a>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- ── Section 6: Latest Posts ──────────────────────────────────────────── -->
<section class="latest-posts" aria-label="<?php esc_attr_e( 'Latest posts from Mara', 'rolling-reno' ); ?>">
    <div class="container">
        <header class="section-header">
            <h2 class="section-header__title"><?php esc_html_e( 'Latest from Mara', 'rolling-reno' ); ?></h2>
            <p class="section-header__sub"><?php esc_html_e( 'Hot off the press', 'rolling-reno' ); ?></p>
        </header>

        <?php
        $latest_query = new WP_Query( array(
            'posts_per_page' => 6,
            'ignore_sticky_posts' => 1,
        ) );
        ?>

        <div class="posts-grid">
            <?php
            if ( $latest_query->have_posts() ) :
                while ( $latest_query->have_posts() ) :
                    $latest_query->the_post();
                    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card-sm' );
                ?>
                <article class="post-card" aria-labelledby="post-<?php the_ID(); ?>-title">
                    <a href="<?php the_permalink(); ?>" class="post-card__image-link" tabindex="-1" aria-hidden="true">
                        <div class="post-card__image-wrap">
                            <?php if ( $thumb ) : ?>
                                <img
                                    class="post-card__image"
                                    src="<?php echo esc_url( $thumb ); ?>"
                                    alt=""
                                    width="480"
                                    height="360"
                                    loading="lazy"
                                >
                            <?php else : ?>
                                <div class="post-card__image-placeholder" aria-hidden="true">🚐</div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="post-card__body">
                        <div class="post-card__meta">
                            <?php echo rr_category_badge(); ?>
                            <span class="label-text"><?php echo esc_html( rr_read_time() ); ?></span>
                        </div>
                        <h3 class="post-card__title" id="post-<?php the_ID(); ?>-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="post-card__date caption"><?php echo get_the_date(); ?></p>
                    </div>
                </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p><?php esc_html_e( 'No posts yet — check back soon.', 'rolling-reno' ); ?></p>
            <?php endif; ?>
        </div>

        <div class="posts-grid__cta">
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn--ghost">
                <?php esc_html_e( 'See all posts →', 'rolling-reno' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- ── Section 7: About Mara Teaser ─────────────────────────────────────── -->
<section class="about-teaser" aria-label="<?php esc_attr_e( 'About Mara Collins', 'rolling-reno' ); ?>">
    <div class="container">
        <div class="about-teaser__grid">
            <div class="about-teaser__image-col">
                <?php if ( $mara_about_img ) : ?>
                    <img
                        src="<?php echo esc_url( $mara_about_img ); ?>"
                        alt="<?php esc_attr_e( 'Mara Collins, van life blogger, in her converted Sprinter', 'rolling-reno' ); ?>"
                        width="600"
                        height="800"
                        loading="lazy"
                        class="about-teaser__image"
                    >
                <?php else : ?>
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/mara-portrait.jpg"
                        alt="<?php esc_attr_e( 'Mara Collins, van life blogger, in her converted Sprinter', 'rolling-reno' ); ?>"
                        width="600"
                        height="800"
                        loading="lazy"
                        class="about-teaser__image"
                    >
                <?php endif; ?>
            </div>
            <div class="about-teaser__content">
                <span class="about-teaser__label label-text"><?php esc_html_e( 'Meet Mara Collins', 'rolling-reno' ); ?></span>
                <h2 class="about-teaser__title">
                    <?php esc_html_e( 'From Dublin to the open road — I swapped the city for a converted van.', 'rolling-reno' ); ?>
                </h2>
                <p class="about-teaser__body">
                    <?php esc_html_e( "I'm from Dublin. For most of my twenties I lived the way you're supposed to — commute, flat, good job, repeat. Then I bought a knackered Renault Trafic for €3,500, converted it over a summer, and drove it to Kerry. That was five years ago. I'm still going.", 'rolling-reno' ); ?>
                </p>
                <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="about-teaser__cta">
                    <?php esc_html_e( 'Read my story →', 'rolling-reno' ); ?>
                </a>
                <div class="about-teaser__testimonial">
                    <p class="about-teaser__quote">
                        "<?php esc_html_e( "Mara's guides saved me €2,000 on my build.", 'rolling-reno' ); ?>"
                    </p>
                    <p class="about-teaser__attribution">— Siobhan, Cork 🇮🇪</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Section 8: Lead Magnet / Email Opt-in ───────────────────────────── -->
<section class="cta-banner cta-banner--leadmagnet" aria-labelledby="leadmagnet-heading">
    <div class="cta-banner__inner container">
        <div class="cta-banner__text">
            <h2 class="cta-banner__heading" id="leadmagnet-heading">
                <?php esc_html_e( "Get Mara's Free Van Build Starter Kit", 'rolling-reno' ); ?>
            </h2>
            <p class="cta-banner__sub">
                <?php esc_html_e( 'The exact checklist from Build #1 — tools, materials, costs, mistakes to avoid. Used by 4,200+ subscribers before starting their own conversion.', 'rolling-reno' ); ?>
            </p>
        </div>
        <form class="cta-banner__form" action="<?php echo rr_newsletter_action(); ?>" method="POST">
            <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
            <?php rr_newsletter_hidden_fields(); ?>
            <input
                type="email"
                name="email"
                placeholder="<?php esc_attr_e( 'Your email address', 'rolling-reno' ); ?>"
                required
                autocomplete="email"
                class="cta-banner__input"
                aria-label="<?php esc_attr_e( 'Email address', 'rolling-reno' ); ?>"
            >
            <button type="submit" class="btn--cta-banner">
                <?php esc_html_e( 'Send me the kit →', 'rolling-reno' ); ?>
            </button>
            <p class="cta-banner__fine"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'rolling-reno' ); ?></p>
        </form>
    </div>
</section>

<!-- ── Section 9: Gear Spotlight Strip ─────────────────────────────────── -->
<section class="gear-strip" role="region" aria-label="<?php esc_attr_e( 'Gear recommendations', 'rolling-reno' ); ?>">
    <div class="container">
        <header class="section-header">
            <h2 class="section-header__title"><?php esc_html_e( 'Gear Mara Actually Uses', 'rolling-reno' ); ?></h2>
            <p class="section-header__sub"><?php esc_html_e( 'Tested on the road. Linked with love.', 'rolling-reno' ); ?></p>
        </header>
        <div class="gear-strip__scroll">
            <?php
            // Gear spotlight — query posts tagged or categorised as gear
            $gear_query = new WP_Query( array(
                'posts_per_page' => 8,
                'category_name'  => 'gear',
            ) );

            if ( $gear_query->have_posts() ) :
                while ( $gear_query->have_posts() ) :
                    $gear_query->the_post();
                    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card-sm' );
            ?>
            <div class="gear-card">
                <div class="gear-card__image-wrap">
                    <?php if ( $thumb ) : ?>
                        <img
                            src="<?php echo esc_url( $thumb ); ?>"
                            alt="<?php the_title_attribute(); ?>"
                            class="gear-card__image"
                            width="220"
                            height="147"
                            loading="lazy"
                        >
                    <?php else : ?>
                        <div class="gear-card__image-placeholder" aria-hidden="true">🔧</div>
                    <?php endif; ?>
                </div>
                <div class="gear-card__body">
                    <p class="gear-card__name"><?php the_title(); ?></p>
                    <p class="gear-card__verdict"><?php echo esc_html( rr_excerpt( null, 12 ) ); ?></p>
                    <a
                        href="<?php the_permalink(); ?>"
                        class="gear-card__cta"
                        aria-label="<?php echo esc_attr( sprintf( __( 'Read about %s', 'rolling-reno' ), get_the_title() ) ); ?>"
                    >
                        <?php esc_html_e( 'Shop →', 'rolling-reno' ); ?>
                    </a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <?php // Placeholder cards when no gear posts exist ?>
                <?php
                $placeholder_gear = array(
                    array( 'Renogy 200W Solar Kit', '"First recommendation for anyone starting out — clean install, solid warranty."', '☀️' ),
                    array( 'Webasto Diesel Heater', '"Survived three Irish winters with this. Non-negotiable."', '🔥' ),
                    array( 'BougeRV 40A MPPT', '"Upgraded from a PWM and wished I\'d done it Build #1."', '⚡' ),
                    array( 'Thinsulate SM600L', '"The only van insulation I recommend now. Not even close."', '🌡️' ),
                    array( 'Dometic CFX3 25L Fridge', '"Changed everything about how I eat on the road."', '🧊' ),
                );
                foreach ( $placeholder_gear as $pg ) : ?>
                <div class="gear-card">
                    <div class="gear-card__image-wrap">
                        <div class="gear-card__image-placeholder" aria-hidden="true"><?php echo $pg[2]; ?></div>
                    </div>
                    <div class="gear-card__body">
                        <p class="gear-card__name"><?php echo esc_html( $pg[0] ); ?></p>
                        <p class="gear-card__verdict"><?php echo esc_html( $pg[1] ); ?></p>
                        <a href="<?php echo esc_url( home_url( '/gear' ) ); ?>" class="gear-card__cta">
                            <?php esc_html_e( 'Shop →', 'rolling-reno' ); ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="gear-strip__footer">
            <a href="<?php echo esc_url( home_url( '/gear' ) ); ?>" class="btn btn--ghost">
                <?php esc_html_e( 'See all gear guides →', 'rolling-reno' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- ── Section 10: Instagram Strip ─────────────────────────────────────── -->
<?php
$rr_ig_handle      = get_theme_mod( 'rr_instagram_handle', 'maracollins' );
$rr_ig_url         = 'https://instagram.com/' . sanitize_text_field( $rr_ig_handle );
$rr_lightwidget_id = get_theme_mod( 'rr_lightwidget_id', '' );
?>
<section class="instagram-strip" aria-label="<?php esc_attr_e( 'Instagram feed', 'rolling-reno' ); ?>">
    <div class="container">
        <div class="instagram-strip__header">
            <p class="instagram-strip__label"><?php esc_html_e( 'Follow along', 'rolling-reno' ); ?></p>
            <h2 class="instagram-strip__handle">@<?php echo esc_html( $rr_ig_handle ); ?></h2>
        </div>
        <?php if ( shortcode_exists( 'instagram-feed' ) ) : ?>
            <?php echo do_shortcode( '[instagram-feed]' ); ?>
        <?php elseif ( ! empty( $rr_lightwidget_id ) ) : ?>
            <div class="instagram-grid instagram-grid--lightwidget" aria-label="<?php esc_attr_e( 'Instagram photos', 'rolling-reno' ); ?>">
                <script src="https://cdn.lightwidget.com/widgets/lightwidget.plugin.js"></script>
                <iframe src="//lightwidget.com/widgets/<?php echo esc_attr( $rr_lightwidget_id ); ?>.html"
                    scrolling="no"
                    allowtransparency="true"
                    class="lightwidget-plugin"
                    style="width:100%;border:0;overflow:hidden;"
                    title="<?php esc_attr_e( 'Instagram feed', 'rolling-reno' ); ?>"
                ></iframe>
            </div>
        <?php else : ?>
            <div class="instagram-grid" aria-label="<?php esc_attr_e( 'Instagram photos', 'rolling-reno' ); ?>">
                <?php
                $emojis = array( '🌿', '🚐', '🏔️', '🌅', '☀️', '🌊', '🔧', '🌙' );
                for ( $i = 1; $i <= 8; $i++ ) : ?>
                <a href="<?php echo esc_url( $rr_ig_url ); ?>" class="instagram-cell" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( 'View photo %d on Instagram', 'rolling-reno' ), $i ) ); ?>">
                    <div class="instagram-cell__placeholder"><?php echo $emojis[ $i - 1 ]; ?></div>
                    <div class="instagram-cell__overlay" aria-hidden="true">
                        <span class="instagram-cell__icon">📷</span>
                    </div>
                </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        <a href="<?php echo esc_url( $rr_ig_url ); ?>" class="btn btn--ghost" target="_blank" rel="noopener noreferrer">
            <?php esc_html_e( 'Follow on Instagram →', 'rolling-reno' ); ?>
        </a>
    </div>
</section>

<!-- ── Section 11: Footer (in footer.php) ─────────────────────────────── -->

<?php get_footer(); ?>
