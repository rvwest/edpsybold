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
$phone = tribe_get_phone();
$website = tribe_get_venue_website_link();
$website_title = tribe_events_get_venue_website_title(); ?>


<?php do_action('tribe_events_single_meta_venue_section_start') ?>
<?php if ($website): ?>
	<dt class="tribe-venue-url-label">
		<?php echo esc_html(tribe_get_venue_label_singular()) ?> website
	</dt>
<?php else: ?>
	<div class="meta-item">
		<div class="label">Venue</div>
		<div class="detail event-venue">
			<?php echo tribe_get_venue() ?>
		</div>
	</div>
	</php endif; ?>


	<?php if (tribe_address_exists()): ?>
		<div class="meta-item">
			<div class="label">Venue address</div>
			<div class="detail event-venue">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if (tribe_show_google_map_link()): ?>
						<?php echo tribe_get_map_link_html(); ?>
					<?php else: ?>
						Location without GM
					<?php endif; ?>
				</address>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!empty($phone)): ?>
		<div class="label">Venue phone</div>
		<div class="detail event-venue">
			<?php echo $phone ?>
		</div>
	<?php endif ?>


<?php endif ?>

<?php do_action('tribe_events_single_meta_venue_section_end') ?>
<!-- file end: tribe-events/modules/meta/venue.php -->