<?php

class Ast_Custom_Post_Type_Country {



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

    public function ast_custom_post_country_init() {

    	//Create custom post type Country
	    $labels = array(
            'name'                  => _x( 'Countries', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'Country', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Country', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Country', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New Country', 'textdomain' ),
            'new_item'              => __( 'New Country', 'textdomain' ),
            'edit_item'             => __( 'Edit Country', 'textdomain' ),
            'view_item'             => __( 'View Country', 'textdomain' ),
            'all_items'             => __( 'Countries', 'textdomain' ),
            'search_items'          => __( 'Search Countries', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Countries:', 'textdomain' ),
            'not_found'             => __( 'No Countries found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Countries found in Trash.', 'textdomain' ),
        );     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => "events-manager",
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'country' ),
            'capability_type'    => 'page',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title')
        );
        register_post_type( 'Country', $args );
     
		unset( $args );
	    unset( $labels );



	    //Create custom post type State
	    $labels = array(
            'name'                  => _x( 'States', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'State', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'State', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'State', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New State', 'textdomain' ),
            'new_item'              => __( 'New State', 'textdomain' ),
            'edit_item'             => __( 'Edit State', 'textdomain' ),
            'view_item'             => __( 'View State', 'textdomain' ),
            'all_items'             => __( 'States', 'textdomain' ),
            'search_items'          => __( 'Search States', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent States:', 'textdomain' ),
            'not_found'             => __( 'No States found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No States found in Trash.', 'textdomain' ),
        );     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => "events-manager",
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'state' ),
            'capability_type'    => 'page',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title')
        );
        register_post_type( 'State', $args );
     
		unset( $args );
	    unset( $labels );

	    //Create custom post type City
	    $labels = array(
            'name'                  => _x( 'Cities', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'City', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'City', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'City', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New City', 'textdomain' ),
            'new_item'              => __( 'New City', 'textdomain' ),
            'edit_item'             => __( 'Edit City', 'textdomain' ),
            'view_item'             => __( 'View City', 'textdomain' ),
            'all_items'             => __( 'Cities', 'textdomain' ),
            'search_items'          => __( 'Search Cities', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Cities:', 'textdomain' ),
            'not_found'             => __( 'No Cities found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Cities found in Trash.', 'textdomain' ),
        );     
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => "events-manager",
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'city' ),
            'capability_type'    => 'page',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title')
        );
        register_post_type( 'City', $args );
     
		unset( $args );
	    unset( $labels );

        
        flush_rewrite_rules();
    }


	/**
     * Register a custom post field called.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_state_custom_fields(){
	 
	    add_meta_box( 
	            'ast-state-metabox', //this is id
	            'State Custom Fields', //metabox title
	            array($this,'ast_state_custom_fields_callback'), //callback function
	            'state' //post type
	          );
	}
	 	 
	/**
     * Register a custom post field Save.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_state_custom_fields_save(){
	 
	    global $post;

	        // only run this for series
	    if ( 'state' != get_post_type( $post->ID ) ){
	        return $post->ID;        
	    }

	    // verify nonce
	    if ( empty( $_POST['country_custom_nonce'] ) || !wp_verify_nonce( $_POST['country_custom_nonce'], basename( __FILE__ ) ) ){
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
	    if(isset($_POST["_ast_selected_country"])){ 
	    	$ast_selected_country = intval($_POST["_ast_selected_country"]);
			update_post_meta($post->ID, '_ast_selected_country', $ast_selected_country);
	    }       
	    
	}
	 
	/**
     * Register a custom post field called.
     *
     * @see Callback function.
     */
	public function ast_state_custom_fields_callback(){
		global $post;

	    $selected_country = get_post_meta( $post->ID, '_ast_selected_country', true );
	    
	    $all_country = get_posts( array(
	        'post_type' => 'country',
	        'numberposts' => -1,
	        'orderby' => 'post_title',
	        'order' => 'ASC'
	    ) );
	    ?>
	    <input type="hidden" name="country_custom_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
	    <table class="form-table">	    	
		    <tr valign="top">
		    	<th scope="row"><label for="_ast_selected_country">Country</label></th>
		    	<td><select name="_ast_selected_country" required>
		    		<?php foreach ( $all_country as $country ) : ?> 
		    	    	<option value="<?php echo $country->ID; ?>"<?php if($selected_country == $country->ID){ echo 'selected="selected"'; } ?>><?php echo $country->post_title; ?></option>
		    		<?php endforeach; ?>
		    	</select></td>
			</tr>

	    </table> <?php 
	}



		/**
     * Register a custom post field called.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_city_custom_fields(){
	 
	    add_meta_box( 
	            'ast-city-metabox', //this is id
	            'City Custom Fields', //metabox title
	            array($this,'ast_city_custom_fields_callback'), //callback function
	            'city' //post type
	          );
	}
	 	 
	/**
     * Register a custom post field Save.
     *
     * @see add_meta_box() for label keys.
     */
	public function ast_city_custom_fields_save(){
	 
	    global $post;

	        // only run this for series
	    if ( 'city' != get_post_type( $post->ID ) ){
	        return $post->ID;        
	    }

	    // verify nonce
	    if ( empty( $_POST['city_custom_nonce'] ) || !wp_verify_nonce( $_POST['city_custom_nonce'], basename( __FILE__ ) ) ){
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
	    if(isset($_POST["_ast_selected_state"])){ 
	    	$ast_selected_state = intval($_POST["_ast_selected_state"]);
			update_post_meta($post->ID, '_ast_selected_state', $ast_selected_state);
	    }       
	    
	}
	 
	/**
     * Register a custom post field called.
     *
     * @see Callback function.
     */
	public function ast_city_custom_fields_callback(){
		global $post;
	    $selected_state = get_post_meta( $post->ID, '_ast_selected_state', true );
	    
	    $all_state = get_posts( array(
	        'post_type' => 'state',
	        'numberposts' => -1,
	        'orderby' => 'post_title',
	        'order' => 'ASC'
	    ) );
	    ?>
	    <input type="hidden" name="city_custom_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
	    <table class="form-table">	    	
		    <tr valign="top">
		    	<th scope="row"><label for="_ast_selected_state">State</label></th>
		    	<td><select name="_ast_selected_state" required><?php foreach ( $all_state as $state ) : ?>     	
		        <option value="<?php echo $state->ID; ?>"<?php if($selected_state == $state->ID){ echo 'selected="selected"'; } ?>><?php echo $state->post_title; ?></option>
		    	<?php endforeach; ?>
		    	</select></td>
			</tr>

	    </table> <?php 
	}


}





