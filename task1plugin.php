<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI:  https://example.com/
 * Description: A boilerplate WordPress plugin that enqueues scripts and styles.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com/
 * License:     GPL2
 * Text Domain: my-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enqueue plugin styles and scripts.
 */
function my_plugin_enqueue_assets() {
    // Define paths
    $plugin_url = plugin_dir_url( __FILE__ );

    // Enqueue CSS
    wp_enqueue_style(
        'my-plugin-styles',
        $plugin_url . 'assets/css/my-plugin-styles.css',
        array(), // Dependencies
        '1.0.0', // Version
        'all'    // Media
    );

    // Enqueue JS
    wp_enqueue_script(
        'my-plugin-scripts',
        $plugin_url . 'assets/js/my-plugin-scripts.js',
        array( 'jquery' ), // Dependencies
        '1.0.0', // Version
        true     // Load in footer
    );

    // Optional: Pass data from PHP to JS
    wp_localize_script( 'my-plugin-scripts', 'myPluginData', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'site_name' => get_bloginfo( 'name' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_assets' );

/**
 * Enqueue admin-specific scripts and styles (optional).
 */
function my_plugin_enqueue_admin_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style(
        'my-plugin-admin-styles',
        $plugin_url . 'assets/css/my-plugin-admin.css',
        array(),
        '1.0.0',
        'all'
    );

    wp_enqueue_script(
        'my-plugin-admin-scripts',
        $plugin_url . 'assets/js/my-plugin-admin.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'my_plugin_enqueue_admin_assets' );

add_action( 'gform_after_submission', 'send_form_to_webhook', 10, 2 );

function send_form_to_webhook( $entry, $form ) {

    // Convert entry data to an array
    $data = [];

    foreach ( $form['fields'] as $field ) {
        $field_id = $field->id;
        $label = $field->label;
        $value = rgar( $entry, $field_id );

        $data[$label] = $value;
    }

    // Webhook URL (replace with yours)
    $webhook_url = 'https://webhook.site/48db2220-435a-433a-bc19-7dbd9f1cabf2';

    // Send POST request
    wp_remote_post( $webhook_url, [
        'method' => 'POST',
        'body'   => json_encode( $data ),
        'headers' => [
            'Content-Type' => 'application/json'
        ],
    ] );
}
