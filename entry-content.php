<!-- file: entry-content.php -->

<div class="entry-content grid12" itemprop="mainEntityOfPage">

<div class="blog-swirls-tr"></div>
    <meta itemprop="description" content="<?php echo esc_html(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <div class="content-body"><?php the_content(); ?></div>
    <?php if (!is_search()) {
        get_template_part('entry', 'author');
    } ?>
    <div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
<!-- file end: entry-content.php -->