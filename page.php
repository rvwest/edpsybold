<!-- file: page.php -->
<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <?php if (is_singular('wpbdp_listing')): ?>
            <?php the_content(); ?>
        <?php else: ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="header">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                    <?php edit_post_link(); ?>
                    <?php get_page_promo(); ?>
                </header>
                <div class="entry-content" itemprop="mainContentOfPage">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('itemprop' => 'image'));
                    } ?>
                    <?php the_content(); ?>
                    <div class="entry-links"><?php wp_link_pages(); ?></div>
                </div>
            </article>
        <?php endif; ?>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
<!-- file end: page.php -->