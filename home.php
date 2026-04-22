<?php
/**
 * Rolling Reno v2 — home.php
 * Blog posts index (used when a static front page is set).
 * WordPress loads this template for the "Posts page" (/blog/).
 */

get_header();
?>

<!-- ── Blog Index ────────────────────────────────────────────────────────── -->
<main id="main" role="main" class="blog-index" style="margin-top: 72px; padding: var(--space-20) 0;">
    <div class="container">

        <header class="section-header" style="margin-bottom: var(--space-12);">
            <h1 class="section-header__title"><?php esc_html_e( 'From the Road', 'rolling-reno' ); ?></h1>
            <p class="section-header__sub"><?php esc_html_e( 'Stories, guides, and gear from Mara Collins.', 'rolling-reno' ); ?></p>
        </header>

        <div class="posts-grid">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'rr-card-sm' );
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

        <?php the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => '← ' . __( 'Newer posts', 'rolling-reno' ),
            'next_text' => __( 'Older posts', 'rolling-reno' ) . ' →',
        ) ); ?>

    </div>
</main>

<?php get_footer(); ?>
