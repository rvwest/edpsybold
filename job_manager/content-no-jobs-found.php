<?php
/**
 * Notice when no jobs were found in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-no-jobs-found.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.0.0
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php echo '<!-- file: /job_manager/content-no-jobs-found.php -->'; ?>
<?php if ( defined( 'DOING_AJAX' ) ) : ?>
	<li class="no_job_listings_found">
		<div class="no_job_listings_found-text"> <?php esc_html_e( 'We don\'t currently have any job listings.', 'wp-job-manager' ); ?><br/>
	<a href="post/">Add your job</a></div>
	<div class="no_job_listings_found-image"><img src="<?php echo get_template_directory_uri(); ?>/images/edpsy-swirls-13-light.svg" alt=""></div>
</li>
<?php else : ?>
	<p class="no_job_listings_found"><?php esc_html_e( 'We are currently no vacancies.', 'wp-job-manager' ); ?></p>
	<div class="jobs-placeholder"><img src="<?php echo get_template_directory_uri(); ?>/images/job-plant.jpg" alt=""></div>
<?php endif; ?>
<?php echo '<!-- file end: /job_manager/content-no-jobs-found.php -->'; ?>