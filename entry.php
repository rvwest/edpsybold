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
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
    rel="bookmark">
    <div class="archive-article-img">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail(); ?>
    <?php endif; ?>
</div>     
   

            <h2 class="entry-title">
                <?php the_title(); ?>
            </h2>
            </a>
            <?php edit_post_link(); ?>
            <?php if (!is_search()) {
                get_template_part('blog-list-meta');
            } ?>
        </header>
    </article>
<?php } ?>
<!-- file end: entry.php -->