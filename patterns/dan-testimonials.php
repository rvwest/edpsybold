<?php
/**
 * Pattern: Dan — Testimonials
 *
 * Light background. Centred heading block above.
 * CSS-columns masonry layout (column-count: 3, break-inside: avoid).
 * Each card: blue (#78A8CF) background, quote mark block, quote text, attribution.
 *
 * ACF fields: dan_testimonials_eyebrow, dan_testimonials_heading,
 *             dan_testimonials (repeater: quote_text, quote_name, quote_title, quote_org)
 */

$eyebrow      = get_field( 'dan_testimonials_eyebrow' );
$heading      = get_field( 'dan_testimonials_heading' );
$testimonials = get_field( 'dan_testimonials' );
?>
<section class="dan-testimonials edp-fullwidth" aria-label="Testimonials">
<div class="dan-inner">

    <?php if ( $eyebrow || $heading ) : ?>
        <div class="dan-testimonials__header">
            <?php if ( $eyebrow ) : ?>
                <p class="dan-testimonials__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 class="dan-testimonials__heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ( $testimonials ) : ?>
        <div class="dan-testimonials__masonry">
            <?php foreach ( $testimonials as $t ) : ?>
                <blockquote class="dan-testimonial-card">
                    <div class="dan-testimonial-card__quote-mark" aria-hidden="true">&ldquo;</div>
                    <?php if ( $t['quote_text'] ) : ?>
                        <p class="dan-testimonial-card__text"><?php echo wp_kses_post( $t['quote_text'] ); ?></p>
                    <?php endif; ?>
                    <footer class="dan-testimonial-card__attribution">
                        <?php if ( $t['quote_name'] ) : ?>
                            <cite class="dan-testimonial-card__name"><?php echo esc_html( $t['quote_name'] ); ?></cite>
                        <?php endif; ?>
                        <?php if ( $t['quote_title'] ) : ?>
                            <p class="dan-testimonial-card__title-role"><?php echo esc_html( $t['quote_title'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( $t['quote_org'] ) : ?>
                            <p class="dan-testimonial-card__org"><?php echo esc_html( $t['quote_org'] ); ?></p>
                        <?php endif; ?>
                    </footer>
                </blockquote>
            <?php endforeach; ?>
        </div><!-- .dan-testimonials__masonry -->
    <?php endif; ?>

</div><!-- .dan-inner -->
</section><!-- .dan-testimonials -->
