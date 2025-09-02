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
                <?php echo get_avatar($coauthor->user_email, '300', '', '', array('style' => '')); ?>
            </div>

            <div class="author-description">
                <h2 class="author-title">About <span class="author-heading"><?php echo $coauthor->display_name; ?></h2>
                <?php
                if (is_a($coauthor, 'WP_User')) {
                    $job_title = get_user_meta($coauthor->ID, 'job_title', true);
                } else {
                    $job_title = get_post_meta($coauthor->ID, 'job_title', true);
                }
                if ($job_title) : ?>
                    <div class="author-job-title"><?php echo esc_html($job_title); ?></div>
                <?php endif; ?>

                <p class="author-bio">
                    <?php echo $coauthor->description; ?>
                </p>
                <?php if ( is_single() ) : ?>
                    <p class="author-bio">
                        View all posts by
                        <a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ); ?>">
                            <?php echo esc_html( $coauthor->display_name ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

        </div>


    <?php endforeach;
}
?>
<!-- file end: biography.php -->
