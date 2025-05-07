<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://evnt.is/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id = Tribe__Main::post_id_helper();
$website = tribe_get_event_website_link($event_id, 'Find out more + book');
$website_title = tribe_events_get_event_website_title();

// Event Website
// TODO - extract url from $website
if (!empty($website)): ?>
	<?php esc_html($website) ?>
	<div class="meta-item">
		<div class="label">More info</div>
		<div class="detail event-link">
			<?php
			echo $website;
			?></li>
		</div>
	</div>


<?php endif; ?>