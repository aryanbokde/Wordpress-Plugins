<?php

/**
 * Fired during plugin activation
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Book_Management
 * @subpackage Book_Management/includes
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Activator {

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

        if ($wpdb->get_var("SHOW table like '".$this->wp_create_tbl_books()."'") != $this->wp_create_tbl_books()) {

            $table_books = "CREATE TABLE `".$this->wp_create_tbl_books()."` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(150) DEFAULT NULL,
                          `amount` int(11) DEFAULT NULL,
                          `publication` varchar(150) DEFAULT NULL,
                          `description` text DEFAULT NULL,
                          `book_image` varchar(200) DEFAULT NULL,
                          `email` varchar(150) DEFAULT NULL,
                          `status` int(11) NOT NULL DEFAULT 1,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"; //table create query
            
            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($table_books);
        }

    }

    public function wp_create_tbl_books(){

       global  $wpdb;  
       return $wpdb->prefix . "books"; //this function return wordpress prefix
    }

}

