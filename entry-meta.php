<!-- file: entry-meta.php -->
<?php require_once __DIR__ . '/entry-read-time.php'; ?>

<div class="meta-bg"></div>
<div class="entry-date-readtime">
        <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"
            title="<?php echo esc_attr(get_the_date()); ?>" <?php if (is_single()) {
                   echo 'itemprop="datePublished" pubdate';
               } ?>><?php the_time(get_option('date_format')); ?></time>
        <?php
        $read_time = edp_calculate_read_time();
        $read_label = sprintf(
            _n('%d minute read time', '%d minute read', $read_time, 'edpsybold'),
            intval($read_time)
        );
        ?>
        <div class="read-time"><?php echo esc_html($read_label); ?></div>
</div>
<div class="tags--header">
    <?php
$tags = get_the_terms(get_the_ID(), 'post_tag');
if ($tags && ! is_wp_error($tags)) {
    $count = count($tags);

    if ($count > 4) {
        // Show the first three tags
        $display = array_slice($tags, 0, 3);
        foreach ($display as $tag) {
            echo '<a class="post-tag" href="' . esc_url(get_tag_link($tag)) . '">' . esc_html($tag->name) . '</a>';
        }
        // Replace the fourth with a +X others link to the full tag list
        $others = $count - 3;
        $label = _n('+ %d other', '+ %d others', $others, 'edpsybold');
        echo '<a class="post-tag post-tag--more" href="#page-tags">' . sprintf($label, intval($others)) . '</a>';
    } else {
        // 4 or fewer: show them all
        foreach ($tags as $tag) {
            echo '<a class="post-tag" href="' . esc_url(get_tag_link($tag)) . '">' . esc_html($tag->name) . '</a>';
        }
    }
}
?>
            </div>

<div class="share-button button edp-button">
    SHAREBUTTON
            </div>
<!-- file end: entry-meta.php -->