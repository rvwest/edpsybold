<?php
/**
 * The custom template in child theme for displaying Guest Author's biography: Using Co-Author Plus plugin. content-single.php has also been modified from line 42-51.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */



if (function_exists('coauthors_posts_links')) {

    $author_id = (get_user_by('slug', $coauthor));
    ; ?>
    <!-- file: archive-biography.php -->
    <div class="author-info">
        <div class="author-avatar">
            <?php
            echo get_avatar(get_the_author_meta('user_email'), '300', '', '', array('style' => ''));
            ?>

        </div>

        <div class="author-description author-description--boxed">
            <h2 class="author-title">About <span
                    class="author-heading"><?php echo get_the_author_meta('display_name', $coauthor); ?></h2>

            <p class="author-bio">
                <?php the_author_meta('description'); ?>
            </p>

        </div>

    </div>



<?php } ?>

<!-- file end: archive-biography.php -->