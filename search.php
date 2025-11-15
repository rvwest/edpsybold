<!-- file: search.php -->
<?php get_header(); ?>

<?php
$search_query = get_search_query();
$show_old_events = edpsybold_should_show_old_events();
$available_post_types = edpsybold_collect_search_post_types($search_query, $show_old_events);
$selected_content_type = isset($_GET['content_type']) ? sanitize_key(wp_unslash($_GET['content_type'])) : 'everything';
if (!in_array($selected_content_type, $available_post_types, true)) {
    $selected_content_type = 'everything';
}

$has_old_events = edpsybold_search_has_old_events($search_query);
$show_toggle_for_events = post_type_exists('tribe_events')
    && ('everything' === $selected_content_type || 'tribe_events' === $selected_content_type)
    && ($show_old_events || $has_old_events);
?>

<section class="search-results" id="search-results">
    <header class="header">
        <h1 class="entry-title" itemprop="name">
            <?php printf(esc_html__('Search Results for: %s', 'edpsybold'), esc_html($search_query)); ?>
        </h1>
        <div class="search-results__search-form">
            <?php get_search_form(); ?>
        </div>
        <?php if (!empty($available_post_types)): ?>
            <form class="search-results__filters" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">
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
                <?php if ($show_toggle_for_events): ?>
                    <div class="search-results__toggle">
                        <input type="hidden" name="show_old_events" value="0">
                        <label>
                            <input type="checkbox" name="show_old_events" value="1" <?php checked($show_old_events); ?>
                                onchange="this.form.submit()">
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
    </header>

    <?php if (have_posts()): ?>
        <?php while (have_posts()): ?>
            <?php
            the_post();
            $post_type_label = edpsybold_get_search_post_type_label(get_post_type());
            ?>
            <article <?php post_class('search-result'); ?> id="post-<?php the_ID(); ?>">
                <header class="search-result__header">
                    <h2 class="search-result__title">
                        <span class="search-result__type"><?php echo esc_html($post_type_label); ?>:</span>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                </header>
                <div class="search-result__excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <?php get_template_part('nav', 'below'); ?>
    <?php else: ?>
        <article id="post-0" class="post no-results not-found">
            <header class="header">
                <h2 class="entry-title" itemprop="name"><?php esc_html_e('Nothing Found', 'edpsybold'); ?></h2>
            </header>
            <div class="entry-content" itemprop="mainContentOfPage">
                <p><?php esc_html_e('Sorry, nothing matched your search. Please try again.', 'edpsybold'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </article>
    <?php endif; ?>
</section>

<?php get_footer(); ?>
<!-- file end: search.php -->

