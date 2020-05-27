<?php
/**
 * Customer request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customer request class.
 */
class WC_Postpay_Request_Customer {

	/**
	 * Build request.
	 *
	 * @param string $user_id User id.
	 *
	 * @return array
	 */
	public static function build( $user_id ) {
		$customer = new WC_Customer( $user_id );

		return array(
			'email'       => $customer->get_email(),
			'id'          => $customer->get_id(),
			'first_name'  => $customer->get_first_name(),
			'last_name'   => $customer->get_last_name(),
			'date_joined' => WC_Postpay_Adapter::datetime( $customer->get_date_created() ),
			'account'     => 'existing',
		);
	}
}
