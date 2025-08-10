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
 * @var WP_Post            $event        The event post object with properties added by the `tribe_get_event` function.
 * @var \DateTimeInterface $request_date The request date object. This will be "today" if the user did not input any
 *                                       date, or the user input date.
 * @var bool               $is_past      Whether the current display mode is "past" or not.
 * @var string             $slug         The slug of the current view.
 *
 * @see tribe_get_event() For the format of the event object.
 */
$is_homepage = is_front_page() || is_home();
$container_classes = ['edp-events-calendar-list__event-row'];
$container_classes['edp-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class(['tribe-events-calendar-list__event', 'tribe-common-g-row', 'tribe-common-g-row--gutters'], $event->ID);
?>
<!-- Adds ondemand tag -->
<?php
/**
 * Determine whether the event belongs to the "on-demand" category. When
 * rendering on the home page the event's classes do not include category
 * information, so we use `has_term` to perform the check.
 */
$is_on_demand = function_exists('has_term') && has_term('on-demand', 'tribe_events_cat', $event->ID);
if (!$is_on_demand) {
        foreach ($event_classes as $class) {
                if (strpos($class, 'cat_on-demand') !== false) {
                        $is_on_demand = true;
                        break;
                }
        }
}
if ($is_on_demand) {
        $container_classes[] = 'cat_on-demand';
}
?>
<div <?php tribe_classes($container_classes); ?>>
	<a href="<?php echo esc_url($event->permalink); ?>" rel="bookmark"
		class="tribe-events-calendar-list__event-title-link tribe-common-anchor-thin">


		<?php if ($is_on_demand): ?>
                <?php $this->template('list/event/ondemand-tag'); ?>
        <?php else: ?>
                <?php $this->template('list/event/date-tag', [
                        'event'        => $event,
                        'request_date' => $request_date,
                        'is_past'      => $is_past,
                ]); ?>
        <?php endif; ?>

		<?php if ($is_homepage): ?>  
<div class="edp-event-title-and-meta">
	<?php endif; ?>
		<div class="edp-events-calendar-list__event-header">

			<?php $this->template('list/event/title', ['event' => $event]); ?>

		</div>
		<div class="edp-events-calendar-list__event-meta">
		<?php if ($is_on_demand): ?>
						<address class="edp-events-calendar-list__event-venue tribe-common-b2">
							<span class="edp-events-calendar-list__event-venue-title tribe-common-b2--bold">
								On-demand training </span>
							<span class="edp-events-calendar-list__event-venue-address">
							</span>
						</address>
					<?php else: ?>
                                                <?php $this->template('list/event/venue', [
                                                        'event' => $event,
                                                        'slug'  => $slug,
                                                ]); ?>
					<?php endif; ?>
			
			<?php $this->template('list/event/cost', ['event' => $event]); ?>
		</div>

		<?php if ($is_homepage): ?>
		</div>
	<?php endif; ?>



	</a>
</div>
<!-- file: tribe/events/v2/list/event.php -->