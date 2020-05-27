<?php
/**
 * Postpay split payment gateway
 */

defined( 'ABSPATH' ) || exit;

/**
 * Postpay split payment gateway class.
 */
final class WC_Postpay_Split_Payment extends WC_Postpay_Gateway {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id                 = WC_Postpay::PAYMENT_GATEWAY_ID;
		$this->method_title       = __( 'Postpay Split Payment', 'postpay' );
		$this->method_description = __( 'Buy now and pay later with zero interest and zero fees.', 'postpay' );
		$this->order_button_text  = __( 'Proceed to Postpay', 'postpay' );

		parent::__construct();
		$this->icon = WC_POSTPAY_DIR_URL . 'assets/images/' . $this->id . '-' . $this->theme . '.png';
	}

	/**
	 * Initialise settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = include WC_POSTPAY_DIR_PATH . 'includes/settings/postpay-split-payment.php';
	}
}
