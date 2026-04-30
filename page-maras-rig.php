<?php
/**
 * Template Name: Mara's Rig
 * Rolling Reno v2 — page-maras-rig.php
 * MJM-258: Expand Mara's Rig proof hub.
 */

get_header();

$hero_img = get_theme_mod( 'rr_mara_rig_image', get_template_directory_uri() . '/assets/images/mara-hero.jpg' );

$proof_stats = array(
    array(
        'value' => '2019',
        'label' => __( 'Mercedes Sprinter 313 LWB', 'rolling-reno' ),
    ),
    array(
        'value' => '€9,200',
        'label' => __( 'documented build spend', 'rolling-reno' ),
    ),
    array(
        'value' => '200W',
        'label' => __( 'Renogy solar on the roof', 'rolling-reno' ),
    ),
    array(
        'value' => '100Ah',
        'label' => __( 'lithium house battery', 'rolling-reno' ),
    ),
);

$build_sections = array(
    array(
        'kicker' => __( 'Power', 'rolling-reno' ),
        'title'  => __( 'Small, simple, serviceable electrical', 'rolling-reno' ),
        'body'   => __( 'The current trusted setup is deliberately modest: 200W Renogy solar, a 100Ah lithium battery, MPPT charge control, fused 12V circuits, and no mystery wiring hidden behind cladding. It runs lights, fridge, laptop work, fans, charging, and the diesel heater controller without needing campsite hookup every night.', 'rolling-reno' ),
        'proof'  => __( 'Proof point: the system is sized around real daily use, not brochure numbers — coffee, laptop, lights, fridge, and one winter evening buffer.', 'rolling-reno' ),
        'link'   => home_url( '/gear/#solar-power' ),
        'cta'    => __( 'See the power gear', 'rolling-reno' ),
    ),
    array(
        'kicker' => __( 'Heat + insulation', 'rolling-reno' ),
        'title'  => __( 'Built for wet Irish winters', 'rolling-reno' ),
        'body'   => __( 'Thinsulate in the walls, sensible vapour control, covered metal ribs where possible, and a Webasto diesel heater made the biggest difference between a pretty van and one Mara could actually sleep in through January on the west coast.', 'rolling-reno' ),
        'proof'  => __( 'Proof point: the heater and insulation choices came from cold-weather use, including nights where condensation would have ruined a cheaper build.', 'rolling-reno' ),
        'link'   => home_url( '/gear/#insulation' ),
        'cta'    => __( 'See climate gear', 'rolling-reno' ),
    ),
    array(
        'kicker' => __( 'Kitchen', 'rolling-reno' ),
        'title'  => __( 'A kitchen that gets used, not photographed once', 'rolling-reno' ),
        'body'   => __( 'The kitchen is built around repeatable meals and easy cleaning: a compressor fridge, two-burner stove, proper water storage, wipe-clean surfaces, and enough counter space to make dinner without moving half the van first.', 'rolling-reno' ),
        'proof'  => __( 'Proof point: every kitchen recommendation is judged by clean-up time, fuel availability, and whether it still works when parked on uneven ground.', 'rolling-reno' ),
        'link'   => home_url( '/gear/#kitchen' ),
        'cta'    => __( 'See kitchen kit', 'rolling-reno' ),
    ),
);

$ledger_rows = array(
    array( __( 'Base vehicle', 'rolling-reno' ), __( '2019 Mercedes Sprinter 313 LWB', 'rolling-reno' ), __( 'Enough standing room and parts availability without going huge.', 'rolling-reno' ) ),
    array( __( 'Insulation', 'rolling-reno' ), __( '3M Thinsulate SM600L', 'rolling-reno' ), __( 'Cleaner install than foam board in awkward ribs; better for cold, damp use.', 'rolling-reno' ) ),
    array( __( 'Solar', 'rolling-reno' ), __( 'Renogy 200W roof array', 'rolling-reno' ), __( 'Adequate for a realistic solo setup if loads stay honest.', 'rolling-reno' ) ),
    array( __( 'Battery', 'rolling-reno' ), __( '100Ah lithium', 'rolling-reno' ), __( 'The quality-of-life upgrade Mara would not go back from.', 'rolling-reno' ) ),
    array( __( 'Heating', 'rolling-reno' ), __( 'Webasto diesel heater', 'rolling-reno' ), __( 'Expensive, but justified by winter comfort and dry air.', 'rolling-reno' ) ),
    array( __( 'Total documented spend', 'rolling-reno' ), __( '€9,200', 'rolling-reno' ), __( 'Excludes the base vehicle; includes the major fit-out choices.', 'rolling-reno' ) ),
);

$lessons = array(
    __( 'Do the power audit before buying solar panels. Panels are visible; daily loads are what actually decide the system.', 'rolling-reno' ),
    __( 'Leave inspection access. Anything hidden forever will fail in the least convenient lay-by.', 'rolling-reno' ),
    __( 'Spend money on heat, sleep, and safety before clever storage. Those three decide whether the van gets used year-round.', 'rolling-reno' ),
    __( 'Take build photos as you go. They are not just memories — they are your wiring map, screw map, and resale evidence.', 'rolling-reno' ),
);
?>

<main id="main" role="main" class="rig-page">

    <section class="rig-hero" aria-label="<?php esc_attr_e( "Mara's Rig overview", 'rolling-reno' ); ?>">
        <?php if ( $hero_img ) : ?>
            <img
                class="rig-hero__image"
                src="<?php echo esc_url( $hero_img ); ?>"
                alt="<?php esc_attr_e( "Mara's converted Sprinter parked for a build check", 'rolling-reno' ); ?>"
                width="1920"
                height="1080"
                loading="eager"
                fetchpriority="high"
            >
        <?php endif; ?>
        <div class="rig-hero__overlay" aria-hidden="true"></div>
        <div class="rig-hero__content">
            <?php rr_breadcrumb(); ?>
            <p class="rig-hero__eyebrow"><?php esc_html_e( 'Proof hub', 'rolling-reno' ); ?></p>
            <h1 class="rig-hero__title"><?php esc_html_e( "Mara's Rig", 'rolling-reno' ); ?></h1>
            <p class="rig-hero__sub"><?php esc_html_e( 'The build details behind the advice: what is installed, what it cost, what failed, and which gear earned a permanent place in the van.', 'rolling-reno' ); ?></p>
            <div class="rig-hero__ctas">
                <a class="btn btn--primary" href="#build-ledger"><?php esc_html_e( 'View the build ledger', 'rolling-reno' ); ?></a>
                <a class="btn btn--outline-inverse" href="<?php echo esc_url( home_url( '/gear/' ) ); ?>"><?php esc_html_e( 'Browse tested gear', 'rolling-reno' ); ?></a>
            </div>
        </div>
    </section>

    <section class="rig-proof-strip" aria-label="<?php esc_attr_e( 'Build proof summary', 'rolling-reno' ); ?>">
        <div class="container">
            <dl class="rig-proof-strip__grid">
                <?php foreach ( $proof_stats as $stat ) : ?>
                    <div class="rig-proof-stat">
                        <dt><?php echo esc_html( $stat['value'] ); ?></dt>
                        <dd><?php echo esc_html( $stat['label'] ); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </section>

    <section class="rig-intro" aria-label="<?php esc_attr_e( 'Why this hub exists', 'rolling-reno' ); ?>">
        <div class="container--narrow">
            <p class="rig-intro__label"><?php esc_html_e( 'Why trust this page?', 'rolling-reno' ); ?></p>
            <h2><?php esc_html_e( 'This is where the advice has to prove itself.', 'rolling-reno' ); ?></h2>
            <p><?php esc_html_e( "Rolling Reno is not built around fantasy van shots. Mara's Rig is the receipt drawer: the build choices, compromises, costs, and road-tested notes that support the guides across the site.", 'rolling-reno' ); ?></p>
            <p><?php esc_html_e( 'If a guide recommends a product or method, this hub should make it clear whether Mara used it, tested it, replaced it, or ruled it out.', 'rolling-reno' ); ?></p>
        </div>
    </section>

    <section class="rig-build-cards" aria-label="<?php esc_attr_e( 'Build systems', 'rolling-reno' ); ?>">
        <div class="container">
            <div class="section-header section-header--centered">
                <span class="section-header__label"><?php esc_html_e( 'Systems that matter', 'rolling-reno' ); ?></span>
                <h2 class="section-header__title"><?php esc_html_e( 'The setup behind the guides', 'rolling-reno' ); ?></h2>
            </div>
            <div class="rig-build-cards__grid">
                <?php foreach ( $build_sections as $section ) : ?>
                    <article class="rig-build-card">
                        <p class="rig-build-card__kicker"><?php echo esc_html( $section['kicker'] ); ?></p>
                        <h3><?php echo esc_html( $section['title'] ); ?></h3>
                        <p><?php echo esc_html( $section['body'] ); ?></p>
                        <p class="rig-build-card__proof"><?php echo esc_html( $section['proof'] ); ?></p>
                        <a class="rig-build-card__link" href="<?php echo esc_url( $section['link'] ); ?>"><?php echo esc_html( $section['cta'] ); ?> →</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="rig-ledger" id="build-ledger" aria-label="<?php esc_attr_e( 'Build ledger', 'rolling-reno' ); ?>">
        <div class="container">
            <div class="rig-ledger__header">
                <p class="rig-intro__label"><?php esc_html_e( 'Build ledger', 'rolling-reno' ); ?></p>
                <h2><?php esc_html_e( 'What is actually in the van', 'rolling-reno' ); ?></h2>
                <p><?php esc_html_e( 'A practical snapshot of the major fit-out choices. This is the page to update whenever Mara changes a component, adds a field note, or publishes a deeper guide.', 'rolling-reno' ); ?></p>
            </div>
            <div class="rig-ledger__table-wrap" role="region" aria-label="<?php esc_attr_e( 'Mara rig build details table', 'rolling-reno' ); ?>" tabindex="0">
                <table class="rig-ledger__table">
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e( 'Area', 'rolling-reno' ); ?></th>
                            <th scope="col"><?php esc_html_e( 'Current choice', 'rolling-reno' ); ?></th>
                            <th scope="col"><?php esc_html_e( "Mara's note", 'rolling-reno' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $ledger_rows as $row ) : ?>
                            <tr>
                                <th scope="row"><?php echo esc_html( $row[0] ); ?></th>
                                <td><?php echo esc_html( $row[1] ); ?></td>
                                <td><?php echo esc_html( $row[2] ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="rig-proof-modules" aria-label="<?php esc_attr_e( 'Proof points and lessons', 'rolling-reno' ); ?>">
        <div class="container">
            <div class="rig-proof-modules__grid">
                <article class="rig-proof-panel rig-proof-panel--dark">
                    <p class="rig-build-card__kicker"><?php esc_html_e( 'Field notes', 'rolling-reno' ); ?></p>
                    <h2><?php esc_html_e( 'What changed after real use', 'rolling-reno' ); ?></h2>
                    <ul>
                        <?php foreach ( $lessons as $lesson ) : ?>
                            <li><?php echo esc_html( $lesson ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
                <article class="rig-proof-panel">
                    <p class="rig-build-card__kicker"><?php esc_html_e( 'Proof still needed', 'rolling-reno' ); ?></p>
                    <h2><?php esc_html_e( 'Photo checklist for the next content pass', 'rolling-reno' ); ?></h2>
                    <p><?php esc_html_e( 'To make this hub even stronger, the next visual pass should add real build photos for these checkpoints:', 'rolling-reno' ); ?></p>
                    <ol>
                        <li><?php esc_html_e( 'Roof solar layout and cable entry gland.', 'rolling-reno' ); ?></li>
                        <li><?php esc_html_e( 'Electrical bay with labels visible.', 'rolling-reno' ); ?></li>
                        <li><?php esc_html_e( 'Heater install location and vent routing.', 'rolling-reno' ); ?></li>
                        <li><?php esc_html_e( 'Kitchen storage opened, not staged closed.', 'rolling-reno' ); ?></li>
                    </ol>
                </article>
            </div>
        </div>
    </section>

    <section class="rig-next-steps" aria-label="<?php esc_attr_e( 'Related guides', 'rolling-reno' ); ?>">
        <div class="container--narrow">
            <p class="rig-intro__label"><?php esc_html_e( 'Keep going', 'rolling-reno' ); ?></p>
            <h2><?php esc_html_e( 'Use the rig notes to plan your own build', 'rolling-reno' ); ?></h2>
            <div class="rig-next-steps__links">
                <a href="<?php echo esc_url( home_url( '/gear/' ) ); ?>"><?php esc_html_e( 'Gear Mara actually uses', 'rolling-reno' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/van-life/' ) ); ?>"><?php esc_html_e( 'Van life build guides', 'rolling-reno' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Mara', 'rolling-reno' ); ?></a>
            </div>
            <p class="rig-next-steps__disclosure"><?php esc_html_e( 'Affiliate note: product links live on the gear page and may earn Rolling Reno a commission at no extra cost to you. Recommendations should stay limited to gear Mara has used, tested, or clearly marked as researched.', 'rolling-reno' ); ?></p>
        </div>
    </section>

    <?php
    if ( have_posts() && is_page() ) :
        while ( have_posts() ) :
            the_post();
            $content = get_the_content();
            if ( $content ) :
                ?>
                <section class="rig-editor-content" aria-label="<?php esc_attr_e( 'Additional page content', 'rolling-reno' ); ?>">
                    <div class="container--narrow post-body">
                        <?php the_content(); ?>
                    </div>
                </section>
                <?php
            endif;
        endwhile;
    endif;
    ?>

</main>

<?php
get_footer();
