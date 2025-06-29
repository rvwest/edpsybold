<!-- file: tribe-events/modules/meta/categories.php -->
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

echo tribe_get_event_categories(
	get_the_id(),
	[
		'before' => '',
		'sep' => ', ',
		'after' => '',
		'label' => 'Event type', 
		'label_before' => '<div class="meta-item"><div class="label">',
		'label_after' => '</div>',
		'wrap_before' => '	<div class="detail event-category">',
		'wrap_after' => '</div></div>',
	]
);
?>
<!-- file end: tribe-events/modules/meta/categories.php -->