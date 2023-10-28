<?php
/**
 * Checkout request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Checkout request class.
 */
class WC_Postpay_Request_Checkout {

	/**
	 * Build request.
	 *
	 * @param string             $order_id Order id.
	 * @param WC_Postpay_Gateway $gateway  Postpay gateway instance.
	 *
	 * @return array
	 */
	public static function build( $order_id, $gateway ) {

		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-address.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-coupon.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-customer.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-guest.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-item.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-metadata.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-shipping.php';

		$order = wc_get_order( $order_id );

		$data = array(
			'order_id'        => $order_id . '-' . uniqid(),
			'total_amount'    => WC_Postpay_Adapter::decimal( $order->get_total() ),
			'tax_amount'      => WC_Postpay_Adapter::decimal( $order->get_total_tax() ),
			'currency'        => $order->get_currency(),
			'billing_address' => WC_Postpay_Request_Address::build( $order->get_address( 'billing' ) ),
			'customer'        => $customer,
			'items'           => array_map(
				function( $item ) use ( $order ) {
					return WC_Postpay_Request_Item::build( $order, $item );
				},
				array_values( $order->get_items() )
			),
			'discounts'       => array_map(
				'WC_Postpay_Request_Coupon::build',
				array_values( $order->get_items( 'coupon' ) )
			),
			'merchant'        => array(
				'confirmation_url' => $gateway->get_url( 'capture', $order ),
				'cancel_url'       => $gateway->get_url( 'cancel', $order ),
			),
			'metadata'        => WC_Postpay_Request_Metadata::build( $gateway ),
			'num_instalments' => $gateway::NUM_INSTALMENTS,
		);

		if ( is_user_logged_in() ) {
			$data['customer'] = WC_Postpay_Request_Customer::build( $order->get_user_id() );
		} else {
			$data['customer'] = WC_Postpay_Request_Guest::build( $order );
		}

		if ( $order->get_shipping_method() ) {
			$data['shipping'] = WC_Postpay_Request_Shipping::build( $order );
		}

		return $data;
	}
}
