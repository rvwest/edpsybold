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
?>
<a href="<?php the_permalink(); ?>" class="crp_link post-3212 crp_job">
	<?php if ($logo = get_the_company_logo()): ?>
		<figure>
			<div class="background-image" style="background-image: url('<?php echo esc_url($logo); ?>')"></div>
		</figure>
	<?php endif; ?>
	<h3 class="crp_title">
		<span class="title-tag"><i class="far fa-bell-on"></i> Job: </span>
		<?php wpjm_the_job_title(); ?>
		- <?php the_company_name(false); ?>
	</h3>
</a>