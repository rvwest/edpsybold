<?php
echo '<!-- file: home.php -->';

get_header();

get_template_part('_home-slice-hero'); ?>

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

    <div class="article-grid">
        <?php
        $item_index = 0;
        for ($i = 0; $i < 6; $i++) {
            if ($i === 2 && $has_jobs) {
                // Insert job summary as item 3
                echo '<div class="article-item job-summary">';
                echo do_shortcode('[job_summary width="" align=""]');
                echo '</div>';
            } else {
                if (isset($display_posts[$item_index])) {
                    $post = $display_posts[$item_index];
                    setup_postdata($post);
                    get_template_part('_home-article-item');
                    wp_reset_postdata();
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
                <?php
                setup_postdata($post);
                get_template_part('_home-article-item');
                wp_reset_postdata();
                ?>
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

        <div class="article-grid">
            <?php foreach ($next_posts as $post): ?>
                <?php
                setup_postdata($post);
                get_template_part('_home-article-item');
                wp_reset_postdata();
                ?>
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
                <?php
                setup_postdata($post);
                get_template_part('_home-article-item');
                wp_reset_postdata();
                ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php
    endif;
endif;
?>

<!-- next articles -->

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

// Fetch next 3 posts, excluding all shown so far
$final_posts = get_posts(array(
    'numberposts' => 6,
    'post_status' => 'publish',
    'post__not_in' => $excluded_ids,
));
?>

<?php if (!empty($final_posts)): ?>
    <section class="final-articles grid12">
        <div class="article-grid">
            <?php foreach ($final_posts as $post): ?>
                <?php
                setup_postdata($post);
                get_template_part('_home-article-item');
                wp_reset_postdata();
                ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php
$homepage_jobs_output = do_shortcode('[jobs-homepage per_page="3" show_filters="false"]');
if (trim($homepage_jobs_output) !== '') :
?>
<section class="homepage-jobs-wrapper">
<div class="homepage-jobs grid12">
<h2><a href="jobs/">Jobs</a></h2>
<?php echo $homepage_jobs_output; ?>
<div class="home-see-all"><a href="jobs/" class="edp-button-outline button">See all jobs</a></div>
</div>
</section>
<?php endif; ?>

<?php
// Query the next 4 upcoming events
$events = tribe_get_events([
        'posts_per_page' => 4,
        'start_date'     => date('Y-m-d H:i:s'),
        'orderby'        => 'event_date',
        'order'          => 'ASC',
]);

$event_count = count($events);
$count_class = edpsybold_count_class($event_count);
?>
<section class="homepage-events-wrapper <?php echo esc_attr($count_class); ?>">
    <div class="homepage-events grid12">
        <h2><a href="events">Next events</a></h2>
        <?php
        if ($events) :
                echo '<div class="edp-events-calendar-list">';
                $tpl = new class {
                        public function template($template, $data = []) {
                                $path = locate_template('tribe/events/v2/' . $template . '.php');
                                if (!$path) {
                                        return;
                                }
                                extract($data);
                                include $path;
                        }
                };

                $event_index = 0;
                foreach ($events as $event_post) {
                        if ($event_index % 2 === 0) {
                                echo '<div class="edp-events-calendar-list__event-row-wrapper">';
                        }

                        $event = tribe_get_event($event_post);
                        $tpl->template('list/event', [
                                'event'        => $event,
                                'is_past'      => false,
                                'request_date' => null,
                                'slug'         => 'home',
                        ]);

                        $event_index++;
                        if ($event_index % 2 === 0 || $event_index === $event_count) {
                                echo '</div>';
                        }
                }
                echo '</div>';
        else :
                echo '<p>No upcoming events found.</p>';
        endif;
        ?>
<div class="home-see-all"><a href="events/" class="button edp-button-outline edp-button-outline--reversed">See all events</a></div>    
</div>
    
</section>



<?php 
get_footer();
echo '<!-- file end: home.php -->'; ?>