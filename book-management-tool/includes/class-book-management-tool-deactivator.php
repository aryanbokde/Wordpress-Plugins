<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.ccube.ind.in/team/
 * @since      1.0.0
 *
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Book_Management_Tool
 * @subpackage Book_Management_Tool/includes
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Tool_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

    private $table_activator;

    public function __construct($activator){

        $this->table_activator = $activator;

    }

	public function deactivate() {

        global $wpdb;

        //Dropping table on plugin deactivation...

        $wpdb->query("DROP TABLE IF EXISTS ".$this->table_activator->wp_owt_tbl_books());
        $wpdb->query("DROP TABLE IF EXISTS ".$this->table_activator->wp_owt_tbl_book_shelf());

        //delete pages when plugin deactivate 

        $get_data = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT ID from ".$wpdb->prefix."posts WHERE post_name = %s", "book_tool"
            )
        );
        
        $page_id = $get_data->ID;

        if ($page_id > 0) {
            wp_delete_post( $page_id, true );
        }
        
	}

}
