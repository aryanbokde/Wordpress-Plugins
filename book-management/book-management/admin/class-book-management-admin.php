<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Book_Management
 * @subpackage Book_Management/admin
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Admin {

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
	private $table_activator;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		require_once BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'includes/class-book-management-activator.php';
		$activator = new Book_Management_Activator();
		$this->table_activator = $activator;

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
		 * defined in Book_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$valid_pages = array('book_dashboard', 'add_new');

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if (in_array($page, $valid_pages)) {

			wp_enqueue_style("book-boostrap", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all' );

			wp_enqueue_style("book-datatable", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/css/jquery.dataTables.min.css', array(), $this->version, 'all' );

			wp_enqueue_style("book-sweetalert", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/css/sweetalert.min.css', array(), $this->version, 'all' );
		}
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
		 * defined in Book_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$valid_pages = array('book_dashboard', 'add_new');

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if (in_array($page, $valid_pages)) {

			wp_enqueue_script('jquery');

			wp_enqueue_script( "book-boostrap-js", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/js/bootstrap.min.js', array('jquery'), $this->version, true);

			wp_enqueue_script("book-table-js", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/js/jquery.dataTables.min.js', array('jquery'), $this->version, true);

			wp_enqueue_script("book-validate", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/js/jquery.validate.min.js', array('jquery'), $this->version, true);

			wp_enqueue_script("book-sweetalert-js", BOOK_MANAGEMENT_PLUGIN_DIR_URL . 'assets/js/sweetalert.min.js', array('jquery'), $this->version, true);

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-management-admin.js', array( 'jquery' ), $this->version, true );

			wp_localize_script($this->plugin_name, "ast_book", array(
				'name' => 'ArsenalTech Private Limited',
				'author' => 'Rakesh Bokde',
				'ajaxurl' => admin_url('admin-ajax.php')
			));
		}
	}

	public function book_management_admin_menu(){

	    add_menu_page( "Manage Books", "Manage Books", "manage_options", "book_dashboard", array($this, "book_management_dashboard"), "dashicons-admin-site-alt3", 24 );

	   	add_submenu_page('book_dashboard', 'View All', 'View All', 'manage_options', 'book_dashboard', array($this, "book_management_dashboard"));

	   	add_submenu_page( "book_dashboard", "Add New", "Add New", "manage_options", "add_new", array($this, "book_management_add"));
	}

	 public function handle_admin_ajax_request(){
	 	

	 	global $wpdb;
		//handle all ajax request of admin
		$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : "";

		if (!empty($param)) {
			
			if ($param == "create_book") {
				
				$txt_name = isset($_REQUEST['txt_name']) ? $_REQUEST['txt_name'] : "";
				$txt_amt = isset($_REQUEST['txt_amt']) ? intval($_REQUEST['txt_amt']) : 0;
				$txt_publication = isset($_REQUEST['txt_publication']) ? $_REQUEST['txt_publication'] : "";
				$txt_description = isset($_REQUEST['txt_description']) ? $_REQUEST['txt_description'] : "";
				//$image = isset($_REQUEST['image']) ? intval($_REQUEST['image']) : 0;
				$txt_email = isset($_REQUEST['txt_email']) ? $_REQUEST['txt_email'] : "";
				$dd_status = isset($_REQUEST['dd_status']) ? intval($_REQUEST['dd_status']) : 0;

				$wpdb->insert($this->table_activator->wp_create_tbl_books(), array(
					"name" => $txt_name,
					"amount" => $txt_amt,
					"publication" => $txt_publication,
					"description" => $txt_description,
					"book_image"	=> "demo",
					"email" => $txt_email,
					"status" => $dd_status
				));

				if ($wpdb->insert_id > 0) {
					
					echo json_encode(array(
						"status" => 1,
						"message" => "Book Created Successfully"
					));
				}else{

					echo json_encode(array(
						"status" => 0,
						"message" => "Failed to Create Book"
					));
				}

			}elseif ($param == "delete_book_list") {

				$book_id = isset($_REQUEST['book_id']) ? intval($_REQUEST['book_id']) : 0;

				if ($book_id > 0) {

					$wpdb->delete($this->table_activator->wp_create_tbl_books(), array(
						"id" => $book_id
					));

					echo json_encode(array(
							"status" => 1,
							"message" => "Book deleted successfully"
						));
				}else{
					echo json_encode(array(
						"status" => 0,
						"message" => "Book is not valid"
					));
				}

			}

		}
		wp_die();

	 }	


	public function book_management_dashboard(){

		$action = isset($_GET['action']) ? trim($_GET['action']) : "";
		//$msg = "";
		if($action == "book-edit"){

			$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : "";
			
			ob_start();

			include_once( BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'admin/partials/tmpl-edit-book.php' );

			$template = ob_get_contents();

			ob_clean();
			
			echo $template;

		}elseif($action == "book-delete"){

			$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : "";
			ob_start();

			include_once( BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'admin/partials/tmpl-delete-book.php' );

			$template = ob_get_contents();

			ob_clean();
			
			echo $template;

		}else{

			ob_start();

			include_once( BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'admin/partials/tmpl-book-list.php' );

			$template = ob_get_contents();

			ob_clean();
			
			echo $template;

		}
		//echo $msg ;

	}

	public function book_management_add(){
		
			ob_start();

			include_once( BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'admin/partials/tmpl-create-book.php' );

			$template = ob_get_contents();

			ob_clean();
			
			echo $template;
			
	}
}
