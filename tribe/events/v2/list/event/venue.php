<?php
/**
 * View: List Single Event Venue
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/venue.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 6.2.0
 * @since 6.2.0 Added the `tec_events_view_venue_after_address` action.
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 * @var string  $slug  The slug of the view.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if (!$event->venues->count()) {
	return;
}

$separator = esc_html_x(', ', 'Address separator', 'the-events-calendar');
$venue = $event->venues[0];
?>
<address class="epd-events-calendar-list__event-venue tribe-common-b2">

	<span class="epd-events-calendar-list__event-venue-address">
		<?php
		//	echo esc_html($address);
		
		if (!empty($venue->city)):
			echo esc_html($venue->city);
		endif;

		?>
	</span>
	<?php
	/**
	 * Fires after the full venue has been displayed.
	 *
	 * @since 6.2.0
	 *
	 * @param WP_Post $event Event post object.
	 * @param string  $slug  Slug of the view.
	 */
	do_action('tec_events_view_venue_after_address', $event, $slug);
	?>
</address>