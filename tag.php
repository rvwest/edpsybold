<!-- file: tag.php -->
<?php get_header(); ?>
<header class="header">
    <div class="title-tag">
        <h1 class="entry-title" itemprop="name">Blog</h1>
        <h2><i class="far fa-tags"></i> <a class="tag-block" href="../../blog"><?php single_term_title(); ?> <i
                    class="far fa-times fa-sm"></i></a></h2>
    </div>
    <div class="archive-meta" itemprop="description">
        <?php if ('' != get_the_archive_description()) {
            echo esc_html(get_the_archive_description());
        } ?>
    </div>
    <?php get_page_promo(); ?>
</header>
<?php if (is_tag('transitions')): ?>
    <div style="width: 100%">
        <div class="cta-body-block cta-body-block--series-pale" style="max-width: 800px;">
            <img decoding="async" src="/wp-content/themes/edpsybold/images/edpsy-swirls-13.svg">
            <p>Found out about our special&nbsp;<a href="https://www.justgiving.com/page/edpsy-orguk-special-edition-reuk"
                    tabindex="0">transitions series</a></p>
        </div>
    </div>
<?php endif; ?>

<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <?php get_template_part('entry'); ?>
    <?php endwhile; endif; ?>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>
<!-- file end: tag.php -->