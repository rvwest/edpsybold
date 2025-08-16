<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing-company.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.14.0
 * @version     1.32.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! get_the_company_name() ) {
	return;
}
?>
<?php echo '<!-- file: /job_manager/content-single-job_listing-company.php -->'; ?>
<!-- <div class="company">
<?php $logo = get_the_company_logo( $post, $size ); ?>
<?php if ( has_post_thumbnail( $post ) ) :?>
	<?php the_company_logo(); ?>
<?php endif; ?>
<div class="company-meta"><p class="name">
		<?php if ( $website = get_the_company_website() ) : ?>
			<a class="company-name" href="<?php echo esc_url( $website ); ?>"><?php the_company_name( ); ?></a>
		<?php else : ?>
			<?php the_company_name( ); ?> 
		<?php endif; ?>
	</p>
	<?php the_company_tagline( '<p class="tagline">', '</p>' ); ?>
	<?php the_company_twitter( '<p class="twitter"><i class="fab fa-twitter"></i> ', '</p>' ); ?>
	<?php echo '<!-- file end: /job_manager/content-single-job_listing-company.php -->'; ?>
		</div></div> -->
