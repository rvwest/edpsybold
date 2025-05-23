<!-- file: tribe-events/modules/meta/cost.php -->
<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://evnt.is/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id = Tribe__Main::post_id_helper();
$cost = tribe_get_formatted_cost();
?>

<?php
// Event Cost
if (!empty($cost)): ?>
	<div class="meta-item">
		<div class="label">Cost</div>
		<div class="detail event-cost"><?php echo esc_html($cost); ?></div>
	</div>
<?php endif ?>
<!-- file end: tribe-events/modules/meta/cost.php -->