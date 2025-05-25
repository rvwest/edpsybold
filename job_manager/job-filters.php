<!-- file: job_manager/job-filters.php -->
<?php
/**
 * Filters in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-filters.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.33.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

wp_enqueue_script('wp-job-manager-ajax-filters');

do_action('job_manager_job_filters_before', $atts);
?>

<form class="job_filters">
	<?php do_action('job_manager_job_filters_start', $atts); ?>

	<?php do_action('job_manager_job_filters_end', $atts); ?>
</form>

<?php do_action('job_manager_job_filters_after', $atts); ?>

<noscript><?php esc_html_e('Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'wp-job-manager'); ?></noscript>
<!-- file end: job_manager/job-filters.php -->