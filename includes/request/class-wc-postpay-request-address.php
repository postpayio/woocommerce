<?php
/**
 * Address request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Address request class.
 */
class WC_Postpay_Request_Address {

	/**
	 * Build request.
	 *
	 * @param array $address Raw address.
	 *
	 * @return array
	 */
	public static function build( $address ) {
		return array(
			'first_name'  => $address['first_name'],
			'last_name'   => $address['last_name'],
			'phone'       => empty( $address['phone'] ) ? '' : $address['phone'],
			'line1'       => $address['address_1'],
			'line2'       => $address['address_2'],
			'city'        => $address['city'],
			'state'       => $address['state'],
			'country'     => $address['country'],
			'postal_code' => empty( $field['postcode'] ) ? '' :
			wc_format_postcode( $address['postcode'], $address['country'] ),
		);
	}
}
