<?php
/**
 * Pattern: Dan — Signature Talks
 *
 * Pink (#C982A8) background box, max-width 1070px, centred.
 * Header: centred eyebrow + heading.
 * Talks grid: 3 equal columns (flex). Each card: topic pill, description, audience.
 * CTA block below with border-top, text, and dark button.
 *
 * ACF fields: dan_talks_eyebrow, dan_talks_heading,
 *             dan_talks (repeater: talk_topic, talk_description, talk_audience),
 *             dan_talks_cta_text, dan_talks_cta_url
 */

$eyebrow  = get_field( 'dan_talks_eyebrow' );
$heading  = get_field( 'dan_talks_heading' );
$talks    = get_field( 'dan_talks' );
$cta_text = get_field( 'dan_talks_cta_text' );
$cta_url  = get_field( 'dan_talks_cta_url' );
?>
<section class="dan-talks" aria-label="Signature talks">
<div class="dan-inner">
    <div class="dan-talks__box">

        <div class="dan-talks__header">
            <?php if ( $eyebrow ) : ?>
                <p class="dan-talks__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 class="dan-talks__heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
        </div>

        <?php if ( $talks ) : ?>
            <div class="dan-talks__grid">
                <?php foreach ( $talks as $talk ) : ?>
                    <div class="dan-talks__card">
                        <?php if ( $talk['talk_topic'] ) : ?>
                            <span class="dan-talks__topic"><?php echo esc_html( $talk['talk_topic'] ); ?></span>
                        <?php endif; ?>
                        <?php if ( $talk['talk_description'] ) : ?>
                            <p class="dan-talks__desc"><?php echo wp_kses_post( $talk['talk_description'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( $talk['talk_audience'] ) : ?>
                            <div class="dan-talks__audience-block">
                                <span class="dan-talks__audience-label">Audience: </span>
                                <span class="dan-talks__audience-value"><?php echo esc_html( $talk['talk_audience'] ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div><!-- .dan-talks__card -->
                <?php endforeach; ?>
            </div><!-- .dan-talks__grid -->
        <?php endif; ?>

        <?php if ( $cta_text || $cta_url ) : ?>
            <div class="dan-talks__cta">
                <?php if ( $cta_text ) : ?>
                    <p class="dan-talks__cta-text"><?php echo esc_html( $cta_text ); ?></p>
                <?php endif; ?>
                <?php if ( $cta_url ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="dan-talks__cta-btn">
                        Book Dan to speak
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div><!-- .dan-talks__box -->
</div><!-- .dan-inner -->
</section><!-- .dan-talks -->
