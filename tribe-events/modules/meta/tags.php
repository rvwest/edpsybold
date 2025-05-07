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

tribe_meta_event_archive_tags(
	/* Translators: %s: Event (singular) */
	sprintf(
		esc_html__('%s Tags:', 'the-events-calendar'),
		tribe_get_event_label_singular()
	),
	', ',
	true
);
?>