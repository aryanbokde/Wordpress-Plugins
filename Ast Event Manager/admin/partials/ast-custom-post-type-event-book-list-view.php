<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
	global $wpdb;
	if (!empty($_GET['book_id'])) {
		
		$ast_event_book_id = $_GET['book_id'];		
        $table_list = get_option("ast_table_name");

        foreach($table_list as $key => $tablename){
        	if ($key == "book_event_table") {
        		$db_table_name = $tablename;
        	}
        }

		$results = $wpdb->get_results ( "SELECT * FROM $db_table_name WHERE `ID` = $ast_event_book_id ");

		foreach($results as $result){ 
			if (!empty($result->event_id)) {
                $event_data = get_post($result->event_id);
                $event_name = $event_data->post_title;
            }else{
                $event_name = $result->event_id;
            }
		?>
		   <div class="Postdata">
		   		<h1>View Book Event</h1>
			    <form method="post" id="event-form-data">
			        <table style="text-align: left; height: 152px;" border="1" cellspacing="0" cellpadding="5" width="100%">
						<tr><th width="25%">Name</td><td><?php echo $result->name; ?></td></tr>
						<tr><th width="25%">Mobile</td><td><?php echo $result->mobile; ?></td></tr>
						<tr><th width="25%">Email</td><td><?php echo $result->email; ?></td></tr>
						<tr><th width="25%">Event Name</td><td><?php echo $event_name; ?></td></tr>
					</table>                 
			    </form>
			</div>
		<?php }

	}else{
		echo "Sorry, Data not found..!";
	}

?>






