<?php
/**
 * Pattern: Dan — Closing CTA
 *
 * Full-width closing slice, styled after the dan-talks box (pink
 * background, centred content, border-top CTA row). Placeholder
 * styling — expected to be adapted once real design direction lands.
 *
 * ACF fields: dan_cta_heading, dan_cta_text, dan_cta_button_text, dan_cta_button_url
 */

$heading = get_field('dan_cta_heading');
$text = get_field('dan_cta_text');
$button_text = get_field('dan_cta_button_text');
$button_url = get_field('dan_cta_button_url');
?>
<section class="dan-cta edp-fullwidth" aria-label="Get in touch">
    <div class="dan-inner">
        <div class="dan-cta__box">

            <?php if ($heading): ?>
                <h2 class="dan-cta__heading"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($text || $button_url): ?>
                <div class="dan-cta__cta">
                    <?php if ($text): ?>
                        <p class="dan-cta__cta-text"><?php echo esc_html($text); ?></p>
                    <?php endif; ?>
                    <?php if ($button_url): ?>
                        <a href="<?php echo esc_url($button_url); ?>" class="button edp-button-solid" tabindex="0">
                            <?php echo esc_html($button_text ?: 'Get in touch'); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div><!-- .dan-cta__box -->
    </div><!-- .dan-inner -->
</section><!-- .dan-cta -->
