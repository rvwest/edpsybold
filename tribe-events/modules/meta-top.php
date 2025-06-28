<!-- file: tribe-events/modules/meta-top.php -->
<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @version 4.6.10
 *
 * @package TribeEventsCalendar
 */
?>
<div class="meta-slice">
		<div class="meta-img-l"></div>
		<div class="event-listing-meta">
			<?php
 // Cost
 tribe_get_template_part('modules/meta/cost');
 // Date / time 
 tribe_get_template_part('modules/meta/datetime');
 // Booking link
 tribe_get_template_part('modules/meta/book');
 // Venue and venue address
 tribe_get_template_part('modules/meta/venue');
 // Organiser details
 if (tribe_has_organizer()) {
	 tribe_get_template_part('modules/meta/organizer');
 }
 // Categories (eg webinar)
 tribe_get_template_part('modules/meta/categories');

 ?>



</div>
<div class="meta-img-r"></div>

</div>

<!-- file end: tribe-events/modules/meta-top.php -->