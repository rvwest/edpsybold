<!-- file: job_manager/job-application-email.php -->
<?php
/**
 * Apply by email content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application-email.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<p class="apply-block">
	<?php printf(wp_kses_post(__('<strong>For more information, and to apply for this job contact</strong> <a class="job_application_email" href="mailto:%1$s%2$s">%1$s</a>', 'wp-job-manager')), esc_html($apply->email), '?subject=' . rawurlencode($apply->subject)); ?>
</p>
<!-- file end: job_manager/job-application-email.php -->