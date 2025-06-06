<!-- file: entry-meta.php -->
<div class="entry-meta">
    <div class="author-name"><?php _e(' by ', 'advertica-lite');
    if (function_exists('coauthors_posts_links')) {
        coauthors_posts_links();
    } else {
        the_author_posts_link(first_name, last_name);
    } ?></div>


    <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"
        title="<?php echo esc_attr(get_the_date()); ?>" <?php if (is_single()) {
               echo 'itemprop="datePublished" pubdate';
           } ?>><?php the_time(get_option('date_format')); ?></time>
    <?php if (is_single()) {
        echo '<meta itemprop="dateModified" content="' . esc_attr(get_the_modified_date()) . '">';
    } ?>

    <div class="tag-links"><i class="fal fa-tags fa-sm"></i>
        <div class="tag-link-list"><?php the_tags($before = ''); ?></div>
    </div>
</div>
<!-- file end: entry-meta.php -->