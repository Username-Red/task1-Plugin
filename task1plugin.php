<?php
/**
 * Plugin Name: My Custom Boilerplate Plugin
 * Plugin URI:  https://example.com/
 * Description: A custom plugin boilerplate for adding scripts, styles, and future functionality.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com/
 * License:     GPL2
 * Text Domain: my-custom-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * =========================
 * ENQUEUE FRONTEND SCRIPTS & STYLES
 * =========================
 */
function my_custom_plugin_enqueue_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // Enqueue CSS
    wp_enqueue_style(
        'my-custom-plugin-styles',
        $plugin_url . 'assets/css/my-custom-plugin-styles.css',
        array(),
        '1.0.0',
        'all'
    );

    // Enqueue JavaScript
    wp_enqueue_script(
        'my-custom-plugin-scripts',
        $plugin_url . 'assets/js/my-custom-plugin-scripts.js',
        array( 'jquery' ), // dependencies
        '1.0.0',
        true // load in footer
    );
}
add_action( 'wp_enqueue_scripts', 'my_custom_plugin_enqueue_assets' );

/**
 * =========================
 * ENQUEUE ADMIN SCRIPTS & STYLES
 * =========================
 */
function my_custom_plugin_enqueue_admin_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // Admin CSS
    wp_enqueue_style(
        'my-custom-plugin-admin-styles',
        $plugin_url . 'assets/css/my-custom-plugin-admin.css',
        array(),
        '1.0.0',
        'all'
    );

    // Admin JS
    wp_enqueue_script(
        'my-custom-plugin-admin-scripts',
        $plugin_url . 'assets/js/my-custom-plugin-admin.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'my_custom_plugin_enqueue_admin_assets' );

/**
 * =========================
 * PLACEHOLDER FOR FUTURE FUNCTIONALITY
 * =========================
 */
function my_custom_plugin_custom_function() {
    // This is where you will add custom PHP functionality in the future.
    // For now, let's just log a test message
    error_log( 'My Custom Boilerplate Plugin is active!' );
}
add_action( 'init', 'my_custom_plugin_custom_function' );
