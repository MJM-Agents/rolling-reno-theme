<?php
/**
 * Rolling Reno v2 — template-parts/affiliate-card.php
 * Reusable affiliate product card component
 *
 * Usage:
 *   get_template_part( 'template-parts/affiliate-card', null, array(
 *       'image_url'   => '...',
 *       'image_alt'   => '...',
 *       'name'        => 'Renogy 200W Solar Starter Kit',
 *       'verdict'     => '"Used on Build #2..."',
 *       'stars'       => '★★★★½',
 *       'stars_label' => '4.5 out of 5 stars',
 *       'shop_url'    => 'https://amazon.com/...',
 *       'shop_label'  => 'Shop on Amazon →',
 *   ) );
 *
 * Or with ACF/post meta — adapt as needed.
 */

$args = isset( $args ) ? $args : array();

$image_url   = isset( $args['image_url'] )   ? $args['image_url']   : '';
$image_alt   = isset( $args['image_alt'] )   ? $args['image_alt']   : '';
$name        = isset( $args['name'] )        ? $args['name']        : '';
$verdict     = isset( $args['verdict'] )     ? $args['verdict']     : '';
$stars       = isset( $args['stars'] )       ? $args['stars']       : '★★★★★';
$stars_label = isset( $args['stars_label'] ) ? $args['stars_label'] : '5 out of 5 stars';
$shop_url    = isset( $args['shop_url'] )    ? $args['shop_url']    : '#';
$shop_label  = isset( $args['shop_label'] )  ? $args['shop_label']  : __( 'Shop on Amazon →', 'rolling-reno' );
?>

<div class="affiliate-card" aria-label="<?php esc_attr_e( 'Product recommendation', 'rolling-reno' ); ?>">

    <div class="affiliate-card__image-wrap">
        <?php if ( $image_url ) : ?>
            <img
                src="<?php echo esc_url( $image_url ); ?>"
                alt="<?php echo esc_attr( $image_alt ); ?>"
                width="160"
                height="160"
                loading="lazy"
                class="affiliate-card__image"
            >
        <?php else : ?>
            <!-- Placeholder until product imagery is sourced -->
            <div class="affiliate-card__image-placeholder" aria-hidden="true">🔧</div>
        <?php endif; ?>
    </div>

    <div class="affiliate-card__body">
        <span class="affiliate-card__label label-text">
            <?php esc_html_e( 'Mara Recommends', 'rolling-reno' ); ?>
        </span>

        <?php if ( $name ) : ?>
            <h4 class="affiliate-card__name"><?php echo esc_html( $name ); ?></h4>
        <?php endif; ?>

        <?php if ( $verdict ) : ?>
            <p class="affiliate-card__verdict"><?php echo esc_html( $verdict ); ?></p>
        <?php endif; ?>

        <div class="affiliate-card__footer">
            <div class="affiliate-card__stars" aria-label="<?php echo esc_attr( $stars_label ); ?>">
                <?php echo esc_html( $stars ); ?>
            </div>

            <?php if ( $shop_url && $shop_url !== '#' ) : ?>
                <a
                    href="<?php echo esc_url( $shop_url ); ?>"
                    class="btn btn--primary btn--sm"
                    rel="nofollow sponsored"
                    target="_blank"
                    aria-label="<?php echo esc_attr( sprintf( __( 'Shop %s on Amazon (affiliate link, opens in new tab)', 'rolling-reno' ), $name ) ); ?>"
                >
                    <?php echo esc_html( $shop_label ); ?>
                </a>
            <?php endif; ?>
        </div>

        <p class="affiliate-card__disclosure">
            <?php esc_html_e( '*Affiliate link — Mara earns a small commission at no cost to you.', 'rolling-reno' ); ?>
        </p>
    </div>

</div>
