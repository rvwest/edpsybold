<article <?php post_class('article-item'); ?>>
    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium'); ?>
        <?php endif; ?>
        <h3><?php the_title(); ?></h3>
    </a>
</article>