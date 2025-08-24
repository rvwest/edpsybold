<?php
echo '<!-- file: _promo-banner.php -->';

// Fetch settings
$visible = get_theme_mod('promo_banner_visible');
if (!$visible) {
    return;
}

$class = get_theme_mod('promo_banner_css_class', '');
$icon  = get_theme_mod('promo_banner_icon', '');
$text1 = get_theme_mod('promo_banner_text1', '');
$text2 = get_theme_mod('promo_banner_text2', '');
?>
<div class="promo-banner-block edp-fullwidth <?php echo esc_attr( $class ); ?>">

        <div class="promo-banner-wrapper grid12">
            <p>
                <?php if ( $icon ) : ?>
                    <i class="<?php echo esc_attr( $icon ); ?>"></i>&nbsp;
                <?php endif; ?>
            <?php echo wp_kses_post( $text1 ); ?>
            </p>
            <?php if ( $text2 ) : ?>
                <p class="cta-second-link"><?php echo wp_kses_post( $text2 ); ?></p>
            <?php endif; ?>
            </div>
</div>
<?php echo '<!-- file end: _promo-banner.php -->'; ?>
