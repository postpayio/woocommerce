<?php
/**
 * Coupon request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Coupon request class.
 */
class WC_Postpay_Request_Coupon {

	/**
	 * Build request.
	 *
	 * @param WC_Order_Item_Coupon $coupon Coupon applied.
	 *
	 * @return array
	 */
	public static function build( $coupon ) {
		return array(
			'code'   => $coupon->get_code(),
			'name'   => ( new WC_Coupon( $coupon->get_code() ) )->get_description(),
			'amount' => WC_Postpay_Adapter::decimal( $coupon->get_discount() ),
		);
	}
}
