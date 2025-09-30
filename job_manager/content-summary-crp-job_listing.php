<?php
/**
 * Job listing summary
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-summary-job_listing.php.
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

global $job_manager;


echo do_shortcode('[job_summary width="" align=""]');

?>