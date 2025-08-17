<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Metabox For Venues
 * This is used to add a metabox to the event submission form to allow for choosing or
 * creating a venue for user submitted events.
 *
 * This is ALSO used in the Venue edit view. Be careful to test changes in both places.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/venue.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 2.1
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

// If the user cannot create new venues *and* if there are no venues
// to select from then there's no point in generating this UI
if ( ! tribe( 'community.main' )->event_form()->should_show_linked_posts_module( Tribe__Events__Venue::POSTTYPE ) ) {
    return;
}

// We need the variables here otherwise it will throw notices
$venue_label_singular = tribe_get_venue_label_singular();

if ( ! isset( $event ) ) {
	$event = null;
}

$google_maps_enabled = tribe_get_option( 'embedGoogleMaps', true )
?>

<div id="event_tribe_venue" class="tribe-section tribe-section-venue eventForm <?php echo tribe_community_events_single_geo_mode() ? 'tribe-single-geo-mode' : ''; ?>">
	<div class="tribe-section-header">
		<h3 class="<?php echo tribe_community_events_field_has_error( 'organizer' ) ? 'error' : ''; ?>">
			<?php
			printf( esc_html__( '%s', 'tribe-events-community' ), $venue_label_singular );
			echo tribe_community_required_field_marker( 'venue' );
			?>
		
	</h3>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_venue' );

	?>


<div class="tribe-events-community-details eventForm" id="event_tribe_venue">

<div class="tribe-community-event-info">






<div class="venue">

<label for="VenueName">
	<?php esc_html_e( 'Venue name', 'tribe-events-community' ); ?>:
</label>
<input
	type="text"
	id="VenueName"
	name="venue[Venue]"
	size="25"
	value="<?php echo esc_attr( tribe_get_venue() ); ?>"
/>
</div>
<p><strong>-- or --</strong></p>
<div class="venue">
		
						<label for="VenueName">
							<?php esc_html_e( 'This is an online event', 'tribe-events-community' ); ?>:
						</label>
						<input
							type="checkbox"
							id="VenueName"
							name="venue[Venue]"
							value="Online"
						/>
		
					</div>
			

					<h4>Venue details (if you have them)</h4>
		<div class="venue">

		<label for="VenueAddress">
			<?php esc_html_e( 'Address', 'tribe-events-community' ); ?>:
		</label>
		<input
			type="text"
			id="VenueAddress"
			name="venue[Address]"
			size="25"
			value="<?php echo esc_attr( tribe_get_address() ); ?>"
		/>

	</div><!-- .venue -->
	<div class="venue">

		<label for="VenueCity">
			<?php esc_html_e( 'City', 'tribe-events-community' ); ?>:
		</label>
		<input
			type="text"
			id="VenueCity"
			name="venue[City]"
			size="25"
			value="<?php echo esc_attr( tribe_get_city() ); ?>"
		/>
	</div><!-- .venue -->

	<?php if ( ! tribe_community_events_single_geo_mode() ) : ?>
		<div class="venue" style="display:none;">
			<label for="EventCountry">
				<?php esc_html_e( 'Country', 'tribe-events-community' ); ?>:
			</label>
			<input
				id="EventCountry"
				name="venue[Country]"
				type="text"
				size="25"
				value="United Kingdom"
			/>
		</div><!-- .venue -->

		<div class="venue">
			<label for="StateProvinceText">
				<?php esc_html_e( 'County', 'tribe-events-community' ); ?>:
			</label>
			<input
				id="StateProvinceText"
				name="venue[Province]"
				type="text"
				size="25"
				value="<?php echo esc_attr( tribe_get_province() ); ?>"
			/>
			<!--<select
				id="StateProvinceSelect"
				name="venue[State]"
				class="tribe-dropdown"
			>
				<option value=""><?php esc_html_e( 'Select a State', 'tribe-events-community' ); ?></option>
				<?php foreach ( Tribe__View_Helpers::loadStates() as $abbr => $fullname ) : ?>
					<option
						value="<?php echo esc_attr( $abbr ); ?>"
						<?php selected( tribe_get_state() == $abbr ); ?>
					><?php echo esc_html( $fullname ) ?></option>
				<?php endforeach; ?>
			</select>-->

		</div><!-- .venue -->
	<?php endif; ?>

	<div class="venue">

		<label for="EventZip">
			<?php esc_html_e( 'Postcode', 'tribe-events-community' ); ?>:
		</label>
		<input
			type="text"
			id="EventZip"
			name="venue[Zip]"
			size="6"
			value="<?php echo esc_attr( tribe_get_zip() ); ?>"
		/>

	</div><!-- .venue -->

	<div class="venue">

		<label for="EventPhone">
			<?php esc_html_e( 'Venue phone', 'tribe-events-community' ); ?>:
		</label>
		<input
			type="tel"
			id="EventPhone"
			name="venue[Phone]"
			size="14"
			value="<?php echo esc_attr( tribe_get_phone() ); ?>"
		/>
	</div><!-- .venue -->

	<!--<div class="venue">

		<label for="EventWebsite">
			<?php esc_html_e( 'Website', 'tribe-events-community' ); ?>:
		</label>
		<input
			type="url"
			id="EventWebsite"
			name="venue[URL]"
			size="14"
			placeholder value
			value="<?php echo esc_attr( tribe_get_venue_website_url() ); ?>"
		/>

	</div>
	<p class="helptext">eg https://www.venuehotels.co.uk</p>
				-->
<!-- .venue -->

	<?php
	/**
	 * After venue editor's meta fields are output.
	 */
	do_action( 'tribe_events_community_after_venue_meta' )
	?>

</div><!-- #event_tribe_venue -->

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_venue' );
	?>
</div>
				</div>