<!-- file: search.php -->
<?php
get_header();

$search_query = get_search_query(false);
$show_old_events = edpsybold_should_show_old_events();
$available_post_types = edpsybold_collect_search_post_types($search_query, $show_old_events);
$selected_content_type = isset($_GET['content_type']) ? sanitize_key(wp_unslash($_GET['content_type'])) : 'everything';
if (!in_array($selected_content_type, $available_post_types, true)) {
    $selected_content_type = 'everything';
}

$show_toggle_for_events = post_type_exists('tribe_events');
$should_render_filters_form = !empty($available_post_types) || $show_toggle_for_events || $show_old_events;

global $wp_query;
$results_count = $wp_query instanceof WP_Query ? (int) $wp_query->found_posts : 0;

$search_context = array(
    'search_query' => $search_query,
    'show_old_events' => $show_old_events,
    'available_post_types' => $available_post_types,
    'selected_content_type' => $selected_content_type,
    'show_toggle_for_events' => $show_toggle_for_events,
    'should_render_filters_form' => $should_render_filters_form,
    'results_count' => $results_count,
);

require locate_template('search-results.php');

get_footer();
?>
<!-- file end: search.php -->
