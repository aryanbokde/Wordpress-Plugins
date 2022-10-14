<?php 

/* 1. Adds a custom field. NB. I am using some Norwegian words in the below text.
 * 2. Then adds a validate error message if person does not fill out the field. 
 * 3. Then adds the custom field to the order page. 
 */


/**
 * Adds a custom field. NB. I am using some Norwegian words in the below text.
 **/

add_filter("woocommerce_gateway_description", "techiepress_ast_description_fields", 20, 2);

function techiepress_ast_description_fields($description, $payment_id){

	if ('ast' != $payment_id) {
		return $description;
	}

	ob_start();

	echo "<div style='display:block; width:100%; height:auto;'>";	
	echo "<img src='". plugins_url('../assets/img/icon.png', __FILE__) ."' style='width:40px;'>";

	woocommerce_form_field(
		'payment_number', 
		array(
			'type' => 'text',
			'label' => __('Payment Phone Number', 'ast_woo'),
			'placeholder' => _x('Phone Number', 'placeholder', 'ast_woo'),
			'class' => array('form-row'),
			'required' => true,
			'label_class' => array('Hello-class')
		)
	);

	woocommerce_form_field(
		'paying_network', 
		array(
			'type' => 'select',
			'label' => __('Payment network', 'ast_woo'),	
			'label_class' => array('Hello-class'),		
			'class' => array('form-row', 'form-row-wide'),
			'required' => true,
			'options' => array(
				'none' =>  __('Select Payment Network', 'ast_woo'),
				'mtn_mobile' =>  __('MTN Mobile Money', 'ast_woo'),
				'airtel_money' =>  __('Airtel Money', 'ast_woo'),
			),
			
		)
	);

	echo "</div>";

	$description = ob_get_clean();

	return $description;

}


/**
 * Then adds a validate error message if person does not fill out the field. 
 **/
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
    // Check if set, if its not set add an error.

    if ('ast' == $_POST['payment_method'] && ! isset($_POST['payment_number']) || empty($_POST['payment_number'])) {
    	wc_add_notice( __( 'Please enter payment number' ), 'error' );
    }   

    if ('ast' == $_POST['payment_method'] && ! isset($_POST['paying_network']) || empty($_POST['paying_network']) || $_POST['paying_network'] == 'none') {
    	 wc_add_notice( __( 'Please Select Paying Network' ), 'error' );
    	// echo $_POST['paying_network'];
    }      
}



/**
 * 3. Update field value on post meta.
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_display_update_meta', 10, 1 );	

function my_custom_checkout_field_display_update_meta($order_id){
    	
	if ( isset($_POST['payment_number']) || !empty($_POST['payment_number'])) {
    	update_post_meta( $order_id, 'payment_number', $_POST['payment_number']);
    }
    if ( isset($_POST['paying_network']) || !empty($_POST['paying_network'])) {
    	update_post_meta( $order_id, 'paying_network', $_POST['paying_network']);
    }

}


/**
 * 4. Display field value on the order edit page.
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){

	echo '<p><strong>Payment Number</strong><br><span>'. get_post_meta($order->get_id(), 'payment_number', true ) .'</span></p>';
	echo '<p><strong>Payment Network</strong><br><span>'. get_post_meta($order->get_id(), 'paying_network', true ) .'</span></p>';	

}


/**
 * 5. Display field value on the order edit page.
 */
add_action( 'woocommerce_order_item_meta_end', 'my_custom_order_item_meta_end', 10, 3 );

function my_custom_order_item_meta_end($item_id, $item, $order){

	echo '<p><strong>Payment Number</strong><br><span>'. get_post_meta($order->get_id(), 'payment_number', true ) .'</span></p>';

}









