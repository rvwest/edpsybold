<?php
/**
 * Pattern: Dan — Policy & Systems
 *
 * Yellow background box, full content width inside 185px h-padding.
 * Left column: eyebrow, heading, description.
 * Right column: list of policy items with title, description, and arrow link.
 *
 * ACF fields: dan_policy_eyebrow, dan_policy_heading, dan_policy_description,
 *             dan_policy_items (repeater: item_title, item_description, item_url)
 */

$eyebrow = get_field('dan_policy_eyebrow');
$heading = get_field('dan_policy_heading');
$description = get_field('dan_policy_description');
$items = get_field('dan_policy_items');
?>
<section class="dan-policy" aria-label="Policy and systems work">
    <div class="dan-inner">

        <div class="dan-policy__box">

            <div class="dan-policy__left">
                <?php if ($eyebrow): ?>
                    <p class="dan-policy__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading): ?>
                    <h2 class="dan-policy__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="dan-policy__description"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>
            </div><!-- .dan-policy__left -->

            <?php if ($items): ?>
                <div class="dan-policy__right">
                    <?php foreach ($items as $item): ?>
                        <div class="dan-policy__item">
                            <?php if ($item['item_title']): ?>
                                <p class="dan-policy__item-title"><?php echo esc_html($item['item_title']); ?></p>
                            <?php endif; ?>
                            <?php if ($item['item_description']): ?>
                                <p class="dan-policy__item-desc"><?php echo esc_html($item['item_description']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['item_url'])): ?>
                                <a href="<?php echo esc_url($item['item_url']); ?>" class="dan-policy__item-link"
                                    aria-label="Learn more about <?php echo esc_attr($item['item_title']); ?>" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="far fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                        </div><!-- .dan-policy__item -->
                    <?php endforeach; ?>
                </div><!-- .dan-policy__right -->
            <?php endif; ?>

        </div><!-- .dan-policy__box -->
        <div class="dan-policy__swirl"></div>
    </div><!-- .dan-inner -->
</section><!-- .dan-policy -->