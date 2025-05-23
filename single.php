<!-- file: single.php -->
<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <?php get_template_part('entry'); ?>
    <?php endwhile; endif; ?>
<?php get_template_part('biography', get_post_format()); ?>
<?php get_footer(); ?>
<!-- file end: single.php -->