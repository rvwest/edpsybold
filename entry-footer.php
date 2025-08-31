<!-- file: entry-footer.php -->
 <hr>
<footer class="entry-footer grid12">
  
    <span class="tag-links"><?php
$before = '<div class="tag-title">Tags:</div><div class="tag-items">';
$seperator = ''; // blank instead of comma
$after = '</div>';

the_tags( $before, $seperator, $after );
?></span>
    <?php get_template_part('biography', get_post_format()); ?>
</footer>
<!-- file end: entry-footer.php -->