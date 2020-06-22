<?php
/**
 * Postpay gateway
 */

defined( 'ABSPATH' ) || exit;

use Postpay\Exceptions\ApiException;

/**
 * Postpay gateway abstract class.
 */
abstract class WC_Postpay_Gateway extends WC_Payment_Gateway {

	/**
	 * Postpay adapter instance.
	 *
	 * @var WC_Postpay_Adapter
	 */
	protected $adapter;

	/**
	 * Number of instalments.
	 *
	 * @var int
	 */
	const NUM_INSTALMENTS = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->has_fields = true;
		$this->supports   = array( 'products', 'refunds' );

		$this->init_form_fields();
		$this->init_settings();

		$this->title       = $this->get_option( 'title' );
		$this->description = $this->get_option( 'description' );
		$this->theme       = $this->get_option( 'theme', 'light' );
		$this->sandbox     = 'yes' === $this->get_option( 'sandbox', 'yes' );
		$this->in_context  = 'yes' === $this->get_option( 'in_context', 'yes' );
		$this->debug       = 'yes' === $this->get_option( 'debug', 'no' );
		$this->css         = $this->get_option( 'css', '#payment ul li.payment_method_' . $this->id );
		$this->widget      = 'yes' === $this->get_option( str_replace( '-', '_', $this->id ) . '_widget', 'yes' );
		$this->token_param = $this->id . '-token';

		require_once WC_POSTPAY_DIR_PATH . 'includes/class-wc-postpay-api.php';

		new WC_Postpay_Api( $this->id );
		$this->adapter = new WC_Postpay_Adapter( $this );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		add_action( 'api_' . $this->id . '_capture', array( $this, 'capture' ), 10, 2 );
		add_action( 'api_' . $this->id . '_cancel', array( $this, 'cancel' ), 10, 2 );
	}

	/**
	 * Check if the gateway is available for use.
	 *
	 * @return bool
	 */
	public function is_available() {
		return (
			parent::is_available() &&
			! empty( $this->get_option( 'merchant_id' ) ) &&
			! empty( $this->get_secret_key() )
		);
	}

	/**
	 * Get secret key.
	 *
	 * @return string
	 */
	public function get_secret_key() {
		return $this->sandbox ? $this->get_option( 'sandbox_secret_key' ) : $this->get_option( 'secret_key' );
	}

	/**
	 * Build the payment fields area.
	 */
	public function payment_fields() {
		wc_postpay_script( 'wc-postpay-js' );
		wc_get_postpay_template( 'payment-fields.php', array( 'gateway' => $this ) );
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order id.
	 *
	 * @return array
	 */
	public function process_payment( $order_id ) {
		try {
			$response = $this->adapter->checkout( $order_id );
		} catch ( ApiException $e ) {
			wc_add_notice( $e->getMessage(), 'error' );
			return array( 'result' => 'failure' );
		}

		if ( $this->in_context ) {
			$order        = wc_get_order( $order_id );
			$pay_url      = $order->get_checkout_payment_url( true );
			$redirect_url = add_query_arg( $this->token_param, $response['token'], $pay_url );
		} else {
			if ( $this->sandbox ) {
				$host = 'checkout-sandbox.postpay.io';
			} else {
				$host = 'checkout.postpay.io';
			}
			$redirect_url = "https://$host/$response[token]";
		}

		return array(
			'result'   => 'success',
			'redirect' => $redirect_url,
		);
	}

	/**
	 * Capture an approved order.
	 *
	 * @param string $transaction_id Transaction id.
	 * @param string $order_key      Order key.
	 */
	public function capture( $transaction_id, $order_key ) {
		$order = $this->get_order( $transaction_id, $order_key );

		if ( $order && $order->needs_payment() ) {
			try {
				$this->adapter->capture( $transaction_id );
				$order->payment_complete( $transaction_id );
			} catch ( ApiException $e ) {
				$order->update_status( 'failed' );
				$order->add_order_note(
					sprintf( /* translators: %1$s: transaction id %2$s: error code */
						__( 'Postpay capture failed. ID: %1$s. Code: %2$s.', 'postpay' ),
						$transaction_id,
						$e->getErrorCode()
					)
				);
			}
			wp_safe_redirect( $this->get_return_url( $order ) );
			exit;
		}
		wc_add_notice( __( 'Postpay capture error.', 'postpay' ), 'error' );
		wp_safe_redirect( wc_get_checkout_url() );
	}

	/**
	 * Cancel a checkout.
	 *
	 * @param string $transaction_id Transaction id.
	 * @param string $order_key      Order key.
	 */
	public function cancel( $transaction_id, $order_key ) {
		$order = $this->get_order( $transaction_id, $order_key );

		if ( $order && $order->needs_payment() && ! empty( $_GET['status'] ) ) {
			$status = wc_clean( wp_unslash( $_GET['status'] ) );

			if ( 'CANCELLED' !== $status ) {
				$order->add_order_note(
					sprintf( /* translators: %1$s: order status %2$s: transaction id */
						__( 'Postpay order %1$s. ID: %2$s.', 'postpay' ),
						strtolower( $status ),
						$transaction_id
					)
				);
			}
		}
		wc_add_notice( __( 'Postpay order cancelled.', 'postpay' ) );
		wp_safe_redirect( wc_get_checkout_url() );
	}

	/**
	 * Process a refund if supported.
	 *
	 * @param int    $order_id Order ID.
	 * @param float  $amount Refund amount.
	 * @param string $reason Refund reason.
	 *
	 * @return bool|WP_Error
	 */
	public function process_refund( $order_id, $amount = null, $reason = '' ) {
		$order          = wc_get_order( $order_id );
		$transaction_id = $order->get_transaction_id();
		$refund_id      = $order_id . '-' . uniqid();

		try {
			$this->adapter->refund( $transaction_id, $refund_id, $amount, $reason );
		} catch ( ApiException $e ) {
			return new WP_Error(
				'error',
				sprintf( /* translators: %1$s: transaction id %2$s: error code */
					__( 'Postpay refund failed. ID: %1$s. Code: %2$s.', 'postpay' ),
					$transaction_id,
					$e->getErrorCode()
				)
			);
		} catch ( Exception $e ) {
			return new WP_Error( 'error', $e->getMessage() );
		}
		return true;
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public function load_scripts() {
		if ( $this->is_available() && is_checkout() && ! empty( $_GET[ $this->token_param ] ) ) {
			wc_postpay_js( $this->settings );

			wc_postpay_script(
				'wc-postpay-checkout',
				array( 'token' => wc_clean( wp_unslash( $_GET[ $this->token_param ] ) ) )
			);
		}
	}

	/**
	 * Get order instance.
	 *
	 * @param string $transaction_id Transaction id.
	 * @param string $order_key      Order key.
	 *
	 * @return bool|WC_Order|WC_Order_Refund
	 */
	protected function get_order( $transaction_id, $order_key ) {
		$order_id = explode( '-', $transaction_id )[0];
		$order    = wc_get_order( $order_id );

		if ( $order && $this->id === $order->get_payment_method() && hash_equals( $order->get_order_key(), $order_key ) ) {
			return $order;
		}
		return false;
	}
}
