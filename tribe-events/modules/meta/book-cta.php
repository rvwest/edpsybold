<!-- file: tribe-events/modules/meta/book-cta.php -->
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

// Event Website
// TODO - extract url from $website
if (!empty($website)): ?>
	<?php esc_html($website) ?>
	<div class="meta-item page-cta">
		<div class="detail event-link">
			<?php
			echo my_custom_event_website_link( get_the_ID($event_id), 'Find out more and book', '_blank', 'button edp-button-solid' );
			?></li>
		</div>
	</div>


<?php endif; ?>
<!-- file end: tribe-events/modules/meta/book-cta.php -->