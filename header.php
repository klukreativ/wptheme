<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- WP will automatically insert the charset used based on the site info -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<!-- will assign classes to body dynamically depending on what page it's being displayed-->

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url(); ?>"><strong>Fictional</strong> University</a>
            </h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <!-- 
                    // dynamically displays menu based off of the the menu created in dashboard
                    wp_nav_menu(array( // takes ass arr
                        'theme_location' => 'headerMenuLocation',
                    ))
                    -->

                    <ul>
                        <!-- by using php & site_url we are setting the root -->
                        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"' ?> ><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                        <li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"'?>>><a href="<?php echo get_post_type_archive_link('program'); ?>">Programs</a></li>
                        <!-- adds class to highlight navbar link when on active page by checking URL -->
                        <li <?php if (get_post_type() == 'event' || is_page('past-events')) echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
                        <li><a href="#">Campuses</a></li>
                        <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"'; ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
                    </ul>
                </nav>
                <div class="site-header__util">
                    <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </header>