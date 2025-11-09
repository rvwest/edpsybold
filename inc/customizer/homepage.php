<?php
/**
 * Homepage Customizer integration.
 *
 * @package edpsybold
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/customizer/class-customize-post-lookup-control.php';

add_action('customize_controls_enqueue_scripts', 'edpsy_enqueue_customizer_post_lookup_assets');
/**
 * Enqueue Customizer assets for the post lookup control.
 */
function edpsy_enqueue_customizer_post_lookup_assets()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    $script_path = $theme_dir . '/assets/admin/js/customizer-post-lookup.js';
    $style_path = $theme_dir . '/assets/admin/css/customizer-post-lookup.css';

    wp_register_script(
        'edpsy-customizer-post-lookup',
        $theme_uri . '/assets/admin/js/customizer-post-lookup.js',
        array('customize-controls'),
        file_exists($script_path) ? filemtime($script_path) : false,
        true
    );

    wp_localize_script(
        'edpsy-customizer-post-lookup',
        'edpsyPostLookup',
        array(
            'routes' => array(
                'post' => esc_url_raw(rest_url('edpsy/v1/post-lookup')),
                'tag' => esc_url_raw(rest_url('edpsy/v1/tag-lookup')),
            ),
            'ajaxActions' => array(
                'post' => 'edpsy_post_lookup',
                'tag' => 'edpsy_tag_lookup',
            ),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_rest'),
            'debounce' => 250,
            'strings' => array(
                'searchPosts' => __('Search posts…', 'edpsybold'),
                'searchTags' => __('Search tags…', 'edpsybold'),
                'loading' => __('Loading…', 'edpsybold'),
                'noResults' => __('No results found.', 'edpsybold'),
                'error' => __('Something went wrong. Please try again.', 'edpsybold'),
                'clear' => __('Clear', 'edpsybold'),
                'selectResult' => __('Use the arrow keys to navigate results and press Enter to select.', 'edpsybold'),
                'unavailable' => __('Unavailable', 'edpsybold'),
                'tagHasNoPosts' => __('This tag has no published posts yet.', 'edpsybold'),
                'selectionCleared' => __('The previous selection no longer meets the filter requirements and was cleared.', 'edpsybold'),
                'selectionInvalid' => __('This selection is no longer available. Please choose another post.', 'edpsybold'),
            ),
            'featuresCategory' => defined('EDPSY_FEATURES_CATEGORY_SLUG') ? EDPSY_FEATURES_CATEGORY_SLUG : 'features',
        )
    );

    wp_register_style(
        'edpsy-customizer-post-lookup',
        $theme_uri . '/assets/admin/css/customizer-post-lookup.css',
        array(),
        file_exists($style_path) ? filemtime($style_path) : false
    );

    wp_enqueue_script('edpsy-customizer-post-lookup');
    wp_enqueue_style('edpsy-customizer-post-lookup');
}

add_action('customize_register', 'edpsy_customize_register_homepage', 20);
/**
 * Register homepage Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function edpsy_customize_register_homepage(WP_Customize_Manager $wp_customize)
{
    $section_id = 'edp_home_section';

    if (!$wp_customize->get_section($section_id)) {
        $wp_customize->add_section($section_id, array(
            'title' => __('edpsy homepage settings', 'edpsybold'),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        ));
    } else {
        $wp_customize->get_section($section_id)->title = __('edpsy homepage settings', 'edpsybold');
    }

    // Hero post selection.
    $wp_customize->add_setting('hero_post_id', array(
        'default' => 0,
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        'validate_callback' => 'edpsy_validate_hero_post',
    ));

    $wp_customize->add_control(
        new Customize_Post_Lookup_Control(
            $wp_customize,
            'hero_post_id',
            array(
                'label' => __('Hero Post', 'edpsybold'),
                'section' => $section_id,
                'settings' => 'hero_post_id',
                'lookup_type' => 'post',
                'placeholder' => __('Search posts…', 'edpsybold'),
                'description' => __('Choose the article that appears in the hero area.', 'edpsybold'),
            )
        )
    );

    // Focus On toggles and title.
    $wp_customize->add_setting('focus_on_enabled', array(
        'default' => false,
        'type' => 'theme_mod',
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('focus_on_enabled', array(
        'label' => __('Show "Focus On" section', 'edpsybold'),
        'section' => $section_id,
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('focus_on_title', array(
        'default' => 'Focus On',
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('focus_on_title', array(
        'label' => __('"Focus On" section title', 'edpsybold'),
        'section' => $section_id,
        'type' => 'text',
    ));

    // Focus On tag selector.
    $wp_customize->add_setting('focus_on_tag', array(
        'default' => '',
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
        'validate_callback' => 'edpsy_validate_focus_tag',
    ));

    $wp_customize->add_control(
        new Customize_Post_Lookup_Control(
            $wp_customize,
            'focus_on_tag',
            array(
                'label' => __('Focus On tag', 'edpsybold'),
                'section' => $section_id,
                'settings' => 'focus_on_tag',
                'lookup_type' => 'tag',
                'placeholder' => __('Search tags…', 'edpsybold'),
                'description' => __('Select a tag to filter the Focus On posts. Posts that no longer match are cleared automatically.', 'edpsybold'),
                'control_settings' => array(
                    'tagStatus' => true,
                ),
            )
        )
    );

    // Focus On post selectors.
    for ($i = 1; $i <= 4; $i++) {
        $setting_id = "focus_on_post_$i";
        $wp_customize->add_setting($setting_id, array(
            'default' => 0,
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
            'validate_callback' => 'edpsy_validate_focus_post',
        ));

        $wp_customize->add_control(
            new Customize_Post_Lookup_Control(
                $wp_customize,
                $setting_id,
                array(
                    'label' => sprintf(__('Focus On post %d', 'edpsybold'), $i),
                    'section' => $section_id,
                    'settings' => $setting_id,
                    'lookup_type' => 'post',
                    'placeholder' => __('Search posts…', 'edpsybold'),
                    'filters' => array(
                        'tag_setting' => 'focus_on_tag',
                    ),
                    'control_settings' => array(
                        'group' => 'focus_on_posts',
                        'position' => $i,
                    ),
                )
            )
        );
    }

    // Longer Reads settings.
    $wp_customize->add_setting('longer_reads_enabled', array(
        'default' => false,
        'type' => 'theme_mod',
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('longer_reads_enabled', array(
        'label' => __('Show "Longer Reads" section', 'edpsybold'),
        'section' => $section_id,
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('longer_reads_title', array(
        'default' => 'Longer Reads',
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('longer_reads_title', array(
        'label' => __('"Longer Reads" section title', 'edpsybold'),
        'section' => $section_id,
        'type' => 'text',
    ));

    for ($i = 1; $i <= 2; $i++) {
        $setting_id = "longer_reads_post_$i";
        $wp_customize->add_setting($setting_id, array(
            'default' => 0,
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
            'validate_callback' => 'edpsy_validate_longer_reads_post',
        ));

        $wp_customize->add_control(
            new Customize_Post_Lookup_Control(
                $wp_customize,
                $setting_id,
                array(
                    'label' => sprintf(__('Longer Reads post %d', 'edpsybold'), $i),
                    'section' => $section_id,
                    'settings' => $setting_id,
                    'lookup_type' => 'post',
                    'placeholder' => __('Search posts…', 'edpsybold'),
                    'filters' => array(
                        'category' => defined('EDPSY_FEATURES_CATEGORY_SLUG') ? EDPSY_FEATURES_CATEGORY_SLUG : 'features',
                    ),
                    'control_settings' => array(
                        'group' => 'longer_reads',
                        'position' => $i,
                    ),
                )
            )
        );
    }
}

/**
 * Validate hero post selection.
 *
 * @param WP_Error|null         $validity Validation object.
 * @param mixed                 $value    Selected value.
 * @param WP_Customize_Setting $setting  Setting instance.
 *
 * @return WP_Error|null
 */
function edpsy_validate_hero_post($validity, $value, $setting)
{
    unset($setting);
    return edpsy_validate_post_against_rules($validity, $value, array());
}

/**
 * Validate Focus On tag selection.
 *
 * @param WP_Error|null $validity Validation object.
 * @param string        $value    Selected tag slug.
 *
 * @return WP_Error|null
 */
function edpsy_validate_focus_tag($validity, $value)
{
    $value = sanitize_text_field($value);

    if ('' === $value) {
        return $validity;
    }

    if (!term_exists($value, 'post_tag')) {
        if (!$validity instanceof WP_Error) {
            $validity = new WP_Error();
        }
        $validity->add('invalid', __('Select a valid tag.', 'edpsybold'));
    }

    return $validity;
}

/**
 * Validate Focus On posts.
 *
 * @param WP_Error|null         $validity Validation object.
 * @param mixed                 $value    Selected value.
 * @param WP_Customize_Setting $setting  Setting instance.
 *
 * @return WP_Error|null
 */
function edpsy_validate_focus_post($validity, $value, $setting)
{
    $filters = array();

    $manager = $setting instanceof WP_Customize_Setting ? $setting->manager : null;
    $tag_slug = '';
    if ($manager instanceof WP_Customize_Manager) {
        $posted_tag = $manager->post_value('focus_on_tag');
        if (null !== $posted_tag) {
            $tag_slug = sanitize_text_field($posted_tag);
        }
    }

    if ('' === $tag_slug) {
        $tag_slug = sanitize_text_field(get_theme_mod('focus_on_tag', ''));
    }

    if ('' !== $tag_slug) {
        $filters['tag'] = $tag_slug;
    }

    return edpsy_validate_post_against_rules($validity, $value, $filters);
}

/**
 * Validate Longer Reads posts.
 *
 * @param WP_Error|null         $validity Validation object.
 * @param mixed                 $value    Selected value.
 * @param WP_Customize_Setting $setting  Setting instance.
 *
 * @return WP_Error|null
 */
function edpsy_validate_longer_reads_post($validity, $value, $setting)
{
    unset($setting);
    $filters = array(
        'category' => defined('EDPSY_FEATURES_CATEGORY_SLUG') ? EDPSY_FEATURES_CATEGORY_SLUG : 'features',
    );

    return edpsy_validate_post_against_rules($validity, $value, $filters);
}

/**
 * Shared validation helper for post selections.
 *
 * @param WP_Error|null $validity Validation object.
 * @param mixed         $value    Selected value.
 * @param array         $filters  Filters to enforce (tag/category).
 *
 * @return WP_Error|null
 */
function edpsy_validate_post_against_rules($validity, $value, array $filters)
{
    $post_id = absint($value);

    if (0 === $post_id) {
        return $validity;
    }

    if (!edpsy_homepage_post_is_valid($post_id)) {
        if (!$validity instanceof WP_Error) {
            $validity = new WP_Error();
        }

        $validity->add('invalid', __('Select a published post.', 'edpsybold'));
        return $validity;
    }

    if (!empty($filters['tag']) && !has_term($filters['tag'], 'post_tag', $post_id)) {
        if (!$validity instanceof WP_Error) {
            $validity = new WP_Error();
        }
        $validity->add('tag_mismatch', __('The selected post must use the chosen tag.', 'edpsybold'));
    }

    if (!empty($filters['category'])) {
        $category_slug = sanitize_text_field($filters['category']);
        if ($category_slug && !has_term($category_slug, 'category', $post_id)) {
            if (!$validity instanceof WP_Error) {
                $validity = new WP_Error();
            }
            $validity->add('category_mismatch', __('The selected post must be in the required category.', 'edpsybold'));
        }
    }

    return $validity;
}

/**
 * Determine if a post is a valid published article.
 *
 * @param int $post_id Post ID.
 *
 * @return bool
 */
function edpsy_homepage_post_is_valid($post_id)
{
    $post = get_post($post_id);

    if (!$post instanceof WP_Post) {
        return false;
    }

    return 'post' === $post->post_type && 'publish' === $post->post_status;
}

add_action('customize_save_after', 'edpsy_homepage_customizer_after_save');
/**
 * After save enforcement for homepage selections.
 *
 * @param WP_Customize_Manager $manager Customizer instance.
 */
function edpsy_homepage_customizer_after_save(WP_Customize_Manager $manager)
{
    if (!current_user_can('edit_theme_options')) {
        return;
    }

    $hero_id = absint(get_theme_mod('hero_post_id'));
    if ($hero_id && !edpsy_homepage_post_is_valid($hero_id)) {
        set_theme_mod('hero_post_id', 0);
        $setting = $manager->get_setting('hero_post_id');
        if ($setting instanceof WP_Customize_Setting) {
            $setting->add_error(__('The selected hero post is no longer available and was cleared.', 'edpsybold'));
        }
    }

    $tag_slug = sanitize_text_field(get_theme_mod('focus_on_tag', ''));
    if ($tag_slug && !term_exists($tag_slug, 'post_tag')) {
        set_theme_mod('focus_on_tag', '');
        $setting = $manager->get_setting('focus_on_tag');
        if ($setting instanceof WP_Customize_Setting) {
            $setting->add_error(__('The selected tag could not be found and was cleared.', 'edpsybold'));
        }
        $tag_slug = '';
    }

    for ($i = 1; $i <= 4; $i++) {
        $setting_id = "focus_on_post_$i";
        $post_id = absint(get_theme_mod($setting_id));
        if (!$post_id) {
            continue;
        }

        $setting = $manager->get_setting($setting_id);
        $invalid = false;

        if (!edpsy_homepage_post_is_valid($post_id)) {
            $invalid = true;
            $message = __('One of your Focus On selections is no longer published and was cleared.', 'edpsybold');
        } elseif ($tag_slug && !has_term($tag_slug, 'post_tag', $post_id)) {
            $invalid = true;
            $message = __('A Focus On post no longer matches the selected tag and was cleared.', 'edpsybold');
        }

        if ($invalid) {
            set_theme_mod($setting_id, 0);
            if ($setting instanceof WP_Customize_Setting) {
                $setting->add_error($message);
            }
        }
    }

    $features_slug = defined('EDPSY_FEATURES_CATEGORY_SLUG') ? EDPSY_FEATURES_CATEGORY_SLUG : 'features';
    for ($i = 1; $i <= 2; $i++) {
        $setting_id = "longer_reads_post_$i";
        $post_id = absint(get_theme_mod($setting_id));
        if (!$post_id) {
            continue;
        }

        $setting = $manager->get_setting($setting_id);
        if (!edpsy_homepage_post_is_valid($post_id) || ($features_slug && !has_term($features_slug, 'category', $post_id))) {
            set_theme_mod($setting_id, 0);
            if ($setting instanceof WP_Customize_Setting) {
                $setting->add_error(__('Longer Reads selections must stay in the configured category; invalid items were cleared.', 'edpsybold'));
            }
        }
    }
}
