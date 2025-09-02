<?php
/**
 * Calculate estimated read time for posts.
 *
 * This function assumes an average reading speed suited for
 * university-level readers and technical content.
 */
if ( ! function_exists( 'edp_calculate_read_time' ) ) {
    /**
     * Estimate read time in minutes for a post.
     *
     * @param int|null $post_id Post ID. Defaults to current post.
     * @param int      $wpm     Reading speed in words per minute.
     *
     * @return int Estimated read time in whole minutes (minimum of 1).
     */
    function edp_calculate_read_time( $post_id = null, $wpm = 200 ) {
        if ( null === $post_id ) {
            $post_id = get_the_ID();
        }

        $content = get_post_field( 'post_content', $post_id );
        if ( empty( $content ) ) {
            return 1;
        }

        $content    = strip_shortcodes( $content );
        $content    = wp_strip_all_tags( $content );
        $word_count = str_word_count( $content );

        $minutes = (int) ceil( $word_count / max( 1, $wpm ) );

        return max( $minutes, 1 );
    }
}
