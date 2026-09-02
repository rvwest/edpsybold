<!-- file: job_manager/content-job_listing.php -->

<?php if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $post;

// Mirrors the guard in WP Job Manager's own content-job_listing.php: this theme
// override otherwise bypasses the password and view-capability checks for any
// listing surfaced through a direct WP_Query.
if (post_password_required($post) || !job_manager_user_can_view_job_listing($post->ID)) {
    return;
}

echo '<!-- file: job_manager/content-job_listing.php -->';
?>

<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr($post->geolocation_long); ?>"
    data-latitude="<?php echo esc_attr($post->geolocation_lat); ?>">
    <a href="<?php the_job_permalink(); ?>">
        <div class="job-listing-logo"><?php the_company_logo(); ?></div>
        <div class="job-listing--details-meta">
            <div class="job-listing-details">
                <div class="job-title">
                    <h2><?php wpjm_the_job_title(); ?></h2>
                </div>

                <div class="company">
                    <?php the_company_name(); ?>

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
        </div>
    </a>
</li>
<!-- file end: job_manager/content-job_listing.php -->