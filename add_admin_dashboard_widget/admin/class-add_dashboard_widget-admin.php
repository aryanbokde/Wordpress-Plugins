<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Add_dashboard_widget
 * @subpackage Add_dashboard_widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Add_dashboard_widget
 * @subpackage Add_dashboard_widget/admin
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Add_dashboard_widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Add_dashboard_widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Add_dashboard_widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/add_dashboard_widget-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Add_dashboard_widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Add_dashboard_widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/add_dashboard_widget-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function wpdocs_register_my_custom_menu_page() {
		add_menu_page(__( 'Latest Orders', 'textdomain' ), 'Latest Orders', 'manage_options', 'latest-orders.php', array($this, 'display_admin_widget_custom_area'), 'dashicons-star-empty', 6 );
	}


	//Create Admin Dashboard Widget
	public function admin_dashboard_widget_create(){

		/**
		 * Add a widget to the dashboard.
		 *
		 * This function is hooked into the 'wp_dashboard_setup' action below.
		 */		
	    wp_add_dashboard_widget(
	        'wporg_dashboard_widget',                          // Widget slug.
	        esc_html__( 'Latest Orders List', 'wporg' ), // Title.
	         array($this, "display_admin_widget_custom_area")  // Display function.
	    );
	    
	    // Globalize the metaboxes array, this holds all the widgets for wp-admin.
	    global $wp_meta_boxes;
	     
	    // Get the regular dashboard widgets array 
	    // (which already has our new widget but appended at the end).
	    $default_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	     
	    // Backup and delete our new dashboard widget from the end of the array.
	    $example_widget_backup = array( 'wporg_dashboard_widget' => $default_dashboard['wporg_dashboard_widget'] );
	    unset( $default_dashboard['wporg_dashboard_widget'] );
	  
	    // Merge the two arrays together so our widget is at the beginning.
	    $sorted_dashboard = array_merge( $example_widget_backup, $default_dashboard );
	  
	    // Save the sorted array back into the original metaboxes. 
	    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard; 		
	}

	/**
	 * Create the function to output the content of our Dashboard Widget.
	 */
	public function display_admin_widget_custom_area() {

	    ob_start(); //Start buffer

		include_once(ADD_DASHBOARD_PLUGIN_PATH.'admin/partials/tmpl-display-widget-area.php');

		$template = ob_get_contents(); //Reading content

		ob_clean(); //Closing and cleaning buffer

		echo $template;

	}


	

}





