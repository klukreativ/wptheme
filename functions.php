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
