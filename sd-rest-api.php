<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://shwetadanej.com
 * @since             1.0.0
 * @package           Sd_Rest_Api
 *
 * @wordpress-plugin
 * Plugin Name:       SD-REST-APIs
 * Plugin URI:        https://shwetadanej.com
 * Description:       This plugin is created for the demo purpose to showcase the REST API usage.
 * Version:           1.0.0
 * Author:            Shweta Danej
 * Author URI:        https://shwetadanej.com/
 * Text Domain:       sd-rest-api
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SD_REST_API_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sd-rest-api-activator.php
 */
function activate_sd_rest_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sd-rest-api-activator.php';
	Sd_Rest_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sd-rest-api-deactivator.php
 */
function deactivate_sd_rest_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sd-rest-api-deactivator.php';
	Sd_Rest_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sd_rest_api' );
register_deactivation_hook( __FILE__, 'deactivate_sd_rest_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sd-rest-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sd_rest_api() {

	$plugin = new Sd_Rest_Api();
	$plugin->run();
}
run_sd_rest_api();
