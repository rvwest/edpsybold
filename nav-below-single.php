<!-- file: nav-below-single.php -->
<?php $args = array(
    'prev_text' => '<span class="meta-nav">&larr;</span> %title',
    'next_text' => '%title <span class="meta-nav">&rarr;</span>'
);
the_post_navigation($args);
echo '<!-- file end: nav-below-single.php -->';