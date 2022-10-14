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
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ast-custom-post-type',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
