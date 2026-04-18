<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="featured-image"><?php the_post_thumbnail( 'large' ); ?></div>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
