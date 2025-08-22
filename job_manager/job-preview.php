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
	

	<div class="progressbar-container job-preview">
<ul class="progressbar">
<li>Write</li>
<li class="active">Preview</li>
<li>Pay</li>
</ul>

</div>

	<div class="job_listing_preview edp-jobs single-job_listing">
	

	<article id="post-<?php the_ID(); ?>" <?php post_class('grid12'); ?>>

<header>
	<div class="job-company">
		<h1 class="entry-title" itemprop="headline">
			<?php the_title(); ?>
		</h1>
		<div class="company">
		<?php if ( $website = get_the_company_website() ) : ?>
<a class="company-name" href="<?php echo esc_url( $website ); ?>"><?php the_company_name( ); ?></a>
<?php else : ?>
<?php the_company_name( ); ?> 
<?php endif; ?>
		

		</div>
	</div>
	<div class="job-listing-logo"><?php the_company_logo(); ?></div>
</header>



<div class="meta-slice">
	<div class="meta-img-l"></div>
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

		<?php if ($closing) { ?>
			<div class="meta-item">
				<div class="label">Closing date</div>
				<div class="detail closing-date"><?php echo date("j F Y", strtotime($closing)) ?></div>
			</div>
		<?php } ?>

		<?php if ($interview) { ?>
			<div class="meta-item">
				<div class="label">Interview date</div>
				<div class="detail closing-date"><?php echo $interview ?></div>
			</div>
		<?php } ?>




		<?php do_action('job_listing_meta_end'); ?>
	</div>
	<div class="meta-img-r"></div>
</div>

<?php if (get_option('job_manager_hide_expired_content', 1) && 'expired' === $post->post_status): ?>
	<div class="job-manager-info"><?php _e('This listing has expired.', 'wp-job-manager'); ?></div>
<?php else: ?>
	<div class="job_description">
		<?php wpjm_the_job_description(); ?>
	</div>


	<?php get_job_manager_template( 'job-application.php' ); ?>

<?php endif; ?>










	
	
		
		<input type="hidden" name="job_id" value="<?php echo esc_attr( $form->get_job_id() ); ?>" />
		<input type="hidden" name="step" value="<?php echo esc_attr( $form->get_step() ); ?>" />
		<input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form->get_form_name() ); ?>" />
	</div>
	
<div class="preview-actions wpjm-submit-block">
		
	
		<button type="submit" name="edit_job" value="1" class="button edp-button-outline">
  <i class="fas fa-arrow-left" aria-hidden="true"> Edit job</i>
</button>
		
		<button type="submit" name="continue" value="1" id="job_preview_submit_button" class="button edp-button-solid">
  Pay for listing <i class="fas fa-arrow-right" aria-hidden="true"></i>
</button>

	<?php
	/**
	 * Fires at the bottom of the preview job form.
	 *
	 * @since 1.32.2
	 */
	do_action( 'preview_job_form_end' );
	?>
</form>
</article>
<!-- file end: /job_manager/job-dashboard.php -->