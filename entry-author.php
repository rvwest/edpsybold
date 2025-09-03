<!-- file: entry-author.php -->

<div class="entry-author--top">
     
        <?php
        if ( function_exists( 'coauthors_posts_links' ) ) {
            global $post;
            $author_id = $post->post_author;
            $coauthors = get_coauthors();
            
            if (!empty($coauthors)): ?>
                <div class="authors-section author-count-<?php echo count($coauthors); ?>">
                    <!-- Display all author avatars first -->
                    <div class="author-avatars">
                        <?php 
                        $author_counter = 1;
                        foreach($coauthors as $coauthor): ?>
                            <div class="author-avatar author-<?php echo $author_counter; ?>">
                                <?php echo get_avatar( $coauthor->user_email, '', '', '', array( 'style' => 'author' ) ); ?>
                            </div>
                        <?php 
                        $author_counter++;
                        endforeach; ?>
                    </div><!-- .author-avatars -->
                    
                    <!-- Display all author names -->
                    <div class="author-name">
                        by 
                        <?php 
                        $author_names = array();
                        foreach($coauthors as $coauthor) {
                            $author_names[] = '<span class="author-heading"><a href="' . esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ) . '">' . esc_html( $coauthor->display_name ) . '</a></span>';
                        }
                        
                        $author_count = count($coauthors);
                        if ($author_count == 2) {
                            // Two authors: use "&" between them
                            echo implode('<br> & ', $author_names);
                        } elseif ($author_count > 2) {
                            // More than 2 authors: use commas, but "&" before the last author
                            $last_author = array_pop($author_names);
                            echo implode(',<br> ', $author_names) . '<br>& ' . $last_author;
                        } else {
                            // Single author: just display the name
                            echo $author_names[0];
                        }
                        ?>
                    </div><!-- .author-names -->
                    <div class="author-deco"></div>
                </div><!-- .authors-section -->
            <?php endif;
        }
        ?>
        
</div><!-- file end: entry-author.php -->