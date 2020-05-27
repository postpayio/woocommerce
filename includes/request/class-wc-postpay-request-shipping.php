<?php
/**
 * Shipping request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shipping request class.
 */
class WC_Postpay_Request_Shipping {

	/**
	 * Build request.
	 *
	 * @param WC_Order $order Order instance.
	 *
	 * @return array
	 */
	public static function build( $order ) {
		return array(
			'id'      => implode(
				',',
				array_map(
					function( $shipping_method ) {
						return $shipping_method->get_method_id();
					},
					$order->get_shipping_methods()
				)
			),
			'name'    => $order->get_shipping_method(),
			'amount'  => WC_Postpay_Adapter::decimal( $order->get_shipping_total() ),
			'address' => WC_Postpay_Request_Address::build( $order->get_address( 'shipping' ) ),
		);
	}
}
