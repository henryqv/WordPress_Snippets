<?php

/**
 * Plugin Name: Custom WP Top/Admin Bar Dropdown
 * Plugin URI: https://codewp.ai
 * Description: This plugin adds a custom dropdown with links for clients in the WordPress top/admin bar.
 * Version: 1.0
 * Author: CodeWP Assistant
 * Author URI: https://codewp.ai
 * Text Domain: codewp
 */

add_action('admin_bar_menu', 'add_links_to_admin_bar', 100);

function add_links_to_admin_bar($admin_bar){
    $admin_bar->add_menu(array(
        'id'    => 'client-links',
        'title' => 'Client Links',
        'href'  => '#',
        'meta'  => array(
            'title' => __('Client Links', 'codewp'),
        ),
    ));

    $admin_bar->add_menu(array(
        'id'    => 'client-link-1',
        'parent' => 'client-links',
        'title' => 'Client Dashboard',
        'href'  => 'https://clientwebsite.com/dashboard',
        'meta'  => array(
            'title' => __('Client Dashboard', 'codewp'),
        ),
    ));

    $admin_bar->add_menu(array(
        'id'    => 'client-link-2',
        'parent' => 'client-links',
        'title' => 'Account Settings',
        'href'  => 'https://clientwebsite.com/account-settings',
        'meta'  => array(
            'title' => __('Account Settings', 'codewp'),
        ),
    ));
}