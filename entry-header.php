<!-- file: entry-header.php -->
<div class="blog-header-block">
<header class="grid12">
    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
</header>
<div class="author-image-header-block grid12">

    <?php edit_post_link(); ?>
 
    <?php if (has_post_thumbnail()): ?>
        <?php if (is_singular()): ?>
           <div class="entry-image"> <?php the_post_thumbnail('full', array('itemprop' => 'image')); ?></div>
        <?php else: ?>
            <a href="<?php the_post_thumbnail_url('full'); ?>" title="<?php $attachment_id = get_post_thumbnail_id($post->ID);
              the_title_attribute(array('post' => get_post($attachment_id))); ?>">
                <?php the_post_thumbnail('full', array('itemprop' => 'image')); ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!is_search()) {
        get_template_part('entry', 'meta');
    } ?>



</div>
</div>

<!-- file end: entry-header.php -->