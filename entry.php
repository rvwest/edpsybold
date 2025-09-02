<!-- file: entry.php -->
<?php
if (is_singular()) { ?>
    <!-- var: single page -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php get_template_part('entry-header'); ?>
        <?php get_template_part('entry-content'); ?>
        
        <?php get_template_part('entry-footer'); ?>
    </article>

<?php } else { ?>
    <!-- var: listing page -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <?php get_template_part('entry-summary'); ?>
        <header>

            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                    rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php edit_post_link(); ?>
            <?php if (!is_search()) {
                get_template_part('blog-list-meta');
            } ?>
        </header>
    </article>
<?php } ?>
<!-- file end: entry.php -->