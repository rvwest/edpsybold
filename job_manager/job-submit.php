<?php
/**
 * Content for job submission (`[submit_job_form]`) shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-submit.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.33.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

global $job_manager;
?>
<!-- file: /job_manager/job-submit.php -->
	

	<div class="progressbar-container">
		<ul class="progressbar">
			<li class="active">Write</li>
			<li>Preview</li>
			<li>Pay</li>
		</ul>
	</div>
<form action="<?php echo esc_url($action); ?>" method="post" id="submit-job-form" class="job-manager-form"
	enctype="multipart/form-data">
	<h2>Account</h2>
	<div class="form-block edpjobs-signin">



		<?php do_action('submit_job_form_start'); ?>

		<?php if (apply_filters('submit_job_form_show_signin', true)): ?>

			<?php get_job_manager_template('account-signin.php'); ?>
			
		<?php endif; ?>
	</div>

	<?php if (job_manager_user_can_post_job() || job_manager_user_can_edit_job($job_id)): ?>

		<!-- Job Information Fields -->

		<?php
		if (isset($resume_edit) && $resume_edit) {
			printf('<p class="new-job-warning" ><strong><i class="far fa-exclamation-triangle"></i> ' . esc_html__("You about to edit an existing job. If this isn't what you planned - %s", 'wp-job-manager') . '</strong></p>', '<a href="?new=1&key=' . esc_attr($resume_edit) . '">' . esc_html__('Create a new job', 'wp-job-manager') . '</a>');
		}
		?>

		<?php do_action('submit_job_form_job_fields_start'); ?>

		<!-- Company Information Fields -->
		<?php if ($company_fields): ?>
			<h2><?php esc_html_e('Your organisation', 'wp-job-manager'); ?></h2>
			<div class="form-block">
				

				<?php do_action('submit_job_form_company_fields_start'); ?>

				<?php foreach ($company_fields as $key => $field): ?>
					<fieldset class="fieldset-<?php echo esc_attr($key); ?> fieldset-type-<?php echo esc_attr($field['type']); ?>">
						<label
							for="<?php echo esc_attr($key); ?>"><?php echo wp_kses_post($field['label']) . wp_kses_post(apply_filters('submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __('(optional)', 'wp-job-manager') . '</small>', $field)); ?></label>
						<div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
							<?php get_job_manager_template('form-fields/' . $field['type'] . '-field.php', ['key' => $key, 'field' => $field]); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>

				<?php do_action('submit_job_form_company_fields_end'); ?>
			</div>
		<?php endif; ?>
		
		<h2>Job headline</h2>
<div class="form-block">
  <?php foreach ( $job_fields as $key => $field ) : 
        $is_editor = ( isset( $field['type'] ) && 'wp-editor' === $field['type'] );
        if ( $is_editor ) : ?>
		</div>
		<h2><?php echo esc_html__( 'Job description', 'your-textdomain' ); ?></h2>
		<div class="form-block form-block-job-description" id="form-block-job-description">
        <?php endif; ?>

        <fieldset class="fieldset-<?php echo esc_attr( $key ); ?> fieldset-type-<?php echo esc_attr( $field['type'] ); ?>">
          <label for="<?php echo esc_attr( $key ); ?>">
            <?php
              echo wp_kses_post( $field['label'] ) .
                   wp_kses_post(
                     apply_filters(
                       'submit_job_form_required_label',
                       $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>',
                       $field
                     )
                   );
            ?>
          </label>
          <div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
            <?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', [ 'key' => $key, 'field' => $field ] ); ?>
          </div>
        </fieldset>

        <?php if ( $is_editor ) : ?>
		</div>  <h2>Job details</h2> <div class="form-block">
        <?php endif; ?>
  <?php endforeach; ?>

  <?php do_action( 'submit_job_form_job_fields_end' ); ?>
</div>

		
		<?php do_action('submit_job_form_end'); ?>
		<p class="wpjm-submit-block">
			<input type="hidden" name="job_manager_form" value="<?php echo esc_attr($form); ?>" />
			<input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr($step); ?>" />
			<?php
			if (isset($can_continue_later) && $can_continue_later) {
				echo '<input type="submit" name="save_draft" class="button secondary save_draft" value="' . esc_attr__('Save Draft', 'wp-job-manager') . '" formnovalidate />';
			}
			?>
		 	
			 <button type="submit" name="submit_job" value="1" class="button edp-button-solid">
  Preview and continue <i class="fas fa-arrow-right" aria-hidden="true"></i>
</button>
			<span class="spinner"
				style="background-image: url(<?php echo esc_url(includes_url('images/spinner.gif')); ?>);"></span>
		</p>
	<?php else: ?>

		<?php do_action('submit_job_form_disabled'); ?>

	<?php endif; ?>
</form>
<!-- file: /job_manager/job-submit.php -->
