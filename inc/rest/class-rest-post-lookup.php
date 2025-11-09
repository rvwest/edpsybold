<?php
/**
 * REST endpoints for Customizer post and tag lookups.
 *
 * @package edpsybold
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Edpsy_REST_Post_Lookup_Controller')) {
    class Edpsy_REST_Post_Lookup_Controller extends WP_REST_Controller
    {
        /**
         * Controller instance.
         *
         * @var Edpsy_REST_Post_Lookup_Controller|null
         */
        protected static $instance = null;

        /**
         * Retrieve singleton instance.
         *
         * @return Edpsy_REST_Post_Lookup_Controller
         */
        public static function instance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        protected function __construct()
        {
            $this->namespace = 'edpsy/v1';
            $this->rest_base = 'post-lookup';
        }

        /**
         * Register REST routes.
         */
        public function register_routes()
        {
            register_rest_route(
                $this->namespace,
                '/' . $this->rest_base,
                array(
                    array(
                        'methods' => WP_REST_Server::READABLE,
                        'callback' => array($this, 'get_items'),
                        'permission_callback' => array($this, 'permissions_check'),
                        'args' => $this->get_collection_params(),
                    ),
                )
            );

            register_rest_route(
                $this->namespace,
                '/tag-lookup',
                array(
                    array(
                        'methods' => WP_REST_Server::READABLE,
                        'callback' => array($this, 'get_tags'),
                        'permission_callback' => array($this, 'permissions_check'),
                        'args' => array(
                            'search' => array(
                                'description' => __('Limit results to tags matching this string.', 'edpsybold'),
                                'type' => 'string',
                                'sanitize_callback' => 'sanitize_text_field',
                                'default' => '',
                            ),
                            'page' => array(
                                'description' => __('Result page number.', 'edpsybold'),
                                'type' => 'integer',
                                'sanitize_callback' => 'absint',
                                'default' => 1,
                                'minimum' => 1,
                            ),
                            'per_page' => array(
                                'description' => __('Number of results per page.', 'edpsybold'),
                                'type' => 'integer',
                                'sanitize_callback' => 'absint',
                                'default' => 20,
                                'minimum' => 1,
                                'maximum' => 50,
                            ),
                            'slug' => array(
                                'description' => __('Limit results to specific tag slugs.', 'edpsybold'),
                                'type' => 'string',
                                'sanitize_callback' => 'sanitize_text_field',
                                'default' => '',
                            ),
                        ),
                    ),
                )
            );
        }

        /**
         * Collection parameters for the post lookup endpoint.
         *
         * @return array
         */
        public function get_collection_params()
        {
            return array(
                'search' => array(
                    'description' => __('Limit results to posts whose titles match this string.', 'edpsybold'),
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '',
                ),
                'page' => array(
                    'description' => __('Result page number.', 'edpsybold'),
                    'type' => 'integer',
                    'sanitize_callback' => 'absint',
                    'default' => 1,
                    'minimum' => 1,
                ),
                'per_page' => array(
                    'description' => __('Number of results per page.', 'edpsybold'),
                    'type' => 'integer',
                    'sanitize_callback' => 'absint',
                    'default' => 20,
                    'minimum' => 1,
                    'maximum' => 50,
                ),
                'tag' => array(
                    'description' => __('Filter results by tag slug.', 'edpsybold'),
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '',
                ),
                'category' => array(
                    'description' => __('Filter results by category slug.', 'edpsybold'),
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '',
                ),
                'include' => array(
                    'description' => __('Comma separated list of post IDs to include regardless of filters.', 'edpsybold'),
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '',
                ),
            );
        }

        /**
         * Permissions check for lookup endpoints.
         *
         * @param WP_REST_Request $request Request object.
         *
         * @return true|WP_Error
         */
        public function permissions_check($request)
        {
            if (!current_user_can('edit_theme_options')) {
                return new WP_Error('rest_forbidden', __('You are not allowed to perform this action.', 'edpsybold'), array('status' => rest_authorization_required_code()));
            }

            $nonce = $request->get_header('X-WP-Nonce');
            if ($nonce && wp_verify_nonce($nonce, 'wp_rest')) {
                return true;
            }

            // Fallback to cookies for authenticated requests.
            if (is_user_logged_in()) {
                return true;
            }

            return new WP_Error('rest_invalid_nonce', __('Invalid nonce.', 'edpsybold'), array('status' => 403));
        }

        /**
         * Handle GET requests for post lookups.
         *
         * @param WP_REST_Request $request Request instance.
         *
         * @return WP_REST_Response|WP_Error
         */
        public function get_items($request)
        {
            $search = $request->get_param('search');
            $page = max(1, (int) $request->get_param('page'));
            $per_page = (int) $request->get_param('per_page');
            $per_page = min(50, max(1, $per_page));
            $tag = $request->get_param('tag');
            $category = $request->get_param('category');
            $include = $this->parse_include_ids($request->get_param('include'));

            $cache_enabled = ('' === $search && empty($include)) || $page > 1;
            $cache_key = 'edpsy_post_lookup_' . md5(wp_json_encode(array(
                'search' => $search,
                'page' => $page,
                'per_page' => $per_page,
                'tag' => $tag,
                'category' => $category,
                'include' => $include,
                'user' => get_current_user_id(),
            )));

            if ($cache_enabled) {
                $cached = wp_cache_get($cache_key, 'edpsy_post_lookup');
                if (false !== $cached) {
                    return rest_ensure_response($cached);
                }
            }

            $query_args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'orderby' => array(
                    'date' => 'DESC',
                    'title' => 'ASC',
                ),
                'ignore_sticky_posts' => true,
                'suppress_filters' => true,
                'no_found_rows' => true,
                'search_columns' => array('post_title'),
            );

            if (!empty($include)) {
                $query_args['post__in'] = $include;
                $query_args['orderby'] = 'post__in';
                $query_args['posts_per_page'] = count($include);
            } else {
                $query_args['offset'] = ($page - 1) * $per_page;
                $query_args['posts_per_page'] = $per_page;

                if (!empty($search)) {
                    $query_args['s'] = $search;
                }

                if (!empty($tag)) {
                    $query_args['tag'] = $tag;
                }

                if (!empty($category)) {
                    $query_args['category_name'] = $category;
                }
            }

            $posts = get_posts($query_args);

            $items = array();
            foreach ($posts as $post) {
                $items[] = $this->format_post_for_response($post, $tag, $category);
            }

            $response = array(
                'items' => $items,
                'page' => $page,
                'has_more' => empty($include) && count($posts) === $per_page,
            );

            if ($cache_enabled) {
                wp_cache_set($cache_key, $response, 'edpsy_post_lookup', 60);
            }

            return rest_ensure_response($response);
        }

        /**
         * Handle GET requests for tag lookups.
         *
         * @param WP_REST_Request $request Request instance.
         *
         * @return WP_REST_Response|WP_Error
         */
        public function get_tags($request)
        {
            $search = $request->get_param('search');
            $page = max(1, (int) $request->get_param('page'));
            $per_page = (int) $request->get_param('per_page');
            $per_page = min(50, max(1, $per_page));
            $slug_list = $request->get_param('slug');

            $cache_enabled = '' === $search || $page > 1;
            $cache_key = 'edpsy_tag_lookup_' . md5(wp_json_encode(array(
                'search' => $search,
                'page' => $page,
                'per_page' => $per_page,
                'slug' => $slug_list,
                'user' => get_current_user_id(),
            )));

            if ($cache_enabled) {
                $cached = wp_cache_get($cache_key, 'edpsy_post_lookup');
                if (false !== $cached) {
                    return rest_ensure_response($cached);
                }
            }

            $args = array(
                'taxonomy' => 'post_tag',
                'hide_empty' => false,
                'offset' => ($page - 1) * $per_page,
                'number' => $per_page,
                'orderby' => 'name',
                'order' => 'ASC',
            );

            if (!empty($search)) {
                $args['search'] = $search;
            }

            if (!empty($slug_list)) {
                $slugs = array_filter(array_map('sanitize_title', explode(',', $slug_list)));
                if (!empty($slugs)) {
                    $args['slug'] = $slugs;
                }
            }

            $terms = get_terms($args);
            if (is_wp_error($terms)) {
                return $terms;
            }

            $items = array();
            foreach ($terms as $term) {
                $items[] = array(
                    'slug' => $term->slug,
                    'name' => html_entity_decode($term->name, ENT_QUOTES, get_bloginfo('charset')),
                    'count' => (int) $term->count,
                );
            }

            $response = array(
                'items' => $items,
                'page' => $page,
                'has_more' => count($terms) === $per_page,
            );

            if ($cache_enabled) {
                wp_cache_set($cache_key, $response, 'edpsy_post_lookup', 60);
            }

            return rest_ensure_response($response);
        }

        /**
         * Format a post for API output.
         *
         * @param WP_Post $post     Post object.
         * @param string  $tag      Optional tag filter.
         * @param string  $category Optional category filter.
         *
         * @return array
         */
        protected function format_post_for_response($post, $tag, $category)
        {
            $title = get_the_title($post);

            return array(
                'id' => (int) $post->ID,
                'title' => html_entity_decode($title, ENT_QUOTES, get_bloginfo('charset')),
                'date' => get_post_time('Y-m-d', false, $post),
                'permalink' => get_permalink($post),
                'matches_tag' => $tag ? has_term($tag, 'post_tag', $post) : true,
                'matches_category' => $category ? has_term($category, 'category', $post) : true,
            );
        }

        /**
         * Parse include IDs from a request parameter.
         *
         * @param string $include Raw include parameter.
         *
         * @return array
         */
        protected function parse_include_ids($include)
        {
            if (empty($include)) {
                return array();
            }

            if (is_array($include)) {
                $ids = array_map('absint', $include);
            } else {
                $ids = array_map('absint', explode(',', $include));
            }

            return array_values(array_filter($ids));
        }
    }
}

add_action('rest_api_init', array('Edpsy_REST_Post_Lookup_Controller', 'instance'));
add_action('rest_api_init', function () {
    Edpsy_REST_Post_Lookup_Controller::instance()->register_routes();
});

add_action('wp_ajax_edpsy_post_lookup', 'edpsy_ajax_post_lookup_handler');
/**
 * AJAX fallback for post lookup.
 */
function edpsy_ajax_post_lookup_handler()
{
    if (!current_user_can('edit_theme_options')) {
        wp_send_json_error(array('message' => __('You are not allowed to perform this action.', 'edpsybold')), 403);
    }

    check_ajax_referer('wp_rest', 'nonce');

    $request = new WP_REST_Request('GET', '/edpsy/v1/post-lookup');
    foreach (array('search', 'page', 'per_page', 'tag', 'category', 'include') as $param) {
        if (isset($_REQUEST[$param])) {
            $request->set_param($param, wp_unslash($_REQUEST[$param]));
        }
    }

    $response = Edpsy_REST_Post_Lookup_Controller::instance()->get_items($request);
    if ($response instanceof WP_Error) {
        $error_response = rest_convert_error_to_response($response);
        wp_send_json_error($error_response->get_data(), $error_response->get_status());
    }

    wp_send_json_success($response->get_data());
}

add_action('wp_ajax_edpsy_tag_lookup', 'edpsy_ajax_tag_lookup_handler');
/**
 * AJAX fallback for tag lookup.
 */
function edpsy_ajax_tag_lookup_handler()
{
    if (!current_user_can('edit_theme_options')) {
        wp_send_json_error(array('message' => __('You are not allowed to perform this action.', 'edpsybold')), 403);
    }

    check_ajax_referer('wp_rest', 'nonce');

    $request = new WP_REST_Request('GET', '/edpsy/v1/tag-lookup');
    foreach (array('search', 'page', 'per_page') as $param) {
        if (isset($_REQUEST[$param])) {
            $request->set_param($param, wp_unslash($_REQUEST[$param]));
        }
    }

    $response = Edpsy_REST_Post_Lookup_Controller::instance()->get_tags($request);
    if ($response instanceof WP_Error) {
        $error_response = rest_convert_error_to_response($response);
        wp_send_json_error($error_response->get_data(), $error_response->get_status());
    }

    wp_send_json_success($response->get_data());
}
