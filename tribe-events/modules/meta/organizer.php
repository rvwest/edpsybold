<!-- file: tribe-events/modules/meta/organizer.php -->
<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/organizer.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count($organizer_ids) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
$website_title = tribe_events_get_organizer_website_title();
?>


<?php
do_action('tribe_events_single_meta_organizer_section_start');

foreach ($organizer_ids as $organizer) {
	if (!$organizer) {
		continue;
	}

	?>

	<div class="meta-item">
		<div class="label">Organiser</div>
		<div class="detail event-organiser">
			<ul>
				<li><?php $organize_website = tribe_get_event_meta($organizer, '_OrganizerWebsite', true);
				$organizer_name = get_the_title($organizer);
				if ($organize_website) {
					echo '<a rel=”nofollow” href="' . esc_url($organize_website) . '">' . esc_html($organizer_name) . '</a>';
				} else {
					echo esc_html($organizer_name);
				} ?></li>
				<?php if ($phone) {
					echo '<li>' . esc_html($phone) . '</li>';
				} ?>
				<?php if ($email) {
					echo '<a rel=”nofollow” href="mailto:' . esc_html($email) . '">' . esc_html($email) . '</a>';
				} ?>
			</ul>
		</div>
	</div>
<?php } ?>
<!-- file end: tribe-events/modules/meta/organizer.php -->