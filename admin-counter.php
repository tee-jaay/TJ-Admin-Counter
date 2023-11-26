<?php
/**
 * Plugin Name: Tj Admin Counter
 * Description: Shows the current number of admins counter in the top bar.
 * Version: 0.0.2
 * Author: Tamjid
 * Author URI: https://teejaay.me
 * License: MIT License
 * License URI: https://teejaay.me/wp-content/plugins/tj-admin-counter/license.txt
 * Requires at least: 5.0
 * Tested up to: 6.4.1
 * Requires PHP: 7.4.33
 * @package Tj_Admin_Counter
 */

// Include the email functions file
require_once(plugin_dir_path(__FILE__) . 'functions/email_notify.php');

// Enqueue the external stylesheet
function tj_admin_counter_enqueue_styles() {
    wp_enqueue_style('admin-counter-styles', plugin_dir_url(__FILE__) . 'styles/main.css');
}
// Main function
function tj_admin_counter_count_admins_in_admin_bar() {
    global $wp_admin_bar;
    $admins_count = count(get_users(array('role' => 'administrator')));

    // Define a CSS class based on the number of admins
    $css_class = ($admins_count === 1) ? 'admin-counter-green' : 'admin-counter-red';
    
    // Enqueue styles
    tj_admin_counter_enqueue_styles();

    // Construct the link to the Users page with the Administrator role filter
    $users_page_url = admin_url('users.php') . '?role=administrator';

    $title = sprintf('<a href="%s" class="%s">', esc_url($users_page_url), $css_class) . __('Admins: ', 'tj-admin-counter') . $admins_count . '</a>';

    $wp_admin_bar->add_node(
        array(
            'id'    => 'admin-count',
            'title' => $title,
            'parent' => 'top-secondary',
        )
    );

    // Send email if conditions are met
    tj_admin_counter_send_email();
}

add_action('admin_bar_menu', 'tj_admin_counter_count_admins_in_admin_bar', 999);
