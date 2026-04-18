<?php
/**
 * Rolling Reno v2 — index.php
 * Fallback template. WordPress requires this file.
 * For posts/archive use home.php. For pages use appropriate template.
 */
get_header();
?>

<main id="main" role="main" style="margin-top: 72px; padding: var(--space-20) 0;">
    <div class="container--narrow">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
        ?>
        <article <?php post_class(); ?> aria-labelledby="index-post-<?php the_ID(); ?>">
            <h2 id="index-post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="post-body" style="max-width: 100%; padding: 0;">
                <?php the_excerpt(); ?>
            </div>
        </article>
        <?php
            endwhile;
            the_posts_pagination();
        else :
            get_template_part( '404' );
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
