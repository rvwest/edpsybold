<?php
$search_query = $search_context['search_query'];
$available_post_types = $search_context['available_post_types'];
$selected_content_type = $search_context['selected_content_type'];
$show_toggle_for_events = $search_context['show_toggle_for_events'];
$should_render_filters_form = $search_context['should_render_filters_form'];
$show_old_events = $search_context['show_old_events'];
?>
<div class="search-main-box" id="search-main-box">

    <form role="search" method="get" class="search-form search-wrapper" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="search-block">
            <div class="main-input">
                <label for="search-field"
                    class="screen-reader-text"><?php esc_html_e('Search for:', 'edpsybold'); ?></label>
                <svg class="svgicon svgicon--search search__input-control-icon-svg" viewBox="0 0 16 16"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.164 10.133L16 14.97 14.969 16l-4.836-4.836a6.225 6.225 0 01-3.875 1.352 6.24 6.24 0 01-4.427-1.832A6.272 6.272 0 010 6.258 6.24 6.24 0 011.831 1.83 6.272 6.272 0 016.258 0c1.67 0 3.235.658 4.426 1.831a6.272 6.272 0 011.832 4.427c0 1.422-.48 2.773-1.352 3.875zM6.258 1.458c-1.28 0-2.49.498-3.396 1.404-1.866 1.867-1.866 4.925 0 6.791a4.774 4.774 0 003.396 1.405c1.28 0 2.489-.498 3.395-1.405 1.867-1.866 1.867-4.924 0-6.79a4.774 4.774 0 00-3.395-1.405z">
                    </path>
                </svg>
                <input type="search" id="search-field" class="search-field"
                    placeholder="<?php echo esc_attr_x('Search …', 'placeholder', 'edpsybold'); ?>"
                    value="<?php echo esc_attr($search_query); ?>" name="s" />
                <?php if ('everything' !== $selected_content_type): ?>
                    <input type="hidden" name="content_type" value="<?php echo esc_attr($selected_content_type); ?>">
                <?php endif; ?>
                <?php if ($show_old_events): ?>
                    <input type="hidden" name="show_old_events" value="1">
                <?php endif; ?>
            </div>
        </div>
        <div class="submit-btn">
            <button type="submit"
                class="edp-button-solid"><?php echo esc_html_x('Search', 'submit button', 'edpsybold'); ?></button>
        </div>
    </form>


    <?php if (!empty($available_post_types)): ?>
        <form class="search-results__filters search-listings-sort-options" method="get"
            action="<?php echo esc_url(home_url('/')); ?>">
            <input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">

            <label for="search-content-type">
                Show:
            </label>

            <select id="search-content-type" name="content_type" onchange="this.form.submit()">
                <option value="everything" <?php selected($selected_content_type, 'everything'); ?>>
                    <?php esc_html_e('Everything', 'edpsybold'); ?>
                </option>
                <?php foreach ($available_post_types as $type): ?>
                    <option value="<?php echo esc_attr($type); ?>" <?php selected($selected_content_type, $type); ?>>
                        <?php echo esc_html(edpsybold_get_search_post_type_label($type)); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <noscript>
                <button type="submit"><?php esc_html_e('Apply filters', 'edpsybold'); ?></button>
            </noscript>
        </form>
    <?php endif; ?>
</div>
<?php if ($show_toggle_for_events): ?>
    <form class="search-results__filters-2 search-listings-sort-options-2" method="get"
        action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">


        <div class="search-results__toggle checkbox-pair">
            <input type="hidden" name="show_old_events" value="0">
            <label>
                <input type="checkbox" name="show_old_events" value="1" <?php checked($show_old_events); ?>
                    onchange="this.form.submit()">
                Include old events
            </label>
        </div>

        <noscript>
            <button type="submit"><?php esc_html_e('Apply choice', 'edpsybold'); ?></button>
        </noscript>
    </form>
<?php elseif ($show_old_events): ?>
    <input type="hidden" name="show_old_events" value="1">
<?php endif; ?>