<?php
/**
 * Plugin Name: Salah Recorder
 * Description: A plugin to record daily Salah prayers.
 * Version: 0.1
 * Author: Zaheer Akram
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue scripts and styles
function sr_enqueue_scripts() {
    wp_enqueue_style('salah-recorder-css', plugins_url('/assets/css/salah-recorder.css', __FILE__));
    wp_enqueue_script('salah-recorder-js', plugins_url('/assets/js/salah-recorder.js', __FILE__), array('jquery'), false, true);
    // Localize script to pass AJAX URL to JavaScript.
    wp_localize_script('salah-recorder-js', 'salahRecorderAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'sr_enqueue_scripts');

require_once plugin_dir_path( __FILE__ ) . '/includes/sr-cpt.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/sr-shortcode-display.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/sr-ajax-update-data.php';