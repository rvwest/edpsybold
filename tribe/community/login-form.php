<?php
/**
 * Community: Login Form
 *
 * Override this template in your own theme by creating a file at:
 *     [your-theme]/tribe/community/login-form.php
 *
 * See more documentation about our views templating system.
 *
 * @version 4.10.17
 *
 * @since   4.10.14
 * @since   4.10.17 Corrected template override path.
 *
 * @var $caption      string
 * @var $page_slug    string
 */

// Send people to the standard WordPress login screen rather than an inline
// form, then bring them back to the Community page they were trying to reach.
$redirect = 'event_form' === $page_slug
	? tribe_community_events_add_event_link()
	: tribe_community_events_list_events_link();

?>

<div class="tribe-community-events tribe-events-community-login-form">

	<?php do_action('tec_events_community_{$page_slug}_before_login_form'); ?>

	<?php do_action('tribe_community_before_login_form'); ?>

	<p>Please sign in to view the events you've added.</p>

	<a class="tribe-button tribe-button-primary tribe-ce-login" href="<?php echo esc_url(wp_login_url($redirect)); ?>">
		<?php esc_html_e('Sign in', 'tribe-events-community'); ?>
	</a>

	<?php if (get_option('users_can_register')): ?>
		<div class="tribe-ce-register">
			<?php wp_register('<div class="tribe-ce-register">', '</div>', true); ?>
		</div>
	<?php endif; ?>

	<?php do_action('tribe_community_after_login_form'); ?>
</div>