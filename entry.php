<!-- file: entry.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header>
        <?php if (is_singular()) { ?>
            <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
        <?php } else { ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                    rel="bookmark"><?php the_title(); ?></a>
            </h2>
        <?php } ?>
        <?php edit_post_link(); ?>
        <?php if (!is_search()) {
            get_template_part('entry', 'meta');
        } ?>
        <span class="author-name"><?php _e(' by ', 'advertica-lite');
        if (function_exists('coauthors_posts_links')) {
            coauthors_posts_links();
        } else {
            the_author_posts_link(first_name, last_name);
        } ?></span>
    </header>
    <?php get_template_part('entry', (is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content')); ?>
    <?php if (is_singular()) {
        get_template_part('entry-footer');
    } ?>
</article>
<!-- file end: entry.php -->