<?php
/**
 * Rolling Reno v2 — home.php
 * Blog posts index (used when a static front page is set).
 * WordPress loads this template for the "Posts page" (/blog/).
 */

get_header();
?>

<!-- ── Blog Index ────────────────────────────────────────────────────────── -->
<main id="main" role="main" class="blog-index blog-index--professional">
    <div class="container">

        <header class="section-header blog-hero">
            <h1 class="section-header__title"><?php esc_html_e( 'From the Road', 'rolling-reno' ); ?></h1>
            <p class="section-header__sub"><?php esc_html_e( 'Practical renovation guides, real gear calls, and off-grid systems advice — organized so you can find the next decision fast.', 'rolling-reno' ); ?></p>
        </header>

        <?php
        $rr_blog_search = get_search_query();
        $rr_active_category = rr_blog_active_category_slug();
        ?>
        <section class="blog-discovery" aria-labelledby="blog-discovery-heading">
            <div class="blog-discovery__header">
                <h2 id="blog-discovery-heading"><?php esc_html_e( 'Find the right guide', 'rolling-reno' ); ?></h2>
                <p><?php esc_html_e( 'Search by topic or choose a path. Your filters are shareable, so you can save or send the exact guide list.', 'rolling-reno' ); ?></p>
            </div>

            <form class="blog-search" role="search" method="get" action="<?php echo esc_url( rr_blog_index_url() ); ?>">
                <label class="blog-search__label" for="blog-search-input"><?php esc_html_e( 'Search Rolling Reno articles', 'rolling-reno' ); ?></label>
                <div class="blog-search__row">
                    <input
                        id="blog-search-input"
                        class="blog-search__input"
                        type="search"
                        name="s"
                        value="<?php echo esc_attr( $rr_blog_search ); ?>"
                        placeholder="<?php esc_attr_e( 'Try solar, inspection, insurance…', 'rolling-reno' ); ?>"
                    >
                    <?php if ( $rr_active_category ) : ?>
                        <input type="hidden" name="category" value="<?php echo esc_attr( $rr_active_category ); ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn--primary"><?php esc_html_e( 'Search', 'rolling-reno' ); ?></button>
                </div>
            </form>

            <nav class="category-filters blog-category-nav" aria-label="<?php esc_attr_e( 'Filter blog posts by category', 'rolling-reno' ); ?>">
                <a class="category-filter<?php echo $rr_active_category ? '' : ' is-active'; ?>" href="<?php echo esc_url( $rr_blog_search ? add_query_arg( 's', $rr_blog_search, rr_blog_index_url() ) : rr_blog_index_url() ); ?>"<?php echo $rr_active_category ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All Posts', 'rolling-reno' ); ?></a>
                <?php foreach ( rr_blog_nav_topics() as $topic ) :
                    $url = rr_blog_topic_url( $topic['slug'] );
                    if ( ! $url ) {
                        continue;
                    }
                    if ( $rr_blog_search ) {
                        $url = add_query_arg( 's', $rr_blog_search, $url );
                    }
                    $is_active = $rr_active_category === $topic['slug'];
                ?>
                    <a class="category-filter<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $url ); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $topic['label'] ); ?></a>
                <?php endforeach; ?>
            </nav>

            <p class="blog-results-count" role="status" aria-live="polite">
                <?php
                global $wp_query;
                printf(
                    esc_html( _n( '%s article found', '%s articles found', (int) $wp_query->found_posts, 'rolling-reno' ) ),
                    esc_html( number_format_i18n( (int) $wp_query->found_posts ) )
                );
                ?>
            </p>
        </section>

        <section class="blog-pathways" aria-labelledby="blog-pathways-heading">
            <div class="blog-pathways__header">
                <p class="eyebrow"><?php esc_html_e( 'Browse by path', 'rolling-reno' ); ?></p>
                <h2 id="blog-pathways-heading"><?php esc_html_e( 'Start with the part of the build you are actually facing', 'rolling-reno' ); ?></h2>
                <p><?php esc_html_e( 'Rolling Reno is organized around the practical decisions readers make: planning, choosing a rig, systems, interiors, and life on the road.', 'rolling-reno' ); ?></p>
            </div>
            <div class="blog-pathways__grid">
                <?php
                $hub_cards = rr_blog_hub_cards();
                foreach ( rr_blog_nav_topics() as $topic ) :
                    $url = rr_blog_topic_url( $topic['slug'] );
                    if ( ! $url ) {
                        continue;
                    }
                    $card = $hub_cards[ $topic['slug'] ] ?? array( 'eyebrow' => __( 'Read next', 'rolling-reno' ), 'text' => __( 'Browse guides in this topic.', 'rolling-reno' ) );
                ?>
                <a class="blog-pathway-card" href="<?php echo esc_url( $url ); ?>">
                    <span class="blog-pathway-card__eyebrow"><?php echo esc_html( $card['eyebrow'] ); ?></span>
                    <span class="blog-pathway-card__title"><?php echo esc_html( $topic['label'] ); ?></span>
                    <span class="blog-pathway-card__text"><?php echo esc_html( $card['text'] ); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="blog-latest" aria-labelledby="blog-latest-heading">
            <div class="blog-latest__header">
                <p class="eyebrow"><?php esc_html_e( 'Latest field notes', 'rolling-reno' ); ?></p>
                <h2 id="blog-latest-heading"><?php esc_html_e( 'Fresh guides from the road', 'rolling-reno' ); ?></h2>
            </div>
            <div class="posts-grid blog-posts-grid">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    $thumb = rr_get_post_image_url( get_the_ID(), 'rr-card-sm' );
            ?>
            <article class="post-card" aria-labelledby="post-<?php the_ID(); ?>-title" <?php post_class(); ?>>
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
                    <h2 class="post-card__title" id="post-<?php the_ID(); ?>-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="post-card__date caption"><?php echo get_the_date(); ?></p>
                    <p class="post-card__excerpt"><?php echo esc_html( rr_excerpt( null, 20 ) ); ?></p>
                </div>
            </article>
            <?php
                endwhile;
            else : ?>
                <p><?php esc_html_e( 'No posts yet — check back soon.', 'rolling-reno' ); ?></p>
            <?php endif; ?>
            </div>
        </section>

        <section class="cta-banner cta-banner--leadmagnet" id="newsletter" aria-labelledby="blog-newsletter-heading">
            <div class="cta-banner__inner">
                <div class="cta-banner__text">
                    <h2 class="cta-banner__heading" id="blog-newsletter-heading">
                        <?php esc_html_e( "Get Mara's Free Van Build Starter Kit", 'rolling-reno' ); ?>
                    </h2>
                    <p class="cta-banner__sub">
                        <?php esc_html_e( 'The exact checklist from Build #1 — tools, materials, costs, mistakes to avoid. Start your own conversion with fewer surprises.', 'rolling-reno' ); ?>
                    </p>
                </div>
                <form class="cta-banner__form" action="<?php echo rr_newsletter_action(); ?>" method="POST">
                    <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
                    <?php rr_newsletter_hidden_fields( 'blog_lead_magnet' ); ?>
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

        <?php the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => '← ' . __( 'Newer posts', 'rolling-reno' ),
            'next_text' => __( 'Older posts', 'rolling-reno' ) . ' →',
        ) ); ?>

    </div>
</main>

<?php get_footer(); ?>
