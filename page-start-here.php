<?php
/**
 * Template Name: Start Here
 * Rolling Reno — beginner roadmap page.
 *
 * MJM-267: Replace the thin editor placeholder with a real entry path.
 */

get_header();

$topics    = function_exists( 'rr_blog_nav_topics' ) ? rr_blog_nav_topics() : array();
$hub_cards = function_exists( 'rr_blog_hub_cards' ) ? rr_blog_hub_cards() : array();

$steps = array(
    array(
        'number' => '01',
        'title'  => __( 'Decide what kind of rolling home you are actually building', 'rolling-reno' ),
        'copy'   => __( 'Start with budget, use case, parking, travel style, and whether an RV, van, or smaller rig makes sense before you buy parts.', 'rolling-reno' ),
        'slug'   => 'start-here-planning',
        'link'   => home_url( '/blog/?s=inspection&category=start-here-planning' ),
        'cta'    => __( 'Read planning guides', 'rolling-reno' ),
    ),
    array(
        'number' => '02',
        'title'  => __( 'Choose the right base vehicle before the renovation locks you in', 'rolling-reno' ),
        'copy'   => __( 'Compare vans, older RVs, minivans, electric vans, and used-rig red flags so the build fits the actual chassis.', 'rolling-reno' ),
        'slug'   => 'vehicle-guides',
        'link'   => home_url( '/blog/?category=vehicle-guides' ),
        'cta'    => __( 'Compare vehicles', 'rolling-reno' ),
    ),
    array(
        'number' => '03',
        'title'  => __( 'Plan systems before walls and cabinets hide the expensive mistakes', 'rolling-reno' ),
        'copy'   => __( 'Electrical, solar, water, ventilation, heat, and safety decisions should happen while the build is still easy to change.', 'rolling-reno' ),
        'slug'   => 'systems-off-grid',
        'link'   => home_url( '/blog/?category=systems-off-grid' ),
        'cta'    => __( 'Plan off-grid systems', 'rolling-reno' ),
    ),
    array(
        'number' => '04',
        'title'  => __( 'Build an interior that works after the photos are over', 'rolling-reno' ),
        'copy'   => __( 'Use the layout, storage, kitchen, bed, bathroom, insulation, flooring, and material guides to make the rig livable.', 'rolling-reno' ),
        'slug'   => 'interior-build-layouts',
        'link'   => home_url( '/blog/?category=interior-build-layouts' ),
        'cta'    => __( 'Build the interior', 'rolling-reno' ),
    ),
    array(
        'number' => '05',
        'title'  => __( 'Pressure-test the road-life reality', 'rolling-reno' ),
        'copy'   => __( 'Insurance, healthcare, domicile, work, routines, gear, maintenance, and mental load matter as much as the build list.', 'rolling-reno' ),
        'slug'   => 'rv-life',
        'link'   => home_url( '/blog/?category=rv-life' ),
        'cta'    => __( 'Plan life on the road', 'rolling-reno' ),
    ),
);
?>

<main id="main" role="main" class="start-here-page">
    <section class="start-here-hero" aria-labelledby="start-here-title">
        <div class="container">
            <p class="eyebrow"><?php esc_html_e( 'New to Rolling Reno?', 'rolling-reno' ); ?></p>
            <h1 id="start-here-title"><?php esc_html_e( 'Start here: build the right rig in the right order', 'rolling-reno' ); ?></h1>
            <p class="start-here-hero__dek">
                <?php esc_html_e( 'If you are staring at an empty van, a tired RV, or a Pinterest board that got out of hand, use this page as the map. It points you to the first decisions, the safety-critical systems, and the guides worth reading before money starts disappearing.', 'rolling-reno' ); ?>
            </p>
            <div class="start-here-hero__ctas">
                <a class="btn btn--primary btn--lg" href="<?php echo esc_url( function_exists( 'rr_blog_index_url' ) ? rr_blog_index_url() : home_url( '/blog/' ) ); ?>">
                    <?php esc_html_e( 'Browse all guides →', 'rolling-reno' ); ?>
                </a>
                <a class="btn btn--outline-inverse btn--lg" href="#starter-kit">
                    <?php esc_html_e( 'Get the starter kit', 'rolling-reno' ); ?>
                </a>
            </div>
        </div>
    </section>

    <section class="start-here-trust" aria-label="<?php esc_attr_e( 'Why trust this roadmap', 'rolling-reno' ); ?>">
        <div class="container start-here-trust__grid">
            <div>
                <strong><?php esc_html_e( '37+', 'rolling-reno' ); ?></strong>
                <span><?php esc_html_e( 'practical renovation guides', 'rolling-reno' ); ?></span>
            </div>
            <div>
                <strong><?php esc_html_e( 'Safety first', 'rolling-reno' ); ?></strong>
                <span><?php esc_html_e( 'electrical, weight, water, heat, and ventilation before decor', 'rolling-reno' ); ?></span>
            </div>
            <div>
                <strong><?php esc_html_e( 'Real budgets', 'rolling-reno' ); ?></strong>
                <span><?php esc_html_e( 'trade-offs, mistakes, and maintenance costs included', 'rolling-reno' ); ?></span>
            </div>
        </div>
    </section>

    <section class="start-here-roadmap" aria-labelledby="roadmap-heading">
        <div class="container">
            <header class="section-header">
                <p class="eyebrow"><?php esc_html_e( 'The roadmap', 'rolling-reno' ); ?></p>
                <h2 id="roadmap-heading" class="section-header__title"><?php esc_html_e( 'Read these paths in order', 'rolling-reno' ); ?></h2>
                <p class="section-header__sub"><?php esc_html_e( 'Skip around if you need to, but this order avoids the expensive rework: planning → vehicle → systems → interior → life on the road.', 'rolling-reno' ); ?></p>
            </header>

            <div class="start-here-roadmap__list">
                <?php foreach ( $steps as $step ) : ?>
                    <article class="start-here-step">
                        <span class="start-here-step__number"><?php echo esc_html( $step['number'] ); ?></span>
                        <div class="start-here-step__body">
                            <h3><?php echo esc_html( $step['title'] ); ?></h3>
                            <p><?php echo esc_html( $step['copy'] ); ?></p>
                            <a href="<?php echo esc_url( $step['link'] ); ?>"><?php echo esc_html( $step['cta'] ); ?> →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if ( $topics ) : ?>
    <section class="blog-pathways start-here-pathways" aria-labelledby="topic-heading">
        <div class="container">
            <div class="blog-pathways__header">
                <p class="eyebrow"><?php esc_html_e( 'Choose your current problem', 'rolling-reno' ); ?></p>
                <h2 id="topic-heading"><?php esc_html_e( 'Jump into the guide hub that matches today’s decision', 'rolling-reno' ); ?></h2>
                <p><?php esc_html_e( 'Every hub groups related guides so you are not bouncing between random posts.', 'rolling-reno' ); ?></p>
            </div>
            <div class="blog-pathways__grid">
                <?php foreach ( $topics as $topic ) :
                    $url = function_exists( 'rr_blog_topic_url' ) ? rr_blog_topic_url( $topic['slug'] ) : '';
                    $url = $url ? $url : home_url( '/blog/' );
                    $card = $hub_cards[ $topic['slug'] ] ?? array( 'eyebrow' => __( 'Read next', 'rolling-reno' ), 'text' => __( 'Browse guides in this topic.', 'rolling-reno' ) );
                ?>
                    <a class="blog-pathway-card" href="<?php echo esc_url( $url ); ?>">
                        <span class="blog-pathway-card__eyebrow"><?php echo esc_html( $card['eyebrow'] ); ?></span>
                        <span class="blog-pathway-card__title"><?php echo esc_html( $topic['label'] ); ?></span>
                        <span class="blog-pathway-card__text"><?php echo esc_html( $card['text'] ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="start-here-featured" aria-labelledby="featured-guides-heading">
        <div class="container">
            <header class="section-header">
                <p class="eyebrow"><?php esc_html_e( 'Beginner-safe first reads', 'rolling-reno' ); ?></p>
                <h2 id="featured-guides-heading" class="section-header__title"><?php esc_html_e( 'Start with these guides', 'rolling-reno' ); ?></h2>
            </header>

            <div class="posts-grid">
                <?php
                $featured = new WP_Query( array(
                    'posts_per_page'      => 6,
                    'ignore_sticky_posts' => true,
                    's'                   => 'guide checklist beginner inspection budget electrical solar insurance',
                ) );

                if ( ! $featured->have_posts() ) {
                    $featured = new WP_Query( array(
                        'posts_per_page'      => 6,
                        'ignore_sticky_posts' => true,
                    ) );
                }

                if ( $featured->have_posts() ) :
                    while ( $featured->have_posts() ) :
                        $featured->the_post();
                        $thumb = function_exists( 'rr_get_post_image_url' ) ? rr_get_post_image_url( get_the_ID(), 'rr-card-sm' ) : get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                ?>
                    <article class="post-card" aria-labelledby="start-post-<?php the_ID(); ?>">
                        <a href="<?php the_permalink(); ?>" class="post-card__image-link" tabindex="-1" aria-hidden="true">
                            <div class="post-card__image-wrap">
                                <?php if ( $thumb ) : ?>
                                    <img class="post-card__image" src="<?php echo esc_url( $thumb ); ?>" alt="" width="480" height="360" loading="lazy">
                                <?php else : ?>
                                    <div class="post-card__image-placeholder" aria-hidden="true">🚐</div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="post-card__body">
                            <div class="post-card__meta">
                                <?php echo function_exists( 'rr_category_badge' ) ? rr_category_badge() : ''; ?>
                                <span class="label-text"><?php echo esc_html( function_exists( 'rr_read_time' ) ? rr_read_time() : __( 'Guide', 'rolling-reno' ) ); ?></span>
                            </div>
                            <h3 class="post-card__title" id="start-post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="post-card__excerpt"><?php echo esc_html( function_exists( 'rr_excerpt' ) ? rr_excerpt( null, 20 ) : get_the_excerpt() ); ?></p>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <section class="cta-banner cta-banner--leadmagnet" id="starter-kit" aria-labelledby="starter-kit-heading">
        <div class="container">
            <div class="cta-banner__inner">
                <div class="cta-banner__text">
                    <h2 class="cta-banner__heading" id="starter-kit-heading"><?php esc_html_e( "Get Mara's Free Van Build Starter Kit", 'rolling-reno' ); ?></h2>
                    <p class="cta-banner__sub"><?php esc_html_e( 'A practical checklist for tools, materials, first costs, and mistakes to avoid before your first build weekend.', 'rolling-reno' ); ?></p>
                </div>
                <form class="cta-banner__form" action="<?php echo esc_url( function_exists( 'rr_newsletter_action' ) ? rr_newsletter_action() : home_url( '/' ) ); ?>" method="POST">
                    <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
                    <?php if ( function_exists( 'rr_newsletter_hidden_fields' ) ) { rr_newsletter_hidden_fields( 'start_here_starter_kit' ); } ?>
                    <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'rolling-reno' ); ?>" required autocomplete="email" class="cta-banner__input" aria-label="<?php esc_attr_e( 'Email address', 'rolling-reno' ); ?>">
                    <button type="submit" class="btn--cta-banner"><?php esc_html_e( 'Send me the kit →', 'rolling-reno' ); ?></button>
                    <p class="cta-banner__fine"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'rolling-reno' ); ?></p>
                </form>
            </div>
        </div>
    </section>
</main>

<?php get_footer();
