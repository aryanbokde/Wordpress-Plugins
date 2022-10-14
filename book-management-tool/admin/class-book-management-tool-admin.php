<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.ccube.ind.in/team/
 * @since      1.0.0
 *
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/admin
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Tool_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name 	The ID of this plugin.
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

		require_once BOOK_MANAGEMENT_TOOL_PLUGIN_PATH . 'includes/class-book-management-tool-activator.php';
		$activator = new Book_Management_Tool_Activator();
		$this->table_activator = $activator;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$valid_pages = array('book-management-tool', 'book-management-create-book-shelf', 'book-management-list-book-shelf', 'book-management-create-book', 'book-management-list-book'); 

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if (in_array($page, $valid_pages)) {

			// adding css files in valid pages
			wp_enqueue_style( "owt-bootstrap", BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all' );

			wp_enqueue_style( "owt-datatable", BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css', array(), $this->version, 'all' );

			wp_enqueue_style( "owt-sweetalert", BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/sweetalert.min.css', array(), $this->version, 'all' );

			// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/book-management-tool-admin.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$valid_pages = array('book-management-tool', 'book-management-create-book-shelf', 'book-management-list-book-shelf', 'book-management-create-book', 'book-management-list-book');

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if (in_array($page, $valid_pages)) {

			wp_enqueue_script("jquery");

			wp_enqueue_script( 'owt-bootstrap', BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( 'owt-datatable', BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( 'owt-validate', BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( 'owt-sweetalert', BOOK_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/sweetalert.min.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-management-tool-admin.js', array( 'jquery' ), $this->version, true );

			wp_localize_script($this->plugin_name, "owt_book", array(
				'name' => 'ArsenalTech Private Limited',
				'author' => 'Rakesh Bokde',
				'ajaxurl' => admin_url('admin-ajax.php')
			));

		}

	}

	//Create Menu Method
	public function book_management_menu(){

		add_menu_page( 'Book Management Tool', 'Book Management Tool', 'manage_options', 'book-management-tool', array($this, "book_management_plugin"), "dashicons-admin-site-alt3", 26);
		
		add_submenu_page( "book-management-tool", "Dashboard", "Dashboard", "manage_options", "book-management-tool", array($this, "book_management_plugin"));

		add_submenu_page( "book-management-tool", "Create Book Shelf", "Create Book Shelf", "manage_options", "book-management-create-book-shelf", array($this, "book_management_create_book_shelf"));

		add_submenu_page( "book-management-tool", "List Book Shelf", "List Book Shelf", "manage_options", "book-management-list-book-shelf", array($this, "book_management_list_book_shelf"));

		add_submenu_page( "book-management-tool", "Create Book", "Create Book", "manage_options", "book-management-create-book", array($this, "book_management_create_book"));

		add_submenu_page( "book-management-tool", "List Book", "List Book", "manage_options", "book-management-list-book", array($this, "book_management_list_book")); 
	}

	//menu callback function
	public function book_management_plugin(){

		global $wpdb;
		echo "<h3>This Is Dashboard</h3>";
	}

	//Create Book Shelf Layout
	public function book_management_create_book_shelf(){

		ob_start(); //Start buffer

		include_once(BOOK_MANAGEMENT_TOOL_PLUGIN_PATH.'admin/partials/tmpl-create-book-shelf.php');

		$template = ob_get_contents(); //Reading content

		ob_clean(); //Closing and cleaning buffer

		echo $template;
	}

	//Create List Book Shelf Layout
	public function book_management_list_book_shelf(){

		global $wpdb;

		$book_shelf = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM ".$this->table_activator->wp_owt_tbl_book_shelf(), ""
			)
		);


		ob_start(); //Start buffer

		include_once(BOOK_MANAGEMENT_TOOL_PLUGIN_PATH.'admin/partials/tmpl-list-books-shelf.php');

		$template = ob_get_contents(); //Reading content

		ob_clean(); //Closing and cleaning buffer

		echo $template;

	}

	//Create Book Layout
	public function book_management_create_book(){

		global $wpdb;

		$book_shelf = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id, shelf_name FROM ".$this->table_activator->wp_owt_tbl_book_shelf(), ""
			)
		);

		ob_start(); //Start buffer

		include_once(BOOK_MANAGEMENT_TOOL_PLUGIN_PATH.'admin/partials/tmpl-create-book.php');

		$template = ob_get_contents(); //Reading content

		ob_clean(); //Closing and cleaning buffer

		echo $template;

	}

	//Create List Book Layout
	public function book_management_list_book(){

		global $wpdb;

		$book_list = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT book.*, book_shelf.shelf_name FROM " . $this->table_activator->wp_owt_tbl_books(). " as book LEFT JOIN " . $this->table_activator->wp_owt_tbl_book_shelf()." as book_shelf ON book.shelf_id = book_shelf.id ORDER BY id DESC ", ""
			)
		);
		ob_start(); //Start buffer

		include_once(BOOK_MANAGEMENT_TOOL_PLUGIN_PATH.'admin/partials/tmpl-list-books.php');

		$template = ob_get_contents(); //Reading content

		ob_clean(); //Closing and cleaning buffer

		echo $template;

	}

	public function handle_ajax_requests_admin(){

		global $wpdb;
		//handle all ajax request of admin
		$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : "";

		if (!empty($param)) {
			
			if ($param == "first_simple_ajax") {
				echo json_encode(array(
					"status" => 1,
					"message" => "First Ajax Request",
					"data" => array(
						"name" => "Bpointer Technologies Pune",
						"author" => "Rakesh Bokde"

					)
				));
			}elseif ($param == "create_book_shelf") {

				//get all data from form
				$name = isset($_REQUEST['txt_name']) ? $_REQUEST['txt_name'] : ""; 
				$capacity = isset($_REQUEST['txt_capacity']) ? $_REQUEST['txt_capacity'] : "";
				$location = isset($_REQUEST['txt_location']) ? $_REQUEST['txt_location'] : "";
				$status = isset($_REQUEST['dd_status']) ? $_REQUEST['dd_status'] : "";

				$wpdb->insert($this->table_activator->wp_owt_tbl_book_shelf(), array(
					"shelf_name" => $name,
					"capacity" => $capacity,
					"shelf_location" => $location,
					"status" => $status
				));

				if ($wpdb->insert_id > 0) {
					
					echo json_encode(array(
						"status" => 1,
						"message" => "Book Shelf Created Successfully"
					));
				}else{

					echo json_encode(array(
						"status" => 0,
						"message" => "Failed to Create Book Shelf"
					));
				}					
			}elseif($param == "delete_book_shelf"){

				$shelf_id = isset($_REQUEST['shelf_id']) ? intval($_REQUEST['shelf_id']) : 0;

				if ($shelf_id > 0) {
					
					$wpdb->delete($this->table_activator->wp_owt_tbl_book_shelf(), array(
						"id" => $shelf_id
					));

					echo json_encode(array(
						"status" => 1,
						"message" => "Book shelf deleted successfully"
					));

				}else{

					echo json_encode(array(
						"status" => 0,
						"message" => "Book shelf is not valid"
					));
				}
			}elseif($param == "create_book") {
				
				$shelf_id = isset($_REQUEST['dd_book_shelf']) ? intval($_REQUEST['dd_book_shelf']) : 0;
				$txt_name = isset($_REQUEST['txt_name']) ? $_REQUEST['txt_name'] : "";
				$txt_email = isset($_REQUEST['txt_email']) ? $_REQUEST['txt_email'] : "";
				$txt_publication = isset($_REQUEST['txt_publication']) ? $_REQUEST['txt_publication'] : "";
				$txt_description = isset($_REQUEST['txt_description']) ? $_REQUEST['txt_description'] : "";
				$book_image = isset($_REQUEST['book_cover_image']) ? $_REQUEST['book_cover_image'] : "";
				$txt_cost = isset($_REQUEST['txt_cost']) ? intval($_REQUEST['txt_cost']) : 0;
				$dd_status = isset($_REQUEST['dd_status']) ? intval($_REQUEST['dd_status']) : 0;

				$wpdb->insert($this->table_activator->wp_owt_tbl_books(), array(
					"name" => strtoupper($txt_name),
					"amount" => $txt_cost,
					"publication" => $txt_publication,
					"description" => $txt_description,
					"book_image" => $book_image,
					"email" => $txt_email,
					"shelf_id" => $shelf_id,
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

			}elseif($param == "delete_book_list"){

				$book_id = isset($_REQUEST['book_list']) ? intval($_REQUEST['book_list']) : 0;

				if ($book_id > 0) {
					
					$wpdb->delete($this->table_activator->wp_owt_tbl_books(), array(
						"id" => $book_id
					));

					echo json_encode(array(
						"status" => 1,
						"message" => "Book list deleted successfully"
					));

				}else{

					echo json_encode(array(
						"status" => 0,
						"message" => "Book list is not valid"
					));
				}
			}


		}

		wp_die();
	}

}

