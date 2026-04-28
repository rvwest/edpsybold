<?php
/**
 * Pattern: Dan — Stats Bar
 *
 * Immediately below the hero. Dark background with a 6-segment colour stripe
 * at the top, then a centred eyebrow/heading and a row of stat cards.
 *
 * Stripe colours (left to right): Orange, Yellow, Green, Blue, Pink, Purple
 *
 * ACF fields: dan_stats_eyebrow, dan_stats_heading,
 *             dan_stats (repeater: stat_number, stat_label, stat_sublabel, stat_bg_colour)
 */

$eyebrow = get_field('dan_stats_eyebrow');
$heading = get_field('dan_stats_heading');
$stats = get_field('dan_stats');
?>
<div class="dan-stats__stripe" aria-hidden="true">
    <div class="dan-stats__stripe-seg"></div>
    <div class="dan-stats__stripe-seg"></div>
    <div class="dan-stats__stripe-seg"></div>
    <div class="dan-stats__stripe-seg"></div>
    <div class="dan-stats__stripe-seg"></div>
    <div class="dan-stats__stripe-seg"></div>
</div>
<section class="dan-stats edp-fullwidth" aria-label="Impact at a glance">



    <div class="dan-stats__inner ">

        <?php if ($eyebrow || $heading): ?>
            <div class="dan-stats__header">
                <?php if ($eyebrow): ?>
                    <p class="dan-stats__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading): ?>
                    <h2 class="dan-stats__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($stats): ?>
            <div class="dan-stats__row">
                <?php foreach ($stats as $stat):
                    $bg = isset($stat['stat_bg_colour']) ? sanitize_hex_color($stat['stat_bg_colour']) : '#E5C957';
                    ?>
                    <div class="dan-stats__card" style="border-color: <?php echo esc_attr($bg); ?>;">
                        <?php if ($stat['stat_number']): ?>
                            <p class="dan-stats__number"><?php echo esc_html($stat['stat_number']); ?></p>
                        <?php endif; ?>
                        <?php if ($stat['stat_label']): ?>
                            <p class="dan-stats__label"><?php echo esc_html($stat['stat_label']); ?></p>
                        <?php endif; ?>
                        <?php if ($stat['stat_sublabel']): ?>
                            <p class="dan-stats__sublabel"><?php echo esc_html($stat['stat_sublabel']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div><!-- .dan-stats__inner -->

</section><!-- .dan-stats -->