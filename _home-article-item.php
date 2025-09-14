<?php 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
echo '<!-- file: _home-article-item.php -->'; ?>
<article <?php post_class('article-item'); ?>>
    <a href="<?php the_permalink(); ?>">
        <div class="article-item--image"><?php if (has_post_thumbnail()): ?>
          <div class="home-article-image">
            <?php the_post_thumbnail('medium'); ?>

        </div>
        </div>
        <?php endif; ?>
        <h3><?php the_title(); ?></h3>
    </a>
</article>