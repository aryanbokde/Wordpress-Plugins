<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/includes
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {
        //$this->ast_custom_table_remove();
        $this->ast_deleting_new_page_for_registration();
	}

    // Delete table when deactivate
    public function ast_custom_table_remove() {
        global $wpdb;
        $table_list = get_option("ast_table_name");

        foreach($table_list as $key => $value){

            //echo $key.' : '.$value.'<br>';
            $sql = "DROP TABLE IF EXISTS $value;";
            $wpdb->query($sql);

        }     

    }    

    public function ast_deleting_new_page_for_registration()
    {
        $page_id = get_option('ast_event_registration_page_id');  

        if (!empty($page_id)) {
            foreach ($page_id as $key => $value) {    
                wp_delete_post($value, false);
            }
        }
    }

}
