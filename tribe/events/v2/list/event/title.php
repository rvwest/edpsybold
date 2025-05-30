<!-- file: tribe/events/v2/list/event/title.php -->
<?php
/**
 * View: List View - Single Event Title
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
?>
<h3 class="edp-events-calendar-list__event-title">

	<?php
	// phpcs:ignore
	echo $event->title;
	?>

</h3>
<!-- file end: tribe/events/v2/list/event/title.php -->