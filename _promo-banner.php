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
$link  = get_theme_mod('promo_banner_link', '');
?>
<div class="cta-header-block <?php echo esc_attr( $class ); ?>">
    <div class="container">
        <div class="row-fluid fixedrow">
            <p>
                <?php if ( $icon ) : ?>
                    <i class="<?php echo esc_attr( $icon ); ?>"></i>&nbsp;
                <?php endif; ?>
                Come join us: <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text1 ); ?></a>
            </p>
            <p class="cta-second-link"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text2 ); ?></a></p>
        </div>
    </div>
</div>
<?php echo '<!-- file end: _promo-banner.php -->'; ?>
