<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/admin
 * @author     Rakesh <rakesh.bokde@arsenaltech.com>
 */
class Ast_Custom_Post_Type_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
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
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ast_Custom_Post_Type_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ast_Custom_Post_Type_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ast-custom-post-type-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ast_Custom_Post_Type_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ast_Custom_Post_Type_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ast-custom-post-type-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }


    public function events_register_ref_page()
    {
        add_menu_page(
            'Events Manager',
            'Events Manager',
            'read',
            'events-manager',
            array($this, null), // Callback, leave empty
            'dashicons-calendar',
            22 // Position
        );
        add_submenu_page('events-manager', 'Event Types', 'Event Types', 'manage_options', 'edit-tags.php?taxonomy=event-types&post_type=event', null);
        add_submenu_page('events-manager', 'Event Options', 'Event Options', 'manage_options', 'event-manager-options', array($this, 'events_ref_page_callback'));
        add_submenu_page('events-manager', 'Event Booked', 'Event Booked', 'manage_options', 'event-booked', array($this, 'events_booked_list_callback'));
        add_submenu_page('events-manager', 'File Manager', 'File Manager', 'manage_options', 'file-manager', array($this, 'ast_files_management'));
    }

    /**
     * Display callback function for event manager custom option.
     */
    public function events_ref_page_callback()
    {
		?>
        <div class="wrap">
            <h1><?php _e('Events Management Shortcode Reference & Options', 'textdomain'); ?></h1>
            <p><?php _e('Helpful Stuff', 'textdomain'); ?></p>
        </div>
        <form method="post" action="options.php">
		    <?php settings_fields( 'ast-event-management-custom-options' ); ?>
		    <?php do_settings_sections( 'ast-event-management-custom-options' ); ?>
		    <table class="form-table">
		        <tr valign="top">
			        <th scope="row">Select Default Country</th>
			        <td>
			        	<?php 		    		
				    		$ast_country = get_option('ast_default_country');
				    		// if (empty($ast_country)) {
				    		// 	$args = array(  
							   //      'post_type' => 'country',
							   //      'post_status' => 'publish',
							   //      'posts_per_page' => -1,
							   //      'orderby' => 'post_title',
							   //      'order' => 'ASC',
							   //  );
							   //  $loop = new WP_Query( $args );         
							   //  while ( $loop->have_posts() ) : $loop->the_post(); 
							   //  	if (get_the_title() == "India") {
							   //  		$ast_country = get_the_ID();
							   //  	}
							   //  endwhile;
							   //  wp_reset_postdata();    		 	
				    		// } 
				    		
				    		$all_country = get_posts( array(
							        'post_type' => 'country',
							        'numberposts' => -1,
							        'orderby' => 'post_title',
							        'order' => 'ASC'
						    ) );
								
				    	?>
				    	
			        	<select name="ast_default_country" id="ast-default-country" required>
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
			        <th scope="row">Select Default State </th>
			        <td>
			        	<?php 		    		
				    		$ast_state = get_option('ast_default_state');
				    		// if (empty($ast_state)) {
				    			
				    		// 	$args = array(  
							   //      'post_type' => 'state',
							   //      'post_status' => 'publish',
							   //      'posts_per_page' => -1,
							   //      'orderby' => 'post_title',
							   //      'order' => 'ASC',
							   //  );
							   //  $loop = new WP_Query( $args );         
							   //  while ( $loop->have_posts() ) : $loop->the_post(); 
							   //  	if (get_the_title() == "Maharashtra") {
							   //  		 $ast_state = get_the_ID();
							   //  	}
							   //  endwhile;
							   //  wp_reset_postdata(); 									 	
				    		// } 
				    		$args = array(
							    'post_type' => 'state',
						        'numberposts' => -1,
						        'orderby' => 'post_title',
						        'order' => 'ASC'
							);
							$all_state = get_posts( $args );				    		
								
				    	?>
				    	<p class="text-danger"><span id="default_state_error"></span> </p>
				    	<select name="ast_default_state" id="ast-default-state" required>
                                <option value="">Select State</option>
			        		<?php 
			    				foreach($all_state as $state){ ?>
			    				<option value="<?php echo $state->ID; ?>" <?php if($ast_state == $state->ID){ echo 'selected="selected"'; } ?>><?php echo $state->post_title; ?></option>
			    				<?php } 
			    			?>
			        	</select>
			        	
			        </td>
		        </tr>
		        
		        <tr valign="top">
			        <th scope="row">Select Default City </th>
			        <td>
			        	<?php 		    		
				    		$ast_city = get_option('ast_default_city'); 
				    		// if (empty($ast_city)) {
				    			
				    		// 	$args = array(  
							   //      'post_type' => 'city',
							   //      'post_status' => 'publish',
							   //      'posts_per_page' => -1,
							   //      'orderby' => 'post_title',
							   //      'order' => 'ASC',
							   //  );
							   //  $loop = new WP_Query( $args );         
							   //  while ( $loop->have_posts() ) : $loop->the_post(); 
							   //  	if (get_the_title() == "Nagpur") {
							   //  		 $ast_city = get_the_ID();
							   //  	}
							   //  endwhile;
							   //  wp_reset_postdata(); 									 	
				    		// } 
				    		$args = array(
							    'post_type' => 'city',
						        'numberposts' => -1,
						        'orderby' => 'post_title',
						        'order' => 'ASC'
							);
							$all_city = get_posts( $args );				    		
								
				    	?>
				    	<p class="text-danger"><span id="default_city_error"></span> </p>
				    	<select name="ast_default_city" id="ast-default-city" required>
                                <option value="">Select City</option>
			        		<?php 
			    				foreach($all_city as $city){ ?>
			    				<option value="<?php echo $city->ID; ?>" <?php if($ast_city == $city->ID){ echo 'selected="selected"'; } ?>><?php echo $city->post_title; ?></option>
			    				<?php } 
			    			?>
			        	</select>			        	
			        </td>
		        </tr>

                <tr valign="top">
                    <th scope="row">Select Default Currency </th>
                    <td>
                        <?php     
                            $ast_currency = get_option('ast_default_currency'); 
                            $table_list = get_option("ast_table_name");
                            foreach($table_list as $key => $value){
                                if ($key == "ast_event_currency") {
                                    $currency_table = $value;                                   
                                }
                            }                             
                            global $wpdb;
                            $results = $wpdb->get_results( "SELECT * FROM $currency_table ");

                        ?>
                        
                        <p class="text-danger"><span id="default_currency_error"></span> </p>
                        <select name="ast_default_currency" id="ast-default-currency" required>
                            <option value="">Select Currency</option>     
                            <?php 
                                if (count($results) > 0){
                                    foreach($results as $currency){ ?>
                                        <option value="<?php echo $currency->ID; ?>" <?php if( $ast_currency == $currency->ID ){ echo 'selected="selected"'; } ?>><?php 
                                        echo $currency->symbol. " : " . $currency->currencyname; ?></option> 
                                <?php }
                                }
                                     
                            ?>       
                        </select>                       
                    </td>
                </tr>

		    </table>
		    
		    <?php submit_button(); ?>

		</form>
        <div class="wrap">
            <h1><?php _e('Shortcode Reference', 'textdomain'); ?></h1>
            <p><?php _e('Helpful Stuff', 'textdomain'); ?></p>
            <ul>
                <li><?php _e('Use this shortcode to display event [ ast-event-post type="event" post_status="publish" order="DESC" orderby="date" posts_per_page="8" ]'); ?></li>
                <li><?php _e('Put this [ast-event-prifile] shortcode on user order page to display order..!', 'textdomain'); ?></li>
                <li><?php _e('Do not change Event registration page id or Not replace shortcod..!', 'textdomain'); ?></li>
            </ul>
        </div>
		<?php
    }


	public function register_my_event_management_custom_options_settings() 
    {
		//register our settings
		register_setting( 'ast-event-management-custom-options', 'ast_default_country' );
		register_setting( 'ast-event-management-custom-options', 'ast_default_state' );
		register_setting( 'ast-event-management-custom-options', 'ast_default_city' );
        register_setting( 'ast-event-management-custom-options', 'ast_default_currency' );
	}


    public function ast_get_state_custom_field()
    {
        if (isset($_REQUEST)) {

            $country_id = $_REQUEST['c_id'];

            $all_state = get_posts(array(
                'post_type' => 'state',
                'numberposts' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'   => '_ast_selected_country',
                        'value' => $country_id,
                    ),
                )
            ));

            if (!empty($all_state)) {

                $items = array();
                foreach ($all_state as $state) {
                    $items[] = $state;
                }

                $response = array(
                    'message'  => true,
                    'data'       => $items
                );

                wp_send_json($response);
            } else {

                $response = array(
                    'message'  => false,
                    'data'       => "Data not available to related Country"
                );

                wp_send_json($response);
            }
        }
    }

    public function ast_get_city_custom_field()
    {
        if (isset($_REQUEST)) {

            $state_id = $_REQUEST['s_id'];

            $all_city = get_posts(array(
                'post_type' => 'city',
                'numberposts' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'   => '_ast_selected_state',
                        'value' => $state_id,
                    ),
                )
            ));

            if (!empty($all_city)) {

                $items = array();
                foreach ($all_city as $city) {
                    $items[] = $city;
                }

                $response = array(
                    'message'  => true,
                    'data'       => $items
                );

                wp_send_json($response);
            } else {

                $response = array(
                    'message'  => false,
                    'data'       => "Data not available to related State"
                );

                wp_send_json($response);
            }
        }
    }

    public function ast_get_country_id_onchange()
    {
    	if (isset($_REQUEST)) {

            $country_id = $_REQUEST['c_id'];

            $all_state = get_posts(array(
                'post_type' => 'state',
                'numberposts' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'   => '_ast_selected_country',
                        'value' => $country_id,
                    ),
                )
            ));

            if (!empty($all_state)) {

                $items = array();
                foreach ($all_state as $state) {
                    $items[] = $state;
                }

                $response = array(
                    'message'  => true,
                    'data'       => $items
                );

                wp_send_json($response);
            } else {

                $response = array(
                    'message'  => false,
                    'data'       => "Data not available to related to this country."
                );

                wp_send_json($response);
            }
        }
    }

    public function ast_get_state_id_onchange()
    {
    	if (isset($_REQUEST)) {

            $state_id = $_REQUEST['s_id'];

            $all_city = get_posts(array(
                'post_type' => 'city',
                'numberposts' => -1,
                'orderby' => 'post_title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key'   => '_ast_selected_state',
                        'value' => $state_id,
                    ),
                )
            ));

            if (!empty($all_city)) {

                $items = array();
                foreach ($all_city as $city) {
                    $items[] = $city;
                }

                $response = array(
                    'message'  => true,
                    'data'       => $items
                );

                wp_send_json($response);
            } else {

                $response = array(
                    'message'  => false,
                    'data'       => "Data not available to related to this State."
                );

                wp_send_json($response);
            }
        }
    }

    public function events_booked_list_callback(){

        $action = isset($_GET['action']) ? trim($_GET['action']) : "";

        if ($action == "ast-view-event") {

            ob_start();
            include_once( AST_CUSTOM_POST_TYPE_DIR_PATH . 'admin/partials/ast-custom-post-type-event-book-list-view.php' );               
            $template = ob_get_contents();
            ob_clean();            
            echo $template;

        }else{

            ob_start();
            include_once( AST_CUSTOM_POST_TYPE_DIR_PATH . 'admin/partials/ast-custom-post-type-event-book-list-display.php' );               
            $template = ob_get_contents();
            ob_clean();            
            echo $template;

        }        
        
    }


    public function ast_files_management(){
        ob_start();
        include_once( AST_CUSTOM_POST_TYPE_DIR_PATH . 'admin/partials/ast-custom-post-type-admin-display.php' );               
        $template = ob_get_contents();
        ob_clean();            
        echo $template;
    }


}
