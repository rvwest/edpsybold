<!-- file: single-job_listing.php -->
<?php $closing = get_post_meta($post->ID, '_closing_date', true, get_option('date_format')); ?>
<?php $interview = get_post_meta($post->ID, '_interview_date', true) ?>

<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('grid12'); ?>>

            <header>
                <div class="job-company">
                    <h1 class="entry-title" itemprop="headline">
                        <?php the_title(); ?>
                    </h1>
                    <div class="company">
                    <?php if ( $website = get_the_company_website() ) : ?>
			<a class="company-name" href="<?php echo esc_url( $website ); ?>"><?php the_company_name( ); ?></a>
		<?php else : ?>
			<?php the_company_name( ); ?> 
		<?php endif; ?>
                    

                    </div>
                </div>
                <div class="job-listing-logo"><?php the_company_logo(); ?></div>
            </header>



            <div class="meta-slice">
                <div class="meta-img-l"></div>
                <div class="job-listing-meta">
                    <!-- <span class="location"></span> -->
                    <?php do_action('job_listing_meta_start'); ?>
                    <div class="meta-item">
                        <div class="label">Location</div>
                        <div class="detail location"><?php the_job_location(); ?></div>
                    </div>
                    <div class="meta-item">
                        <div class="label">Salary</div>
                        <div class="detail salary"><?php gma_wpjmef_display_combined_data_listings(); ?></div>
                    </div>

                    <?php if (get_option('job_manager_enable_types')) { ?>
                        <div class="meta-item">
                            <div class="label">Contract</div>
                            <div class="detail contract"> <?php $types = wpjm_get_the_job_types(); ?>
                                <?php if (!empty($types)):
                                    foreach ($types as $type): ?>
                                        <span
                                            class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></span>
                                    <?php endforeach; endif; ?>
                            </div>
                        </div>

                    <?php } ?>

                    <?php if ($closing) { ?>
                        <div class="meta-item">
                            <div class="label">Closing date</div>
                            <div class="detail closing-date"><?php echo date("j F Y", strtotime($closing)) ?></div>
                        </div>
                    <?php } ?>

                    <?php if ($interview) { ?>
                        <div class="meta-item">
                            <div class="label">Possible interview date</div>
                            <div class="detail closing-date"><?php echo $interview ?></div>
                        </div>
                    <?php } ?>




                    <?php do_action('job_listing_meta_end'); ?>
                </div>
                <div class="meta-img-r"></div>
            </div>

            <?php if (get_option('job_manager_hide_expired_content', 1) && 'expired' === $post->post_status): ?>
                <div class="job-manager-info"><?php _e('This listing has expired.', 'wp-job-manager'); ?></div>
            <?php else: ?>
                <div class="job_description">
                    <?php wpjm_the_job_description(); ?>
                </div>



                <?php if (candidates_can_apply()): ?>
                    <?php get_job_manager_template('job-application.php'); ?>
                    
                <?php endif; ?>

            <?php endif; ?>







        </article>
        <div class="fullwidth">
            <div class="job-footer grid12">
            <div class="job-footer-contents"><p><a href="/jobs" class="button edp-button-outline secondary see-all-jobs">See all jobs</a></p>
                <p class="footnote-asa"><i class="fad fa-check"></i> We follow the <a
                        href="https://www.asa.org.uk/type/non_broadcast/code_section/20.html">CAP Code for employment ads</a>.
                </p>
            </div>
                </div>
        </div>



    <?php endwhile; endif; ?>

<?php get_footer(); ?>
<!-- file end: single-job_listing.php -->