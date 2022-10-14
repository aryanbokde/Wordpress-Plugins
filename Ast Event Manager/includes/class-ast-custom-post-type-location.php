<?php

class Ast_Custom_Post_Type_Location {



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

    /**
     * Register a custom post type called "location".
     *
     * @see get_post_type_labels() for label keys.
     */
    public function ast_custom_post_location_init() {
        $labels = array(
            'name'                  => _x( 'locations', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'location', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'locations', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'location', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New location', 'textdomain' ),
            'new_item'              => __( 'New location', 'textdomain' ),
            'edit_item'             => __( 'Edit location', 'textdomain' ),
            'view_item'             => __( 'View location', 'textdomain' ),
            'all_items'             => __( 'Locations', 'textdomain' ),
            'search_items'          => __( 'Search locations', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent locations:', 'textdomain' ),
            'not_found'             => __( 'No locations found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No locations found in Trash.', 'textdomain' ),
            'featured_image'        => _x( 'location Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'location archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into location', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this location', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter locations list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'locations list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'locations list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => "events-manager",
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'location' ),
            'capability_type'    => 'page',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor'),
        );
     
        register_post_type( 'location', $args );
        flush_rewrite_rules();
    }
		

	/**
     * Register a custom post field called.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_location_custom_fields(){
	 
	    add_meta_box( 
	            'ast-location-metabox', //this is id
	            'Locations Custom Fields', //metabox title
	            array($this,'ast_location_custom_fields_callback'), //callback function
	            'location' //post type
	          );
	}
	 	 
	/**
     * Register a custom post field Save.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_location_custom_fields_save(){
	 
	    global $post;

	        // only run this for series
	    if ( 'location' != get_post_type( $post->ID ) ){
	        return $post->ID;        
	    }

	    // verify nonce
	    if ( empty( $_POST['location_custom_nonce'] ) || !wp_verify_nonce( $_POST['location_custom_nonce'], basename( __FILE__ ) ) ){
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
	    if(isset($_POST["_ast_google_map_link"])){ 

	    	$ast_city = sanitize_text_field($_POST["_ast_city"]);
	    	$ast_state = sanitize_text_field($_POST["_ast_state"]);
	    	$ast_country = sanitize_text_field($_POST["_ast_country"]);
	    	$ast_Latitude = sanitize_text_field($_POST["_ast_Latitude"]);
	    	$ast_Longitude = sanitize_text_field($_POST["_ast_Longitude"]);
	    	$ast_google_map_link = sanitize_url($_POST["_ast_google_map_link"]);

			
			update_post_meta($post->ID, '_ast_city', $ast_city);
			update_post_meta($post->ID, '_ast_state', $ast_state);
			update_post_meta($post->ID, '_ast_country', $ast_country);
			update_post_meta($post->ID, '_ast_Latitude', $ast_Latitude);
			update_post_meta($post->ID, '_ast_Longitude', $ast_Longitude);
			update_post_meta($post->ID, '_ast_google_map_link', $ast_google_map_link);

	    }       
	    
	}
	 
	/**
     * Register a custom post field called.
     *
     * @see Callback function.
     */
	public function ast_location_custom_fields_callback(){
		global $post;
	    ?>

	    <input type="hidden" name="location_custom_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />

	    <table class="form-table">

	    	<tr valign="top">
		    	<?php 		
		    		  		
		    		$ast_country = get_post_meta( $post->ID, '_ast_country', true );
		    		// if (empty($ast_country)) {
		    		// 	$ast_country = get_option('ast_default_country');  
		    		// }
		    		 
				    $all_country = get_posts( array(
				        'post_type' => 'country',
				        'numberposts' => -1,
				        'orderby' => 'post_title',
				        'order' => 'ASC'
				    ) );	
						
		    	?>
		    	<th scope="row"><label for="_ast_country">Country</label></th>
		    	<td>
		    		<select id="ast_country"  name="_ast_country" required>
		    			<option value="">Select Country</option>
		    			<?php 
		    				foreach($all_country as $country){ ?>
		    				<option value="<?php echo $country->ID; ?>" <?php if($ast_country == $country->ID){ echo 'selected="selected"'; } ?>><?php echo $country->post_title; ?></option>
		    				<?php } 
		    			?>
		    			
		    		</select>
		    	</td>
			</tr>
		    
			<tr valign="top">
		    	<th scope="row"><label for="_ast_state">State</label></th>
		    	<td>
			    	<?php		  		
			    		$ast_state = get_post_meta( $post->ID, '_ast_state', true );
			    		$the_state_data = get_post($ast_state );
			    	?>
			    	<p><span class="text-danger" id="state_error"></span></p>
		    		<select id="ast_state" name="_ast_state" required>	
		    			<option value="<?php echo $ast_state; ?>"><?php echo $the_state_data->post_title; ?></option>     	
		    		</select>
		    	</td>
			</tr>
			
			<tr valign="top">		    	
		    	<th scope="row"><label for="_ast_city">City</label></th>
		    	<?php 
		    		$ast_city = get_post_meta( $post->ID, '_ast_city', true ); 
		    		$the_city_data = get_post($ast_city );
		    		
		    	?>
		    	<td>
		    		<p><span class="text-danger" id="city_error"></span></p>
		    		<select id="ast_city" name="_ast_city" required>
		    			<option value="<?php echo $ast_city; ?>"><?php echo $the_city_data->post_title; ?></option>  
		    		</select>
		    	</td>
			</tr>

			<tr valign="top">
		    	<?php $ast_Latitude = get_post_meta( $post->ID, '_ast_Latitude', true ); ?>
		    	<th scope="row"><label for="_ast_Latitude">Latitude</label></th>
		    	<td><input placeholder="Latitude" class="form-control" type="text" name="_ast_Latitude" value="<?php echo $ast_Latitude; ?>"></td>
			</tr>

			<tr valign="top">
		    	<?php $ast_Longitude= get_post_meta( $post->ID, '_ast_Longitude', true ); ?>
		    	<th scope="row"><label for="_ast_Longitude">Longitude</label></th>
		    	<td><input placeholder="Longitude" class="form-control" type="text" name="_ast_Longitude" value="<?php echo $ast_Longitude; ?>"></td>
			</tr>

			<tr valign="top">
		    	<?php $ast_location_google_map_link = get_post_meta( $post->ID, '_ast_google_map_link', true ); ?>
		    	<th scope="row"><label for="_ast_google_map_link">Google Map Link</label></th>
		    	<td><input placeholder="Map Location Link" class="form-control" type="url" name="_ast_google_map_link" value="<?php echo $ast_location_google_map_link; ?>"></td>
			</tr>

	    </table> <?php 
	}


}





