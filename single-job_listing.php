<!-- edpsybold - used to control the job ad page ---->

<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header>

                <h1 class="entry-title" itemprop="headline">
                    <?php the_title(); ?>
                </h1>
                <div class="company">
                    <?php the_company_name(); ?>

                </div>

            </header>
            <div class="job-listing-logo"><?php the_company_logo(); ?></div>




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
                <div class="meta-item">
                    <div class="label">Closing date</div>
                    <div class="detail closing-date"></div>
                </div>
                <div class="meta-item">
                    <div class="label">Interview date</div>
                    <div class="detail interview-date"></div>
                </div>
                <?php do_action('job_listing_meta_end'); ?>
            </div>


            <div class="job_description">
                <?php wpjm_the_job_description(); ?>
            </div>
            </div>


            <?php if (is_singular()) {
                get_template_part('entry-footer');
            } ?>
        </article>
        <?php if (comments_open() && !post_password_required()) {
            comments_template('', true);
        } ?>
    <?php endwhile; endif; ?>
<footer class="footer">
    <?php get_template_part('nav', 'below-single'); ?>
</footer>
<?php get_footer(); ?>