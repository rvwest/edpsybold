<!DOCTYPE html>
<!-- file: header.php -->
<html <?php language_attributes(); ?> <?php edpsybold_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <?php get_template_part('_promo-banner'); ?>

        <header id="header" role="banner" class="edp-fullwidth">
            <div class="gridcontainer grid12">
                <div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                    <?php
                    // Determine if we're on the homepage or blog page
                    $is_homepage = is_front_page() || is_home();

                    // Cache the current post slug for conditional layouts
                    $current_slug = '';
                    $queried_object = get_queried_object();
                    if ($queried_object && !is_wp_error($queried_object) && property_exists($queried_object, 'post_name')) {
                        $current_slug = $queried_object->post_name;
                    }

                    // Open the h1 tag only if on the homepage
                    if ($is_homepage) {
                        echo '<h1>';
                    }
                    ?>


                    <a href="<?php echo esc_url(home_url('/')); ?>"
                        title="<?php echo esc_attr(get_bloginfo('name')); ?>" class="header-logo-wrapper" rel="home"
                        itemprop="url">
                        <span class="visually-hidden"
                            itemprop="name"><?php echo esc_html(get_bloginfo('name')); ?></span>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/edpsy-logo-dark.svg'); ?>"
                            alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="header-logo" itemprop="logo" />
                    </a>

                    <?php
                    // Close the h1 tag if it was opened
                    if ($is_homepage) {
                        echo '</h1>';
                    }
                    ?>
                </div>
                <!-- <div id="site-description" <?php if (!is_single()) {
                    echo ' itemprop="description"';
                } ?>>
                    <?php bloginfo('description'); ?>
                </div> -->

                <button class="menu-toggle" aria-label="Toggle menu"><i class="far fa-bars"></i></button>
                <nav class="top-nav-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu', // Menu location (defined in functions.php)
                        'container' => false, // Remove nav container
                        'menu_class' => 'edp-main-menu', // Optional: Add class to the <ul>
                    ));
                    ?>
                </nav>
            </div>

        </header>

        <?php if (is_singular('job_listing')): ?>
            <!-- var: single jobs page -->
            <div class="backblock edp-fullwidth">
                <div class="grid12">
                    <div class="backblock-link"><a href="../../jobs/"><i class="far fa-arrow-left fa-xs"></i> all
                            jobs</a></div>
                </div>
            </div>
            <div id="container" class="edp-fullwidth">
                <main id="content" role="main">





                <?php elseif ($current_slug === 'interest-groups'): ?>
                    <!-- var: interest groups page -->
                    <div id="container"
                        class="edp-fullwidth edp-special-page-wide edp-special-page-dark edp-special-page-listings">
                        <main id="content" role="main" class="grid12">


                        <?php elseif (is_singular('post')): ?>
                            <!-- var: single blog page -->
                            <div class="backblock edp-fullwidth">
                                <div class="grid12">
                                    <div class="backblock-link"><a href="../../blog"><i class="far fa-arrow-left fa-xs"></i>
                                            all
                                            blogs</a>
                                    </div>
                                </div>
                            </div>
                            <div id="container">
                                <main id="content" role="main">


                                <?php elseif (is_singular('wpbdp_listing')): ?>
                                    <!-- var: single thesis page -->
                                    <div class="backblock edp-fullwidth">
                                        <div class="grid12">
                                            <div class="backblock-link"><a href="../../thesis-directory"><i
                                                        class="far fa-arrow-left fa-xs"></i> thesis directory</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="container" class="edp-fullwidth">
                                        <main id="content" role="main">


                                        <?php elseif (is_singular('tribe_events')): ?>
                                            <!-- var: single event page -->
                                            <div class="backblock edp-fullwidth">
                                                <div class="grid12">
                                                    <div class="backblock-link"><a href="../../events"><i
                                                                class="far fa-arrow-left fa-xs"></i> all events</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="container">
                                                <main id="content" role="main" class="fullwidth">
                                                <?php elseif ($is_homepage): ?>
                                                    <!-- var: homepage -->
                                                    <div id="container" class="edp-fullwidth">
                                                        <main id="content" role="main">

                                                        <?php elseif (in_array('edp-parent-mentoring', get_body_class(), true)): ?>
                                                            <!-- var: single thesis page -->
                                                            <div class="backblock edp-fullwidth">
                                                                <div class="grid12">
                                                                    <div class="backblock-link"><a href="../../mentoring"><i
                                                                                class="far fa-arrow-left fa-xs"></i>
                                                                            all mentors
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="container" class="edp-fullwidth">
                                                                <main id="content" role="main" class="grid12">

                                                                <?php elseif (in_array('edp-parent-interest-groups', get_body_class(), true)): ?>
                                                                    <!-- var: single thesis page -->
                                                                    <div class="backblock edp-fullwidth">
                                                                        <div class="grid12">
                                                                            <div class="backblock-link"><a
                                                                                    href="../../interest-groups"><i
                                                                                        class="far fa-arrow-left fa-xs"></i>
                                                                                    all groups</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="container" class="edp-fullwidth">
                                                                        <main id="content" role="main" class="grid12">
                                                                        <?php else: ?>
                                                                            <!-- var: regular page -->

                                                                            <div id="container" class="edp-fullwidth">
                                                                                <main id="content" role="main"
                                                                                    class="grid12">
                                                                                <?php endif; ?>
                                                                                <!-- file end: header.php -->