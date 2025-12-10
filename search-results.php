<?php
$search_context = wp_parse_args(
    isset($search_context) && is_array($search_context) ? $search_context : array(),
    array(
        'search_query' => '',
        'show_old_events' => false,
        'available_post_types' => array(),
        'selected_content_type' => 'everything',
        'show_toggle_for_events' => false,
        'should_render_filters_form' => false,
        'results_count' => 0,
    )
);
?>

<section class="search-results" id="search-results">
    <header class="header">
        <h1 class="entry-title" itemprop="name">
            <?php printf(esc_html__('Search Results for: %s', 'edpsybold'), esc_html($search_context['search_query'])); ?>
        </h1>

        <?php require locate_template('search-form.php'); ?>

        <p class="search-results__count">
            <?php
            printf(
                esc_html(_n('%s result', '%s results', $search_context['results_count'], 'edpsybold')),
                esc_html(number_format_i18n($search_context['results_count']))
            );
            ?>
        </p>
    </header>

    <?php if (have_posts()): ?>
        <?php while (have_posts()): ?>
            <?php
            the_post();
            require locate_template('search-result.php');
            ?>
        <?php endwhile; ?>

        <?php require locate_template('pagination.php'); ?>
    <?php else: ?>
        <article id="post-0" class="post no-results not-found">
            <header class="header">
                <h2 class="entry-title" itemprop="name"><?php esc_html_e('Nothing Found', 'edpsybold'); ?></h2>
            </header>
            <div class="entry-content" itemprop="mainContentOfPage">
                <p><?php esc_html_e('Sorry, nothing matched your search. Please try again.', 'edpsybold'); ?></p>
                <?php require locate_template('search-form.php'); ?>
            </div>
        </article>
    <?php endif; ?>
</section>
