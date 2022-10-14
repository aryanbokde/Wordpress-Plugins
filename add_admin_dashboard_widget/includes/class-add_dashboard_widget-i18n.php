<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Add_dashboard_widget
 * @subpackage Add_dashboard_widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Add_dashboard_widget
 * @subpackage Add_dashboard_widget/includes
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Add_dashboard_widget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'add_dashboard_widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
