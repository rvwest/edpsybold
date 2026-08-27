
<!-- file: entry-meta.php -->
<?php require_once __DIR__ . '/entry-read-time.php'; ?>


<div class="entry-meta">
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
    // Active campaign tag (if any) is listed first and flagged for styling.
    foreach ($tags as $i => $tag) {
        if (get_field('tag_cta_active', $tag)) {
            $campaign_index = $i;
            break;
        }
    }
    if (isset($campaign_index)) {
        $campaign_tag = $tags[$campaign_index];
        unset($tags[$campaign_index]);
        array_unshift($tags, $campaign_tag);
        $tags = array_values($tags);
    }

    $tag_link = function ($tag) {
        $class = 'post-tag' . (get_field('tag_cta_active', $tag) ? ' campaign-tag' : '');
        return '<a class="' . esc_attr($class) . '" href="' . esc_url(get_tag_link($tag)) . '">' . esc_html($tag->name) . '</a>';
    };

    $count = count($tags);

    if ($count > 5) {
        // Show first 4; last of the shown ones has no wrapper/comma
        $display = array_slice($tags, 0, 4);
        $last_index = count($display) - 1;
        foreach ($display as $i => $tag) {
            $link = $tag_link($tag);
            if ($i === $last_index) {
                // Last displayed tag: no wrapper/comma
                echo '<div class="post-tag-wrapper">' . $link . '</div>';
            } else {
                // Non-last: wrap with comma after
                echo '<div class="post-tag-wrapper">' . $link . ',</div>';
            }
        }
        // Then append the +X others link without a preceding comma
        $others = $count - 4;
        $label  = _n('+ %d other', '+ %d others', $others, 'edpsybold');
        echo ' <a class="post-tag post-tag--more" href="#footer-tags-block">' . sprintf($label, intval($others)) . '</a>';
    } else {
        // 5 or fewer: show them all, only the last lacks wrapper/comma
        $last_index = $count - 1;
        foreach ($tags as $i => $tag) {
            $link = $tag_link($tag);
            if ($i === $last_index) {
                echo $link;
            } else {
                echo '<div class="post-tag-wrapper">' . $link . ',</div>';
            }
        }
    }
}
?>
            </div>
<div class="entry-meta--share-button"><button type="button" id="share-button" class="edp-button-pill">
    <?php esc_html_e('share', 'edpsybold'); ?> <i class="far fa-share-alt"></i>
</button>
</div>
</div>
<!-- file end: entry-meta.php -->
