<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
echo '<!-- file: _home-article-item.php -->'; ?>
<?php
$relative_link = edp_get_relative_permalink(get_the_ID());

if ('' === $relative_link) {
    $relative_link = '#';
}
?>
<article <?php post_class('article-item'); ?>>
    <a href="<?php echo esc_url($relative_link); ?>">
        <div class="article-item--image"><?php if (has_post_thumbnail()): ?>
          <div class="home-article-image">
            <?php the_post_thumbnail('medium'); ?>

        </div>
        </div>
        <?php endif; ?>
        <h3><?php the_title(); ?></h3>
    </a>
</article>