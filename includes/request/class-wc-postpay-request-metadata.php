<?php
/**
 * Metadata request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Metadata request Class.
 */
class WC_Postpay_Request_Metadata {

	/**
	 * Build request.
	 *
	 * @return array
	 */
	public static function build() {
		global $wp_version;

		return array(
			'php'      => array(
				'version' => phpversion(),
			),
			'platform' => array(
				'wordpress'   => array(
					'version' => $wp_version,
				),
				'woocommerce' => array(
					'version' => WC_VERSION,
				),
			),
			'module'   => array(
				'package' => 'postpay/woocommerce',
				'version' => WC_POSTPAY_VERSION,
			),
		);
	}
}
