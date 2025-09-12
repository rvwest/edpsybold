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
  //  wp_enqueue_style('edpsybold-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'edpsybold-share',
        get_template_directory_uri() . '/js/share.js',
        array(),
        filemtime(get_template_directory() . '/js/share.js'),
        true
    );
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

// ========== Debugger - show CSS in use  =================================================== //
// ======================================================================== //

// Footer debug
// add_action('wp_footer', function () {
//    global $wp_styles;
//    echo '<pre>';
//    print_r($wp_styles->queue);
//
//    echo '</pre>';
//}, 998);

// ========== Remove comments ================================================= //
// ============================================================================ //

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
// ======================================================================== //
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
        wp_dequeue_style('tribe_events-community-styles');
        wp_dequeue_style('tribe-events-full-calendar-style');
        wp_dequeue_style('tribe-events-admin-ui');
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
// ======================================================================== //

add_action('wp_enqueue_scripts', 'remove_wp_plugin_frontend_css', 9999);
function add_job_manager_body_classes($classes)
{
    if (is_page('jobs')) { // Check if it's the jobs page
        $classes[] = 'edp-jobs job-listings-page'; // Add a class for the jobs page
    }
    if (is_singular('job_listing')) { // Check if it's a single job listing
        $classes[] = 'edp-jobs single-job-listing'; // Add a class for single job listings
    }
    if ( function_exists('job_manager_get_page_id') 
     && is_page( job_manager_get_page_id( 'submit_job_form' ) ) ) {
    // We're on the "Post a Job" (submit form) page
    $classes[] = 'edp-jobs add-job'; // Add a class for single job listings
}
    
    return $classes;
}
add_filter('body_class', 'add_job_manager_body_classes');


// ========== Homepage ================================================= //
// ======================================================================== //


// ======== Customizer - featured post

function mytheme_customize_register($wp_customize) {
    // Add a section for the Hero Post
    $wp_customize->add_section('edp_home_section', array(
        'title'       => __('edpsy homepage settings', 'mytheme'),
        'priority'    => 30,
    ));

    // Get all posts for the dropdown
    $posts = get_posts(array('numberposts' => -1));
    $choices = array('' => '— Select a post —');
    foreach ($posts as $post) {
        $choices[$post->ID] = $post->post_title;
    }

    // Add the setting
    $wp_customize->add_setting('hero_post_id', array(
        'default'   => '',
        'sanitize_callback' => 'absint',
    ));

    // Add the control
    $wp_customize->add_control('hero_post_id', array(
        'label'    => __('Select Hero Post', 'mytheme'),
        'section'  => 'edp_home_section',
        'settings' => 'hero_post_id',
        'type'     => 'select',
        'choices'  => $choices,
    ));
}
add_action('customize_register', 'mytheme_customize_register');


// ======== Customizer - 'focus on' posts

function edp_customize_register($wp_customize) {
    $section = 'edp_home_section';

    // ===== Focus On section =====

    // Toggle
    $wp_customize->add_setting('focus_on_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('focus_on_enabled', array(
        'label' => __('Show "Focus On" section', 'yourtheme'),
        'section' => $section,
        'type' => 'checkbox',
    ));

    // Title
    $wp_customize->add_setting('focus_on_title', array(
        'default' => 'Focus On',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('focus_on_title', array(
        'label' => __('"Focus On" Section Title', 'yourtheme'),
        'section' => $section,
        'type' => 'text',
    ));

    // Tag dropdown
    $tags = get_tags(array('hide_empty' => false));
    $tag_choices = array('' => '— Select Tag —');
    foreach ($tags as $tag) {
        $tag_choices[$tag->term_id] = $tag->name;
    }

    $wp_customize->add_setting('focus_on_tag', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('focus_on_tag', array(
        'label' => __('Tag to use for selecting posts', 'yourtheme'),
        'section' => $section,
        'type' => 'select',
        'choices' => $tag_choices,
    ));

    // Prepare post choices once (outside the loop)
    $post_choices = array('' => '— Select a post —');
    $posts = get_posts(array(
        'numberposts' => 100,
        'post_status' => 'publish',
    ));
    foreach ($posts as $post) {
        $post_choices[$post->ID] = $post->post_title;
    }

    // Add Focus On post selectors
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("focus_on_post_$i", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control("focus_on_post_$i", array(
            'label' => __("Focus On Post $i", 'yourtheme'),
            'section' => $section,
            'type' => 'select',
            'choices' => $post_choices,
        ));
    }

    // ===== Longer Reads Section =====

    // Toggle
    $wp_customize->add_setting('longer_reads_enabled', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('longer_reads_enabled', array(
        'label' => __('Show "Longer Reads" section', 'yourtheme'),
        'section' => $section,
        'type' => 'checkbox',
    ));

    // Title
    $wp_customize->add_setting('longer_reads_title', array(
        'default' => 'Longer Reads',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('longer_reads_title', array(
        'label' => __('"Longer Reads" Section Title', 'yourtheme'),
        'section' => $section,
        'type' => 'text',
    ));

    // Add Longer Reads post selectors
    for ($i = 1; $i <= 2; $i++) {
        $wp_customize->add_setting("longer_reads_post_$i", array(
            'default' => '',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control("longer_reads_post_$i", array(
            'label' => __("Longer Read Post $i", 'yourtheme'),
            'section' => $section,
            'type' => 'select',
            'choices' => $post_choices,
        ));
    }
}
add_action('customize_register', 'edp_customize_register');

function edp_get_promo_classes() {
    $file = get_template_directory() . '/css/parts/promo-banner.css';
    $classes = array();
    if (file_exists($file)) {
        $css = file_get_contents($file);
        if (preg_match_all('/\\.promo-banner-block-style--[a-z0-9_-]+/', $css, $matches)) {
            foreach (array_unique($matches[0]) as $class) {
                $name  = ltrim($class, '.');
                $label = preg_replace('/^promo-banner-block-style--/', '', $name);
                $label = str_replace('-', ' ', $label);
                $classes[$name] = $label;
            }
        }
    }
    return $classes;
}

if (class_exists('WP_Customize_Control')) {
    class Edp_Customize_Rich_Text_Control extends WP_Customize_Control {
        public $type = 'edp_rich_text';

        public function enqueue() {
            wp_enqueue_editor();
        }

        public function render_content() {
            $editor_id = $this->id . '_editor';
            $settings = array(
                'textarea_name' => $editor_id,
                'media_buttons' => false,
                'teeny' => true,
            );

            if ($this->label) {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            }
            if ($this->description) {
                echo '<span class="description customize-control-description">' . esc_html($this->description) . '</span>';
            }

            wp_editor($this->value(), $editor_id, $settings);
            echo '<input type="hidden" id="' . esc_attr($editor_id) . '_link" ';
            $this->link();
            echo ' value="' . esc_attr($this->value()) . '" />';
            ?>
            <script>
                jQuery(function ($) {
                    var editor = tinymce.get('<?php echo esc_js($editor_id); ?>');
                    function syncEditor() {
                        var content = editor ? editor.getContent() : $('#<?php echo esc_js($editor_id); ?>').val();
                        $('#<?php echo esc_js($editor_id); ?>_link').val(content).trigger('change');
                    }
                    if (editor) {
                        editor.on('keyup change', syncEditor);
                    }
                    $('#<?php echo esc_js($editor_id); ?>').on('keyup change', syncEditor);
                });
            </script>
            <?php
        }
    }
}

function edp_promo_banner_customize($wp_customize) {
    $wp_customize->add_section('edp_promo_banner', array(
        'title' => __('Promo banner', 'yourtheme'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('promo_banner_visible', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('promo_banner_visible', array(
        'label' => __('Show promo banner', 'yourtheme'),
        'section' => 'edp_promo_banner',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('promo_banner_css_class', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('promo_banner_css_class', array(
        'label' => __('Style', 'yourtheme'),
        'section' => 'edp_promo_banner',
        'type' => 'select',
        'choices' => edp_get_promo_classes(),
    ));

    $wp_customize->add_setting('promo_banner_icon', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('promo_banner_icon', array(
        'label' => __('Font Awesome icon class', 'yourtheme'),
        'section' => 'edp_promo_banner',
        'type' => 'text',
    ));

    $wp_customize->add_setting('promo_banner_text1', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new Edp_Customize_Rich_Text_Control($wp_customize, 'promo_banner_text1', array(
        'label' => __('Text 1', 'yourtheme'),
        'section' => 'edp_promo_banner',
    )));

    $wp_customize->add_setting('promo_banner_text2', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control(new Edp_Customize_Rich_Text_Control($wp_customize, 'promo_banner_text2', array(
        'label' => __('Text 2', 'yourtheme'),
        'section' => 'edp_promo_banner',
    )));
}
add_action('customize_register', 'edp_promo_banner_customize');

function edpsybold_count_class($count) {
    return 'edp-bold-posts-' . intval($count);
}

// ========== Jobs homepage shortcode =========== //

// Register [jobs-homepage] shortcode with count-based CSS class
function wpjm_jobs_homepage_shortcode($atts) {
    $atts = shortcode_atts([
        'per_page' => 3,
    ], $atts, 'jobs-homepage');

    ob_start();

    // Query jobs
    $jobs = new WP_Query([
        'post_type'      => 'job_listing',
        'posts_per_page' => intval($atts['per_page']),
        'post_status'    => 'publish',
    ]);

    $job_count = $jobs->found_posts;

    if ( $jobs->have_posts() ) {
        $count_class = edpsybold_count_class($job_count);
        echo '<div class="jobs-homepage-grid ' . esc_attr($count_class) . '">';
        while ( $jobs->have_posts() ) {
            $jobs->the_post();

            // Load custom template for each job
            get_template_part('_home-jobs-item');
        }
        if  ( $count_class < 3 ) { 
        get_template_part('_home-jobs-promo');
        }
        echo '</div>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('jobs-homepage', 'wpjm_jobs_homepage_shortcode');


// ========== Page promos ================================================= //
// ======================================================================== //

function get_page_promo() {
    $raw = include get_template_directory() . '/promo-config.php';

    // Normalize config into groups of ['keys' => [...], 'html' => '...']
    $groups = [];
    if (is_array($raw)) {
        foreach ($raw as $k => $v) {
            // New format: each item is an array with 'keys' and 'html'
            if (is_array($v) && isset($v['keys'], $v['html'])) {
                $groups[] = [
                    'keys' => array_values((array) $v['keys']),
                    'html' => $v['html'],
                ];
            } else {
                // Back-compat: associative 'key' => 'html'
                if (is_string($k)) {
                    $groups[] = [
                        'keys' => [$k],
                        'html' => $v,
                    ];
                }
            }
        }
    }

    // Current route (path without leading/trailing slashes)
    $request_path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $route = trim($request_path ?? '/', '/');

    // Pattern matcher: supports exact and simple prefix wildcard '/*'
    $matches = function ($pattern, $route) {
        if (!is_string($pattern)) return false;
        $pattern = trim($pattern, '/');
        if ($pattern === '') {
            return $route === '';
        }
        if (substr($pattern, -2) === '/*') {
            $base = rtrim(substr($pattern, 0, -2), '/');
            return ($route === $base) || (strpos($route, $base . '/') === 0);
        }
        return $route === $pattern; // exact only
    };

    // 1) Try path-based matching first (arrays of keys + wildcards)
    foreach ($groups as $group) {
        foreach ($group['keys'] as $pattern) {
            if ($matches($pattern, $route)) {
                echo '<div class="page-promo">' . $group['html'] . '</div>';
                return;
            }
        }
    }

    // 2) Fallback to original logic (page slug, category slug, post type archive)
    // Build an associative map of exact keys only for quick lookup
    $promos_assoc = [];
    foreach ($groups as $group) {
        foreach ($group['keys'] as $pattern) {
            if (is_string($pattern) && substr(trim($pattern), -2) !== '/*') {
                $promos_assoc[trim($pattern, '/')] = $group['html'];
            }
        }
    }

    if (is_page()) {
        $post = get_post();
        if (!$post) return;

        $slug     = $post->post_name; // current page slug
        $parent   = $post->post_parent ? get_post_field('post_name', $post->post_parent) : '';
        $combined = $parent ? $parent . '/' . $slug : $slug;

        if (isset($promos_assoc[$combined])) {
            echo '<div class="page-promo">' . $promos_assoc[$combined] . '</div>';
            return;
        }
        if (isset($promos_assoc[$slug])) {
            echo '<div class="page-promo">' . $promos_assoc[$slug] . '</div>';
            return;
        }
        if (isset($promos_assoc[(string) $post->ID])) {
            echo '<div class="page-promo">' . $promos_assoc[(string) $post->ID] . '</div>';
            return;
        }
    } elseif (is_category()) {
        $category = get_queried_object();
        if ($category && isset($promos_assoc[$category->slug])) {
            echo '<div class="page-promo">' . $promos_assoc[$category->slug] . '</div>';
            return;
        }
    } elseif (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if ($post_type && isset($promos_assoc[$post_type])) {
            echo '<div class="page-promo">' . $promos_assoc[$post_type] . '</div>';
            return;
        }
    }
}



// ========== Blog pages ================================================= //
// ======================================================================== //

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
// ======================================================================== //

// ---------- Post a job //


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
        'description' => "eg " . date('j F', strtotime('+45 days')) . " - " . date('j F Y', strtotime('+47 days')),
        'sanitize_callback' => [__CLASS__, 'sanitize_text_field'],
    );
    $fields['job']['cap_declaration'] = array(
        'label' => __('Declaration', 'job_manager'),
        'type' => 'checkbox',
        'required' => true,
        'placeholder' => 'I confirm this',
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


/* fixes dodgy placeholder text on registration */
add_filter('wpjm_get_registration_fields', 'custom_registration_fields');

function custom_registration_fields($fields)
{
	// Here we target one of the job fields (job_title) and change it's label
	$fields['create_account_email']['label'] = "Your email";
	$fields['create_account_email']['placeholder'] = "";
	$fields['create_account_email']['description'] = "";
	// And return the modified fields
	return $fields;
}


// Allows direct CSS changes to the job description editor box

add_filter( 'mce_css', function( $mce_css ) {
    // Optionally limit to the submit job page:
    if ( function_exists('job_manager_get_page_id') && is_page( job_manager_get_page_id( 'submit_job_form' ) ) ) {
        $style = get_stylesheet_directory_uri() . '/css/job-editor.css';
        return $mce_css ? $mce_css . ',' . $style : $style;
    }
    return $mce_css;
});

// Improve step 2 CTA button text 

add_filter('submit_job_step_preview_submit_text', 'custom_submit_button_text');

function custom_submit_button_text($button_text)
{
	return __('Confirm and pay', 'wp-job-manager-simple-paid-listings');
}




// ========== Events pages ================================================= //

// Add "Online" checkbox after Venue in the Location section
add_action('tribe_events_after_venue_metabox', function($post) {
    $value = get_post_meta($post->ID, '_EventOnline', true);
    ?>
    <tr>
        <td class='tribe-table-field-label'>
            <label for="EventOnline"><?php esc_html_e('Online event?', 'edpsybold'); ?></label>
        </td>
        <td>
            <input
                id="EventOnline"
                name="EventOnline"
                type="checkbox"
                value="1"
                <?php checked($value, '1'); ?>
            />
            <span class="description"><?php esc_html_e('Check if this is an online/virtual event', 'edpsybold'); ?></span>
        </td>
    </tr>
    <?php
});

// Add "CTA Label" text field after Event Website URL
add_action('tribe_events_url_table', function($event_id) {
    $value = get_post_meta($event_id, '_EventCTALabel', true);
    ?>
    <tr>
        <td style="width:172px;">
            <label for="EventCTALabel"><?php esc_html_e('CTA Label', 'edpsybold'); ?></label>
        </td>
        <td>
            <input
                id="EventCTALabel"
                name="EventCTALabel"
                type="text"
                value="<?php echo esc_attr($value); ?>"
                size="25"
                placeholder="<?php esc_attr_e('Find out more and book', 'edpsybold'); ?>"
            />
            <span class="description"><?php esc_html_e('Optional', 'edpsybold'); ?></span>
        </td>
    </tr>
    <?php
});

// Save the custom fields when the event is saved
add_action('save_post_tribe_events', function($post_id) {
    if (isset($_POST['EventOnline'])) {
        update_post_meta($post_id, '_EventOnline', '1');
    } else {
        update_post_meta($post_id, '_EventOnline', '0');
    }
    if (isset($_POST['EventCTALabel'])) {
        update_post_meta($post_id, '_EventCTALabel', sanitize_text_field($_POST['EventCTALabel']));
    }
});

// Tabbable links fix 
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

//==== Navigation ====== //

// Mobile menu toggle script
function edpsy_enqueue_mobile_menu_script()
{
    wp_enqueue_script(
        'mobile-menu',
        get_template_directory_uri() . '/js/mobile-menu.js',
        array('jquery'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'edpsy_enqueue_mobile_menu_script');


function edpsy_enqueue_event_label_width_script()
{
    if (is_singular('tribe_events')) {
        wp_enqueue_script(
            'event-label-width',
            get_template_directory_uri() . '/js/event-label-width.js',
            array('jquery'),
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'edpsy_enqueue_event_label_width_script');


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


// Add event categories to body tag
function add_event_category_to_body_class($classes)
{
	if (is_singular('tribe_events')) {
		$categories = get_the_terms(get_the_ID(), 'tribe_events_cat');
		if ($categories && !is_wp_error($categories)) {
			foreach ($categories as $category) {
				$classes[] = 'event-cat-' . sanitize_html_class($category->slug);
			}
		}
	}
	return $classes;
}
add_filter('body_class', 'add_event_category_to_body_class');

// Add classes to the event website link 
function my_custom_event_website_link( $event = null, $label = null, $target = '_self', $class = '' ): string {
	$post_id = Tribe__Events__Main::postIdHelper( $event );
	$url     = tribe_get_event_website_url( $post_id );
	$target  = $target ? $target : '_self';

	$target = apply_filters( 'tribe_get_event_website_link_target', $target, $url, $post_id );

	$allowed = [ '_self', '_blank', '_parent', '_top', '_unfencedTop' ];
	if ( ! in_array( $target, $allowed ) ) {
		$target = '_self';
	}

	$rel = ( '_blank' === $target ) ? 'noopener noreferrer' : 'external';

	if ( ! empty( $url ) ) {
		$label = empty( $label ) ? $url : $label;
		$label = apply_filters( 'tribe_get_event_website_link_label', $label, $post_id );

		$class_attr = $class ? ' class="' . esc_attr( $class ) . '"' : '';

		$html = sprintf(
			'<a href="%s" target="%s" rel="%s"%s>%s</a>',
			esc_url( $url ),
			esc_attr( $target ),
			esc_attr( $rel ),
			$class_attr,
			esc_html( $label )
		);
	} else {
		$html = '';
	}

	return apply_filters( 'my_custom_event_website_link', $html );
}

// Remove the automatic "View Venue Website" label override
remove_filter( 'tribe_get_venue_website_link_label', [ tribe( 'events.views.v2.hooks' ), 'filter_single_event_details_venue_website_label' ] );

// Add a filter to remove the colon from event metadata
add_filter('tribe_get_event_categories', function($html, $post_id, $args, $categories) {
    // Remove the colon that's automatically added
    $html = str_replace(':', '', $html);
    return $html;
}, 10, 4);


// Tribe community events - submission form help text (to avoid changig the field php)

// Taxonomy = category

function tribe_add_datetime_helptext()
{
	echo '<p class="tribe-helptext"><strong>For events that span non-consecutive dates</strong> (eg 7 March and 9 April) add the start date, then put the full details in the description</p>';
}

add_action('tribe_events_community_section_after_datetime', 'tribe_add_datetime_helptext');

function tribe_add_website_helptext()
{
	echo '<p class="tribe-helptext">For more information about the event. Don\'t worry if there isn\'t one</p>';
}

add_action('tribe_events_community_section_after_website', 'tribe_add_website_helptext');


// Add the custom event cost column to the admin list view
function tribe_events_add_column_headers($columns)
{
	$events_label_singular = tribe_get_event_label_singular();

	foreach ((array) $columns as $key => $value) {
		$mycolumns[$key] = $value;
		if ($key == 'author') {
			$mycolumns['events-cats'] = sprintf(esc_html__('%s Categories', 'the-events-calendar'), $events_label_singular);
		}
	}
	$columns = $mycolumns;

	unset($columns['date']);
	$columns['start-date'] = esc_html__('Start Date', 'the-events-calendar');
	$columns['end-date'] = esc_html__('End Date', 'the-events-calendar');
	// Cost addition
	$columns['cost'] = esc_html__('Cost', 'the-events-calendar');
	return $columns;
}
add_filter('manage_tribe_events_posts_columns', 'tribe_events_add_column_headers', 10, 1);

// Display the event cost in the custom column
function tribe_events_show_event_cost_column($column, $post_id)
{
	if ($column === 'cost') {
		$event_cost = get_post_meta($post_id, '_EventCost', true);
		if (!empty($event_cost)) {
			echo $event_cost;
		} else {
			echo '-';
		}
	}
}
add_action('manage_tribe_events_posts_custom_column', 'tribe_events_show_event_cost_column', 10, 2);


// Register the tribe events cost custom column as sortable
function tribe_events_custom_sortable_columns($columns)
{
	$columns['cost'] = 'cost';
	return $columns;
}
add_filter('manage_edit-tribe_events_sortable_columns', 'tribe_events_custom_sortable_columns');

// Modify the sorting query
function tribe_events_custom_orderby($query)
{
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	$orderby = $query->get('orderby');

	if ('cost' == $orderby) {
		// Set the meta key for the event cost
		$query->set('meta_key', '_EventCost');
		// Order by meta value as an integer
		$query->set('orderby', 'meta_value_num');
	}
}
add_action('pre_get_posts', 'tribe_events_custom_orderby');


// =========== Thesis Directory  ================================================= //

add_shortcode('get_search_term_used', function () {
	/* translators: %s: Search query/keyword. */
	return sprintf(
		__('Search Results for "%s"', 'business-directory-plugin'),
		esc_attr(get_search_query())
	);
});

// =========== Wordfence email  ================================================= //
function modify_wordfence_ip_display($formatted_row, $row)
{
	if (isset($row['IP'])) {
		$ip = $row['IP'];
		$ip_url = sprintf('<a href="https://cpanel.edpsy.org.uk/cpsess8093929927/frontend/jupiter/denyip/add.html?ip=%s" target="_blank">%s</a>', $ip, $ip);
		$formatted_row = str_replace($ip, $ip_url, $formatted_row);
	}
	return $formatted_row;
}
add_filter('wordfence_attack_table_row', 'modify_wordfence_ip_display', 10, 2);


// =========== Blog list page  ================================================= //

// Add classes to "Older posts" and "Newer posts" links.
function edp_posts_nav_link_attrs( $attr ) {
    // Change this string to whatever classes you want:
    $classes = 'edp-button-solid button';
    return trim( $attr . ' class="' . $classes . '"' );
}
add_filter( 'previous_posts_link_attributes', 'edp_posts_nav_link_attrs' );
add_filter( 'next_posts_link_attributes', 'edp_posts_nav_link_attrs' );