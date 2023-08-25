<?php

function university_files()
{
    // loads script, 3+ arguments are for additional JS dependencies (NULL if none), version number, and T/F for if script should be loaded before end of body
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    // calls a stylesheet on initial load
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_addl_styles', get_theme_file_uri('/build/index.css'));
}

//  adding instructions to wp
add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location'); // registers menu in WP menu page (called name in code, displayed name in UI)
    register_nav_menu('footerLocationOne', 'Footer Menu Location One');
    register_nav_menu('footerLocationTwo', 'Footer Menu Location Two');
    add_theme_support('title-tag');
}
// calls function after setting up theme
add_action('after_setup_theme', 'university_features');

// this function will filter out past events
function university_adjust_queries($query) {
    // is_admin checks to see if you're on the dashboard, this allows us to allow this to run only when viewed by the frontend
    // second argument checks for specific page (event archive)
    // 3rd argument checks to see if it's the default query (vs a custom query which we don't want)
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        // powerful, will affect all queries everywhere on page incl editor
        $query->set('meta_key', 'event_date'); // this selects the parameter we want to work with from the meta queries
        $query->set('orderby', 'meta_value_num'); // orders it by date number
        $query->set('order', 'ASC');
        $query->set('meta_query', [['key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type' => 'numeric']]);
    }

    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'university_adjust_queries'); // calls right before a get post request