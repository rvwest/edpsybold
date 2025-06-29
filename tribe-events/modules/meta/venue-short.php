<!-- file: tribe-events/modules/meta/venue.php -->
<?php /** 
  * Single Event Meta (Venue) Template * 
  * Override this template in your own theme by creating a file at: *
  * [your-theme]/tribe-events/modules/meta/venue.php * 
  * @package TribeEventsCalendar 
  * @version 4.6.19 
  */

if
(!tribe_get_venue_id()) {
	return;
}
$event_id = Tribe__Main::post_id_helper();
$phone = tribe_get_phone();
$venue_name = tribe_get_venue();
$website = tribe_get_venue_website_link($event_id, $venue_name, '_blank');
$website_title = tribe_events_get_venue_website_title(); ?>


<?php do_action('tribe_events_single_meta_venue_section_start') ?>

	<div class="meta-item">
		<div class="label">Venue</div>
		<div class="detail event-venue">

			<?php if ($website): ?>
				<?php echo $website ?>
			<?php else: ?>
				<?php echo tribe_get_venue() ?>
			<?php endif; ?>
		</div>
	</div>
	


	



<?php do_action('tribe_events_single_meta_venue_section_end') ?>
<!-- file end: tribe-events/modules/meta/venue.php -->