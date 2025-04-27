<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();
?>
<div class="bread-title-holder">
		<div class="container">
			<div class="row-fluid">
				<section class="cont_nav"><div class="cont_nav_inner"><?php	tribe_breadcrumbs(); ?></div></section>			</div>
		</div>
	</div>

<!--<div id="tribe-events-pg-template">-->
<div class="page-content default-pagetemp">
		<div class="container post-wrap">
			<div class="row-fluid">
				<div id="content" class="span8 center-col">
		
	<?php tribe_events_before_html(); ?>
	<?php tribe_get_view(); ?>
	<?php tribe_events_after_html(); ?>

				</div>
			</div>
		</div>
	</div> <!-- #tribe-events-pg-template -->
<?php
get_footer();
