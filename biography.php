<?php
/**
 * The custom template in child theme for displaying Guest Author's biography: Using Co-Author Plus plugin. content-single.php has also been modified from line 42-51.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

if (function_exists('coauthors_posts_links')) {
    global $post;
    $author_id = $post->post_author;
    foreach (get_coauthors() as $coauthor): ?>
        <!-- file: biography.php -->
        <div class="author-info">
            <div class="author-avatar">
                <?php echo get_avatar($coauthor->user_email, '150', '', '', array('style' => '')); ?>
            </div>

            <div class="author-description">
                <h2 class="author-title">About <span class="author-heading"><?php echo $coauthor->display_name; ?></h2>

                <p class="author-bio">
                    <?php echo $coauthor->description; ?>
                </p>
                <?php if ( is_single() ) : ?>
                    <p class="author-bio">
                        
                        <a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ); ?>">
                        View all posts by <?php echo esc_html( $coauthor->display_name ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

        </div>


    <?php endforeach;
}
?>
<!-- file end: biography.php -->