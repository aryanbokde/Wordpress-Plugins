<?php

class Ast_Custom_Post_Type_Woocommerce {

	public function IA_woocommerce_data_stores( $stores ) {
	    // the search is made for product-$post_type so note the required 'product-' in key name
	    $stores['product-event'] = 'IA_Data_Store_CPT';
	    return $stores;
	}

	public function IA_woo_product_class( $class_name ,  $product_type ,  $product_id ) {
	    if ($product_type == 'event')
	        $class_name = 'IA_Woo_Product';
	    return $class_name; 
	}

	public function my_woocommerce_product_get_price( $price, $product ) {

	    if ($product->get_type() == 'event' ) {
	        $old_price = intval(get_post_meta($product->id, "_price", true));	  
	        $percent = 20;
			$discount_value = ( $old_price * $percent) / 100;
			$price = $old_price - $discount_value; 
	    }
	    return $price;
	}


	public function my_woocommerce_product_get_stock( $stock, $product ) {

	    if ($product->get_type() == 'event' ) {
	        $stock = get_post_meta($product->id, "_availability", true);	        
	    }
	    return $stock;
	}

	// required function for allowing posty_type to be added; maybe not the best but it works
	public function IA_woo_product_type($false,$product_id) { 
	    if ($false === false) { // don't know why, but this is how woo does it
	        global $post;
	        // maybe redo it someday?!
	        if (is_object($post) && !empty($post)) { // post is set
	            if ($post->post_type == 'event' && $post->ID == $product_id) 
	                return 'event';
	            else {
	                $product = get_post( $product_id );
	                if (is_object($product) && !is_wp_error($product)) { // post not set but it's a event
	                    if ($product->post_type == 'event') 
	                        return 'event';
	                } // end if 
	            }    

	        } elseif(wp_doing_ajax()) { // has post set (usefull when adding using ajax)
	            $product_post = get_post( $product_id );
	            if ($product_post->post_type == 'event') 
	                return 'event';
	        } else { 
	            $product = get_post( $product_id );
	            if (is_object($product) && !is_wp_error($product)) { // post not set but it's a event
	                if ($product->post_type == 'event') 
	                    return 'event';
	            } // end if 

	        } // end if  // end if 



	    } // end if 
	    return false;
	}

	public function IA_woocommerce_checkout_create_order_line_item_object($item, $cart_item_key, $values, $order) {

	    $product = $values['data'];
	    if ($product->get_type() == 'event') {
	        return new IA_WC_Order_Item_Product();
	    } // end if 
	    return $item ;
	}   

	public function cod_woocommerce_checkout_create_order_line_item($item,$cart_item_key,$values,$order) {
	    if ($values['data']->get_type() == 'event') {
	        $item->update_meta_data( '_event', 'yes' ); // add a way to recognize custom post type in ordered items
	        // $item->update_meta_data( '_20%_discount', 'Yes' );
	        return;
	    } // end if 

	}

	public function IA_woocommerce_get_order_item_classname($classname, $item_type, $id) {
	    global $wpdb;
	    $is_IA = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE order_item_id = {$id} AND meta_key = '_event'");

	    if ('yes' === $is_IA) { // load the new class if the item is our custom post
	        $classname = 'IA_WC_Order_Item_Product';
	    } // end if 
	    return $classname;
	}

	public function ast_add_to_cart_button($content){
	    global $post;
	    if ($post->post_type !== 'event') {return $content; }
	    
	    ob_start();
	    ?>
	    <form action="" method="post">	    	
	        <input name="add-to-cart" type="hidden" value="<?php echo $post->ID ?>" />
	        <input name="quantity" type="number" value="1" min="1"  />
	        <input name="submit" type="submit" value="Add to cart" />
	    </form>
	    <?php
	    
	    return $content . ob_get_clean();
	}

	public function ast_add_woocommerce_notice_message(){

	    if (is_singular( 'event' )) {  
	        wc_print_notices();
	    }

	}

}









function register_myclass() {
	class IA_Woo_Product extends WC_Product  {

	    protected $post_type = 'event';

	    public function get_type() {
	        return 'event';
	    }

	    public function __construct( $product = 0 ) {
	        $this->supports[]   = 'ajax_add_to_cart';

	        parent::__construct( $product );


	    }
	    // maybe overwrite other functions from WC_Product

	}

	class IA_Data_Store_CPT extends WC_Product_Data_Store_CPT {

	    public function read( &$product ) { // this is required
	        $product->set_defaults();
	        $post_object = get_post( $product->get_id() );

	        if ( ! $product->get_id() || ! $post_object || 'event' !== $post_object->post_type ) {

	            throw new Exception( __( 'Invalid product.', 'woocommerce' ) );
	        }

	        $product->set_props(
	            array(
	                'name'              => $post_object->post_title,
	                'slug'              => $post_object->post_name,
	                'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
	                'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
	                'status'            => $post_object->post_status,
	                'description'       => $post_object->post_content,
	                'short_description' => $post_object->post_excerpt,
	                'parent_id'         => $post_object->post_parent,
	                'menu_order'        => $post_object->menu_order,
	                'reviews_allowed'   => 'open' === $post_object->comment_status,
	            )
	        );

	        $this->read_attributes( $product );
	        $this->read_downloads( $product );
	        $this->read_visibility( $product );
	        $this->read_product_data( $product );
	        $this->read_extra_data( $product );
	        $product->set_object_read( true );
	    }

	    // maybe overwrite other functions from WC_Product_Data_Store_CPT

	}


	class IA_WC_Order_Item_Product extends WC_Order_Item_Product {
	    public function set_product_id( $value ) {
	        if ( $value > 0 && 'event' !== get_post_type( absint( $value ) ) ) {
	            $this->error( 'order_item_product_invalid_product_id', __( 'Invalid product ID', 'woocommerce' ) );
	        }
	        $this->set_prop( 'product_id', absint( $value ) );
	    }

	}

}


















