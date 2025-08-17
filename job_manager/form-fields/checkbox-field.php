<?php
/**
 * Shows the `checkbox` form field on job listing forms.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/form-fields/checkbox-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!-- file: /job_manager/form-fields/checkbox-field.php -->
<?php if ( ! empty( $field['description'] ) ) : ?>
	<p class="description">
		<?php echo wp_kses_post( $field['description'] ); ?>
	</p>
	<?php endif; ?>
<div class="checkbox-pair">
	<input type="checkbox" class="input-checkbox" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>" id="<?php echo esc_attr( $key ); ?>" <?php checked( ! empty( $field['value'] ), true ); ?> value="1" <?php if ( ! empty( $field['required'] ) ) echo 'required'; ?> />
	<span class="checkbox-label"><?php echo empty( $field['placeholder'] ) ? '' : esc_attr( $field['placeholder'] ); ?></span></div>
<!-- file end: /job_manager/form-fields/checkbox-field.php -->
