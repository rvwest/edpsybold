<!-- file: author.php -->
<!-- file: tag.php -->
<?php 
global $post;
$author_id = $post->post_author;
foreach (get_coauthors() as $coauthor): ?>
<?php get_header(); ?>
<header class="header">
    <div class="title-tag"><h1 class="entry-title" itemprop="name">Blog</h1>
    <h2><i class="fas fa-user-circle"></i> <a class="tag-block" href="../../blog"><?php echo $coauthor->display_name; ?><i class="far fa-times fa-sm"></i></a></h2></div>
    
            <?php get_page_promo(); ?>
</header>
<div class="archive-meta" itemprop="description">

<?php get_template_part( 'biography', get_post_format() ); ?>
        </div>
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <?php get_template_part('entry'); ?>
    <?php endwhile; endif; ?>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>
<!-- file end: tag.php -->

<?php get_header(); ?>
<header class="header">
    <?php the_post(); ?>hksdsajksadhk
    <h1 class="entry-title author" itemprop="name"><?php the_author_link(); ?></h1>
    <div class="archive-meta" itemprop="description">
        <?php if ('' != get_the_author_meta('user_description')) {
            echo esc_html(get_the_author_meta('user_description'));
        } ?>
    </div>
    <?php rewind_posts(); ?>
</header>
<?php while (have_posts()):
    the_post(); ?>
    <?php get_template_part('entry'); ?>
<?php endwhile; ?>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>
<?php endforeach ?>
<!-- file end: author.php -->