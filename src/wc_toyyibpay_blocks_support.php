<?php
defined('ABSPATH') || exit;

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class WC_ToyyibPay_Blocks_Support extends AbstractPaymentMethodType {

    private $gateway;

    protected $name = 'toyyibpay';

    // Initializes the payment method type
    public function initialize() {

        $this->settings = get_option( 'woocommerce_toyyibpay_settings', array() );
		$this->gateway  = new WC_ToyyibPay_Gateway();

    }
	
	// Checks if the payment method is active and available for use
    public function is_active() {
        return $this->gateway->is_available();
    }

 
    // Scripts/handles to be registered for this payment method
    public function get_payment_method_script_handles() {

          
		wp_register_script( 'wc-toyyibpay-blocks-integration', TFW_PLUGIN_URL . '/assets/build/frontend/blocks.js', array(), TFW_PLUGIN_VER, true );

        return array( 'wc-toyyibpay-blocks-integration' );

    }

    private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
        define( $name, $value );
    }
    }

    // Data for payment method script
    public function get_payment_method_data() {

        return array(
            'name'        => $this->name,
            'title'       => $this->get_setting( 'title' ),
            'description' => $this->get_setting( 'description' ),
			'supports'    => array_filter( $this->gateway->supports, array( $this->gateway, 'supports' ) )
        );

    }

}
