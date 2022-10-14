<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/public
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ast_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ast_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$endpoint = is_wc_endpoint_url('order-pay', 'order-received', 'view-order', 'edit-account', 'edit-address', 'lost-password', 'customer-logout', 'add-payment-method' );
		// is_wc_endpoint_url($endpoint);
		if (!is_woocommerce() && !is_account_page() && !is_checkout() && !is_cart() && !is_product() )  {
			wp_enqueue_style( 'ast-bootstrap.min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ast-custom-post-type-public.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'ast-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', array(), $this->version, 'all' );
		}		
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ast_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ast_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (!is_woocommerce() && !is_account_page() && !is_checkout() && !is_cart() && !is_product() )  {
			wp_enqueue_script( 'ast-jquery-3.2.1.min', 'https://code.jquery.com/jquery-3.3.1.min.js', array( 'jquery' ), $this->version, true ); 
			wp_enqueue_script( 'ast-popper.min', plugin_dir_url( __FILE__ ) . 'js/popper.min.js', array( 'jquery' ), $this->version, true ); 
			wp_enqueue_script( 'ast-bootstrap.min', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true ); 
		}
		

		wp_enqueue_script('ast-front-ajax-js', plugin_dir_url(__FILE__) . 'js/ast-custom-post-type-public.js', array('jquery'), $this->version, true);
        wp_localize_script('ast-front-ajax-js', 'my_ajax_front', array('ajax_url' => admin_url('admin-ajax.php')));

	}






}






