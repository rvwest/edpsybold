<?php
add_action('after_setup_theme', 'edpsybold_setup');
function edpsybold_setup()
{
    load_theme_textdomain('edpsybold', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('appearance-tools');
    wp_enqueue_style('edpsy-bold-style', get_template_directory_uri() . '/css/edpsy-bold-style.css', array(), filemtime(get_template_directory()));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'edpsybold')));
}
add_action('admin_notices', 'edpsybold_notice');
function edpsybold_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'edpsybold_notice_dismissed_11') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'edpsybold') . '</big></a>' . wp_kses_post(__('<big><strong>🏆 Thank you for using edpsybold!</strong></big>', 'edpsybold')) . '<p>' . esc_html__('Powering over 10k websites! Buy me a sandwich! 🥪', 'edpsybold') . '</p><a href="https://github.com/bhadaway/edpsybold/issues/57" class="button-primary" target="_blank"><strong>' . esc_html__('How do you use edpsybold?', 'edpsybold') . '</strong></a> <a href="https://opencollective.com/edpsybold" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__('Donate', 'edpsybold') . '</strong></a> <a href="https://wordpress.org/support/theme/edpsybold/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__('Review', 'edpsybold') . '</strong></a> <a href="https://github.com/bhadaway/edpsybold/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__('Support', 'edpsybold') . '</strong></a></p></div>';
}
add_action('admin_init', 'edpsybold_notice_dismissed');
function edpsybold_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'edpsybold_notice_dismissed_11', 'true', true);
}
add_action('wp_enqueue_scripts', 'edpsybold_enqueue');
function edpsybold_enqueue()
{
    wp_enqueue_style('edpsybold-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}
add_action('wp_footer', 'edpsybold_footer');
function edpsybold_footer()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            }
            else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            }
            else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            }
            else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            }
            else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
    <?php
}
add_filter('document_title_separator', 'edpsybold_document_title_separator');
function edpsybold_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'edpsybold_title');
function edpsybold_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function edpsybold_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'edpsybold_schema_url', 10);
function edpsybold_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('edpsybold_wp_body_open')) {
    function edpsybold_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'edpsybold_skip_link', 5);
function edpsybold_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'edpsybold') . '</a>';
}
add_filter('the_content_more_link', 'edpsybold_read_more_link');
function edpsybold_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'edpsybold'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'edpsybold_excerpt_read_more_link');
function edpsybold_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'edpsybold'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'edpsybold_image_insert_override');
function edpsybold_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'edpsybold_widgets_init');
function edpsybold_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'edpsybold'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('wp_head', 'edpsybold_pingback_header');
function edpsybold_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'edpsybold_enqueue_comment_reply_script');
function edpsybold_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function edpsybold_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?>
    </li>
    <?php
}
add_filter('get_comments_number', 'edpsybold_comment_count', 0);
function edpsybold_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}


// ========== Tabbable links fix ================================================= //
function edpsy_enqueue_fix_tab_focus_script()
{
    wp_enqueue_script(
        'fix-tab-focus',
        get_template_directory_uri() . '/js/fix-tab-focus.js',
        array(),
        null,
        true // load in footer
    );
}
add_action('wp_enqueue_scripts', 'edpsy_enqueue_fix_tab_focus_script');

// ========== Debug  ========================================================== //

// Footer debug
add_action('wp_footer', function () {
    global $wp_styles;
    echo '<pre>';
    print_r($wp_styles->queue);

    echo '</pre>';
}, 998);

// Template labeling
//add_filter('template_include', function ($template) {
//    echo "\n<!-- TEMPLATE_INCLUDE: $template -->\n";
//    return $template;
//});



// ========== Remove comments ================================================= //

function disable_page_comments()
{
    if (is_page()) {
        // Close comments on front-end
        add_filter('comments_open', '__return_false');
        add_filter('pings_open', '__return_false');
    }
}
add_action('template_redirect', 'disable_page_comments');

// ========== CSS removal ================================================= //
function remove_wp_plugin_frontend_css()
{
    if (!is_admin()) { // Ensures this only runs on the frontend
        wp_dequeue_style('wp-job-manager-frontend'); // Default handle for frontend.css
        wp_dequeue_style('co-authors-plus-coauthors-style');
        wp_dequeue_style('co-authors-plus-avatar-style');
        wp_dequeue_style('co-authors-plus-image-style');
        wp_dequeue_style('co-authors-plus-name-style');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('wp-job-manager-job-listings');
        wp_dequeue_style('wpbdp-base-css');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('tribe-events-views-v2-skeleton');
        wp_dequeue_style('tribe-events-v2-single-skeleton');
        //wp_dequeue_style('tec-variables-skeleton-css');
        //wp_dequeue_style('tribe-events-views-v2-bootstrap-datepicker-styles');
        // wp_dequeue_style('tribe-tooltipster-css-css');
        //   wp_dequeue_style('tribe-events-views-v2-skeleton-css');
        //    wp_dequeue_style('tec-variables-skeleton');
        //     wp_dequeue_style('tribe-common-skeleton-style-css');

    }
}

add_action('wp_head', function () {
    echo "<style>#tribe-common-skeleton-style-css { display: none !important; }</style>";
}, 999);


// ========== Custom page types ================================================= //

add_action('wp_enqueue_scripts', 'remove_wp_plugin_frontend_css', 9999);
function add_job_manager_body_classes($classes)
{
    if (is_page('jobs')) { // Check if it's the jobs page
        $classes[] = 'edp-jobs job-listings-page'; // Add a class for the jobs page
    }
    if (is_singular('job_listing')) { // Check if it's a single job listing
        $classes[] = 'edp-jobs single-job-listing'; // Add a class for single job listings
    }
    return $classes;
}
add_filter('body_class', 'add_job_manager_body_classes');

// ========== Page promos ================================================= //


function get_page_promo()
{
    $promos = include get_template_directory() . '/promo-config.php';

    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        if (isset($promos[$slug])) {
            echo '<div class="page-promo">' . $promos[$slug] . '</div>';
        }
    } elseif (is_category()) {
        $category = get_queried_object();
        if ($category && isset($promos[$category->slug])) {
            echo '<div class="page-promo">' . $promos[$category->slug] . '</div>';
        }

    } elseif (is_post_type_archive()) {
        $post_type = get_post_type();
        if (isset($promos[$post_type])) {
            echo '<div class="page-promo">' . $promos[$post_type] . '</div>';
        }
    }
}



// ========== Blog pages ================================================= //

add_filter('wpseo_title', 'my_co_author_wseo_title');
function my_co_author_wseo_title($title)
{

    // Only filter title output for author pages
    if (is_author() && function_exists('get_coauthors')) {
        $qo = get_queried_object();
        $author_name = $qo->display_name;
        return $author_name . '&#39;s articles on ' . get_bloginfo('name');
    }
    return $title;

}

// ========== Job manager ================================================= //

// ---------- Post a job ------------------------------------------------- //


// Modifies / remove / add fields for jobs form
// Full field list: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/forms/class-wp-job-manager-form-submit-job.php

add_filter('submit_job_form_fields', 'custom_submit_job_form_fields');

function custom_submit_job_form_fields($fields)
{

    // Here we target one of the job fields (job_title) and change it's label
    $fields['job']['job_location']['description'] = "";
    $fields['job']['job_location']['placeholder'] = "";
    $fields['job']['application']['label'] = "Where to apply";
    $fields['job']['application']['description'] = "eg https://yourorg.gov.uk/apply";
    $fields['job']['application']['value'] = "http://";
    $fields['job']['application']['placeholder'] = "";
    $fields['job']['job_type']['description'] = "You can select more than one";
    $fields['company']['company_name']['placeholder'] = "";
    $fields['company']['company_name']['label'] = "Organisation name";
    $fields['company']['company_logo']['description'] = "Maximum file size 32 MB";
    $fields['company']['company_logo']['allowed_mime_types'] = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
    ];
    $fields['job']['closing_date'] = array(
        'label' => __('Closing date', 'job_manager'),
        'type' => 'date',
        'data_type' => 'string',
        'required' => false,
        'classes' => ['job-manager-datepicker'],
        'priority' => 8,
        'description' => "eg " . date('j F Y', strtotime('+30 days')),
        'sanitize_callback' => [__CLASS__, 'sanitize_meta_field_date'],
    );
    $fields['job']['interview_date'] = array(
        'label' => __('Possible interview dates', 'job_manager'),
        'type' => 'text',
        'data_type' => 'string',
        'required' => false,
        'priority' => 8,
        'description' => "eg " . date('j F Y', strtotime('+45 days')),
        'sanitize_callback' => [__CLASS__, 'sanitize_text_field'],
    );
    $fields['job']['cap_declaration'] = array(
        'label' => __('Declaration', 'job_manager'),
        'type' => 'checkbox',
        'required' => true,
        'placeholder' => 'I confirm this to be true',
        'priority' => 9,
        'description' => __('<p>We follow the <a href="https://www.asa.org.uk/type/non_broadcast/code_section/20.html">CAP Code for employment advertisements</a>. Please confirm:</p><ul><li>This is a genuine employment opportunity</li><li>All details provided are comprehensive and accurate</li><li>You are acting directly for the employer, and not an employment agency</li><li>Your organisation is not in dispute with the <abbr title="Association of Educational Psychologists">AEP</abbr></li></ul>', 'wp-job-manager'),
    );

    unset($fields['company']['company_video']);
    unset($fields['company']['company_tagline']);
    unset($fields['company']['company_twitter']);
    unset($fields['job']['remote_position']);

    // And return the modified fields
    return $fields;
}

// Modifies / remove / add fields for jobs admin
// Full field list: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/forms/class-wp-job-manager-form-submit-job.php

add_filter('job_manager_job_listing_data_fields', 'admin_add_custom_admin_fields');

function admin_add_custom_admin_fields($fields)
{
    $fields['_closing_date'] = array(
        'label' => __('Job closing date', 'wp-job_manager'),
        'data_type' => 'string',
        'classes' => ['job-manager-datepicker'],
        'show_in_admin' => true,
        'placeholder' => '',
        'priority' => 13,
    );
    $fields['_cap_declaration'] = array(
        'label' => __('Declaration', 'wp-job_manager'),
        'type' => 'checkbox',
        'data_type' => 'integer',
        'show_in_admin' => true,
        'placeholder' => '',
        'description' => 'I confirm the above is true',
        'priority' => 15,
    );
    $fields['_interview_date'] = array(
        'label' => __('Possible interview dates', 'job_manager'),
        'type' => 'text',
        'data_type' => 'string',
        'required' => false,
        'priority' => 14,
        'description' => "eg " . date('j F Y', strtotime('+45 days')),
        'sanitize_callback' => [__CLASS__, 'sanitize_text_field'],
    );
    unset($fields['_company_video']);
    unset($fields['_company_tagline']);
    unset($fields['_company_twitter']);
    unset($fields['_remote_position']);
    unset($fields['_featured']);
    unset($fields['_filled']);

    return $fields;
}


add_filter('job_manager_update_job_listings_message', 'custom_job_manager_update_job_listings_message');

function custom_job_manager_update_job_listings_message($save_message)
{
    return ('<i class="far fa-check-circle"></i> Your changes have been saved. <a href="' . esc_url(job_manager_get_permalink('job_dashboard')) . '">Return to your dashboard</a>.');
}


// ========== Events pages ================================================= //


add_filter('tribe_events_event_schedule_details_inner', 'edpsy_custom_time_range_in_brackets', 10, 2);

function edpsy_custom_time_range_in_brackets($inner, $event_id)
{
    $event = get_post($event_id);

    // Only apply on single-day, timed events with different start/end times
    if (
        !tribe_event_is_all_day($event)
        && !tribe_event_is_multiday($event)
        && tribe_get_start_date($event, false, 'g:i A') !== tribe_get_end_date($event, false, 'g:i A')
    ) {
        $date = tribe_get_start_date($event, false, tribe_get_date_format());
        $start_time = tribe_get_start_date($event, false, get_option('time_format'));
        $end_time = tribe_get_end_date($event, false, get_option('time_format'));
        $time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');

        $output = '<span class="tribe-event-date-start">';
        $output .= esc_html($date) . ' <span class="tribe-event-time">(' . esc_html($start_time . $time_range_separator . $end_time) . ')</span>';
        $output .= '</span>';

        return $output;
    }

    // Otherwise return original unchanged
    return $inner;
}