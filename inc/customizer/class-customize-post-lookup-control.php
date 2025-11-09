<?php
/**
 * Customizer control for searchable post and tag lookups.
 *
 * @package edpsybold
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_Customize_Control')) {
    require_once ABSPATH . WPINC . '/class-wp-customize-control.php';
}

if (!class_exists('Customize_Post_Lookup_Control') && class_exists('WP_Customize_Control')) {
    class Customize_Post_Lookup_Control extends WP_Customize_Control
    {
        /**
         * Control type.
         *
         * @var string
         */
        public $type = 'edpsy-post-lookup';

        /**
         * Lookup type (post or tag).
         *
         * @var string
         */
        public $lookup_type = 'post';

        /**
         * Whether clearing the selection is allowed.
         *
         * @var bool
         */
        public $allow_clear = true;

        /**
         * Placeholder text for the search input.
         *
         * @var string
         */
        public $placeholder = '';

        /**
         * Additional filters to expose to the client.
         *
         * @var array
         */
        public $filters = array();

        /**
         * Optional control specific configuration passed to JS.
         *
         * @var array
         */
        public $control_settings = array();

        /**
         * Customize_Post_Lookup_Control constructor.
         *
         * @param WP_Customize_Manager $manager Manager instance.
         * @param string               $id      Control ID.
         * @param array                $args    Control arguments.
         */
        public function __construct($manager, $id, $args = array())
        {
            if (isset($args['lookup_type'])) {
                $this->lookup_type = $args['lookup_type'];
                unset($args['lookup_type']);
            }

            if (isset($args['allow_clear'])) {
                $this->allow_clear = (bool) $args['allow_clear'];
                unset($args['allow_clear']);
            }

            if (isset($args['placeholder'])) {
                $this->placeholder = (string) $args['placeholder'];
                unset($args['placeholder']);
            }

            if (isset($args['filters'])) {
                $this->filters = (array) $args['filters'];
                unset($args['filters']);
            }

            if (isset($args['control_settings'])) {
                $this->control_settings = (array) $args['control_settings'];
                unset($args['control_settings']);
            }

            parent::__construct($manager, $id, $args);
        }

        /**
         * Enqueue assets.
         */
        public function enqueue()
        {
            wp_enqueue_script('edpsy-customizer-post-lookup');
            wp_enqueue_style('edpsy-customizer-post-lookup');
        }

        /**
         * Pass data to JavaScript.
         */
        public function to_json()
        {
            parent::to_json();

            $this->json['lookupType'] = $this->lookup_type;
            $this->json['allowClear'] = $this->allow_clear;
            $this->json['placeholder'] = $this->placeholder;
            $this->json['filters'] = $this->filters;
            $this->json['controlSettings'] = $this->control_settings;
            $this->json['selectedItem'] = $this->get_selected_item();
            $this->json['hasSelection'] = !empty($this->json['selectedItem']);
        }

        /**
         * Fetch the stored value formatted for the client.
         *
         * @return mixed
         */
        protected function get_stored_value()
        {
            $value = $this->value();

            if ('post' === $this->lookup_type) {
                return absint($value);
            }

            return is_string($value) ? $value : '';
        }

        /**
         * Retrieve information about the selected value.
         *
         * @return array|null
         */
        protected function get_selected_item()
        {
            $value = $this->get_stored_value();

            if (empty($value)) {
                return null;
            }

            if ('tag' === $this->lookup_type) {
                $term = get_term_by('slug', $value, 'post_tag');
                if ($term && !is_wp_error($term)) {
                    return array(
                        'value' => $term->slug,
                        'label' => html_entity_decode($term->name, ENT_QUOTES, get_bloginfo('charset')),
                        'count' => (int) $term->count,
                        'valid' => true,
                    );
                }

                return array(
                    'value' => $value,
                    'label' => sprintf(
                        __('Unavailable (%s)', 'edpsybold'),
                        esc_html($value)
                    ),
                    'count' => 0,
                    'valid' => false,
                );
            }

            $post = get_post($value);
            if ($post && 'post' === $post->post_type && 'publish' === $post->post_status) {
                $tag_filter = isset($this->filters['tag_setting']) ? sanitize_text_field(get_theme_mod($this->filters['tag_setting'])) : '';
                $category_filter = isset($this->filters['category']) ? sanitize_text_field($this->filters['category']) : '';

                return array(
                    'value' => (int) $post->ID,
                    'label' => html_entity_decode(get_the_title($post), ENT_QUOTES, get_bloginfo('charset')),
                    'date' => get_post_time('Y-m-d', false, $post),
                    'valid' => true,
                    'matchesTag' => $tag_filter ? has_term($tag_filter, 'post_tag', $post) : true,
                    'matchesCategory' => $category_filter ? has_term($category_filter, 'category', $post) : true,
                );
            }

            return array(
                'value' => (int) $value,
                'label' => sprintf(__('Unavailable (ID %d)', 'edpsybold'), (int) $value),
                'date' => '',
                'valid' => false,
                'matchesTag' => false,
                'matchesCategory' => false,
            );
        }

        /**
         * Render the control content.
         */
        public function render_content()
        {
            $input_id = 'edpsy-post-lookup-' . esc_attr($this->id);
            $results_id = $input_id . '-results';
            $value = $this->get_stored_value();
            ?>
            <?php if ($this->label) : ?>
                <span class="customize-control-title" id="<?php echo esc_attr($input_id); ?>-label"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>
            <?php if ($this->description) : ?>
                <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
            <?php endif; ?>
            <div class="edpsy-post-lookup" data-control-id="<?php echo esc_attr($this->id); ?>" data-lookup-type="<?php echo esc_attr($this->lookup_type); ?>">
                <input type="hidden" class="edpsy-post-lookup__value" value="<?php echo esc_attr($value); ?>" <?php $this->link(); ?> />
                <div class="edpsy-post-lookup__selection" role="list"></div>
                <div class="edpsy-post-lookup__combobox" role="combobox" aria-expanded="false" aria-owns="<?php echo esc_attr($results_id); ?>" aria-haspopup="listbox">
                    <input type="text" id="<?php echo esc_attr($input_id); ?>" class="edpsy-post-lookup__input" aria-autocomplete="list" aria-controls="<?php echo esc_attr($results_id); ?>" aria-labelledby="<?php echo esc_attr($input_id); ?>-label" autocomplete="off" placeholder="<?php echo esc_attr($this->placeholder); ?>" />
                    <?php if ($this->allow_clear) : ?>
                        <button type="button" class="button-link edpsy-post-lookup__clear" aria-label="<?php esc_attr_e('Clear selection', 'edpsybold'); ?>"><?php esc_html_e('Clear', 'edpsybold'); ?></button>
                    <?php endif; ?>
                </div>
                <div class="edpsy-post-lookup__results" id="<?php echo esc_attr($results_id); ?>" role="listbox" tabindex="-1"></div>
                <div class="screen-reader-text edpsy-post-lookup__status" aria-live="polite" aria-atomic="true"></div>
                <div class="edpsy-post-lookup__notice" aria-live="polite"></div>
                <?php if ('tag' === $this->lookup_type) : ?>
                    <div class="edpsy-post-lookup__tag-feedback" aria-live="polite"></div>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}
