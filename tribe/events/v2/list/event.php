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
<div <?php tribe_classes($container_classes); ?>>
	<a href="<?php echo esc_url($event->permalink); ?>" rel="bookmark"
		class="tribe-events-calendar-list__event-title-link tribe-common-anchor-thin">



		<?php $this->template('list/event/date-tag', ['event' => $event]); ?>



		<div class="edp-events-calendar-list__event-header">

			<?php $this->template('list/event/title', ['event' => $event]); ?>

		</div>
		<div class="edp-events-calendar-list__event-meta">
			<?php $this->template('list/event/venue', ['event' => $event]); ?>
			<?php $this->template('list/event/cost', ['event' => $event]); ?>
		</div>



	</a>
</div>