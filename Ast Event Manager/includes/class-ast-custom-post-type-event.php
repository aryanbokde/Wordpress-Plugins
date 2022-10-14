<?php

class Ast_Custom_Post_Type_Event {



	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following function that make up the plugin:
	 *
	 * - ast_custom_post_event_init. Created a custom post type event.
	 * - ast_event_custom_fields. Register custom post type event fields.
	 * - ast_event_custom_fields_save. Save all custom post type field in database.
	 * - ast_event_custom_fields_callback. Defines callback function for custom field.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

    public function ast_custom_post_event_init() {

    	//Create custom post type Events
        $labels = array(
            'name'                  => _x( 'Events', 'Post type general name', 'textdomain' ),
            'register_meta_box_cb' => 'global_notice_meta_box',
            'singular_name'         => _x( 'Event', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Events', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New Event', 'textdomain' ),
            'new_item'              => __( 'New Event', 'textdomain' ),
            'edit_item'             => __( 'Edit Event', 'textdomain' ),
            'view_item'             => __( 'View Event', 'textdomain' ),
            'all_items'             => __( 'All Events', 'textdomain' ),
            'search_items'          => __( 'Search Events', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Events:', 'textdomain' ),
            'not_found'             => __( 'No Events found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Events found in Trash.', 'textdomain' ),
            'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into Event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this Event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => "events-manager",
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'event' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'thumbnail'),
            'taxonomies'   => array( 
            	'event-types'
            )
            
        );

        register_post_type( 'Event', $args );
     
		unset( $args ); //Unset Argument
	    unset( $labels );// Unset Labels



	    //Create custom post type Taxonomy Events Type
        $labels = array(
	        'name'              => _x( 'Events Type ', 'taxonomy general name', 'textdomain' ),
	        'singular_name'     => _x( 'Event Type', 'taxonomy singular name', 'textdomain' ),
	        'search_items'      => __( 'Search Events', 'textdomain' ),
	        'all_items'         => __( 'All Events Type', 'textdomain' ),
	        'parent_item'       => __( 'Parent Events Type', 'textdomain' ),
	        'parent_item_colon' => __( 'Parent Events Type:', 'textdomain' ),
	        'edit_item'         => __( 'Edit Events Type', 'textdomain' ),
	        'update_item'       => __( 'Update Events Type', 'textdomain' ),
	        'add_new_item'      => __( 'Add New Events Type', 'textdomain' ),
	        'new_item_name'     => __( 'New Events Type Name', 'textdomain' ),
	        'menu_name'         => __( 'Event Types', 'textdomain' ),
	    );
	 
	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_in_menu'       => "events-manager",
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'event-types' ),
	    );
	 
	    register_taxonomy( 'event-types', array( 'event' ), $args );

	    unset( $args ); //Unset Argument
	    unset( $labels );// Unset Labels
        
        flush_rewrite_rules();
    }


	/**
     * Register a custom post field called.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_event_custom_fields(){
	 
	    add_meta_box( 
	            'ast-event-metabox', //this is id
	            'Events Custom Fields', //metabox title
	            array($this,'ast_event_custom_fields_callback'), //callback function
	            'event' //post type
	          );
	}
	 	 
	/**
     * Register a custom post field Save.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_event_custom_fields_save(){
	 
	    global $post;

	        // only run this for series
	    if ( 'event' != get_post_type( $post->ID ) ){
	        return $post->ID;        
	    }

	    // verify nonce
	    if ( empty( $_POST['event_custom_nonce'] ) || !wp_verify_nonce( $_POST['event_custom_nonce'], basename( __FILE__ ) ) ){
	        return $post->ID;
	    }

	    // check autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return $post->ID;
	    }

	    // check permissions
	    if ( !current_user_can( 'edit_post', $post->ID ) ) {
	        return $post->ID;
	    }
	 	
	 	//Update custom meta field
	    if(isset($_POST["_ast_selected_location"])){ 

	    	$ast_selected_location = intval($_POST["_ast_selected_location"]);
	    	$ast_event_date = $_POST["_ast_event_date"];
	    	$ast_event_time = $_POST["_ast_event_time"];
	    	$ast_price = intval($_POST["_price"]);
	    	$availability = intval($_POST["_availability"]);

			update_post_meta($post->ID, '_ast_selected_location', $ast_selected_location);
			update_post_meta($post->ID, '_ast_event_date', $ast_event_date);
			update_post_meta($post->ID, '_ast_event_time', $ast_event_time);
			update_post_meta($post->ID, '_price', $ast_price);
			update_post_meta($post->ID, '_availability', $availability);
	    }       
	    
	}
	 
	/**
     * Register a custom post field called.
     *
     * @see Callback function.
     */
	public function ast_event_custom_fields_callback(){
		global $post;
	    $selected_location = get_post_meta( $post->ID, '_ast_selected_location', true );
	    $all_location = get_posts( array(
	        'post_type' => 'location',
	        'numberposts' => -1,
	        'orderby' => 'post_title',
	        'order' => 'ASC'
	    ) );
	    ?>
	    <input type="hidden" name="event_custom_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
	    <table class="form-table">
	    	<?php $ast_price= get_post_meta( $post->ID, '_price', true ); ?>
		    <tr valign="top">
		    	<th scope="row"><label for="_price">Price</label></th>
		    	<td><input type="text" name="_price" value="<?php echo $ast_price; ?>"></td>
			</tr>
		    <tr valign="top">
		    	<th scope="row"><label for="_ast_selected_location">Location</label></th>
		    	<td><select name="_ast_selected_location"><?php foreach ( $all_location as $location ) : ?> 
		    	<?php 
		    		// $ast_city = get_post_meta( $location->ID, '_ast_city', true ); 
		    		// $ast_state = get_post_meta( $location->ID, '_ast_state', true );
		    		// $ast_country = get_post_meta( $location->ID, '_ast_country', true );
		    	?>
		        <option value="<?php echo $location->ID; ?>"<?php if($selected_location == $location->ID){ echo 'selected="selected"'; } ?>><?php echo $location->post_name; ?></option>
		    	<?php endforeach; ?>
		    	</select></td>
			</tr>

		    <?php $ast_event_date = get_post_meta( $post->ID, '_ast_event_date', true ); ?>
		    <tr valign="top">
		    	<th scope="row"><label for="_ast_event_date">Date</label></th>
		    	<td><input type="date" name="_ast_event_date" value="<?php echo $ast_event_date; ?>"></td>
			</tr>

			<?php $ast_event_time = get_post_meta( $post->ID, '_ast_event_time', true ); ?>
		    <tr valign="top">
		    	<th scope="row"><label for="_ast_event_time">Time</label></th>
		    	<td><input type="time" name="_ast_event_time" value="<?php echo $ast_event_time; ?>"></td>
			</tr>
			<?php $availability = get_post_meta( $post->ID, '_availability', true ); ?>
		    <tr valign="top">
		    	<th scope="row"><label for="_availability">Available Seats</label></th>
		    	<td><input type="number" name="_availability" value="<?php echo $availability; ?>"></td>
			</tr>

	    </table> <?php 
	}


}





