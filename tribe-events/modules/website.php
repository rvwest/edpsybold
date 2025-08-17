<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Website Block
 * Renders the website fields in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/website.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since  3.1
 * @since  4.7.1 Now using new tribe_community_events_field_classes function to set up classes for the input.
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

// If posting back, then use $POST values.
if ( ! $_POST ) {
	$event_url = function_exists( 'tribe_get_event_website_url' ) ? tribe_get_event_website_url() : tribe_community_get_event_website_url();
} else {
	$event_url = isset( $_POST['EventURL'] ) ? esc_attr( $_POST['EventURL'] ) : '';
}

?>

<div class="tribe-section tribe-section-website">
	<div class="tribe-section-header">
		<h3><?php printf( __( '%s website', 'tribe-events-community' ), tribe_get_event_label_singular() ); ?></h3>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_website' );
	?>

	<div class="tribe-section-content">
<fieldset>
				<label>Event website </label> 
			
			<field>
				<input
					type="text"
					id="EventURL"
					name="EventURL"
					size="25"
					value="<?php echo esc_url( $event_url ); ?>"
					placeholder="<?php esc_attr_e( 'Enter URL for event information', 'tribe-events-community' ); ?>"
					class="<?php tribe_community_events_field_classes( 'EventURL', [] ); ?>"
				/>
				<p>eg https://www.yourorg.co.uk/event</p>
</field>
</fieldset>
</div>

