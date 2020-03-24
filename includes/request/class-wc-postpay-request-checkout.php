<?php
/**
 * Checkout request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Checkout request Class.
 */
class WC_Postpay_Request_Checkout {

	/**
	 * Build request.
	 *
	 * @param string $order_id Order id.
	 *
	 * @return array
	 */
	public static function build( $order_id ) {

		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-address.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-coupon.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-customer.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-guest.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-item.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-metadata.php';
		require_once plugin_dir_path( WC_POSTPAY_FILE ) . 'includes/request/class-wc-postpay-request-shipping.php';

		$order = wc_get_order( $order_id );

		if ( is_user_logged_in() ) {
			$customer = WC_Postpay_Request_Customer::build( $order->get_user_id() );
		} else {
			$customer = WC_Postpay_Request_Guest::build( $order );
		}

		return array(
			'order_id'        => $order_id . '-' . uniqid(),
			'total_amount'    => WC_Postpay_Adapter::decimal( $order->get_total() ),
			'tax_amount'      => WC_Postpay_Adapter::decimal( $order->get_total_tax() ),
			'currency'        => $order->get_currency(),
			'shipping'        => WC_Postpay_Request_Shipping::build( $order ),
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
				'confirmation_url' => self::get_url( 'capture', $order->get_order_key() ),
				'cancel_url'       => self::get_url( 'cancel', $order->get_order_key() ),
			),
			'metadata'        => WC_Postpay_Request_Metadata::build(),
		);
	}

	/**
	 * Create Api URL.
	 *
	 * @param string $action    Action to perform.
	 * @param string $order_key Order key.
	 *
	 * @return string
	 */
	public static function get_url( $action, $order_key ) {
		return add_query_arg(
			array(
				'action'    => $action,
				'order_key' => $order_key,
			),
			WC()->api_request_url( WC_Postpay::PAYMENT_GATEWAY_ID )
		);
	}
}
