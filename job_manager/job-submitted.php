<?php
/**
 * Notice when job has been submitted.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-submitted.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.34.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_post_types;
echo '<!-- file: /job_manager/job-submitted.php -->';

switch ( $job->post_status ) :
	case 'publish' :
		echo '<div class="job-manager-message">' . wp_kses_post(
			sprintf(
				// translators: %1$s is the job listing post type name, %2$s is the job listing URL.
				esc_html__( '<i class="far fa-check-circle"></i> %1$s listed successfully. To view your listing <a href="%2$s">click here</a>.', 'wp-job-manager' ),
				esc_html( $wp_post_types['job_listing']->labels->singular_name ),
				get_permalink( $job->ID )
			)
		) . '</div>';
	break;
	case 'pending' :
		echo '<div class="job-manager-message"><div class="success-icon"><i class="far fa-check-circle fa-3x"></i></div><div class="success-message"><h2>Thank you</h2><p>' . wp_kses_post(
			sprintf(
				// translators: Placeholder %s is the job listing post type name.
				esc_html__( 'Your %s has been submitted.', 'wp-job-manager' ), 
				esc_html( $wp_post_types['job_listing']->labels->singular_name )
			)
		) . '</p><p>We will email you when the listing has been approved and put live.</p><p>You can also access your advert <a href="' . esc_url( job_manager_get_permalink( 'job_dashboard' )) . '">via your dashboard</a>.</p></div></div>';
	break;
	default :
		do_action( 'job_manager_job_submitted_content_' . str_replace( '-', '_', sanitize_title( $job->post_status ) ), $job );
	break;
endswitch;

do_action( 'job_manager_job_submitted_content_after', sanitize_title( $job->post_status ), $job );
echo '<!-- file end: /job_manager/job-dashboard.php -->';
