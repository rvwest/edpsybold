<!-- file: 404.php -->
<?php get_header(); ?>
<article id="post-0" class="post not-found">
    <header class="header">
        <h1 class="entry-title" itemprop="name"><?php esc_html_e('Not Found', 'edpsybold'); ?></h1>
    </header>
    <div class="entry-content" itemprop="mainContentOfPage">
        <p><?php esc_html_e('Nothing found for the requested page. Try a search instead?', 'edpsybold'); ?></p>
        <?php get_search_form(); ?>
    </div>
</article>
<?php get_footer(); ?>
<!-- file end: 404.php -->