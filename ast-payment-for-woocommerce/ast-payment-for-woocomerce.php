<?php

/**
 * @link              https://arsenaltech.com/
 * @since             1.0.0
 * @package           arsenaltech
 *
 * @wordpress-plugin
 * Plugin Name:       AST Payment for Woocommerce
 * Plugin URI:        https://arsenaltech.com/
 * Description:       Simple Payment gatways for woocommerce
 * Version:           1.0.0
 * Author:            Rakesh
 * Author URI:        https://arsenaltech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ast-woo
 * Domain Path:       /languages
**/



/**
 * Class WC_Gateway_Ast file.
 *
 * @package WooCommerce\Gateways
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Cash on Delivery Gateway.
 *
 * Provides a Cash on Delivery Payment Gateway.
 *
 * @class       WC_Gateway_Payleo
 * @extends     WC_Payment_Gateway
 * @version     0.1.0
 * @package     WooCommerce\Payleo file.
 */

if(! in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) return;

add_action('plugins_loaded', 'ast_payment_init', 11);

function ast_payment_init(){

    if( class_exists('WC_Payment_Gateway') ){

        require_once('includes/class-wp-payment-gateway-ast.php');
        require_once('includes/ast-order-statuses.php');
        require_once('includes/ast-checkout-description-fields.php');
        
    }
}//END ast_payment_init function


add_filter('woocommerce_payment_gateways', 'add_to_ast_payment_gateway');

function add_to_ast_payment_gateway($gayeways){

    $gateways[] = 'WC_Gateway_Ast';   //Calling Class 
    return $gateways;
}





