<!-- file: entry-footer.php -->

<footer class="entry-footer grid12" id="footer-tags-block">

  <div class="tag-links">
    <?php
    $before = '<i class="far fa-tags"></i><div class="tag-items">';
    $seperator = ''; // blank instead of comma
    $after = '</div>';

    the_tags($before, $seperator, $after);
    ?>
  </div>
  <div class="page-divider"> </div>
  <?php get_template_part('biography', get_post_format()); ?>
  <div class="page-divider"> </div>
  <?php if (function_exists('echo_crp')) {
    echo_crp('');
  } ?>
</footer>
<!-- file end: entry-footer.php -->