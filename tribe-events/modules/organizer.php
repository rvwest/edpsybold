<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Metabox For Organizers
 * This is used to add a metabox to the event submission form to allow for choosing or
 * creating an organizer for user submitted events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/organizer.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since  2.1
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

// If the user cannot create new organizers *and* if there are no organizers
// to select from then there's no point in generating this UI
if ( ! tribe( 'community.main' )->event_form()->should_show_linked_posts_module( Tribe__Events__Organizer::POSTTYPE ) ) {
	return;
}

if ( ! isset( $event ) ) {
	$event = Tribe__Events__Main::postIdHelper();
}

$organizer_label_singular = tribe_get_organizer_label_singular();

if ( ! $_POST ) {
	$organizer_name    = esc_attr( tribe_get_organizer() );
	$organizer_phone   = esc_attr( tribe_get_organizer_phone() );
	$organizer_website = esc_url( tribe_get_organizer_website_url() );
	$organizer_email   = esc_attr( tribe_get_organizer_email() );
} else {
	$organizer_name    = isset( $_POST['organizer']['Organizer'] ) ? esc_attr( $_POST['organizer']['Organizer'] ) : '';
	$organizer_phone   = isset( $_POST['organizer']['Phone'] ) ? esc_attr( $_POST['organizer']['Phone'] ) : '';
	$organizer_website = isset( $_POST['organizer']['Website'] ) ? esc_attr( $_POST['organizer']['Website'] ) : '';
	$organizer_email   = isset( $_POST['organizer']['Email'] ) ? esc_attr( $_POST['organizer']['Email'] ) : '';
}
if ( ! isset( $event ) ) {
	$event = null;
}

?>



<div id="event_tribe_organizer" class="tribe-section tribe-section-organizer">
	<div class="tribe-section-header">
		<h3 class="<?php echo tribe_community_events_field_has_error( 'organizer' ) ? 'error' : ''; ?>">
			<?php
			printf( __( '%s Details', 'tribe-events-community' ), tribe_get_organizer_label_singular() );
			echo tribe_community_required_field_marker( 'organizer' );
			?>
		</h3>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_organizer' );
	?>

<!-- Organizer -->
<div class="tribe-events-community-details eventForm " id="event_organizer">

	<div class="tribe-community-event-info">
		
		<?php tribe_community_events_organizer_select_menu( $event ); ?>

		<?php if ( ! tribe_community_events_is_organizer_edit_screen() ) { ?>
			<div class="organizer">
				<label for="OrganizerOrganizer">
					<?php printf( __( '%s Name', 'tribe-events-community' ), $organizer_label_singular ); ?>:
				</label>
				<input type="text" id="OrganizerOrganizer" class="linked-post-name" name="organizer[Organizer]" size="25"  value="<?php echo esc_attr( $organizer_name ); ?>" />
			</div><!-- .organizer -->
		<?php } ?>

		<div class="organizer">
			<label for="OrganizerPhone">
				<?php esc_html_e( 'Phone', 'tribe-events-community' ); ?>:
			</label>
			<input type="text" id="OrganizerPhone" name="organizer[Phone]" size="25" value="<?php echo esc_attr( $organizer_phone ); ?>" />
		</div><!-- .organizer -->
		<div class="organizer">
			<label for="OrganizerEmail"><?php esc_html_e( 'Email', 'tribe-events-community' ); ?>:</label>
			<input type="text" id="OrganizerEmail" name="organizer[Email]" size="25" value="<?php echo esc_attr( $organizer_email ); ?>" />
		</div><!-- .organizer -->
		<div class="organizer">
			<label for="OrganizerWebsite"><?php esc_html_e( 'Website', 'tribe-events-community' ); ?>:</label>
			<div class="input-help-pair"><input type="text" id="OrganizerWebsite" name="organizer[Website]" size="25" value="<?php echo esc_attr( $organizer_website ); ?>" />
			<p class="helptext">eg https://www.yourorg.co.uk</p></div>
		</div>
	
		<!-- .organizer -->
	</div><!-- #event_organizer -->

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_organizer' );
	?>
</div>
		</div>