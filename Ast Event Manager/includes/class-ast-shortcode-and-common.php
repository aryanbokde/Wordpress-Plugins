<?php

class Ast_Custom_Shortcode_and_Common {


	/**
	 * Register shortcode for event management form.
	 *
	 * @since    1.0.0
	 */
	
	public function ast_register_shortcodes() { 
	  add_shortcode( 'ast-event-booked-form', array( $this, 'generate_shortcode_for_ast_event_register') );
	  add_shortcode( 'ast-event-prifile', array( $this, 'generate_shortcode_for_ast_event_users_profile') );
	  add_shortcode( 'ast-event-post', array( $this, 'generate_shortcode_for_ast_event_post') );
	}
	/**
	 * //Ast-event registration form Hmtl form 
	 *
	 * @since    1.0.0
	 */
	
	public function generate_shortcode_for_ast_event_post($attr)
	{

		ob_start();
		// define attributes and their defaults
	    extract( shortcode_atts( array (
	        'type' => 'event',
	        'post_status' => 'publish',
	        'order' => 'DESC',
	        'orderby' => 'date',
	        'posts_per_page' => get_option( 'posts_per_page' ),
	    ), $attr ) );			    

		
		global $wp_query, $paged;
	    if( get_query_var('paged') ){
	        $paged = get_query_var('paged' );
	    } else if ( get_query_var('page') ){
	        $paged = get_query_var('page' );
	    } else{
	        $paged = 1;
	    }
		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;


		$query = new WP_Query(array(
		    'post_type' => $type,
		    'post_status' => $post_status,
		    'posts_per_page' => $posts_per_page,
		    'orderby' => $orderby, 
        	'order' => $order,
        	'paged' => $paged
		));

		?>

		<div class="container">
			<div class="row">
			<?php 
			while ($query->have_posts()) {
				$query->the_post();?>

			    <div class="col-lg-4 mb-5">
			    	<?php  	
			    		$ID = get_the_ID();
					if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) 
			    	{
						echo get_the_post_thumbnail($post->ID);
					} else {
						$imgpath = AST_CUSTOM_POST_TYPE_DIR_URL . 'public/img/default-banner.jpg';
						echo "<img src='".$imgpath."' alt='".get_the_title()."'>";
					} 
					?>
			    	
					<a href="<?php the_permalink(); ?>"><h6 style="margin:10px 0;"><?php the_title(); ?></h6></a>
					<p class="ast-meta">
						<?php 
							$key_1_value = get_post_meta( get_the_ID(), '_ast_selected_location', true );
							if (!empty($key_1_value)) {
								$location = get_post($key_1_value);
								echo "<span class='location icon fa fa-location-arrow'> <strong>Location :</strong> ". $location->post_title ."</span>";
							} 
						?>
					</p>
					<?php echo wp_trim_words(get_the_content(), 40, '...');?>
					<a href="http://localhost/Testing/cart/?add-to-cart=<?php echo $ID ; ?>">Add to Cart</a>
				</div>

			<?php }
			wp_reset_query();

			?>
				
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<?php 
						$big = 999999999; // need an unlikely integer
						 echo paginate_links( array(
						    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
						    'format' => '?paged=%#%',
						    'current' => max( 1, get_query_var('paged') ),
						    'total' => $query->max_num_pages
						) );

					?>
				</div>
			</div>
		</div>
		
		<?php 

		$html_form = ob_get_clean();
		return $html_form;
	}



	public function generate_shortcode_for_ast_event_register($attr)
	{

		ob_start();

		$args = shortcode_atts(array(
			'fclass' => 'default',
			'label' => 'true',
			'inputclass' => 'input-field',
			'buttonclass' => 'submit-button'

		), $attr);

		$qvar = get_query_var('eid');

	    if (!empty($qvar)) {
	        $args = array(
	            'post_type' => 'event',
	            'post_status' => 'publish',
	            'numberposts' => -1,
	            'order'    => 'ASC',
	            'post__in' => array($qvar)
	        );
	        $events = get_posts($args);
	    }else{
	        $args = array(
	            'post_type' => 'event',
	            'post_status' => 'publish',
	            'numberposts' => -1,
	            'order'    => 'ASC'
	        );
	        $events = get_posts($args);
	    }
		?>

		<div class="">
            <form method="post" id="ast-event-register" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table style="border:none;">
                    <?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>
                    <?php 
                        echo "<span class='event-form-error-handling'></span>";
                    ?>
                    <tr>
                        <td style="border:none;">
                            <label>Name</label>
                            <input type="text" name="ast_name" placeholder="Name" >

                    <tr>
                        <td style="border:none;">
                            <label>Mobile</label>
                            <input type="number" name="ast_number" placeholder="Mobile" >
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;">
                            <label>Email</label>
                            <input type="email" name="ast_email" placeholder="Email" >
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;">
                            <label>Events</label>
                            <?php 
                                if ( $events ) { // Make sure we have posts before we attempt to loop through them
                                    echo '<select class="" id="ast-event-id" style="width:100%;" name="ast_event">';
                                    foreach ( $events as $event ) {
                                        setup_postdata( $event );
                                        echo '<option value="' . $event->ID . '">' . $event->post_title . '</option>';
                                    }
                                    wp_reset_postdata(); // VERY VERY IMPORTANT
                                    echo '</select>';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;"><input type="submit" name="event-submit" value="Submit"></td>
                    </tr>
                </table>                               
            </form>
        </div>

		<?php 

		$html_form = ob_get_clean();
		return $html_form;
	}

	/**
	 * //Ast-event registration form Hmtl form 
	 *
	 * @since    1.0.0
	 */
	
	public function generate_shortcode_for_ast_event_users_profile()
	{
		ob_start();	
		if (is_user_logged_in()) {
			global $wpdb;
   			$current_user = wp_get_current_user();   			
   			$current_user_id = $current_user->ID;
   			$current_user_name = $current_user->user_login; 
   			
        	$table_list = get_option("ast_table_name");

	        foreach($table_list as $key => $value){
	        	if ($key == "book_event_table") {
	        		$event_table = $value;
	        	}
	        }
   			
			$results = $wpdb->get_results( "SELECT * FROM $event_table where uid = '".$current_user_id."' ORDER BY created_at DESC");
		
			?>
			<caption>Welcome <?php echo $current_user_name; ?></caption>
			<table class="table" style="max-width:100%;">			  
			  <thead>
			    <tr>
			      <th scope="col">Order#ID</th>
			      <th scope="col">Name</th>
			      <th scope="col">Mobile</th>
			      <th scope="col">Email</th>
			      <th scope="col">Event Name</th>
			      <th scope="col">Created At</th>
			    </tr>
			  </thead>
			  <tbody>
			<?php foreach($results as $data){ 
				$event_data = get_post($data->event_id);
			?>
			    <tr>
			      <th scope="row"><?php echo $data->ID; ?></th>			      
			      <td><?php echo $data->name; ?></td>
			      <td><?php echo $data->mobile; ?></td>
			      <td><?php echo $data->email; ?></td>
			      <td><?php echo $event_data->post_title; ?></td>
			      <td><?php echo $data->created_at; ?></td>
			    </tr>
			<?php } ?>	
			  </tbody>
			</table>


		<?php }else{
			echo "Sorry, you are not authorized to see page content..!";
		}
		$html_form = ob_get_clean();
		return $html_form;
	}

		/**
	 * Get select event ID in event management form 
	 *
	 * @since    1.0.0
	 */
	public function e_query($qvars) {
	    // $qvars = array();
	    $qvars[] = 'eid';    
	    return $qvars;
	}

		/**
	 * Event management form validation and save 
	 *	to the database and mail.	 
	 * @since    1.0.0
	 */
	public function Ast_Registration_form(){

		$my_errors = new WP_Error;
		$astname = $_POST['ast_name'];
		$astmobile = $_POST['ast_number'];
		$astmail = $_POST['ast_email'];
		$asteventid = $_POST['ast_event'];

		$fomrdata = array(
			'ast_name'    =>   $astname,
			'ast_mobile'    =>   $astmobile,
			'ast_mail'     =>   $astmail,
			'ast_eventid'     =>   $asteventid,
		);

		if ( ! isset( $_POST['name_of_nonce_field'] ) || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) 
		) {

			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, your nonce did not verify.</div>'));
		}elseif (empty($astname)) {
			//$my_errors->add( 'nameerror', 'Sorry, name field is required or empty.' );
			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, name field is required or empty.</div>'));
		}elseif(empty($astmobile)){
			//$my_errors->add( 'mobileerror', 'Sorry, mobile field is required or empty.' );
			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, mobile field is required.</div>'));
		}elseif(!preg_match('/^[0-9]{10}+$/', $astmobile)){
			//$my_errors->add( 'mobileerrorn', 'Sorry, you enter invalid mobile number.' );
			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, you enter invalid mobile number.</div>'));
		}elseif(empty($astmail)){
			//$my_errors->add( 'mailerror', 'Sorry, email field is required.' );
			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, email field is required.</div>'));
		}elseif(!filter_var($astmail, FILTER_VALIDATE_EMAIL)){
			echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, Invalid email format.</div>'));
		}else {

				//User detail
				$uname = sanitize_text_field($_POST['ast_name']);
				$umobile = intval($_POST['ast_number']);
				$umail = sanitize_email($_POST['ast_email']);
				$ueventid = intval($_POST['ast_event']);

				$args = array(
		            'post_type' => 'event',
		            'post_status' => 'publish',
		            'numberposts' => -1,
		            'order'    => 'ASC',
		            'post__in' => array($ueventid)
		        );
		        $events = get_posts($args);

		        if ( $events ) {		         	
                    foreach ( $events as $event ) {
                        setup_postdata( $event );
                        $event_id = $event->ID;
                        $event_title = $event->post_title;                        
                    }
                    wp_reset_postdata(); // VERY VERY IMPORTANT                
                }

                global $wpdb;
                $user_ID = get_current_user_id();
                if (empty($user_ID)) {
                 	$user_ID = "Unknown";
                } 
                $db_table_name = $wpdb->prefix . 'events_data';  // table name
				$wpdb->insert($db_table_name, array(
				   "name" => $uname,
				   "mobile" => $umobile,
				   "email" => $umail,
				   "event_id" => $event_id,
				   "uid" => $user_ID,
				));


				$template = '<table><tr><td colspan="2"><h3>Welcome to "' . get_bloginfo('name') . '"</h3></td></tr> <tr><td>Name</td><td>"' . $uname . '"</td></tr> <tr><td>Mobile</td><td>"' . $umobile . '"</td></tr> <tr><td>Mail</td><td>"' . $umail . '"</td></tr> <tr><td>Event Name</td><td>"' . $event_title . '"</td></tr></table>';


				$headers[] = 'Content-type: text/html; charset=utf-8';
				$headers[] = 'From: ' . get_bloginfo("name") . ' <' . get_bloginfo("admin_email") . '>' . "\r\n";
				$message = $template;


				$mailResult = false;
				$mailResult = wp_mail("rakesh.bokde@arsenaltech.com", 'Event Registration Form' . get_bloginfo("name"), $message, $headers);

				if($mailResult){
				    echo wp_send_json(array('status' => true, 'message' => '<div class="alert alert-success">Thank you, Your email has been sent..!</div>', 'mobile' => $umobile, 'event_id' => $event_id, 'event_name' => $event_title ));
				}else{
				    echo wp_send_json(array('status' => false, 'message' => '<div class="alert alert-danger">Sorry, mail not sent..!</div>', 'mobile' => $umobile, 'event_id' => $event_id, 'event_name' => $event_title ));
				}
	
		}
			
	}


	// GET FEATURED IMAGE
	public function AST_get_featured_image($post_ID) {
		global $post;
	    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
	    if ($post_thumbnail_id) {
	        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
	        return $post_thumbnail_img[0];
	    }
	}

	// Get the Price for custom post type event.
	public function AST_get_event_price($post_ID) {    
	    $ast_price = get_post_meta( $post_ID, '_price', true );
	    if (!empty($ast_price)) {
	        return $ast_price;
	    }else{
	    	return 20;
	    }
	}

	// Get the Price for custom post type event.
	public function AST_get_event_location($post_ID) {    
	    $ast_location = get_post_meta( $post_ID, '_ast_selected_location', true );
	    if (!empty($ast_location)) {
	        return $ast_location;
	    }else{
	    	return get_option('ast_default_city');
	    }
	}


	// ADD NEW COLUMN
	public function AST_columns_head($defaults) {
	    $post_type = get_post_type();
	    if ( $post_type == 'event' ) {
	        $defaults['featured_image'] = 'Featured Image';
	        $defaults['price'] = 'Price';
	        $defaults['location'] = 'Location';
	    }
	    return $defaults;
	}
	 
	// SHOW THE FEATURED IMAGE
	public function AST_columns_content($column_name, $post_ID) {
	    if ($column_name == 'price') {
	        $price = $this->AST_get_event_price($post_ID);
	        if ($price) {
	            echo $price;
	        }
	    }
	    if ($column_name == 'location') {
	        $location_id = $this->AST_get_event_location($post_ID);
	        $location_data = get_post($location_id);
	        $location_name = $location_data->post_title;
	        if ($location_name) {
	            echo $location_name;
	        }
	    }
	    if ($column_name == 'featured_image') {
	        $post_featured_image = $this->AST_get_featured_image($post_ID);
	        if ($post_featured_image) {
	            echo '<img src="' . $post_featured_image . '" style="width:55px;"/>';
	        }
	    }
	}







}





