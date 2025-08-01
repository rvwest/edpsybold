<?php
echo '<!-- file: home.php -->';

get_header();

get_template_part('home-slice-hero'); ?>

<?php
// Collect post IDs to exclude
$excluded_ids = array();

// Hero post
$hero_post_id = get_theme_mod('hero_post_id');
if ($hero_post_id) $excluded_ids[] = $hero_post_id;

// Focus On posts
for ($i = 1; $i <= 3; $i++) {
    $id = get_theme_mod("focus_on_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Longer Reads posts
for ($i = 1; $i <= 2; $i++) {
    $id = get_theme_mod("longer_reads_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Check if a job should be displayed
$job_shortcode_output = do_shortcode('[job_summary width="" align=""]');
$has_jobs = !empty(trim($job_shortcode_output));

// Determine how many posts to load
$posts_to_fetch = $has_jobs ? 7 : 6;

// Fetch latest posts, excluding selected ones
$latest_posts = get_posts(array(
    'numberposts' => $posts_to_fetch + count($excluded_ids), // fetch extras to account for exclusions
    'post_status' => 'publish',
    'post__not_in' => $excluded_ids,
));

// Trim to the number needed (5 if job is shown, 6 if not)
$display_post_count = $has_jobs ? 5 : 6;
$display_posts = array_slice($latest_posts, 0, $display_post_count);
?>
<section class="latest-articles grid12">
    <h2>Latest Articles</h2>
    <div class="article-grid">
        <?php
        $item_index = 0;
        for ($i = 0; $i < 6; $i++) {
            if ($i === 2 && $has_jobs) {
                // Insert job summary as item 3
                echo '<div class="article-item job-summary">';
                echo $job_shortcode_output;
                echo '</div>';
            } else {
                if (isset($display_posts[$item_index])) {
                    $post = $display_posts[$item_index];
                    ?>
                    <article <?php post_class('article-item'); ?>>
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
    for ($i = 1; $i <= 4; $i++) {
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
    <section class="focus-on grid12 edp-bold-posts-<?php echo $post_count; ?>">
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

<!-- next 3 articles -->

<?php
// Start with all the previously excluded post IDs
$excluded_ids = array();

// Hero post
$hero_post_id = get_theme_mod('hero_post_id');
if ($hero_post_id) $excluded_ids[] = $hero_post_id;

// Focus On
for ($i = 1; $i <= 3; $i++) {
    $id = get_theme_mod("focus_on_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Longer Reads
for ($i = 1; $i <= 2; $i++) {
    $id = get_theme_mod("longer_reads_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Also exclude posts shown in the latest articles section
// We assume this array was built earlier (see previous section)
if (isset($display_posts)) {
    foreach ($display_posts as $p) {
        $excluded_ids[] = $p->ID;
    }
}

// Now fetch the next 3 latest posts, excluding all of the above
$next_posts = get_posts(array(
    'numberposts' => 3,
    'post_status' => 'publish',
    'post__not_in' => $excluded_ids,
));
?>

<?php if (!empty($next_posts)): ?>
    <section class="next-latest-posts grid12">
        <h2>More Articles</h2>
        <div class="article-grid">
            <?php foreach ($next_posts as $post): ?>
                <article class="article-item">
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
<?php endif; ?>



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
    <section class="longer-reads grid12 edp-bold-posts-<?php echo $post_count; ?>">
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

<!-- next two articles -->

<?php
// Collect excluded post IDs again
$excluded_ids = array();

// Hero post
$hero_post_id = get_theme_mod('hero_post_id');
if ($hero_post_id) $excluded_ids[] = $hero_post_id;

// Focus On
for ($i = 1; $i <= 3; $i++) {
    $id = get_theme_mod("focus_on_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Longer Reads
for ($i = 1; $i <= 2; $i++) {
    $id = get_theme_mod("longer_reads_post_$i");
    if ($id) $excluded_ids[] = $id;
}

// Latest Articles (already in $display_posts)
if (isset($display_posts)) {
    foreach ($display_posts as $p) {
        $excluded_ids[] = $p->ID;
    }
}

// 3 Next Latest
if (isset($next_posts)) {
    foreach ($next_posts as $p) {
        $excluded_ids[] = $p->ID;
    }
}

// Fetch next 2 posts, excluding all shown so far
$final_posts = get_posts(array(
    'numberposts' => 2,
    'post_status' => 'publish',
    'post__not_in' => $excluded_ids,
));
?>

<?php if (!empty($final_posts)): ?>
    <section class="final-articles grid12">
        <h2>Latest Reads</h2>
        <div class="article-grid">
            <?php foreach ($final_posts as $post): ?>
                <article class="article-item">
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
<?php endif; ?>

<section class="grid12">
<h2>Jobs</h2>
<?php echo do_shortcode('[jobs per_page="3" show_filters="false"]') ?>
</section>

<section class="homepage-events-wrapper">
    <div class="homepage-events grid12">
<h2>Next events</h2>
<?php
// Query the next 4 upcoming Tribe events
$events = tribe_get_events( array(
    'posts_per_page' => 4,
    'start_date'     => date( 'Y-m-d H:i:s' ),
    'orderby'        => 'event_date',
    'order'          => 'ASC',
) );

if ( $events ) :
    echo '<ul class="homepage-upcoming-events">';
    foreach ( $events as $event ) :
        $event_id = $event->ID;
        $event_title = get_the_title( $event_id );
        $event_link = get_permalink( $event_id );
        $event_date = tribe_get_start_date( $event_id, false, 'F j, Y g:i a' );
        ?>
        <li>
            <a href="<?php echo esc_url( $event_link ); ?>"><?php echo esc_html( $event_title ); ?></a><br>
            <small><?php echo esc_html( $event_date ); ?></small>
        </li>
        <?php
    endforeach;
    echo '</ul>';
else :
    echo '<p>No upcoming events found.</p>';
endif;
?>
    </div>
</section>



<?php get_template_part('nav', 'below');
get_footer();
echo '<!-- file end: home.php -->'; ?>