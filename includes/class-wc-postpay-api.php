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
	 * @param string $id Api identifier.
	 */
	public function __construct( $id ) {
		$this->id = $id;

		add_action( 'woocommerce_api_' . $this->id, array( $this, 'dispatch' ) );
	}

	/**
	 * Dispatch request.
	 */
	public function dispatch() {
		if ( ! empty( $_GET['action'] ) && ! empty( $_GET['order_id'] ) && ! empty( $_GET['order_key'] ) ) {
			$tag = 'api_' . $this->id . '_' . wc_clean( wp_unslash( $_GET['action'] ) );

			if ( has_action( $tag ) ) {
				do_action(
					$tag,
					wc_clean( wp_unslash( $_GET['order_id'] ) ),
					wc_clean( wp_unslash( $_GET['order_key'] ) )
				);
				exit;
			}
		}

		wp_die( esc_html__( 'Invalid URL.', 'postpay' ) );
	}
}
