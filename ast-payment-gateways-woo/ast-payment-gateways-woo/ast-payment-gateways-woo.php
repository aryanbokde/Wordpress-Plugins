<?php
/*
 * Plugin Name: Ast Payment Gateways Woo
 * Plugin URI: https://arsenaltech.com/
 * Description: Take debit card payments on your store.
 * Author: ArsenalTech
 * Author URI: https://arsenaltech.com/
 * Version: 1.0.1
 */


/*
 * Check if woocommerce exists or not.
 */

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;


add_action( 'plugins_loaded', 'initialize_gateway_class' );
function initialize_gateway_class() {
    class WC_Ast_Payment_Gateway extends WC_Payment_Gateway {
        
        public function __construct() {

            $this->id = 'ast'; // payment gateway ID
            $this->icon = apply_filters('woocommerce_ast_icon', plugin_dir_url( __FILE__ ) . 'assets/img/icon.png'); // payment gateway icon
            $this->has_fields = true; // for custom credit card form
            $this->title = __( 'AST Gateway', 'arsenalTech' ); // vertical tab title
            $this->method_title = __( 'AST Gateway', 'arsenalTech' ); // payment method name
            $this->method_description = __( 'Custom AST payment gateway', 'arsenalTech' ); // payment method description

            //$this->supports = array( 'default_credit_card_form' );

            // load backend options fields
            $this->init_form_fields();

            // load the settings.
            $this->init_settings();
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled = $this->get_option( 'enabled' );
            $this->test_mode = 'yes' === $this->get_option( 'test_mode' );
            $this->private_key = $this->test_mode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
            $this->publish_key = $this->test_mode ? $this->get_option( 'test_publish_key' ) : $this->get_option( 'publish_key' );

            // Action hook to saves the settings
            if(is_admin()) {
                  add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            // Action hook to load custom JavaScript
            //add_action( 'wp_enqueue_scripts', array( $this, 'payment_gateway_scripts' ) );
            
        }


        public function init_form_fields(){

            $this->form_fields = array(
                'enabled' => array(
                    'title'       => __( 'Enable/Disable', 'arsenalTech' ),
                    'label'       => __( 'Enable AST Gateway', 'arsenalTech' ),
                    'type'        => 'checkbox',
                    'description' => __( 'This enable the AST Gateway which allow to accept payment through creadit card.', 'arsenalTech' ),
                    'default'     => 'no',
                    'desc_tip'    => true
                ),
                'title' => array(
                    'title'       => __( 'Title', 'arsenalTech'),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'arsenalTech' ),
                    'default'     => __( 'Credit Card', 'arsenalTech' ),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __( 'Description', 'arsenalTech' ),
                    'type'        => 'textarea',
                    'description' => __( 'This controls the description which the user sees during checkout.', 'arsenalTech' ),
                    'default'     => __( 'Pay with your credit card via our super-cool payment gateway.', 'arsenalTech' ),
                ),
                'test_mode' => array(
                    'title'       => __( 'Test mode', 'arsenalTech' ),
                    'label'       => __( 'Enable Test Mode', 'arsenalTech' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Place the payment gateway in test mode using test API keys.', 'arsenalTech' ),
                    'default'     => 'yes',
                    'desc_tip'    => true,
                ),
                'test_publish_key' => array(
                    'title'       => __( 'Test Publish Key', 'arsenalTech' ),
                    'type'        => 'text'
                ),
                'test_private_key' => array(
                    'title'       => __( 'Test Private Key', 'arsenalTech' ),
                    'type'        => 'password',
                ),
                'publish_key' => array(
                    'title'       => __( 'Live Publish Key', 'arsenalTech' ),
                    'type'        => 'text'
                ),
                'private_key' => array(
                    'title'       => __( 'Live Private Key', 'arsenalTech' ),
                    'type'        => 'password'
                )
            );
        }

        public function payment_scripts() {

            // we need JavaScript to process a token only on cart/checkout pages, right?
            if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
                return;
            }

            // if our payment gateway is disabled, we do not have to enqueue JS too
            if ( 'no' === $this->enabled ) {
                return;
            }

            // no reason to enqueue JavaScript if API keys are not set
            if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
                return;
            }

            // do not work with card detailes without SSL unless your website is in a test mode
            if ( ! $this->testmode && ! is_ssl() ) {
                return;
            }

            // let's suppose it is our payment processor JavaScript that allows to obtain a token
            wp_enqueue_script( 'misha_js', 'https://www.mishapayments.com/api/token.js' );

            // and this is our custom JS in your plugin directory that works with token.js
            wp_register_script( 'woocommerce_misha', plugins_url( 'misha.js', __FILE__ ), array( 'jquery', 'misha_js' ) );

            // in most payment processors you have to use PUBLIC KEY to obtain a token
            wp_localize_script( 'woocommerce_misha', 'misha_params', array(
                'publishableKey' => $this->publishable_key
            ) );

            wp_enqueue_script( 'woocommerce_misha' );

        }


    }
}



add_filter( 'woocommerce_payment_gateways', 'add_custom_gateway_class' );
function add_custom_gateway_class( $gateways ) {
    $gateways[] = 'WC_Ast_Payment_Gateway'; // payment gateway class name
    return $gateways;
}