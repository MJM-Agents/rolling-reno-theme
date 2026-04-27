<?php
/**
 * Rolling Reno v2 — template-parts/affiliate-card.php
 * Reusable affiliate / product recommendation card component.
 *
 * Supports exact Amazon or direct product URLs, affiliate disclosure,
 * image/alt text, optional best-for/pros/cons metadata, and responsive layout.
 *
 * Usage:
 *   get_template_part( 'template-parts/affiliate-card', null, array(
 *       'image_url'   => '...',
 *       'image_alt'   => '...',
 *       'name'        => 'Renogy 200W Solar Starter Kit',
 *       'verdict'     => 'Used on Build #2...',
 *       'stars'       => '★★★★½',
 *       'stars_label' => '4.5 out of 5 stars',
 *       'shop_url'    => 'https://www.amazon.com/dp/...',
 *       'shop_label'  => 'Shop on Amazon →',
 *       'badge'       => 'Solar & Power',
 *       'price'       => '$$',
 *       'best_for'    => 'First-time electrical builds',
 *       'pros'        => array( 'Clean install', 'Solid warranty' ),
 *       'cons'        => array( 'Panels need roof space' ),
 *       'placeholder' => '☀️',
 *   ) );
 */

$args = isset( $args ) ? $args : array();

$image_url     = isset( $args['image_url'] ) ? $args['image_url'] : '';
$image_alt     = isset( $args['image_alt'] ) ? $args['image_alt'] : '';
$name          = isset( $args['name'] ) ? $args['name'] : '';
$verdict       = isset( $args['verdict'] ) ? $args['verdict'] : '';
$stars         = isset( $args['stars'] ) ? $args['stars'] : '★★★★★';
$stars_label   = isset( $args['stars_label'] ) ? $args['stars_label'] : '5 out of 5 stars';
$shop_url      = isset( $args['shop_url'] ) ? $args['shop_url'] : '#';
$badge         = isset( $args['badge'] ) ? $args['badge'] : __( 'Mara Recommends', 'rolling-reno' );
$price         = isset( $args['price'] ) ? $args['price'] : '';
$best_for      = isset( $args['best_for'] ) ? $args['best_for'] : '';
$pros          = ! empty( $args['pros'] ) && is_array( $args['pros'] ) ? array_filter( $args['pros'] ) : array();
$cons          = ! empty( $args['cons'] ) && is_array( $args['cons'] ) ? array_filter( $args['cons'] ) : array();
$placeholder   = isset( $args['placeholder'] ) ? $args['placeholder'] : '🔧';
$is_amazon_url = function_exists( 'rr_is_amazon_url' ) ? rr_is_amazon_url( $shop_url ) : false;
$has_shop_url  = ! empty( $shop_url ) && '#' !== $shop_url;
$shop_label    = isset( $args['shop_label'] ) ? $args['shop_label'] : ( $is_amazon_url ? __( 'Shop on Amazon →', 'rolling-reno' ) : __( 'View product →', 'rolling-reno' ) );
$cta_context   = $is_amazon_url ? __( 'Amazon affiliate link', 'rolling-reno' ) : __( 'product link', 'rolling-reno' );
?>

<article class="affiliate-card" aria-label="<?php echo esc_attr( sprintf( __( 'Product recommendation: %s', 'rolling-reno' ), $name ) ); ?>">
    <?php if ( $has_shop_url ) : ?>
    <a
        href="<?php echo esc_url( $shop_url ); ?>"
        class="affiliate-card__image-link"
        rel="nofollow sponsored noopener"
        target="_blank"
        aria-label="<?php echo esc_attr( sprintf( __( 'View %1$s (%2$s, opens in new tab)', 'rolling-reno' ), $name, $cta_context ) ); ?>"
    >
    <?php endif; ?>
        <div class="affiliate-card__image-wrap">
            <?php if ( $image_url ) : ?>
                <img
                    src="<?php echo esc_url( $image_url ); ?>"
                    alt="<?php echo esc_attr( $image_alt ? $image_alt : $name ); ?>"
                    width="160"
                    height="160"
                    loading="lazy"
                    class="affiliate-card__image"
                >
            <?php else : ?>
                <div class="affiliate-card__image-placeholder" aria-hidden="true"><?php echo esc_html( $placeholder ); ?></div>
            <?php endif; ?>
        </div>
    <?php if ( $has_shop_url ) : ?>
    </a>
    <?php endif; ?>

    <div class="affiliate-card__body">
        <div class="affiliate-card__header">
            <?php if ( $badge ) : ?>
                <span class="affiliate-card__label label-text"><?php echo esc_html( $badge ); ?></span>
            <?php endif; ?>

            <?php if ( $name ) : ?>
                <h4 class="affiliate-card__name"><?php echo esc_html( $name ); ?></h4>
            <?php endif; ?>

            <div class="affiliate-card__meta">
                <?php if ( $stars ) : ?>
                    <span class="affiliate-card__stars" aria-label="<?php echo esc_attr( $stars_label ); ?>"><?php echo esc_html( $stars ); ?></span>
                <?php endif; ?>
                <?php if ( $price ) : ?>
                    <span class="affiliate-card__price"><?php echo esc_html( $price ); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $best_for ) : ?>
            <p class="affiliate-card__best-for"><strong><?php esc_html_e( 'Best for:', 'rolling-reno' ); ?></strong> <?php echo esc_html( $best_for ); ?></p>
        <?php endif; ?>

        <?php if ( $verdict ) : ?>
            <p class="affiliate-card__verdict"><?php echo esc_html( $verdict ); ?></p>
        <?php endif; ?>

        <?php if ( $pros || $cons ) : ?>
            <div class="affiliate-card__details">
                <?php if ( $pros ) : ?>
                    <div class="affiliate-card__detail-list">
                        <strong><?php esc_html_e( 'Pros', 'rolling-reno' ); ?></strong>
                        <ul>
                            <?php foreach ( $pros as $pro ) : ?>
                                <li><?php echo esc_html( $pro ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ( $cons ) : ?>
                    <div class="affiliate-card__detail-list">
                        <strong><?php esc_html_e( 'Watch-outs', 'rolling-reno' ); ?></strong>
                        <ul>
                            <?php foreach ( $cons as $con ) : ?>
                                <li><?php echo esc_html( $con ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="affiliate-card__footer">
            <?php if ( $has_shop_url ) : ?>
                <a
                    href="<?php echo esc_url( $shop_url ); ?>"
                    class="btn btn--primary btn--sm affiliate-card__cta"
                    rel="nofollow sponsored noopener"
                    target="_blank"
                    aria-label="<?php echo esc_attr( sprintf( __( 'View %1$s (%2$s, opens in new tab)', 'rolling-reno' ), $name, $cta_context ) ); ?>"
                >
                    <?php echo esc_html( $shop_label ); ?>
                </a>
            <?php else : ?>
                <span class="affiliate-card__cta affiliate-card__cta--disabled"><?php esc_html_e( 'Product link coming soon', 'rolling-reno' ); ?></span>
            <?php endif; ?>
        </div>

        <p class="affiliate-card__disclosure">
            <?php esc_html_e( 'As an Amazon Associate, Mara earns from qualifying purchases. Some links may also be affiliate links, at no cost to you.', 'rolling-reno' ); ?>
        </p>
    </div>
</article>
