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

// Jobs 
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