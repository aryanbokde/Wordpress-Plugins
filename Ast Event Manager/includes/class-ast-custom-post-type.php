<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ast_Custom_Post_Type_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AST_CUSTOM_POST_TYPE_VERSION' ) ) {
			$this->version = AST_CUSTOM_POST_TYPE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ast-custom-post-type';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_event_hooks();
		$this->define_location_hooks();
		$this->define_country_hooks();
		$this->define_common_hooks();
		$this->define_woocommerce_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ast_Custom_Post_Type_Loader. Orchestrates the hooks of the plugin.
	 * - Ast_Custom_Post_Type_i18n. Defines internationalization functionality.
	 * - Ast_Custom_Post_Type_Admin. Defines all hooks for the admin area.
	 * - Ast_Custom_Post_Type_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ast-custom-post-type-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ast-custom-post-type-public.php';

		/**
		 * The class responsible for defining all Event custom post type that occur in the includes area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-event.php';

		/**
		 * The class responsible for defining all Location custom post type that occur in the includes area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-location.php';

		//The class responsible for defining all Coutry, State, City custom post type that occur in the includes area.		 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-country.php';

		//The class responsible for defining all common function and shortcode related to plugin.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-shortcode-and-common.php';


		//The class responsible for Woocommerce payment system and orders.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ast-custom-post-type-woocommerce.php';

		$this->loader = new Ast_Custom_Post_Type_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ast_Custom_Post_Type_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ast_Custom_Post_Type_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ast_Custom_Post_Type_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'events_register_ref_page' );
		$this->loader->add_action( 'wp_ajax_get_country_state_id', $plugin_admin, 'ast_get_state_custom_field' );
		$this->loader->add_action( 'wp_ajax_get_country_city_id', $plugin_admin, 'ast_get_city_custom_field' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_my_event_management_custom_options_settings' );
		$this->loader->add_action( 'wp_ajax_get-ast-country-id', $plugin_admin, 'ast_get_country_id_onchange' );
		$this->loader->add_action( 'wp_ajax_get-ast-state-id', $plugin_admin, 'ast_get_state_id_onchange' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ast_Custom_Post_Type_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the Event Post Type functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_event_hooks() {

		$plugin_event = new Ast_Custom_Post_Type_Event( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_event, 'ast_custom_post_event_init' );
		$this->loader->add_action( 'after_switch_theme', $plugin_event, 'ast_custom_post_event_init' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_event, 'ast_event_custom_fields' );
		$this->loader->add_action( 'save_post', $plugin_event, 'ast_event_custom_fields_save' );


	}

	/**
	 * Register all of the hooks related to the Location Post Type functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_location_hooks() {

		$plugin_location = new Ast_Custom_Post_Type_Location( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_location, 'ast_custom_post_location_init' );
		$this->loader->add_action( 'after_switch_theme', $plugin_location, 'ast_custom_post_location_init' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_location, 'ast_location_custom_fields' );
		$this->loader->add_action( 'save_post', $plugin_location, 'ast_location_custom_fields_save' );

	}

	/**
	 * Register all of the hooks related to the Country, State, City Post Type functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_country_hooks() {

		$plugin_country = new Ast_Custom_Post_Type_Country( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_country, 'ast_custom_post_country_init' );
		$this->loader->add_action( 'after_switch_theme', $plugin_country, 'ast_custom_post_country_init' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_country, 'ast_state_custom_fields' );
		$this->loader->add_action( 'save_post', $plugin_country, 'ast_state_custom_fields_save' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_country, 'ast_city_custom_fields' );
		$this->loader->add_action( 'save_post', $plugin_country, 'ast_city_custom_fields_save' );

	}


	/**
	 * Register All common function related to shortcode and much more.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_common_hooks() {

		$plugin_common = new Ast_Custom_Shortcode_and_Common( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_common, 'ast_register_shortcodes' );
		$this->loader->add_filter( 'query_vars', $plugin_common, 'e_query');
		$this->loader->add_action( 'wp_ajax_ast-register-event', $plugin_common, 'Ast_Registration_form' );
		$this->loader->add_action( 'wp_ajax_nopriv_ast-register-event', $plugin_common, 'Ast_Registration_form' );
		$this->loader->add_filter( 'manage_posts_columns', $plugin_common, 'AST_columns_head');
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_common, 'AST_columns_content', 10, 2);

	}

	/**
	 * Register All common function related to shortcode and much more.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_woocommerce_hooks() {

		$plugin_woocommerce = new Ast_Custom_Post_Type_Woocommerce( $this->get_plugin_name(), $this->get_version() );

		add_action( 'init', 'register_myclass' );

		$this->loader->add_filter( 'woocommerce_data_stores', $plugin_woocommerce, 'IA_woocommerce_data_stores' , 11, 1 );
		$this->loader->add_filter('woocommerce_product_class', $plugin_woocommerce, 'IA_woo_product_class',25,3 );


		$this->loader->add_filter('woocommerce_get_price', $plugin_woocommerce, 'my_woocommerce_product_get_price',20,2);

		$this->loader->add_filter('woocommerce_product_get_price', $plugin_woocommerce, 'my_woocommerce_product_get_price', 10, 2 );

		$this->loader->add_filter('woocommerce_product_type_query', $plugin_woocommerce, 'IA_woo_product_type', 12,2 );
		$this->loader->add_filter( 'woocommerce_checkout_create_order_line_item_object', $plugin_woocommerce,  'IA_woocommerce_checkout_create_order_line_item_object', 20, 4 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_woocommerce,  'cod_woocommerce_checkout_create_order_line_item', 20, 4 );
		$this->loader->add_filter( 'woocommerce_get_order_item_classname', $plugin_woocommerce,  'IA_woocommerce_get_order_item_classname', 20, 3 );

		$this->loader->add_action( 'loop_start', $plugin_woocommerce, 'ast_add_woocommerce_notice_message' );
		$this->loader->add_filter('the_content', $plugin_woocommerce, 'ast_add_to_cart_button', 20,1);
		

	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ast_Custom_Post_Type_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}





