<?php
$search_query = $search_context['search_query'];
$available_post_types = $search_context['available_post_types'];
$selected_content_type = $search_context['selected_content_type'];
$show_toggle_for_events = $search_context['show_toggle_for_events'];
$should_render_filters_form = $search_context['should_render_filters_form'];
$show_old_events = $search_context['show_old_events'];
?>

<div class="search-results__search-form">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <label for="search-field" class="screen-reader-text"><?php esc_html_e('Search for:', 'edpsybold'); ?></label>
        <input
            type="search"
            id="search-field"
            class="search-field"
            placeholder="<?php echo esc_attr_x('Search …', 'placeholder', 'edpsybold'); ?>"
            value="<?php echo esc_attr($search_query); ?>"
            name="s"
        />
        <?php if ('everything' !== $selected_content_type): ?>
            <input type="hidden" name="content_type" value="<?php echo esc_attr($selected_content_type); ?>">
        <?php endif; ?>
        <?php if ($show_old_events): ?>
            <input type="hidden" name="show_old_events" value="1">
        <?php endif; ?>
        <button type="submit"><?php echo esc_html_x('Search', 'submit button', 'edpsybold'); ?></button>
    </form>
</div>

<?php if ($should_render_filters_form): ?>
    <form class="search-results__filters" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">
        <?php if (!empty($available_post_types)): ?>
            <label for="search-content-type" class="screen-reader-text">
                <?php esc_html_e('Filter by content type', 'edpsybold'); ?>
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
        <?php endif; ?>
        <?php if ($show_toggle_for_events): ?>
            <div class="search-results__toggle">
                <input type="hidden" name="show_old_events" value="0">
                <label>
                    <input type="checkbox" name="show_old_events" value="1" <?php checked($show_old_events); ?> onchange="this.form.submit()">
                    <?php esc_html_e('Show old events', 'edpsybold'); ?>
                </label>
            </div>
        <?php elseif ($show_old_events): ?>
            <input type="hidden" name="show_old_events" value="1">
        <?php endif; ?>
        <noscript>
            <button type="submit"><?php esc_html_e('Apply filters', 'edpsybold'); ?></button>
        </noscript>
    </form>
<?php endif; ?>
