<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://arsenaltech.com/
 * @since             1.0.0
 * @package           Add_dashboard_widget
 *
 * @wordpress-plugin
 * Plugin Name:       Add Admin Dashboard Widget
 * Plugin URI:        https://arsenaltech.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rakesh
 * Author URI:        https://arsenaltech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       add_dashboard_widget
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
define( 'ADD_DASHBOARD_WIDGET_VERSION', '1.0.0' );
define( 'ADD_DASHBOARD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADD_DASHBOARD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-add_dashboard_widget-activator.php
 */
function activate_add_dashboard_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add_dashboard_widget-activator.php';
	$activator = new Add_dashboard_widget_Activator();
    $activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-add_dashboard_widget-deactivator.php
 */
function deactivate_add_dashboard_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-add_dashboard_widget-deactivator.php';
	Add_dashboard_widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_add_dashboard_widget' );
register_deactivation_hook( __FILE__, 'deactivate_add_dashboard_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-add_dashboard_widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_add_dashboard_widget() {

	$plugin = new Add_dashboard_widget();
	$plugin->run();

}
run_add_dashboard_widget();
