<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://shwetadanej.com
 * @since      1.0.0
 *
 * @package    Sd_Rest_Api
 * @subpackage Sd_Rest_Api/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sd_Rest_Api
 * @subpackage Sd_Rest_Api/includes
 * @author     Shweta Danej <shwetadanej@gmail.com>
 */
class Sd_Rest_Api_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sd-rest-api',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
