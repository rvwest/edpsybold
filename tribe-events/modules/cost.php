<?php
// Don't load directly.
defined( 'WPINC' ) or die;

/**
 * Event Submission Form Price Block
 * Renders the pricing fields in the submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/modules/cost.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since  3.1
 * @since  4.7.1 Now using new tribe_community_events_field_classes function to set up classes for the input.
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */

$events_label_singular         = tribe_get_event_label_singular();
$events_label_plural           = tribe_get_event_label_plural();
$events_label_plural_lowercase = tribe_get_event_label_plural_lowercase();
$show_cost_on_community        = apply_filters( 'tribe_events_community_display_cost_section', true );

if ( ! $show_cost_on_community ) {
	return;
}

global $post;

if ( $post instanceof WP_Post ) {
	$_EventCurrencyPosition = get_post_meta( $post->ID, '_EventCurrencyPosition', true );
}

if ( isset( $_EventCurrencyPosition ) && 'suffix' === $_EventCurrencyPosition ) {
	$suffix = true;
} elseif ( isset( $_EventCurrencyPosition ) && 'prefix' === $_EventCurrencyPosition ) {
	$suffix = false;
} elseif ( true === tribe_get_option( 'reverseCurrencyPosition', false ) ) {
	$suffix = true;
} else {
	$suffix = false;
}
?>

<div class="tribe-section tribe-section-cost">
	<div class="tribe-section-header">
		<?php // translators: %s events label. ?>
		<h3><?php printf( esc_html__( '%s Cost', 'tribe-events-community' ), $events_label_singular ); ?></h3>
	</div>

	<?php
	/**
	 * Allow developers to hook and add content to the beginning of this section
	 */
	do_action( 'tribe_events_community_section_before_cost' );
	?>

	<div class="tribe-section-content">
			<fieldset>		
				<?php tribe_community_events_field_label( 'EventCost', __( 'Cost', 'tribe-events-community' ) ); ?>
			
				<field class="tribe-section-content-field">
				<input type="text" id="EventCost" name="EventCost" class="cost-input-field" size="6" value="<?php echo esc_attr( isset( $_POST['EventCost'] ) ? $_POST['EventCost'] : tribe_get_cost() ); ?>" />
				<p>
					eg £30 - £120 <br />
					Leave blank for events that are free
				</p>
				</field>
			</fieldset>
		

	<?php
	/**
	 * Allow developers to hook and add content to the end of this section
	 */
	do_action( 'tribe_events_community_section_after_cost' );
	?>
</div>