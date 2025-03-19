<?php
/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.0.0
 * @version     1.34.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
?>

<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_long ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_lat ); ?>">
	<a href="<?php the_job_permalink(); ?>">
	<div class="listing-logo"><?php the_company_logo(); ?></div>
		<div class="job-list-details">
		<div class="position-main">
			<div class="job-title">
				<h2><?php wpjm_the_job_title(); ?></h2>
			</div>
			<div class="salary"><?php gma_wpjmef_display_combined_data_listings(); ?></div>

			<div class="company">
				<?php the_company_name(); ?> 

				</div></div>
				
		<div class="position-meta">
			<!-- <span class="location"></span> -->
			

				<?php do_action( 'job_listing_meta_start' ); ?>		
				<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
					<div class="meta-types">
					<?php $types = wpjm_get_the_job_types(); ?>
					<?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
						<span class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><?php echo esc_html( $type->name ); ?></span>
					<?php endforeach; endif; ?>
					</div>
				<?php } ?>		
			<span class="date">Posted: <?php the_job_publish_date(); ?></span>
		</div>

			<?php do_action( 'job_listing_meta_end' ); ?>
				</div>
	</a>
</li>
