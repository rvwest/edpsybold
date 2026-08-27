<!-- file: entry-content.php -->

<div class="entry-content grid12" itemprop="mainEntityOfPage">

    <div class="blog-swirls-tr"></div>
    <meta itemprop="description" content="<?php echo esc_html(wp_strip_all_tags(get_the_excerpt(), true)); ?>">
    <div class="content-body"><?php
    $tag_cta_term = edpsybold_get_post_tag_cta(get_the_ID());
    if ($tag_cta_term) {
        $content = apply_filters('the_content', get_the_content());
        $content = str_replace(']]>', ']]&gt;', $content);
        echo edpsybold_insert_after_paragraph($content, edpsybold_render_tag_cta_block($tag_cta_term));
    } else {
        the_content();
    }
    ?></div>
    <?php if (!is_search()) {
        get_template_part('entry', 'author');
    } ?>
    <div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
<!-- file end: entry-content.php -->