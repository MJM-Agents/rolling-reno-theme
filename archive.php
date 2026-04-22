<?php
/**
 * Rolling Reno v2 — archive.php
 * Category / archive hub page — spec: category-page-v2.md
 */

get_header();

$queried_obj  = get_queried_object();
$is_category  = is_category();
$term_name    = $is_category ? single_cat_title( '', false ) : get_the_archive_title();
$term_desc    = $is_category ? category_description() : get_the_archive_description();
$post_count   = $is_category ? $queried_obj->count : false;

// Category-specific config
$cat_config = array(
    'van-life'    => array( 'sub' => 'Guides, conversion diaries, and life on the road — from Ireland and beyond.', 'img_key' => 'rr_cat_img_van_life' ),
    'rv-life'     => array( 'sub' => 'RV adventures, trip guides, and everything Mara has learned on the road.', 'img_key' => 'rr_cat_img_rv_life' ),
    'gear'        => array( 'sub' => 'Tested, trusted gear — every recommendation backed by real-world use.', 'img_key' => 'rr_cat_img_gear' ),
);

$slug        = $is_category ? $queried_obj->slug : '';
$cat_info    = isset( $cat_config[ $slug ] ) ? $cat_config[ $slug ] : array( 'sub' => $term_desc, 'img_key' => '' );
$hero_img    = $cat_info['img_key'] ? get_theme_mod( $cat_info['img_key'], '' ) : '';
$cat_sub     = $cat_info['sub'];
?>

<main id="main" role="main">

    <!-- Category Hero -->
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
                <span><?php echo esc_html( $term_name ); ?></span>
            </nav>
            <h1 class="category-hero__title"><?php echo esc_html( $term_name ); ?></h1>
            <?php if ( $cat_sub ) : ?>
                <p class="category-hero__sub"><?php echo esc_html( $cat_sub ); ?></p>
            <?php endif; ?>
            <?php if ( $post_count ) : ?>
                <p class="category-hero__count">
                    <?php echo esc_html( sprintf( _n( '%d post in this category', '%d posts in this category', $post_count, 'rolling-reno' ), $post_count ) ); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Category Intro Block -->
    <div class="container">
        <div class="category-intro">
            <?php if ( $term_desc ) : ?>
                <p class="category-intro__text"><?php echo wp_kses_post( $term_desc ); ?></p>
            <?php endif; ?>
            <?php
            // Sub-category filter links (child categories)
            if ( $is_category ) :
                $child_cats = get_categories( array(
                    'parent'  => $queried_obj->term_id,
                    'hide_empty' => true,
                ) );
                if ( $child_cats ) : ?>
            <div class="category-filters" role="list">
                <a href="<?php echo esc_url( get_category_link( $queried_obj->term_id ) ); ?>" class="category-filter is-active" aria-current="page" role="listitem">
                    <?php esc_html_e( 'All', 'rolling-reno' ); ?>
                </a>
                <?php foreach ( $child_cats as $child ) : ?>
                <a href="<?php echo esc_url( get_category_link( $child->term_id ) ); ?>" class="category-filter" role="listitem">
                    <?php echo esc_html( $child->name ); ?>
                </a>
                <?php endforeach; ?>
            </div>
                <?php endif;
            endif; ?>
        </div>
    </div>

    <!-- Pinned / Featured Post -->
    <?php
    $pinned_query = new WP_Query( array(
        'posts_per_page' => 1,
        'cat'            => $is_category ? $queried_obj->term_id : 0,
        'meta_key'       => '_rr_pinned',
        'meta_value'     => '1',
    ) );
    if ( ! $pinned_query->have_posts() ) {
        $pinned_query = new WP_Query( array(
            'posts_per_page' => 1,
            'cat'            => $is_category ? $queried_obj->term_id : 0,
            'orderby'        => 'comment_count',
        ) );
    }
    if ( $pinned_query->have_posts() ) :
        $pinned_query->the_post();
        $p_thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card' );
    ?>
    <div class="container">
        <div class="pinned-post">
            <span class="pinned-post__label"><?php esc_html_e( 'START HERE', 'rolling-reno' ); ?></span>
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
                        <span class="badge badge--pinned">📌 <?php esc_html_e( 'Pinned', 'rolling-reno' ); ?></span>
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
        </div>
    </div>
    <?php
    endif;
    wp_reset_postdata();
    ?>

    <!-- Posts Grid -->
    <div class="container">
        <div class="category-posts">
            <div class="category-posts__header">
                <h2 class="category-posts__heading"><?php esc_html_e( 'All Posts', 'rolling-reno' ); ?></h2>
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

            <section class="category-posts__grid" aria-label="<?php echo esc_attr( sprintf( __( 'Posts in %s', 'rolling-reno' ), $term_name ) ); ?>">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        $a_thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card-sm' );
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
                    <p><?php esc_html_e( 'No posts found.', 'rolling-reno' ); ?></p>
                <?php endif; ?>
            </section>

            <!-- Pagination -->
            <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
            <nav class="category-posts__pagination" aria-label="<?php esc_attr_e( 'Post navigation', 'rolling-reno' ); ?>">
                <?php
                $pages = paginate_links( array(
                    'type'      => 'array',
                    'prev_text' => '← ' . __( 'Prev', 'rolling-reno' ),
                    'next_text' => __( 'Next', 'rolling-reno' ) . ' →',
                ) );
                if ( $pages ) :
                    foreach ( $pages as $page ) :
                        $is_current = str_contains( $page, 'current' );
                        // Wrap in nav link
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

        </div><!-- /.category-posts -->
    </div><!-- /.container -->

    <!-- Category Lead Magnet (van-life + gear only) -->
    <?php if ( in_array( $slug, array( 'van-life', 'gear' ) ) ) : ?>
    <section class="cta-banner cta-banner--leadmagnet" aria-labelledby="cat-leadmagnet-heading">
        <div class="cta-banner__inner container">
            <div class="cta-banner__text">
                <h2 class="cta-banner__heading" id="cat-leadmagnet-heading">
                    <?php
                    if ( $slug === 'van-life' ) {
                        esc_html_e( "Van lifer? Get Mara's free Conversion Checklist.", 'rolling-reno' );
                    } else {
                        esc_html_e( "Want Mara's gear buying checklist?", 'rolling-reno' );
                    }
                    ?>
                </h2>
                <p class="cta-banner__sub">
                    <?php esc_html_e( "Before your first build, read this. It's free, and it'll save you hundreds.", 'rolling-reno' ); ?>
                </p>
            </div>
            <form class="cta-banner__form" action="<?php echo rr_newsletter_action(); ?>" method="POST">
                <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
                <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'rolling-reno' ); ?>" required autocomplete="email" class="cta-banner__input" aria-label="<?php esc_attr_e( 'Email address', 'rolling-reno' ); ?>">
                <button type="submit" class="btn--cta-banner"><?php esc_html_e( 'Send me the kit →', 'rolling-reno' ); ?></button>
                <p class="cta-banner__fine"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'rolling-reno' ); ?></p>
            </form>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
