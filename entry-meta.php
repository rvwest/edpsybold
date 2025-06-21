<!-- file: entry-meta.php -->

<div class="meta-bg"></div>
<div class="entry-meta">
     
        <?php
        if ( function_exists( 'coauthors_posts_links' ) ) {
            global $post;
            $author_id = $post->post_author;
            $coauthors = get_coauthors();
            
            if (!empty($coauthors)): ?>
                <div class="authors-section author-count-<?php echo count($coauthors); ?>">
                    <!-- Display all author avatars first -->
                    <div class="author-avatars">
                        <?php foreach($coauthors as $coauthor): ?>
                            <div class="author-avatar">
                                <?php echo get_avatar( $coauthor->user_email, '', '', '', array( 'style' => '' ) ); ?>
                            </div>
                        <?php endforeach; ?>
                    </div><!-- .author-avatars -->
                    
                    <!-- Display all author names -->
                    <div class="author-name">
                        by 
                        <?php 
                        $author_names = array();
                        foreach($coauthors as $coauthor) {
                            $author_names[] = '<span class="author-heading">' . $coauthor->display_name . '</span>';
                        }
                        echo implode(', ', $author_names);
                        ?>
                    </div><!-- .author-names -->
                </div><!-- .authors-section -->
            <?php endif;
        }
        ?>
        



        <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"
            title="<?php echo esc_attr(get_the_date()); ?>" <?php if (is_single()) {
                   echo 'itemprop="datePublished" pubdate';
               } ?>><?php the_time(get_option('date_format')); ?></time>
        <?php if (is_single()) {
            echo '<meta itemprop="dateModified" content="' . esc_attr(get_the_modified_date()) . '">';
        } ?>
</div><!-- file end: entry-meta.php -->