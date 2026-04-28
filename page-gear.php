<?php
/**
 * Template Name: Gear & Resources
 * Rolling Reno v2 — page-gear.php
 * Spec: affiliate-gear-page-v2.md
 */

get_header();
?>

<main id="main" role="main">

    <!-- Page Header -->
    <div class="gear-header">
        <div class="container">
            <div class="gear-header__inner">
                <?php rr_breadcrumb(); ?>
                <h1 class="gear-header__title">
                    <?php esc_html_e( 'Gear I Actually Use — and Trust', 'rolling-reno' ); ?>
                </h1>
                <p class="gear-header__sub">
                    <?php esc_html_e( 'After 3 van builds and 40,000km on the road, here\'s what earned a permanent place in Mara\'s kit.', 'rolling-reno' ); ?>
                </p>
                <p class="gear-header__disclosure">
                    <?php esc_html_e( 'As an Amazon Associate, Mara earns from qualifying purchases. Some links may also be affiliate links, at no cost to you. She only recommends gear she\'s actually used.', 'rolling-reno' ); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Tabs (sticky below nav) -->
    <div class="gear-tabs" role="navigation" aria-label="<?php esc_attr_e( 'Gear categories', 'rolling-reno' ); ?>">
        <div class="container">
            <div class="gear-tabs__list" role="tablist">
                <a href="#all"          class="gear-tab is-active" role="tab" aria-selected="true"  id="tab-all">          <?php esc_html_e( 'All',            'rolling-reno' ); ?></a>
                <a href="#solar-power"  class="gear-tab"           role="tab" aria-selected="false" id="tab-solar">        <?php esc_html_e( 'Solar & Power',  'rolling-reno' ); ?></a>
                <a href="#kitchen"      class="gear-tab"           role="tab" aria-selected="false" id="tab-kitchen">      <?php esc_html_e( 'Kitchen',        'rolling-reno' ); ?></a>
                <a href="#sleeping"     class="gear-tab"           role="tab" aria-selected="false" id="tab-sleeping">     <?php esc_html_e( 'Sleeping',       'rolling-reno' ); ?></a>
                <a href="#insulation"   class="gear-tab"           role="tab" aria-selected="false" id="tab-insulation">   <?php esc_html_e( 'Insulation',     'rolling-reno' ); ?></a>
                <a href="#tools-build"  class="gear-tab"           role="tab" aria-selected="false" id="tab-tools">        <?php esc_html_e( 'Tools & Build',  'rolling-reno' ); ?></a>
                <a href="#safety"       class="gear-tab"           role="tab" aria-selected="false" id="tab-safety">       <?php esc_html_e( 'Safety',         'rolling-reno' ); ?></a>
                <a href="#connectivity" class="gear-tab"           role="tab" aria-selected="false" id="tab-connectivity"> <?php esc_html_e( 'Connectivity',    'rolling-reno' ); ?></a>
                <a href="#clothing"     class="gear-tab"           role="tab" aria-selected="false" id="tab-clothing">     <?php esc_html_e( 'Clothing',       'rolling-reno' ); ?></a>
            </div>
        </div>
    </div>

    <!-- Gear Sections -->
    <div class="container" id="all">

        <?php
        $gear_sections = array(
            array(
                'id'     => 'solar-power',
                'icon'   => '⚡',
                'title'  => __( 'Solar & Power', 'rolling-reno' ),
                'intro'  => __( 'Getting your power setup right is the difference between van life and camping. Here\'s what I\'ve tested and what I\'d buy again.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => 'Renogy 200W Monocrystalline Solar Starter Kit',
                        'verdict'     => '"Used this on Build #2 — clean installation, solid warranty, and exactly enough capacity for a solo or couple van. First recommendation for anyone starting out."',
                        'stars'       => '★★★★½',
                        'stars_label' => '4.5 out of 5 stars',
                        'price'       => '$$',
                        'emoji'       => '☀️',
                        'shop_url'    => 'https://www.amazon.com/s?k=Renogy+200W+Monocrystalline+Solar+Starter+Kit&tag=rollingreno-20',
                        'badge'       => __( 'Solar & Power', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'BougeRV 40A MPPT Solar Charge Controller',
                        'verdict'     => '"Upgraded from a PWM on Build #2 and wished I\'d done it on Build #1. Better efficiency, better battery care."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$',
                        'emoji'       => '⚡',
                        'shop_url'    => 'https://www.amazon.com/s?k=BougeRV+40A+MPPT+Solar+Charge+Controller&tag=rollingreno-20',
                        'badge'       => __( 'Solar & Power', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'Lithium Iron Phosphate 100Ah Battery',
                        'verdict'     => '"The single biggest quality-of-life upgrade from Build #1 to Build #2. Lithium over AGM, every time."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$$',
                        'emoji'       => '🔋',
                        'shop_url'    => 'https://www.amazon.com/s?k=Lithium+Iron+Phosphate+100Ah+Battery&tag=rollingreno-20',
                        'badge'       => __( 'Solar & Power', 'rolling-reno' ),
                    ),
                ),
            ),
            array(
                'id'     => 'kitchen',
                'icon'   => '🍳',
                'title'  => __( 'Kitchen & Food', 'rolling-reno' ),
                'intro'  => __( 'The kitchen is where you spend 30% of your van time. Don\'t cheap out.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => 'Dometic CFX3 25L Compressor Fridge',
                        'verdict'     => '"Changed everything about how I eat on the road. More efficient than it looks. Worth every cent."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$$',
                        'emoji'       => '🧊',
                        'shop_url'    => 'https://www.amazon.com/s?k=Dometic+CFX3+25L+Compressor+Fridge&tag=rollingreno-20',
                        'badge'       => __( 'Kitchen', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'Campingaz Double Burner Camp Stove',
                        'verdict'     => '"Reliable, easy to clean, and uses standard Campingaz cartridges you can find all over Ireland and Europe."',
                        'stars'       => '★★★★',
                        'stars_label' => '4 out of 5 stars',
                        'price'       => '$',
                        'emoji'       => '🔥',
                        'shop_url'    => 'https://www.amazon.com/s?k=Campingaz+Double+Burner+Camp+Stove&tag=rollingreno-20',
                        'badge'       => __( 'Kitchen', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'Aeropress Coffee Maker',
                        'verdict'     => '"Non-negotiable. The best coffee you can make in a van, in under 3 minutes, with no counter space."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$',
                        'emoji'       => '☕',
                        'shop_url'    => 'https://www.amazon.com/s?k=Aeropress+Coffee+Maker&tag=rollingreno-20',
                        'badge'       => __( 'Kitchen', 'rolling-reno' ),
                    ),
                ),
            ),
            array(
                'id'     => 'sleeping',
                'icon'   => '🛏',
                'title'  => __( 'Sleeping & Comfort', 'rolling-reno' ),
                'intro'  => __( 'Sleep is everything. I went through three mattress configs before I got it right.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => 'Rock&Road 100% Natural Latex Van Mattress',
                        'verdict'     => '"Had two cheap foam mattresses before this. This is a different category entirely. No regrets."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$$',
                        'emoji'       => '🛏',
                        'shop_url'    => 'https://www.amazon.com/s?k=Rock%26Road+100%25+Natural+Latex+Van+Mattress&tag=rollingreno-20',
                        'badge'       => __( 'Sleeping', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'Sea to Summit Reactor Extreme Sleeping Bag Liner',
                        'verdict'     => '"Adds 10°C to any sleeping bag rating. Use it in summer alone. Packs to nothing."',
                        'stars'       => '★★★★½',
                        'stars_label' => '4.5 out of 5 stars',
                        'price'       => '$$',
                        'emoji'       => '🌙',
                        'shop_url'    => 'https://www.amazon.com/s?k=Sea+to+Summit+Reactor+Extreme+Sleeping+Bag+Liner&tag=rollingreno-20',
                        'badge'       => __( 'Sleeping', 'rolling-reno' ),
                    ),
                ),
            ),
            array(
                'id'     => 'insulation',
                'icon'   => '🌡️',
                'title'  => __( 'Insulation & Climate', 'rolling-reno' ),
                'intro'  => __( 'Insulation is boring until 3am in January in Connemara. Then it\'s everything.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => '3M Thinsulate SM600L Automotive Insulation',
                        'verdict'     => '"The only van insulation I recommend now. More effective per mm than any foam. Not even close."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$',
                        'emoji'       => '🌡️',
                        'shop_url'    => 'https://www.amazon.com/s?k=3M+Thinsulate+SM600L+Automotive+Insulation&tag=rollingreno-20',
                        'badge'       => __( 'Insulation', 'rolling-reno' ),
                    ),
                    array(
                        'name'        => 'Webasto Air Top 2000 STC Diesel Heater',
                        'verdict'     => '"The reason I survived three Irish winters in a van. Not optional if you\'re doing winter camping."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$$$',
                        'emoji'       => '🔥',
                        'shop_url'    => 'https://www.amazon.com/s?k=Webasto+Air+Top+2000+STC+Diesel+Heater&tag=rollingreno-20',
                        'badge'       => __( 'Insulation', 'rolling-reno' ),
                    ),
                ),
            ),
            array(
                'id'     => 'safety',
                'icon'   => '🛡️',
                'title'  => __( 'Safety & Emergency', 'rolling-reno' ),
                'intro'  => __( 'Carbon monoxide detectors are not optional. I don\'t care how much they cost.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => 'Kidde KN-COPP-3 Carbon Monoxide Detector',
                        'verdict'     => '"First thing I install in every build. Non-negotiable. Full stop."',
                        'stars'       => '★★★★★',
                        'stars_label' => '5 out of 5 stars',
                        'price'       => '$',
                        'emoji'       => '🛡️',
                        'shop_url'    => 'https://www.amazon.com/s?k=Kidde+KN-COPP-3+Carbon+Monoxide+Detector&tag=rollingreno-20',
                        'badge'       => __( 'Safety', 'rolling-reno' ),
                    ),
                ),
            ),
            array(
                'id'     => 'connectivity',
                'icon'   => '📡',
                'title'  => __( 'Connectivity & Work', 'rolling-reno' ),
                'intro'  => __( 'Working from the road is the dream. Here\'s what actually makes it work.', 'rolling-reno' ),
                'products' => array(
                    array(
                        'name'        => 'GL.iNet Slate AX Wi-Fi 6 Travel Router',
                        'verdict'     => '"Turns any mobile connection into a stable Wi-Fi network. Game-changer for remote work."',
                        'stars'       => '★★★★½',
                        'stars_label' => '4.5 out of 5 stars',
                        'price'       => '$$',
                        'emoji'       => '📡',
                        'shop_url'    => 'https://www.amazon.com/s?k=GL.iNet+Slate+AX+Wi-Fi+6+Travel+Router&tag=rollingreno-20',
                        'badge'       => __( 'Connectivity', 'rolling-reno' ),
                    ),
                ),
            ),
        );

        foreach ( $gear_sections as $section ) : ?>

        <section
            class="gear-section"
            id="<?php echo esc_attr( $section['id'] ); ?>"
            aria-labelledby="gear-section-title-<?php echo esc_attr( $section['id'] ); ?>"
        >
            <div class="gear-section__header">
                <span class="gear-section__icon" aria-hidden="true"><?php echo $section['icon']; ?></span>
                <h2 class="gear-section__title" id="gear-section-title-<?php echo esc_attr( $section['id'] ); ?>">
                    <?php echo esc_html( $section['title'] ); ?>
                </h2>
            </div>
            <p class="gear-section__intro"><?php echo esc_html( $section['intro'] ); ?></p>

            <div class="gear-grid">
                <?php foreach ( $section['products'] as $product ) :
                    $asset_shop_url = function_exists( 'rr_featured_gear_asset' ) ? rr_featured_gear_asset( $product['name'], 'url' ) : '';
                    $raw_shop_url   = ! empty( $asset_shop_url ) ? $asset_shop_url : $product['shop_url'];
                    $shop_url       = function_exists( 'rr_affiliate_url' ) ? rr_affiliate_url( $raw_shop_url ) : $raw_shop_url;
                    $image_url      = function_exists( 'rr_featured_gear_asset' ) ? rr_featured_gear_asset( $product['name'], 'image' ) : '';

                    get_template_part( 'template-parts/affiliate-card', null, array(
                        'image_url'   => $image_url,
                        'image_alt'   => $product['name'],
                        'name'        => $product['name'],
                        'verdict'     => $product['verdict'],
                        'stars'       => $product['stars'],
                        'stars_label' => $product['stars_label'],
                        'price'       => $product['price'],
                        'shop_url'    => $shop_url,
                        'shop_label'  => function_exists( 'rr_is_amazon_url' ) && rr_is_amazon_url( $shop_url ) ? __( 'Shop on Amazon →', 'rolling-reno' ) : __( 'View product →', 'rolling-reno' ),
                        'badge'       => $product['badge'],
                        'placeholder' => $product['emoji'],
                    ) );
                endforeach; ?>
            </div>
        </section>

        <?php endforeach; ?>

    </div><!-- /#all.container -->

    <!-- "My Builds" Section -->
    <section class="gear-builds" aria-label="<?php esc_attr_e( "Mara's builds", 'rolling-reno' ); ?>">
        <div class="container">
            <div class="gear-builds__header">
                <h2 class="gear-builds__title"><?php esc_html_e( 'The Builds', 'rolling-reno' ); ?></h2>
                <p class="gear-builds__sub">
                    <?php esc_html_e( "Every piece of gear on this page was chosen from these builds. Here's the full context.", 'rolling-reno' ); ?>
                </p>
            </div>
            <div class="gear-builds__grid">
                <?php
                $builds = array(
                    array(
                        'label' => __( 'Build 1', 'rolling-reno' ),
                        'name'  => __( 'Renault Trafic', 'rolling-reno' ),
                        'year'  => '2019',
                        'url'   => home_url( '/about/#build-renault-trafic' ),
                        'emoji' => '🚐',
                    ),
                    array(
                        'label' => __( 'Build 2', 'rolling-reno' ),
                        'name'  => __( 'Mercedes Sprinter 313', 'rolling-reno' ),
                        'year'  => '2022',
                        'url'   => home_url( '/about/#build-mercedes-sprinter' ),
                        'emoji' => '🚌',
                    ),
                    array(
                        'label' => __( 'Build 3', 'rolling-reno' ),
                        'name'  => __( 'Autotrail Tribute', 'rolling-reno' ),
                        'year'  => '2024',
                        'url'   => home_url( '/about/#build-autotrail-tribute' ),
                        'emoji' => '🏕️',
                    ),
                );
                foreach ( $builds as $build ) : ?>
                <a href="<?php echo esc_url( $build['url'] ); ?>" class="build-card" aria-label="<?php echo esc_attr( sprintf( __( 'Read about %s Build', 'rolling-reno' ), $build['name'] ) ); ?>">
                    <div class="build-card__image-wrap">
                        <div class="build-card__image-placeholder" aria-hidden="true"><?php echo $build['emoji']; ?></div>
                    </div>
                    <div class="build-card__body">
                        <p class="build-card__label"><?php echo esc_html( $build['label'] ); ?></p>
                        <p class="build-card__name"><?php echo esc_html( $build['name'] ); ?></p>
                        <p class="build-card__year"><?php echo esc_html( $build['year'] ); ?></p>
                        <p class="build-card__cta"><?php esc_html_e( 'Read the build →', 'rolling-reno' ); ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Deep Dive Guide Links -->
    <section class="gear-guides" aria-label="<?php esc_attr_e( 'Deep dive gear guides', 'rolling-reno' ); ?>">
        <div class="container">
            <h2 class="gear-guides__title"><?php esc_html_e( 'The Deep Dives', 'rolling-reno' ); ?></h2>
            <p class="gear-guides__sub">
                <?php esc_html_e( "Not sure which product is right for your build? These guides go deeper.", 'rolling-reno' ); ?>
            </p>
            <ul class="gear-guides__list">
                <?php
                $guides = array(
                    array( home_url( '/rv-solar-system-diy-guide/' ),             __( 'RV Solar System DIY: Panels, Sizing, and Off-Grid Power', 'rolling-reno' ) ),
                    array( home_url( '/van-electrical-system-diy-guide/' ),       __( 'Van Electrical System DIY: The Complete 12V Wiring Guide', 'rolling-reno' ) ),
                    array( home_url( '/van-insulation-guide/' ),                  __( 'Van Insulation: The Complete DIY Guide', 'rolling-reno' ) ),
                    array( home_url( '/rv-van-kitchen-build-diy-guide/' ),        __( 'RV & Van Kitchen Build: Cooktops, Fridges, and Layout', 'rolling-reno' ) ),
                    array( home_url( '/rv-van-ventilation-condensation-guide/' ), __( 'RV & Van Ventilation: Roof Fans, Condensation, and Air Flow', 'rolling-reno' ) ),
                    array( home_url( '/rv-van-heating-options/' ),                __( 'RV & Van Heating: Diesel vs Propane vs Wood Stove', 'rolling-reno' ) ),
                );
                foreach ( $guides as $guide ) : ?>
                <li class="gear-guides__item">
                    <a href="<?php echo esc_url( $guide[0] ); ?>"><?php echo esc_html( $guide[1] ); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- Lead Magnet -->
    <section class="cta-banner cta-banner--leadmagnet" aria-labelledby="gear-leadmagnet-heading">
        <div class="cta-banner__inner container">
            <div class="cta-banner__text">
                <h2 class="cta-banner__heading" id="gear-leadmagnet-heading">
                    <?php esc_html_e( "Want Mara's gear buying checklist?", 'rolling-reno' ); ?>
                </h2>
                <p class="cta-banner__sub">
                    <?php esc_html_e( "Before your first build, read this. It's free, and it'll save you hundreds.", 'rolling-reno' ); ?>
                </p>
            </div>
            <form class="cta-banner__form" action="<?php echo rr_newsletter_action(); ?>" method="POST">
                <?php wp_nonce_field( 'rr_newsletter', 'rr_nonce' ); ?>
                <?php rr_newsletter_hidden_fields( 'gear_page_cta' ); ?>
                <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'rolling-reno' ); ?>" required autocomplete="email" class="cta-banner__input" aria-label="<?php esc_attr_e( 'Email address', 'rolling-reno' ); ?>">
                <button type="submit" class="btn--cta-banner"><?php esc_html_e( 'Send me the checklist →', 'rolling-reno' ); ?></button>
                <p class="cta-banner__fine"><?php esc_html_e( 'No spam. Unsubscribe any time.', 'rolling-reno' ); ?></p>
            </form>
        </div>
    </section>

</main>

<?php get_footer(); ?>
