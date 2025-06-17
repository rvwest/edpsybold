<!-- file: tribe/events/v2/list/event.php -->
<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$container_classes = ['edp-events-calendar-list__event-row'];
$container_classes['edp-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class(['tribe-events-calendar-list__event', 'tribe-common-g-row', 'tribe-common-g-row--gutters'], $event->ID);
?>
<!-- Adds ondemand tag --> 
<?php
$is_on_demand = false;
foreach ($event_classes as $class) {
	if (strpos($class, 'cat_on-demand') !== false) {
		$is_on_demand = true;
		$container_classes[] = 'cat_on-demand';
		break;
	}
}
?>
<div <?php tribe_classes($container_classes); ?>>
	<a href="<?php echo esc_url($event->permalink); ?>" rel="bookmark"
		class="tribe-events-calendar-list__event-title-link tribe-common-anchor-thin">


		<?php if ($is_on_demand): ?>
		<?php $this->template('list/event/ondemand-tag') ?>
	<?php else: ?>
		<?php $this->template('list/event/date-tag', ['event' => $event]); ?>
<?php endif; ?>


		<div class="edp-events-calendar-list__event-header">

			<?php $this->template('list/event/title', ['event' => $event]); ?>

		</div>
		<div class="edp-events-calendar-list__event-meta">
		<?php if ($is_on_demand): ?>
						<address class="tribe-events-calendar-list__event-venue tribe-common-b2">
							<span class="tribe-events-calendar-list__event-venue-title tribe-common-b2--bold">
								On-demand training </span>
							<span class="tribe-events-calendar-list__event-venue-address">
							</span>
						</address>
					<?php else: ?>
						<?php $this->template('list/event/venue', ['event' => $event]); ?>
					<?php endif; ?>
			
			<?php $this->template('list/event/cost', ['event' => $event]); ?>
		</div>



	</a>
</div>
<!-- file: tribe/events/v2/list/event.php -->