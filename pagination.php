<nav class="search-results__pagination" aria-label="<?php esc_attr_e('Search results pagination', 'edpsybold'); ?>">
    <?php
    the_posts_pagination(
        array(
            'mid_size' => 2,
            'prev_text' => __('previous', 'edpsybold'),
            'next_text' => __('next', 'edpsybold'),
        )
    );
    ?>
</nav>