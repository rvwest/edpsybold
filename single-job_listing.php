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



            <div class="job-listing-details">
                <div class="job-title">
                    <h2><?php wpjm_the_job_title(); ?></h2>
                </div>


            </div>
            <div class="job-listing-meta">
                <!-- <span class="location"></span> -->


                <?php do_action('job_listing_meta_start'); ?>
                <?php if (get_option('job_manager_enable_types')) { ?>
                    <div class="meta-types">
                        <?php $types = wpjm_get_the_job_types(); ?>
                        <?php if (!empty($types)):
                            foreach ($types as $type): ?>
                                <span
                                    class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></span>
                            <?php endforeach; endif; ?>
                    </div>
                <?php } ?>
                <div class="salary"><?php gma_wpjmef_display_combined_data_listings(); ?></div>

            </div>

            <?php do_action('job_listing_meta_end'); ?>
            </div>

            <?php get_template_part('entry', 'content'); ?>
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