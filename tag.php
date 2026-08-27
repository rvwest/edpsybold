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
<?php
$tag_cta_term = get_queried_object();
if ($tag_cta_term && get_field('tag_cta_active', $tag_cta_term)):
    $tag_cta_text = get_field('tag_cta_text', $tag_cta_term);
    if ($tag_cta_text):
        $tag_cta_image = get_field('tag_cta_image', $tag_cta_term);
        $tag_cta_image_url = $tag_cta_image ? $tag_cta_image['url'] : get_template_directory_uri() . '/images/edpsy-swirls-13.svg';
        $tag_cta_image_alt = $tag_cta_image ? $tag_cta_image['alt'] : ''; ?>
        <div style="width: 100%">
            <div class="cta-body-block cta-body-block--series-pale cta-body-block--series-listingpage">
                <img decoding="async" src="<?php echo esc_url($tag_cta_image_url); ?>" alt="">
                <?php echo $tag_cta_text; ?>
            </div>
        </div>
    <?php endif;
endif; ?>

<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <?php get_template_part('entry'); ?>
    <?php endwhile; endif; ?>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>
<!-- file end: tag.php -->