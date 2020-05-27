<?php
/**
 * Metadata request
 */

defined( 'ABSPATH' ) || exit;

/**
 * Metadata request class.
 */
class WC_Postpay_Request_Metadata {

	/**
	 * Build request.
	 *
	 * @param WC_Postpay_Gateway $gateway Postpay gateway instance.
	 *
	 * @return array
	 */
	public static function build( $gateway ) {
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
			'settings' => array(
				'in_context' => $gateway->in_context,
				'debug'      => $gateway->debug,
				'theme'      => $gateway->theme,
				'css'        => $gateway->css,
			),
		);
	}
}
