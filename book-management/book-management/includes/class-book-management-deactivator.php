<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Book_Management
 * @subpackage Book_Management/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Book_Management
 * @subpackage Book_Management/includes
 * @author     Rakesh <aryanbokde@gmail.com>
 */
class Book_Management_Deactivator {

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
        $wpdb->query("DROP TABLE IF EXISTS ".$this->table_activator->wp_create_tbl_books() );
        
    }

}