<?php
/**
 * The custom template in child theme for displaying Guest Author's biography: Using Co-Author Plus plugin. content-single.php has also been modified from line 42-51.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

if ( function_exists( 'coauthors_posts_links' ) ) {
    global $post;
        $author_id=$post->post_author;
        foreach( get_coauthors() as $coauthor ): ?>
            <div class="author-info">
                <div class="author-avatar">
                <?php echo get_avatar( $coauthor->user_email, '300', '', '', array( 'style' => '' ) ); ?>
                </div><!-- .author-avatar -->

                <div class="author-description">
                    <h2 class="author-title">About <span class="author-heading"><?php echo $coauthor->display_name; ?></h2>

                    <p class="author-bio">
                        <?php echo $coauthor->description; ?></p>
                        <p class="author-bio">
                        View all posts by <a href="<?php echo get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ); ?>"><?php echo $coauthor->display_name; ?></a>
                    </p><!-- .author-bio -->
                </div><!-- .author-description -->

            </div><!-- .author-info -->

        <?php endforeach;
}
?>
