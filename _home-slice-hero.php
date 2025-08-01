<?php 
echo '<!-- file: home.php -->';
$hero_post_id = get_theme_mod('hero_post_id');

if ($hero_post_id) {
    $hero_post = get_post($hero_post_id);
    $hero_image = get_the_post_thumbnail_url($hero_post_id, 'large');
    ?>
    <section class="hero-post grid12">
        <?php if ($hero_image): ?>
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(get_the_title($hero_post)); ?>">
        <?php endif; ?>
        <h1><?php echo esc_html(get_the_title($hero_post)); ?></h1>
    </section>
    <?php
}

?>