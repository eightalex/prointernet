<?php
/*
 * Plugin Name: WP FAQ Schema Markup for SEO
 * Description: Get FAQ Structured Data in Google SERP
 * Version: 1.6
 * Author: Team HobCore
 * Author URI: https://hobcore.com
 * Text Domain: hobcore_wp_faq_schema
 */

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

if (!function_exists('add_action')) {
    echo "Hi there! I'm just a plugin, not much I can do when called directly.";
    exit;
}

// Setup
define('HOBCORE_WP_FAQ_SCHEMA_PLUGIN_URL', __FILE__);

// Includes
include('includes/activate.php');
include('includes/init.php');
include('includes/admin/init.php');


// Hooks
register_activation_hook(__FILE__, 'hobcore_wp_faq_schema_activate_plugin');
register_deactivation_hook(__FILE__, 'hobcore_wp_faq_schema_deactivate_plugin');

add_action('init', 'hobcore_wp_faq_schema_init');
add_action('admin_init', 'hobcore_wp_faq_schema_admin_init');
add_action('admin_enqueue_scripts', 'hobcore_wp_faq_schema_enqueue_admin_scripts');

// Shortcodes
