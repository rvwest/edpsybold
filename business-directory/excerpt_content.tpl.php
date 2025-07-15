<?php
/**
 * Listings excerpt content template 
 *
 * @package BDP/Themes/Default/Templates/Excerpt Content
 */

?>
<!-- file: business-directory/excerpt_content.tpl.php-->

<div class="excerpt-content --wpbdp-hide-title">
	<div class="listing-meta">


		<?php echo $fields->name->html; ?>

		<div class="secondary-meta"><?php
		$methodology_value = strip_tags($fields->methodology->raw[0]);
		if (trim($methodology_value) === 'Interpretative Phenomenological Analysis (IPA)') {
			echo '<div class="wpbdp-field-value wpbdp-methodology">IPA</div>';
		} else if (trim($methodology_value) === 'Multi-methods approaches') {

			echo '<div class="wpbdp-field-value wpbdp-methodology">Multi-method</div>';
		} else {
			echo '<div class="wpbdp-field-value wpbdp-methodology">' . $fields->methodology->raw[0] . '</div>';
		}
		?>

		<?php echo $fields->year->html; ?></div>
	</div>


	<div class="listing-title">
		<h3><?php echo $fields->title->raw; ?></h3>
		<?php echo $fields->subtitle->html; ?>
	</div>
</div>
<!-- file end: business-directory/excerpt_content.tpl.php-->