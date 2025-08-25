<!-- file: nav-below.php -->
<?php
$args = array(
    'prev_text' => '<a class="edp-button-outline button">' . sprintf(esc_html__('%s older', 'edpsybold'), '<i class="fas fa-arrow-left"></i>') . '</a>',
    'next_text' => '<a class="edp-button-outline button">' . sprintf(esc_html__('newer %s', 'edpsybold'), '<i class="fas fa-arrow-right"></i>') . '</a>',
    'screen_reader_text' => ' '
);
the_posts_navigation($args);
echo '<!-- file end: nav-below.php -->';