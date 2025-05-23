<!-- file: nav-below.php -->
<?php $args = array(
    'prev_text' => sprintf(esc_html__('%s older', 'edpsybold'), '<span class="meta-nav">&larr;</span>'),
    'next_text' => sprintf(esc_html__('newer %s', 'edpsybold'), '<span class="meta-nav">&rarr;</span>')
);
the_posts_navigation($args);
echo '<!-- file end: nav-below.php -->';