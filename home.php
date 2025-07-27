<?php
echo '<!-- file: home.php -->';

get_header();

$hero_post_id = get_theme_mod('hero_post_id');

if ($hero_post_id) {
    $hero_post = get_post($hero_post_id);
    $hero_image = get_the_post_thumbnail_url($hero_post_id, 'large');
    ?>
    <section class="hero-post">
        <?php if ($hero_image): ?>
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(get_the_title($hero_post)); ?>">
        <?php endif; ?>
        <h1><?php echo esc_html(get_the_title($hero_post)); ?></h1>
    </section>
    <?php
}

?>
<?php
$hero_post_id = get_theme_mod('hero_post_id');

// Get the latest 7 posts
$args = array(
    'numberposts' => 12,
    'post_status' => 'publish',
);
$latest_posts = get_posts($args);

// Filter out the hero post
$filtered_posts = array_filter($latest_posts, function($post) use ($hero_post_id) {
    return $post->ID != $hero_post_id;
});

// Reset array keys
$filtered_posts = array_values($filtered_posts);

// Assume there is at least one job if this returns non-empty
$has_jobs = !empty(do_shortcode('[job_summary width="" align=""]'));

// Adjust number of posts to fetch: 6 if no job, 5 if job present
$posts_to_show = $has_jobs ? 5 : 6;
$display_posts = array_slice($filtered_posts, 0, $posts_to_show);
?>

<section class="latest-articles">
    <h2>Latest Articles</h2>
    <div class="article-grid">
        <?php
        $item_index = 0;
        for ($i = 0; $i < 6; $i++) {
            if ($i === 2 && $has_jobs) {
                // Insert job at third slot (index 2)
                echo '<div class="article-item job-summary">';
                echo do_shortcode('[job_summary width="" align=""]');
                echo '</div>';
            } else {
                if (isset($display_posts[$item_index])) {
                    $post = $display_posts[$item_index];
                    ?>
                    <article class="article-item">
                        <a href="<?php echo get_permalink($post); ?>">
                            <?php if (has_post_thumbnail($post)): ?>
                                <?php echo get_the_post_thumbnail($post, 'medium'); ?>
                            <?php endif; ?>
                            <h3><?php echo esc_html(get_the_title($post)); ?></h3>
                        </a>
                    </article>
                    <?php
                    $item_index++;
                }
            }
        }
        ?>
    </div>
</section>
<!-- focus on section -->
<?php
if (get_theme_mod('focus_on_enabled')) :
    $section_title = get_theme_mod('focus_on_title', 'Focus On');

    // Collect selected posts
    $posts = array();
    for ($i = 1; $i <= 3; $i++) {
        $post_id = get_theme_mod("focus_on_post_$i");
        if ($post_id) {
            $post = get_post($post_id);
            if ($post && $post->post_status === 'publish') {
                $posts[] = $post;
            }
        }
    }

    $post_count = count($posts);
    if ($post_count > 0) :
?>
    <section class="focus-on edp-bold-posts-<?php echo $post_count; ?>">
        <h2><?php echo esc_html($section_title); ?></h2>
        <div class="focus-posts-grid">
            <?php foreach ($posts as $post): ?>
                <article class="focus-post">
                    <a href="<?php echo get_permalink($post); ?>">
                        <?php if (has_post_thumbnail($post)): ?>
                            <?php echo get_the_post_thumbnail($post, 'medium'); ?>
                        <?php endif; ?>
                        <h3><?php echo esc_html(get_the_title($post)); ?></h3>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php
    endif;
endif;
?>

<!-- longer reads section -->

<?php
if (get_theme_mod('longer_reads_enabled')) :
    $title = get_theme_mod('longer_reads_title', 'Longer Reads');

    // Collect selected posts
    $posts = array();
    for ($i = 1; $i <= 2; $i++) {
        $post_id = get_theme_mod("longer_reads_post_$i");
        if ($post_id) {
            $post = get_post($post_id);
            if ($post && $post->post_status === 'publish') {
                $posts[] = $post;
            }
        }
    }

    $post_count = count($posts);
    if ($post_count > 0) :
?>
    <section class="longer-reads edp-bold-posts-<?php echo $post_count; ?>">
        <h2><?php echo esc_html($title); ?></h2>
        <div class="longer-reads-grid">
            <?php foreach ($posts as $post): ?>
                <article class="longer-read">
                    <a href="<?php echo get_permalink($post); ?>">
                        <?php if (has_post_thumbnail($post)): ?>
                            <?php echo get_the_post_thumbnail($post, 'medium'); ?>
                        <?php endif; ?>
                        <h3><?php echo esc_html(get_the_title($post)); ?></h3>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php
    endif;
endif;
?>



<?php get_template_part('nav', 'below');
get_footer();
echo '<!-- file end: home.php -->'; ?>