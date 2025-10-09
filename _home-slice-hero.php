<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
echo '<!-- file: home-slice-hero.php -->';
$hero_post_id = get_theme_mod('hero_post_id');

if ($hero_post_id) {
    $hero_post  = get_post($hero_post_id);
    if (!$hero_post instanceof WP_Post) {
        return;
    }

    $hero_image = get_the_post_thumbnail_url($hero_post_id, 'large');
    $hero_link  = edp_get_relative_permalink($hero_post_id);

    if ('' === $hero_link) {
        $hero_link = '#';
    }
    ?>

    <section class="hero-post grid12">
<h2>Featured</h2>
    <article <?php post_class('home-hero-item', $hero_post); ?>>
<a href="<?php echo esc_url($hero_link); ?>">
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
    <div class="hero-image" style="background-image: url(<?php echo esc_url($hero_image); ?>)" aria-hidden="true">
            </div>
        <?php endif; ?>

        </a>
    </article>
    </section>
    <?php
}

?>