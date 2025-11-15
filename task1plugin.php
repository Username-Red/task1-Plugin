<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI:  https://example.com/
 * Description: A WordPress plugin that enqueues scripts/styles and sends Gravity Forms submissions to a webhook.
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
 * =========================
 * ENQUEUE FRONTEND ASSETS
 * =========================
 */
function my_plugin_enqueue_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // CSS
    wp_enqueue_style(
        'my-plugin-styles',
        $plugin_url . 'assets/css/my-plugin-styles.css',
        array(),
        '1.0.0',
        'all'
    );

    // JS
    wp_enqueue_script(
        'my-plugin-scripts',
        $plugin_url . 'assets/js/my-plugin-scripts.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );

    // Pass PHP data to JS
    wp_localize_script( 'my-plugin-scripts', 'myPluginData', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'site_name' => get_bloginfo( 'name' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_assets' );

/**
 * =========================
 * ENQUEUE ADMIN ASSETS
 * =========================
 */
function my_plugin_enqueue_admin_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // Admin CSS
    wp_enqueue_style(
        'my-plugin-admin-styles',
        $plugin_url . 'assets/css/my-plugin-admin.css',
        array(),
        '1.0.0',
        'all'
    );

    // Admin JS
    wp_enqueue_script(
        'my-plugin-admin-scripts',
        $plugin_url . 'assets/js/my-plugin-admin.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'my_plugin_enqueue_admin_assets' );

/**
 * =========================
 * GRAVITY FORMS AFTER SUBMISSION WEBHOOK
 * =========================
 */
if ( class_exists( 'GFAPI' ) ) {
    add_action( 'gform_after_submission', 'my_plugin_send_form_to_webhook', 10, 2 );
}

function my_plugin_send_form_to_webhook( $entry, $form ) {

    // Convert entry data to array
    $data = [];
    foreach ( $form['fields'] as $field ) {
        $field_id = $field->id;
        $label = !empty($field->label) ? $field->label : 'Field ' . $field_id;
        $value = rgar( $entry, $field_id );
        $data[$label] = $value;
    }

    // Webhook URL - replace with your URL
    $webhook_url = 'https://webhook.site/YOUR-UNIQUE-URL';

    // Send POST request
    $response = wp_remote_post( $webhook_url, [
        'method'  => 'POST',
        'body'    => json_encode( $data ),
        'headers' => ['Content-Type' => 'application/json'],
        'timeout' => 10
    ]);

    // Debug log success or failure
    if ( is_wp_error( $response ) ) {
        error_log( 'Webhook failed: ' . $response->get_error_message() );
    } else {
        error_log( 'Webhook sent successfully.' );
    }
}
