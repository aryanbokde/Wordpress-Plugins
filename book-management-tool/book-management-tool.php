<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ccube.ind.in/team/
 * @since             1.0.0
 * @package           Book_Management_Tool
 *
 * @wordpress-plugin
 * Plugin Name:       Books Management Tool
 * Plugin URI:        https://www.ccube.ind.in/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rakesh
 * Author URI:        https://www.ccube.ind.in/team/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       book-management-tool
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
define( 'BOOK_MANAGEMENT_TOOL_VERSION', '1.0.0' );
define( 'BOOK_MANAGEMENT_TOOL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOK_MANAGEMENT_TOOL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-book-management-tool-activator.php
 */
function activate_book_management_tool() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-book-management-tool-activator.php';
	$activator = new Book_Management_Tool_Activator();
    $activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-book-management-tool-deactivator.php
 */
function deactivate_book_management_tool() {

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-book-management-tool-activator.php';
    $activator = new Book_Management_Tool_Activator();

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-book-management-tool-deactivator.php';
	$deactivator = new Book_Management_Tool_Deactivator($activator);
    $deactivator->deactivate();
    
}

register_activation_hook( __FILE__, 'activate_book_management_tool' );
register_deactivation_hook( __FILE__, 'deactivate_book_management_tool' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-book-management-tool.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_book_management_tool() {

	$plugin = new Book_Management_Tool();
	$plugin->run();

}
run_book_management_tool();












