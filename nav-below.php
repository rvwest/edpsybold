<!-- file: nav-below.php -->
<?php
$args = array(
    'prev_text' => sprintf( esc_html__('%s older articles', 'edpsybold'), '<i class="fas fa-arrow-left"></i>' ),
    'next_text' => sprintf( esc_html__('newer articles %s', 'edpsybold'), '<i class="fas fa-arrow-right"></i>' ),
    'screen_reader_text' => ' ',
);
the_posts_navigation( $args );
echo '<!-- file end: nav-below.php -->';