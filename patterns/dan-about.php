<?php
/**
 * Pattern: Dan — About Dan
 *
 * Light background section. Decorative illustration bleeds to the left edge
 * (no left padding). Right column contains eyebrow, heading, and two-column body text.
 *
 * Decorative illustration:
 *   Uses the ACF field dan_about_illustration if set.
 *   Fallback: <!-- dan-illustration: about-left-bleed -->
 *   Suggested asset from theme: images/edpsy-swirls-16.svg or edpsy-swirls-26.svg
 *
 * ACF fields: dan_about_eyebrow, dan_about_heading,
 *             dan_about_col1, dan_about_col2, dan_about_illustration
 */

$eyebrow = get_field('dan_about_eyebrow');
$heading = get_field('dan_about_heading');
$col1 = get_field('dan_about_col1');
$col2 = get_field('dan_about_col2');
$illustration = get_field('dan_about_illustration');
?>
<section class="dan-about" aria-label="About Dan">

    <?php if ($illustration): ?>
        <img src="<?php echo esc_url($illustration['url']); ?>" alt="<?php echo esc_attr($illustration['alt']); ?>"
            class="dan-about__illustration" aria-hidden="<?php echo empty($illustration['alt']) ? 'true' : 'false'; ?>" />
    <?php else: ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/edpsy-swirls-26.svg'); ?>" alt=""
            class="dan-about__illustration" aria-hidden="true" />
    <?php endif; ?>

    <div class="dan-about__content">

        <?php if ($eyebrow): ?>
            <p class="dan-about__eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($heading): ?>
            <h2 class="dan-about__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($col1 || $col2): ?>
            <div class="dan-about__body">
                <?php if ($col1): ?>
                    <div class="dan-about__col"><?php echo wp_kses_post($col1); ?></div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div><!-- .dan-about__content -->

</section><!-- .dan-about -->