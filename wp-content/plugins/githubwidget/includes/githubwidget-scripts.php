<?php
// Add Scripts
function ghw_add_scripts()
{
    // Add Main CSS
    wp_enqueue_style('ghw-main-style', plugins_url() . '/githubwidget/css/style.css');
    // Add Main JS
    wp_enqueue_script('ghw-main-script', plugins_url() . '/githubwidget/js/main.js');

    // Add Google Script
    wp_register_script('google', 'https://apis.google.com/js/platform.js');
    wp_enqueue_script('google');
}

// Hook
add_action('wp_enqueue_scripts', 'ghw_add_scripts');
