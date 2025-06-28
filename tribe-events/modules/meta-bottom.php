<!-- file: tribe-events/modules/meta-bottom.php -->
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

 if (tribe_get_venue_id()) {
	// If we have no map to embed and no need to keep the venue separate...
	if (!$set_venue_apart && !tribe_embed_google_map()) {
		tribe_get_template_part('modules/meta/venue');
	} elseif (!$set_venue_apart && !tribe_has_organizer() && tribe_embed_google_map()) {
		// If we have no organizer, no need to separate the venue but we have a map to embed...
		tribe_get_template_part('modules/meta/venue');
		echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
		tribe_get_template_part('modules/meta/map');
		echo '</div>';
	} else {
		// If the venue meta has not already been displayed then it will be printed separately by default
		$set_venue_apart = true;
	}
}

// Include organizer meta if appropriate
if (tribe_has_organizer()) {
	tribe_get_template_part('modules/meta/organizer');
}


?>



</div>
<div class="meta-img-r"></div>

</div>
 <!-- file end: tribe-events/modules/meta-bottom.php -->