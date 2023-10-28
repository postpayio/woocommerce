<?php
/**
 * Postpay Api
 */

defined( 'ABSPATH' ) || exit;

/**
 * Postpay Api dispatcher class.
 */
class WC_Postpay_Api {

	/**
	 * Constructor.
	 *
	 * @param WC_Postpay_Gateway $gateway Api identifier.
	 */
	public function __construct( $gateway ) {
		$this->gateway = $gateway;

		add_action( 'woocommerce_api_' . $this->gateway->id, array( $this, 'dispatch' ) );
	}

	/**
	 * Dispatch request.
	 */
	public function dispatch() {
		$tag = 'api_' . $this->gateway->id . '_' . wc_clean( wp_unslash( $_GET['action'] ) );

		if ( ! empty( $_GET['action'] ) && has_action( $tag ) ) {
			if ( method_exists( $this->gateway, 'dispatch' ) ) {
				$this->gateway->dispatch( $tag );
			} else {
				do_action( $tag );
			}
			exit;
		}

		wp_die( esc_html__( 'Invalid URL.', 'postpay' ) );
	}

	/**
	 * Create Api URL.
	 *
	 * @param string $action     Action to perform.
	 * @param string $gateway_id Postpay gateway id.
	 *
	 * @return string
	 */
	public static function get_url( $action, $gateway_id, $args = null ) {
		$url = add_query_arg( array( 'action' => $action ), WC()->api_request_url( $gateway_id ) );

		if ( ! is_null( $args ) ) {
			$url = add_query_arg( $args, $url );
		}
		return $url;
	}
}
