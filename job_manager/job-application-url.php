<!-- file: job_manager/job-application-url.php -->
<?php
/**
 * Apply using link to website.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application-url.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.32.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
echo '<!-- file: /job_manager/job-application-url.php -->';
?>
<div class="wpjm-submit-block apply-block">
	<a href="<?php echo esc_url($apply->url); ?>" class="button edp-button-solid">Find out more and apply</a>
</div>
<!-- file end: job_manager/job-application-url.php -->