<?php
/**
 * Job listing preview when submitting job listings.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-preview.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.32.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!-- file: /job_manager/job-preview.php -->
<form method="post" id="job_preview" action="<?php echo esc_url( $form->get_action() ); ?>">
	<?php
	/**
	 * Fires at the top of the preview job form.
	 *
	 * @since 1.32.2
	 */
	do_action( 'preview_job_form_start' );
	?>
	<p class="job-post-promo"><i class="far fa-briefcase"></i> £400 for a 30-day listing + mailout and social promos</p>

	<div class="progressbar-container job-preview">
<ul class="progressbar">
<li>Write</li>
<li class="active">Preview</li>
<li>Pay</li>
</ul>

</div>

	<div class="job_listing_preview single-job_listing">
	<div class="clear"></div>
	<?php $logo = get_the_company_logo( $post, $size ); ?>
<?php if ( has_post_thumbnail( $post ) ) :?>
	<?php the_company_logo(); ?>
<?php endif; ?>
		<h1 class="title "><?php the_title(); ?></h1>
<h2 class="name">
		<?php if ( $website = get_the_company_website() ) : ?>
			<a class="company-name" target="_blank" href="<?php echo esc_url( $website ); ?>"><?php the_company_name( ); ?></a>
		<?php else : ?>
			<?php the_company_name( ); ?> 
		<?php endif; ?>
		</h2>


		<?php get_job_manager_template_part( 'content-single', 'job_listing' ); ?>
		
			<?php get_job_manager_template( 'job-application.php' ); ?>
		
		<input type="hidden" name="job_id" value="<?php echo esc_attr( $form->get_job_id() ); ?>" />
		<input type="hidden" name="step" value="<?php echo esc_attr( $form->get_step() ); ?>" />
		<input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form->get_form_name() ); ?>" />
	</div>
<div class="preview-actions">
		<input type="submit" name="edit_job" class="button secondary job-manager-button-edit-listing" value="<?php esc_attr_e( 'Edit Job', 'wp-job-manager' ); ?>" />
		<input type="submit" name="continue" id="job_preview_submit_button" class="button job-manager-button-submit-listing" value="<?php echo esc_attr( apply_filters( 'submit_job_step_preview_submit_text', __( 'Pay and post job', 'wp-job-manager' ) ) ); ?>" />
		</div>
	<?php
	/**
	 * Fires at the bottom of the preview job form.
	 *
	 * @since 1.32.2
	 */
	do_action( 'preview_job_form_end' );
	?>
</form>
<!-- file end: /job_manager/job-dashboard.php -->