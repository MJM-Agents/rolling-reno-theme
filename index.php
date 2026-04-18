<?php get_header(); ?>

<main id="main" class="site-main">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content' ); ?>
    <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e( 'No posts found.', 'rolling-reno' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
