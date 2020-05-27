<?php
/**
 * Guest request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Guest request class.
 */
class WC_Postpay_Request_Guest {

	/**
	 * Build request.
	 *
	 * @param WC_Order $order Order instance.
	 *
	 * @return array
	 */
	public static function build( $order ) {
		return array(
			'email'      => $order->get_billing_email(),
			'first_name' => $order->get_billing_first_name(),
			'last_name'  => $order->get_billing_last_name(),
			'account'    => 'guest',
		);
	}
}
