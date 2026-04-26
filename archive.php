<?php
/**
 * Rolling Reno v2 — archive.php
 * Crawlable category hub page — spec: category-page-v2.md
 */

get_header();

$queried_obj = get_queried_object();
$is_category = is_category();
$slug        = ( $is_category && isset( $queried_obj->slug ) ) ? $queried_obj->slug : '';
$hub_config  = function_exists( 'rr_category_hub_config_for_slug' ) ? rr_category_hub_config_for_slug( $slug ) : array();
$term_name   = $is_category ? single_cat_title( '', false ) : get_the_archive_title();
$term_desc   = $hub_config['intro'] ?? ( $is_category ? wp_strip_all_tags( category_description() ) : wp_strip_all_tags( get_the_archive_description() ) );
$post_count  = ( $is_category && isset( $queried_obj->count ) ) ? (int) $queried_obj->count : false;
$hero_img    = ! empty( $hub_config['img_key'] ) ? get_theme_mod( $hub_config['img_key'], '' ) : '';
$cat_sub     = $hub_config['sub'] ?? $term_desc;
$featured_slugs = $hub_config['featured_slugs'] ?? array();
?>

<main id="main" role="main">

    <section class="category-hero" aria-label="<?php echo esc_attr( $term_name ); ?>">
        <?php if ( $hero_img ) : ?>
            <img
                class="category-hero__image"
                src="<?php echo esc_url( $hero_img ); ?>"
                alt=""
                width="1920"
                height="1152"
                loading="eager"
                fetchpriority="high"
                aria-hidden="true"
            >
        <?php else : ?>
            <div class="category-hero__placeholder" aria-hidden="true"></div>
        <?php endif; ?>
        <div class="category-hero__overlay" aria-hidden="true"></div>
        <div class="category-hero__content container">
            <nav class="category-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rolling-reno' ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rolling-reno' ); ?></a>
                <span aria-hidden="true"> › </span>
                <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'rolling-reno' ); ?></a>
                <span aria-hidden="true"> › </span>
                <span><?php echo esc_html( $term_name ); ?></span>
            </nav>
            <h1 class="category-hero__title"><?php echo esc_html( $term_name ); ?></h1>
            <?php if ( $cat_sub ) : ?>
                <p class="category-hero__sub"><?php echo esc_html( $cat_sub ); ?></p>
            <?php endif; ?>
            <?php if ( $post_count ) : ?>
                <p class="category-hero__count">
                    <?php echo esc_html( sprintf( _n( '%d guide in this hub', '%d guides in this hub', $post_count, 'rolling-reno' ), $post_count ) ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <div class="container">
        <div class="category-intro">
            <?php if ( $term_desc ) : ?>
                <p class="category-intro__text"><?php echo esc_html( $term_desc ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $hub_config['next_steps'] ) ) : ?>
                <div class="category-filters" role="list" aria-label="<?php esc_attr_e( 'Recommended next steps', 'rolling-reno' ); ?>">
                    <?php foreach ( $hub_config['next_steps'] as $next_step ) : ?>
                        <a href="<?php echo esc_url( home_url( $next_step['url'] ) ); ?>" class="category-filter" role="listitem">
                            <?php echo esc_html( $next_step['label'] ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $featured_query_args = array(
        'posts_per_page'      => $featured_slugs ? min( 3, count( $featured_slugs ) ) : 1,
        'ignore_sticky_posts' => true,
    );

    if ( $featured_slugs ) {
        $featured_query_args['post_name__in'] = $featured_slugs;
        $featured_query_args['orderby']       = 'post_name__in';
    } elseif ( $is_category ) {
        $featured_query_args['cat']     = $queried_obj->term_id;
        $featured_query_args['orderby'] = 'comment_count';
    }

    $featured_query = new WP_Query( $featured_query_args );
    if ( $featured_query->have_posts() ) :
    ?>
    <div class="container">
        <div class="pinned-post">
            <span class="pinned-post__label"><?php esc_html_e( 'BEST PLACE TO START', 'rolling-reno' ); ?></span>
            <?php
            while ( $featured_query->have_posts() ) :
                $featured_query->the_post();
                $p_thumb = rr_get_post_image_url( get_the_ID(), 'rr-card' );
            ?>
            <article class="featured-card" aria-labelledby="pinned-title-<?php the_ID(); ?>">
                <div class="featured-card__image-wrap">
                    <?php if ( $p_thumb ) : ?>
                        <img
                            src="<?php echo esc_url( $p_thumb ); ?>"
                            alt="<?php the_title_attribute(); ?>"
                            width="900"
                            height="600"
                            loading="lazy"
                            class="featured-card__image"
                        >
                    <?php else : ?>
                        <div class="featured-card__image-placeholder" aria-hidden="true">🚐</div>
                    <?php endif; ?>
                </div>
                <div class="featured-card__body">
                    <div class="featured-card__meta">
                        <?php echo rr_category_badge(); ?>
                        <span class="badge badge--pinned">📌 <?php esc_html_e( 'Hub pick', 'rolling-reno' ); ?></span>
                        <span class="label-text"><?php echo esc_html( rr_read_time() ); ?></span>
                    </div>
                    <h2 class="featured-card__title" id="pinned-title-<?php the_ID(); ?>">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="featured-card__excerpt"><?php echo esc_html( rr_excerpt( null, 25 ) ); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn--primary">
                        <?php esc_html_e( 'Read the guide →', 'rolling-reno' ); ?>
                    </a>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    endif;
    wp_reset_postdata();
    ?>

    <div class="container">
        <div class="category-posts">
            <div class="category-posts__header">
                <h2 class="category-posts__heading"><?php esc_html_e( 'All Guides', 'rolling-reno' ); ?></h2>
                <div class="category-posts__sort">
                    <span><?php esc_html_e( 'Sort by:', 'rolling-reno' ); ?></span>
                    <a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', get_pagenum_link() ) ); ?>" class="is-active">
                        <?php esc_html_e( 'Latest', 'rolling-reno' ); ?>
                    </a>
                    <a href="<?php echo esc_url( add_query_arg( 'orderby', 'comment_count', get_pagenum_link() ) ); ?>">
                        <?php esc_html_e( 'Popular', 'rolling-reno' ); ?>
                    </a>
                </div>
            </div>

            <section class="category-posts__grid" aria-label="<?php echo esc_attr( sprintf( __( 'Guides in %s', 'rolling-reno' ), $term_name ) ); ?>">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        $a_thumb = rr_get_post_image_url( get_the_ID(), 'rr-card-sm' );
                ?>
                <article class="post-card" aria-labelledby="archive-post-<?php the_ID(); ?>">
                    <a href="<?php the_permalink(); ?>" class="post-card__image-link" tabindex="-1" aria-hidden="true">
                        <div class="post-card__image-wrap">
                            <?php if ( $a_thumb ) : ?>
                                <img class="post-card__image" src="<?php echo esc_url( $a_thumb ); ?>" alt="" width="480" height="360" loading="lazy">
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
                        <h3 class="post-card__title" id="archive-post-<?php the_ID(); ?>">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="post-card__date caption"><?php echo get_the_date(); ?></p>
                    </div>
                </article>
                <?php
                    endwhile;
                else : ?>
                    <p><?php esc_html_e( 'No guides found.', 'rolling-reno' ); ?></p>
                <?php endif; ?>
            </section>

            <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
            <nav class="category-posts__pagination" aria-label="<?php esc_attr_e( 'Guide navigation', 'rolling-reno' ); ?>">
                <?php
                $pages = paginate_links( array(
                    'type'      => 'array',
                    'prev_text' => '← ' . __( 'Prev', 'rolling-reno' ),
                    'next_text' => __( 'Next', 'rolling-reno' ) . ' →',
                ) );
                if ( $pages ) :
                    foreach ( $pages as $page ) :
                        echo str_replace(
                            array( 'page-numbers', 'prev page-numbers', 'next page-numbers', 'current' ),
                            array( 'pagination__item', 'pagination__item pagination__item--prev', 'pagination__item pagination__item--next', 'pagination__item is-current' ),
                            $page
                        );
                    endforeach;
                endif;
                ?>
            </nav>
            <?php endif; ?>

        </div>
    </div>

    <?php if ( ! empty( $hub_config['cta'] ) ) : ?>
    <section class="cta-banner cta-banner--leadmagnet" aria-labelledby="cat-leadmagnet-heading">
        <div class="cta-banner__inner container">
            <div class="cta-banner__text">
                <h2 class="cta-banner__heading" id="cat-leadmagnet-heading"><?php echo esc_html( $hub_config['cta']['heading'] ); ?></h2>
                <p class="cta-banner__sub"><?php echo esc_html( $hub_config['cta']['text'] ); ?></p>
            </div>
            <form class="cta-banner__form" action="<?php echo rr_newsletter_action(); ?>" method="POST">
                <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
                <?php rr_newsletter_hidden_fields( 'category_archive_cta' ); ?>
                <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'rolling-reno' ); ?>" required autocomplete="email" class="cta-banner__input" aria-label="<?php esc_attr_e( 'Email address', 'rolling-reno' ); ?>">
                <button type="submit" class="btn--cta-banner"><?php echo esc_html( $hub_config['cta']['label'] ); ?></button>
                <p class="cta-banner__fine"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'rolling-reno' ); ?></p>
            </form>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
