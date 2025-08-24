<?php
/**
 * My Events List Template
 * The template for a list of a users events.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe/community/event-list.php
 *
 * @link    https://evnt.is/1ao4 Help article for Community & Tickets template files.
 *
 * @version 4.10.17
 *
 * @since   2.1
 * @since   4.8.2 Updated template link.
 * @since   4.10.14 Cleaned up file
 * @since   4.10.17 Corrected template override path.
 *
 * @var $events
 * @var $paged
 */

$columns = tribe_community_events_list_columns();

$main = \Tribe__Events__Community__Main::instance();

$events_label_plural           = $main->get_event_label( 'plural' );
$events_label_plural_lowercase = $main->get_event_label( 'lowercase' );
$show_display_options_dropdown = apply_filters( 'tec_events_community_events_listing_display_options_dropdown', true );

/**
 * Allows filtering for which columns cannot be hidden by users
 *
 * @param array $blocked
 */
$blocked_columns = apply_filters( 'tribe_community_events_list_columns_blocked', [ 'title' ] );
?>

<h2 class="tribe-community-events-list-title"><?php echo esc_html__( 'My Events', 'tribe-events-community' ); ?></h2>
<div class="tribe-community-events-add-event"><a
	class="tribe-button tribe-button-primary add-new"
	href="<?php echo esc_url( tribe_community_events_add_event_link() ); ?>"
>
	<?php echo apply_filters( 'tribe_community_events_add_event_label', __( 'Add New', 'tribe-events-community' ) ); ?>
</a>
</div>


<?php
/**
 * Allow developers to hook and add content to the begining of this section of content
 */
do_action( 'tribe_community_events_before_list_navigation' );
?>

<div class="tribe-event-list-search">
	<form role="search" method="get" class="tribe-search-form" action="">
		<div>
			<label
				class="screen-reader-text"
				for="s"
			>
				<?php esc_html_e( 'Search for:', 'tribe-events-community' ); ?>
			</label>
			<input
				type="search"
				value="<?php echo isset( $_GET['event-search'] ) ? esc_attr( $_GET['event-search'] ) : ''; ?>"
				name="event-search"
				placeholder="<?php esc_attr_e( 'Search Event Titles', 'tribe-events-community' ); ?>"
			/>
			<input
				type="hidden"
				value="<?php echo empty( $_GET['eventDisplay'] ) ? 'list' : esc_attr( $_GET['eventDisplay'] ); ?>"
				name="eventDisplay"
			/>
			<input type="submit" id="search-submit" value="Search"/>
		</div>
	</form>
</div>

<div class="tribe-nav tribe-nav-top">
	<div class="my-events-display-options ce-top">
		<?php tribe_community_events_prev_next_nav(); ?>
	</div>
	<div class="table-menu-wrapper ce-top">
		<?php if ( $show_display_options_dropdown && $events->have_posts() ) : ?>
			<a
				class="table-menu-btn button tribe-button tribe-button-secondary tribe-button-activate"
				href="#"
			>
				<?php echo apply_filters( 'tribe_community_events_list_display_button_text', __( 'Display options', 'tribe-events-community' ) ); ?>
			</a>
		<?php endif; ?>

		<?php
		/**
		 * Allow developers to hook and add content to the end of this section of content
		 */
		do_action( 'tribe_community_events_after_list_navigation_buttons' );
		?>

		<div class="table-menu table-menu-hidden">
			<ul>
				<?php foreach ( $columns as $column_slug => $column_label ) : ?>
					<?php $i = array_search( $column_slug, array_keys( $columns ) ); ?>
					<li>
						<label
							class="<?php echo sanitize_html_class( in_array( $column_slug, $blocked_columns ) ? 'tribe-hidden' : '' ) ?>"
							for="<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
						>
							<input
								class="tribe-toggle-column" type="checkbox"
								id="<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
								checked
							/>
							<?php echo esc_html( $column_label ); ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php // list pagination
	echo tribe_community_events_get_messages();
	echo $main->pagination( $events, '', $main->paginationRange );
	?>
</div>

<?php
/**
 * Allow developers to hook and add content to the begining of this section of content
 */
do_action( 'tribe_community_events_before_list_table' );
?>

<?php if ( $events->have_posts() ) : ?>
	<div class="tribe-responsive-table-container">
		<table
			id="tribe-community-events-list"
			class="tribe-community-events-list my-events display responsive stripe"
		>
			<thead>
				<tr>
					<?php foreach ( $columns as $column_slug => $column_label ) : ?>
						<th
							data-depends="#<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
							data-condition-is-checked
							class="tribe-dependent column-header <?php echo sanitize_html_class( 'column-header-' . $column_slug ); ?>"
						>
							<?php echo esc_html( $column_label ); ?>
						</th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody>
			<?php while ( $events->have_posts() ) : ?>
				<?php $event = $events->next_post(); ?>
				<tr class="<?php echo sanitize_html_class( 1===$events->current_post % 2 ? 'odd' : '' ); ?>">
					<?php foreach ( $columns as $column_slug => $column_label ) : ?>
						<?php
						$context = [
							'column_slug'  => $column_slug,
							'column_label' => $column_label,
							'event'        => $event,
						];
						?>
						<td
							data-depends="#<?php echo sanitize_html_class( 'tribe-toggle-column-' . $column_slug ); ?>"
							data-condition-is-checked
							class="tribe-dependent tribe-list-column <?php echo sanitize_html_class( 'tribe-list-column-' . $column_slug ); ?>"
						>
							<?php  tribe( Tribe__Events__Community__Templates::class )->tribe_get_template_part( 'community/columns/' . sanitize_key( $column_slug ), null, $context ); ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
<?php else : ?>
	<div class="tribe-community-events-list tribe-community-no-items">
		<?php
		if ( isset( $_GET['eventDisplay'] ) && 'past' === $_GET['eventDisplay'] ) {
			$text = esc_html__( 'You have no past %s', 'tribe-events-community' );
		} else {
			$text = esc_html__( 'You have no upcoming %s', 'tribe-events-community' );
		}
		echo sprintf( $text, $events_label_plural_lowercase );
		?>
	</div>
<?php endif; ?>

<?php
/**
 * Allow developers to hook and add content to the end of this section of content
 */
do_action( 'tribe_community_events_after_list_table' );
?>

<div class="tribe-nav tribe-nav-bottom">
	<?php
	echo tribe_community_events_get_messages();
	echo $main->pagination( $events, '', $main->paginationRange );
	?>
</div>
</div>
