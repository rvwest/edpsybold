<!-- file: entry-header.php -->
<header>
    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
    <?php edit_post_link(); ?>
    <?php if (!is_search()) {
        get_template_part('entry', 'meta');
    } ?>
    <?php if (has_post_thumbnail()): ?>
        <?php if (is_singular()): ?>
            <?php the_post_thumbnail('full', array('itemprop' => 'image')); ?>
        <?php else: ?>
            <a href="<?php the_post_thumbnail_url('full'); ?>" title="<?php $attachment_id = get_post_thumbnail_id($post->ID);
              the_title_attribute(array('post' => get_post($attachment_id))); ?>">
                <?php the_post_thumbnail('full', array('itemprop' => 'image')); ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>

</header>
<!-- file end: entry-header.php -->