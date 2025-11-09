<?php 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

echo '<!-- file: _home-article-item.php -->';

$show_badge = get_query_var('edpsybold_show_longer_read_badge', true);
$show_badge = (bool) $show_badge;
?>
<article <?php post_class('article-item'); ?>>
    <a href="<?php the_permalink(); ?>">
        <div class="article-item--image">
            <?php if (has_post_thumbnail()): ?>
                <div class="home-article-image">
                    <?php the_post_thumbnail('medium'); ?>
                    <?php if ($show_badge) {
                        edpsybold_the_longer_read_badge();
                    } ?>
                </div>
            <?php endif; ?>
        </div>
        <h3><?php the_title(); ?></h3>
    </a>
</article>
