<!-- file: tribe-events/single-event.php -->
<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if (!defined('ABSPATH')) {
	die('-1');
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = Tribe__Events__Main::postIdHelper(get_the_ID());

/**
 * Allows filtering of the event ID.
 *
 * @since 6.0.1
 *
 * @param numeric $event_id
 */
$event_id = apply_filters('tec_events_single_event_id', $event_id);

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array   $title_classes List of classes to create the class string from.
 * @param numeric $event_id      The ID of the displayed event.
 */
$title_classes = apply_filters('tribe_events_single_event_title_classes', ['tribe-events-single-event-title'], $event_id);
$title_classes = implode(' ', tribe_get_classes($title_classes));

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string  $before   HTML string to display before the title text.
 * @param numeric $event_id The ID of the displayed event.
 */
$before = apply_filters('tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id);

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string  $after    HTML string to display after the title text.
 * @param numeric $event_id The ID of the displayed event.
 */
$after = apply_filters('tribe_events_single_event_title_html_after', '</h1>', $event_id);

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string  $after    HTML string to display. Return an empty string to not display the title.
 * @param numeric $event_id The ID of the displayed event.
 */
$title = apply_filters('tribe_events_single_event_title_html', the_title($before, $after, false), $event_id);
$cost = tribe_get_formatted_cost($event_id);

?>
<article id="tribe-events-content" class="tribe-events-single type-tribe_events grid12">

	<!-- Notices -->


	<header class="event-page-header">
		<?php echo $title; ?>
		<?php if (strpos(implode(' ', get_body_class()), 'event-cat-on-demand') === false): ?>
			<?php echo tribe_events_event_schedule_details($event_id, '<div class="edp-event-date-time">', '</div>'); ?>
		<?php else: ?>
			<div><span class="edp-event-on-demand">On-demand training</span> <i class="far fa-bolt on-demand-icon"></i>
			</div>
		<?php endif; ?>
		<?php  if (tribe_get_city( $event_id )) {?>
			<div class="edp-event-cost"><?php echo tribe_get_city( $event_id );?></div> 
		<?php } ?>
		<div class="edp-event-cost"><?php echo esc_html($cost); ?></div>
		
	</header>

	<?php tribe_the_notices() ?>
	


	<!-- #tribe-events-header -->

	<?php while (have_posts()):
		the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image($event_id, 'full', false); ?>

			<!-- Event content -->
			<?php do_action('tribe_events_single_event_before_the_content') ?>
			<div class="tribe-events-single-event-description tribe-events-content">
			
			<?php the_content(); ?>
			</div>
			<?php tribe_get_template_part('modules/meta/book-cta'); ?>

			<!-- .tribe-events-single-event-description -->
			<!-- ?php do_action('tribe_events_single_event_after_the_content') ?> -->

			<!-- Event meta -->
			<?php do_action('tribe_events_single_event_before_the_meta') ?>
	</div>
	
			<?php tribe_get_template_part('modules/meta-bottom'); ?>
			<?php 
			// Only show map if it's enabled for this event
			if (tribe_embed_google_map()) {
				tribe_get_template_part('modules/meta/map'); 
			}
			?>
			<?php do_action('tribe_events_single_event_after_the_meta') ?>
		
		<?php if (get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option('showComments', false))
			comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		
	</div>
</article>
<!-- file end: tribe-events/single-event.php -->