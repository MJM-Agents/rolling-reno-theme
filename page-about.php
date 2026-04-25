<?php
/**
 * Template Name: About Mara
 * Rolling Reno v2 — page-about.php
 * Spec: about-mara-v2.md
 */

get_header();

$hero_img    = get_theme_mod( 'rr_mara_about_image', '' );
$avatar_url  = get_theme_mod( 'rr_mara_avatar', '' );

$gallery_imgs = array(
    get_theme_mod( 'rr_gallery_1', get_template_directory_uri() . '/assets/images/mara-card.jpg' ),
    get_theme_mod( 'rr_gallery_2', get_template_directory_uri() . '/assets/images/mara-landscape.jpg' ),
    get_theme_mod( 'rr_gallery_3', get_template_directory_uri() . '/assets/images/mara-portrait.jpg' ),
    get_theme_mod( 'rr_gallery_4', get_template_directory_uri() . '/assets/images/mara-about.jpg' ),
);
$gallery_labels = array(
    __( 'Mara cooking inside her converted van', 'rolling-reno' ),
    __( 'Mara at the Wild Atlantic Way, Ireland', 'rolling-reno' ),
    __( 'Interior of Mara\'s van — warm and cosy', 'rolling-reno' ),
    __( 'Mara with coffee at sunrise, van door open', 'rolling-reno' ),
);
$gallery_placeholders = array( '🍳', '🌊', '🚐', '☀️' );
$gallery_bg = array( '#3D5A47', '#4A6741', '#2C4234', '#C4714A' );
?>

<main id="main" role="main">

    <!-- Section 2: Hero — Photo Only -->
    <section class="about-hero" aria-label="<?php esc_attr_e( 'Mara Collins photo', 'rolling-reno' ); ?>">
        <?php if ( $hero_img ) : ?>
            <img
                class="about-hero__image"
                src="<?php echo esc_url( $hero_img ); ?>"
                alt="<?php esc_attr_e( "Mara Collins standing in the doorway of her converted Sprinter van, Irish countryside behind her", 'rolling-reno' ); ?>"
                width="1920"
                height="1080"
                loading="eager"
                fetchpriority="high"
            >
        <?php else : ?>
            <img
                class="about-hero__image"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/mara-about.jpg"
                alt="<?php esc_attr_e( 'Mara Collins standing in the doorway of her converted Sprinter van, Irish countryside behind her', 'rolling-reno' ); ?>"
                width="1920"
                height="1080"
                loading="eager"
                fetchpriority="high"
            >
        <?php endif; ?>
    </section>

    <!-- Section 3: Intro Block — "Hi. I'm Mara." -->
    <section class="about-intro" aria-label="<?php esc_attr_e( 'Introduction', 'rolling-reno' ); ?>">
        <div class="about-intro__inner">
            <h1 class="about-intro__title"><?php esc_html_e( "Hi. I'm Mara.", 'rolling-reno' ); ?></h1>
            <div class="about-intro__body">
                <p><?php esc_html_e( "I'm from Dublin. For most of my twenties I lived the way you're supposed to — commute, flat, good job, repeat. Then I bought a knackered Renault Trafic for €3,500, converted it over a summer, and drove it to Kerry. That was five years ago. I'm still going.", 'rolling-reno' ); ?></p>
                <p><?php esc_html_e( "I built this site because I made every expensive mistake in the book, and I'd rather you didn't have to. Whether you're planning a weekend warrior van build or going full-time, I'll show you what works — with receipts.", 'rolling-reno' ); ?></p>
            </div>
        </div>
    </section>

    <!-- Section 4: Stats Row -->
    <section class="about-stats" aria-label="<?php esc_attr_e( 'About Mara stats', 'rolling-reno' ); ?>">
        <div class="container">
            <dl class="about-stats__grid">
                <div class="about-stat">
                    <dt class="about-stat__number">3</dt>
                    <dd class="about-stat__label"><?php esc_html_e( 'Builds Documented', 'rolling-reno' ); ?></dd>
                </div>
                <div class="about-stat">
                    <dt class="about-stat__number">40,000km+</dt>
                    <dd class="about-stat__label"><?php esc_html_e( 'On the Road', 'rolling-reno' ); ?></dd>
                </div>
                <div class="about-stat">
                    <dt class="about-stat__number">€35k+</dt>
                    <dd class="about-stat__label"><?php esc_html_e( 'Saved by Readers (Advised)', 'rolling-reno' ); ?></dd>
                </div>
            </dl>
        </div>
    </section>

    <!-- Section 5: Photo Gallery Strip -->
    <section class="about-gallery" aria-label="<?php esc_attr_e( 'Photo gallery', 'rolling-reno' ); ?>">
        <div class="container--wide">
            <div class="about-gallery__strip">
                <?php for ( $i = 0; $i < 4; $i++ ) :
                    $img = $gallery_imgs[ $i ];
                ?>
                <div class="about-gallery__item">
                    <?php if ( $img ) : ?>
                        <img
                            class="about-gallery__image"
                            src="<?php echo esc_url( $img ); ?>"
                            alt="<?php echo esc_attr( $gallery_labels[ $i ] ); ?>"
                            width="600"
                            height="900"
                            loading="lazy"
                        >
                    <?php else : ?>
                        <div
                            class="about-gallery__placeholder"
                            style="background: <?php echo esc_attr( $gallery_bg[ $i ] ); ?>;"
                            aria-label="<?php echo esc_attr( $gallery_labels[ $i ] ); ?>"
                        ><?php echo $gallery_placeholders[ $i ]; ?></div>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Section 6: Full Story -->
    <section class="about-full-story" aria-label="<?php esc_attr_e( "Mara's full story", 'rolling-reno' ); ?>">
        <div class="container--narrow">
            <h2><?php esc_html_e( 'How I ended up here', 'rolling-reno' ); ?></h2>
            <div class="post-body" style="max-width: 100%; padding: 0;">
                <h3 id="build-renault-trafic"><?php esc_html_e( 'The first van', 'rolling-reno' ); ?></h3>
                <p><?php esc_html_e( "It was a 2004 Renault Trafic with 210,000km on it and a suspicious smell I'd rather not describe. I paid €3,500 and immediately regretted it. Then I insulated it, which took three weekends and four trips to a German engineering forum, and immediately stopped regretting it.", 'rolling-reno' ); ?></p>
                <p><?php esc_html_e( "I drove it to the Dingle Peninsula in September and parked up with a view I still haven't beaten. That was the moment I understood what this was about — not minimalism, not Instagram aesthetics, not sticking it to the system. Just the simplest possible version of being exactly where you want to be.", 'rolling-reno' ); ?></p>

                <h3><?php esc_html_e( 'The first breakdown', 'rolling-reno' ); ?></h3>
                <p><?php esc_html_e( "Connemara, February, 2°C at 11pm. The alternator went. My sleeping bag was rated to 5°C. I learned three things that night: always carry a backup power bank, always know where the nearest town is, and always tell someone your rough location before you head somewhere remote. Basic stuff. I learned it the hard way.", 'rolling-reno' ); ?></p>

                <blockquote class="pullquote">
                    <p>"<?php esc_html_e( "I've slept in 12 countries and 200+ locations. The one thing I'm always asked is — how do I start? That's why this site exists.", 'rolling-reno' ); ?>"</p>
                </blockquote>

                <h3 id="build-mercedes-sprinter"><?php esc_html_e( 'The first proper build', 'rolling-reno' ); ?></h3>
                <p><?php esc_html_e( "Build #2 was a 2019 Mercedes Sprinter 313 LWB. I did it properly: Thinsulate insulation, 200W Renogy solar, 100Ah lithium, a Webasto diesel heater, and a kitchen I'm genuinely proud of. Total cost: €9,200. I documented every step because I couldn't find documentation I trusted online — and that documentation became this blog.", 'rolling-reno' ); ?></p>
                <h3 id="build-autotrail-tribute"><?php esc_html_e( 'The current motorhome', 'rolling-reno' ); ?></h3>
                <p><?php esc_html_e( "Build #3 is an Autotrail Tribute motorhome I picked up in 2024, which took everything I'd learned and applied it to a different format entirely. That's still ongoing.", 'rolling-reno' ); ?></p>
            </div>

            <?php if ( have_posts() && is_page() ) :
                while ( have_posts() ) : the_post();
                    // Output any custom page content added via the editor
                    $content = get_the_content();
                    if ( $content ) : ?>
                        <div class="post-body" style="max-width: 100%; padding: 0; margin-top: 2rem;">
                            <?php the_content(); ?>
                        </div>
                    <?php endif;
                endwhile;
            endif; ?>
        </div>
    </section>

    <!-- Section 7: Values -->
    <section class="about-values" aria-label="<?php esc_attr_e( 'What this blog stands for', 'rolling-reno' ); ?>">
        <div class="container">
            <h2 class="about-values__title"><?php esc_html_e( 'What this blog stands for', 'rolling-reno' ); ?></h2>
            <div class="about-values__grid">
                <div class="about-value">
                    <span class="about-value__icon" aria-hidden="true">🔧</span>
                    <h3 class="about-value__title"><?php esc_html_e( 'Real DIY', 'rolling-reno' ); ?></h3>
                    <p class="about-value__desc"><?php esc_html_e( '"I do my own builds. No sponsored upgrades disguised as tutorials."', 'rolling-reno' ); ?></p>
                </div>
                <div class="about-value">
                    <span class="about-value__icon" aria-hidden="true">💰</span>
                    <h3 class="about-value__title"><?php esc_html_e( 'Honest Costs', 'rolling-reno' ); ?></h3>
                    <p class="about-value__desc"><?php esc_html_e( '"I\'ll tell you what things actually cost, not the aspirational version."', 'rolling-reno' ); ?></p>
                </div>
                <div class="about-value">
                    <span class="about-value__icon" aria-hidden="true">🗺️</span>
                    <h3 class="about-value__title"><?php esc_html_e( 'Ireland First', 'rolling-reno' ); ?></h3>
                    <p class="about-value__desc"><?php esc_html_e( '"I\'ll always show you why Ireland is the best van life country on earth."', 'rolling-reno' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Testimonials -->
    <section class="about-testimonials" aria-label="<?php esc_attr_e( 'Reader testimonials', 'rolling-reno' ); ?>">
        <div class="container--narrow">
            <span class="about-testimonials__label"><?php esc_html_e( 'What Readers Say', 'rolling-reno' ); ?></span>
            <div class="about-testimonials__grid">
                <article class="testimonial-card">
                    <blockquote>
                        <p class="testimonial-card__quote">
                            <?php esc_html_e( "Mara's conversion guides saved me €2,000 on my build. I've read dozens of van life blogs and nothing comes close to the level of detail here.", 'rolling-reno' ); ?>
                        </p>
                        <footer>
                            <cite class="testimonial-card__attribution">— <?php esc_html_e( 'Siobhan Ní Bhriain, Cork 🇮🇪', 'rolling-reno' ); ?></cite>
                        </footer>
                    </blockquote>
                </article>
                <article class="testimonial-card">
                    <blockquote>
                        <p class="testimonial-card__quote">
                            <?php esc_html_e( "I was absolutely lost before I found Rolling Reno. The electrical guide alone saved me from a genuinely dangerous install. Thank you Mara.", 'rolling-reno' ); ?>
                        </p>
                        <footer>
                            <cite class="testimonial-card__attribution">— <?php esc_html_e( 'Pádraig Ó Briain, Galway 🇮🇪', 'rolling-reno' ); ?></cite>
                        </footer>
                    </blockquote>
                </article>
                <article class="testimonial-card">
                    <blockquote>
                        <p class="testimonial-card__quote">
                            <?php esc_html_e( "The gear page alone is worth bookmarking forever. Everything is actually used and tested. No fluff. Brilliant site.", 'rolling-reno' ); ?>
                        </p>
                        <footer>
                            <cite class="testimonial-card__attribution">— <?php esc_html_e( 'Áine Murphy, Limerick 🇮🇪', 'rolling-reno' ); ?></cite>
                        </footer>
                    </blockquote>
                </article>
            </div>
        </div>
    </section>

    <!-- Section 9: Press / Featured In -->
    <section class="about-press" aria-label="<?php esc_attr_e( 'As featured in', 'rolling-reno' ); ?>">
        <div class="container">
            <span class="about-press__label"><?php esc_html_e( 'As Featured In', 'rolling-reno' ); ?></span>
            <div class="about-press__logos">
                <?php
                // Placeholder press logos — replace with real logos
                $press = array( 'Irish Times', 'Wanderlust', 'Campervan Magazine', 'The Journal', 'Van Life Diaries' );
                foreach ( $press as $pub ) : ?>
                    <span class="about-press__placeholder"><?php echo esc_html( $pub ); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Section 10: CTA Block -->
    <section class="about-cta" aria-label="<?php esc_attr_e( 'Get started', 'rolling-reno' ); ?>">
        <div class="about-cta__inner">
            <h2 class="about-cta__title"><?php esc_html_e( 'Ready to start?', 'rolling-reno' ); ?></h2>
            <p class="about-cta__sub">
                <?php esc_html_e( "Whether you're here for the conversion guides, the gear lists, or just to see how this works — there's a place to begin.", 'rolling-reno' ); ?>
            </p>
            <div class="about-cta__buttons">
                <a href="<?php echo esc_url( home_url( '/start-here' ) ); ?>" class="btn btn--primary btn--lg">
                    <?php esc_html_e( 'Start Here →', 'rolling-reno' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/#newsletter' ) ); ?>" class="btn btn--ghost btn--lg">
                    <?php esc_html_e( 'Get the free guide →', 'rolling-reno' ); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
