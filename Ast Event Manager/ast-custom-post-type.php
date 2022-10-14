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
 * @package           Ast_Custom_Post_Type
 *
 * @wordpress-plugin
 * Plugin Name:       Ast Event Manager
 * Plugin URI:        https://arsenaltech.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rakesh
 * Author URI:        https://arsenaltech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ast-event-manager
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
define( 'AST_CUSTOM_POST_TYPE_VERSION', '1.0.0' );
define( 'AST_CUSTOM_POST_TYPE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AST_CUSTOM_POST_TYPE_DIR_PATH', plugin_dir_path( __FILE__ ) );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ast-custom-post-type-activator.php
 */
function activate_ast_custom_post_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ast-custom-post-type-activator.php';
	$activator = new Ast_Custom_Post_Type_Activator();
    $activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ast-custom-post-type-deactivator.php
 */
function deactivate_ast_custom_post_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ast-custom-post-type-deactivator.php';
	$deactivator = new Ast_Custom_Post_Type_Deactivator();
    $deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_ast_custom_post_type' );
register_deactivation_hook( __FILE__, 'deactivate_ast_custom_post_type' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ast-custom-post-type.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ast_custom_post_type() {

	$plugin = new Ast_Custom_Post_Type();
	$plugin->run();

}
run_ast_custom_post_type();
