<?php
/**
 * Plugin Name: Tj Admin Counter
 * Description: Shows the current number of admins counter in the top bar.
 * Version: 0.0.1
 * Author: Tamjid
 * Author URI: https://teejaay.me
 * License: MIT License
 * License URI: https://teejaay.me/wp-content/plugins/tj-admin-counter/license.txt
 * 
 * @package Tj_Admin_Counter
 */

// Enqueue the external stylesheet
function tj_admin_counter_enqueue_styles() {
    wp_enqueue_style('admin-counter-styles', plugin_dir_url(__FILE__) . 'main.css');
}

function tj_admin_counter_count_admins_in_admin_bar() {
    global $wp_admin_bar;
    $admins_count = count(get_users(array('role' => 'administrator')));

    // Define a CSS class based on the number of admins
    $css_class = ($admins_count === 1) ? 'admin-counter-green' : 'admin-counter-red';

    // Enqueue styles
    tj_admin_counter_enqueue_styles();

    $title = sprintf('<span class="%s">', $css_class) . __('Admins: ', 'tj-admin-counter') . $admins_count . '</span>';

    $wp_admin_bar->add_node(
        array(
            'id'    => 'admin-count',
            'title' => $title,
            'parent' => 'top-secondary',
        )
    );
}

add_action('admin_bar_menu', 'tj_admin_counter_count_admins_in_admin_bar', 999);
