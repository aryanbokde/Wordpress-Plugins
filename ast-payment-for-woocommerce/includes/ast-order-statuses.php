<?php 

/**
 * Add new invoice status for woocommerce.
 */

add_action("init", "register_my_new_order_statuses");

function register_my_new_order_statuses(){
	register_post_status('wc-invoiced', array(
		'label' => _x('Invoiced', 'Order status', 'ast-payment-gateways'),
		'public' => true,
		'exclude_from_search' => false,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
		'label_count' => _x('Invoiced <span class="count">(%s)<span>', 'Invoiced <span class="count">(%s)<span>', 'ast-payment-gateways')
	));
}


add_filter('wc_order_statuses', 'my_new_wc_order_statuses');

//Register in Wc order status

function my_new_wc_order_statuses($order_statuses){
	$order_statuses['wc_invoiced'] = _x('Invoiced', 'Order status', 'ast-payment-gateways');
	return $order_statuses;
}


function ast_add_bulk_invoice_order_status(){
	global $post_type;

	if ($post_type == 'shop_order') {
		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('<option>').val('mark-invoiced').text('<?php _e('Change status to invoiced', 'ast-woo'); ?>').appendTo("select[name='action']");
					jQuery('<option>').val('mark-invoiced').text('<?php _e('Change status to invoiced', 'ast-woo'); ?>').appendTo("select[name='action2']");
				});
			</script>
		<?php 
	}
}

add_action("admin_footer", "ast_add_bulk_invoice_order_status");


// add_filter( 'manage_edit-shop_order_columns', 'wc_new_order_column' );

// function wc_new_order_column($columns){
//     $columns['my_column'] = 'Transaction Status';
//     return $columns;
// } 






