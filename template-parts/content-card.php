<?php
/**
 * Rolling Reno v2 — template-parts/content-card.php
 * Blog/archive post card shared by server and infinite-scroll responses.
 */

$thumb     = rr_get_post_image_url( get_the_ID(), 'rr-card-sm' );
$thumb_alt = rr_get_post_image_alt( get_the_ID() );
?>
<article class="post-card" aria-labelledby="post-<?php the_ID(); ?>-title" <?php post_class(); ?> data-post-id="<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="post-card__image-link" tabindex="-1" aria-hidden="true">
        <div class="post-card__image-wrap">
            <?php if ( $thumb ) : ?>
                <img
                    class="post-card__image"
                    src="<?php echo esc_url( $thumb ); ?>"
                    alt="<?php echo esc_attr( $thumb_alt ); ?>"
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
