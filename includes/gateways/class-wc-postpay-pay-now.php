<?php
/**
 * Postpay pay now gateway
 */

defined( 'ABSPATH' ) || exit;

/**
 * Postpay pay now gateway class.
 */
final class WC_Postpay_Pay_Now extends WC_Postpay_Gateway {

	/**
	 * Number of instalments.
	 *
	 * @var int
	 */
	const NUM_INSTALMENTS = 1;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id                 = WC_Postpay::PAYMENT_GATEWAY_ID . '-pay-now';
		$this->method_title       = __( 'Postpay Pay Now', 'postpay' );
		$this->method_description = __( 'Accept payments using credit and debit cards.', 'postpay' );
		$this->order_button_text  = __( 'Pay Now', 'postpay' );
		$this->icon               = WC_POSTPAY_DIR_URL . 'assets/images/' . $this->id . '.png';

		parent::__construct();
	}

	/**
	 * Initialise settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = include WC_POSTPAY_DIR_PATH . 'includes/settings/postpay-pay-now.php';
	}
}
