<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.ccube.ind.in/team/
 * @since      1.0.0
 *
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/includes
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Tool_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

        global $wpdb;

        //Dynamic table generating code for owt_tbl_books...

        if ($wpdb->get_var("SHOW table like '".$this->wp_owt_tbl_books()."'") != $this->wp_owt_tbl_books()) {

            $table_books = "CREATE TABLE `".$this->wp_owt_tbl_books()."` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(150) DEFAULT NULL,
                          `amount` int(11) DEFAULT NULL,
                          `publication` varchar(150) DEFAULT NULL,
                          `description` text DEFAULT NULL,
                          `book_image` varchar(200) DEFAULT NULL,
                          `email` varchar(150) DEFAULT NULL,
                          `shelf_id` int(11) DEFAULT NULL,
                          `status` int(11) NOT NULL DEFAULT 1,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"; //table create query

            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($table_books);
        }

        //Dynamic table generating code for owt_tbl_book_shelf...

        if ($wpdb->get_var("Show table like '".$this->wp_owt_tbl_book_shelf()."'") != $this->wp_owt_tbl_book_shelf()) {
        
            $table_shelf = "CREATE TABLE `".$this->wp_owt_tbl_book_shelf()."` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `shelf_name` varchar(150) NOT NULL,
                          `capacity` int(11) NOT NULL,
                          `shelf_location` varchar(200) NOT NULL,
                          `status` int(11) NOT NULL DEFAULT 1,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($table_shelf);

            // $insert_query = "INSERT into ".$this->wp_owt_tbl_book_shelf()." (shelf_name, capacity, shelf_location, status) VALUES 
            //     ('Self4', 230, 'left corner', 1), 
            //     ('Self5', 250, 'right corner', 1), 
            //     ('Self6', 270, 'center corner', 1)";

            // $wpdb->query($insert_query);
        }       

        //Create page on Plugin activation

        $get_data = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * from".$wpdb->prefix."posts WHERE post_name = %s", "book_tool"
            )
        );

        if (!empty($get_data)) {
            echo  "already we have data with this post name ";
        }else{
            $post_arr_data = array(
                "post_title" => "Book Tool",
                'post_name' => "book_tool",
                'post_status'  => "publish",   
                'post_author'  => 1,   
                'post_content'  => "Simple page content of Book Tool",   
                'post_type'  => "page"  
            );

            wp_insert_post( $post_arr_data, $wp_error );
        }

	}

    public function wp_owt_tbl_books(){

       global  $wpdb;  
       return $wpdb->prefix . "owt_tbl_books"; //this function return wordpress prefix
    }

    public function wp_owt_tbl_book_shelf(){

       global  $wpdb;  
       return $wpdb->prefix . "owt_tbl_book_shelf"; //this function return wordpress prefix
    }

}





