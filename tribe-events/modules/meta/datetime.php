<!-- file: tribe-events/modules/meta/datetime.php -->
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
$time_format = get_option('time_format', Tribe__Date_Utils::TIMEFORMAT);
$time_range_separator = tec_events_get_time_range_separator();
$show_time_zone = tribe_get_option('tribe_events_timezones_show_zone', false);
$local_start_time = tribe_get_start_date($event_id, true, Tribe__Date_Utils::DBDATETIMEFORMAT);
$time_zone_label = Tribe__Events__Timezones::is_mode('site') ? Tribe__Events__Timezones::wp_timezone_abbr($local_start_time) : Tribe__Events__Timezones::get_event_timezone_abbr($event_id);

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date(null, false);
$start_time = tribe_get_start_date(null, false, $time_format);
$start_ts = tribe_get_start_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date(null, false);
$end_time = tribe_get_end_date(null, false, $time_format);
$end_ts = tribe_get_end_date(null, false, Tribe__Date_Utils::DBDATEFORMAT);

$time_formatted = null;
if ($start_time == $end_time) {
	$time_formatted = esc_html($start_time);
} else {
	$time_formatted = esc_html($start_time . $time_range_separator . $end_time);
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters('tribe_events_single_event_time_formatted', $time_formatted, $event_id);

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters('tribe_events_single_event_time_title', __('Time:', 'the-events-calendar'), $event_id);

?>

<?php
do_action('tribe_events_single_meta_details_section_start');

// All day (multiday) events
if (tribe_event_is_all_day() && tribe_event_is_multiday()):
	?>
	<div class="meta-item">
		<div class="label">Start date</div>
		<div class="detail event-schedule event-start-date"><?php echo esc_html($start_date); ?></div>
	</div>
	<div class="meta-item">
		<div class="label">End date</div>
		<div class="detail event-schedule event-end-date"><?php echo esc_html($end_date); ?></div>
	</div>
	<?php
	// All day (single day) events
elseif (tribe_event_is_all_day()):
	?>
	<div class="meta-item">
		<div class="label">Date</div>
		<div class="detail event-schedule event-start-time"><?php echo esc_html($start_date); ?></div>
	</div>
	<?php
	// Multiday events
elseif (tribe_event_is_multiday()):
	?>
	<div class="meta-item">
		<div class="label">Start date</div>
		<div class="detail event-schedule event-start-date"><?php echo esc_html($start_datetime); ?></div>
	</div>
	<div class="meta-item">
		<div class="label">End date</div>
		<div class="detail event-schedule event-end-date"><?php echo esc_html($end_datetime); ?></div>
	</div>
	<?php
	// Single day events
else:
	?>

	<div class="meta-item">
		<div class="label">Date</div>
		<div class="detail event-schedule event-end-date"><?php echo esc_html($start_date); ?>
			(<?php echo $time_formatted; ?>)
		</div>
	</div>

<?php endif ?>

<?php
/**
 * Included an action where we inject Series information about the event.
 *
 * @since 6.0.0
 */
do_action('tribe_events_single_meta_details_section_after_datetime');
?>
<!-- file end: tribe-events/modules/meta/datetime.php -->