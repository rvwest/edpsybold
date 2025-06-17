<!-- file: entry-meta.php -->

<div class="meta-bg"></div>
<div class="entry-meta">
     
        <?php
        if ( function_exists( 'coauthors_posts_links' ) ) {
            global $post;
                $author_id=$post->post_author;
                foreach( get_coauthors() as $coauthor ): ?>
                    <div class="author-info">
                        <div class="author-avatar">
                        <?php echo get_avatar( $coauthor->user_email, '', '', '', array( 'style' => '' ) ); ?>
                        </div><!-- .author-avatar -->
        
                        <div class="author-name">
                           by <span class="author-heading"><?php echo $coauthor->display_name; ?>
                        </div>
        
                    </div><!-- .author-info -->
        
                <?php endforeach;
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