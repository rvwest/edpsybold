<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
echo '<!-- file: home-slice-hero.php -->';
$hero_post_id = get_theme_mod('hero_post_id');

if ($hero_post_id) {
    $hero_post = get_post($hero_post_id);
    $hero_image = get_the_post_thumbnail_url($hero_post_id, 'large');
    ?>

    <section class="hero-post grid12">

    <article <?php post_class('home-hero-item'); ?>>
<a href="<?php the_permalink(); ?>">
<div class="hero-text"><h1><?php echo esc_html(get_the_title($hero_post)); ?></h1>
<?php
$raw_content = apply_filters('the_content', $hero_post->post_content);
$paragraphs = explode('</p>', $raw_content);

// Get the first paragraph (if it exists)
if (!empty($paragraphs[0])) {
    echo '<div class="hero-excerpt">' . $paragraphs[0] . '</p></div>';
}
?> </div>  
<?php if ($hero_image): ?>
    <div class="hero-image" style="background-image: url(<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(get_the_title($hero_post)); ?>">
            </div>
        <?php endif; ?>
        
        </a>
    </article>
    </section>
    <?php
}

?>