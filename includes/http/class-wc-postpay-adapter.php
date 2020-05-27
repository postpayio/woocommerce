<?php
/**
 * Postpay adapter
 */

defined( 'ABSPATH' ) || exit;

use Postpay\Exceptions\ApiException;
use Postpay\Postpay;

/**
 * Postpay adapter class.
 */
class WC_Postpay_Adapter {

	/**
	 * Postpay gateway instance.
	 *
	 * @var WC_Postpay_Gateway
	 */
	protected $gateway;

	/**
	 * Postpay client instance.
	 *
	 * @var Postpay
	 */
	protected $client;

	/**
	 * Constructor.
	 *
	 * @param WC_Postpay_Gateway $gateway Postpay gateway instance.
	 */
	public function __construct( $gateway ) {
		$this->gateway = $gateway;

		require_once WC_POSTPAY_DIR_PATH . 'includes/http/class-wc-postpay-client.php';

		if ( $this->gateway->is_available() ) {
			$this->client = new Postpay(
				array(
					'sandbox'        => $gateway->sandbox,
					'merchant_id'    => $gateway->get_option( 'merchant_id' ),
					'secret_key'     => $gateway->get_secret_key(),
					'client_handler' => new WC_Postpay_Client(),
				)
			);
		}
	}

	/**
	 * Send a request and return the response.
	 *
	 * @param string $method HTTP method.
	 * @param string $path   Path of the url.
	 * @param array  $params Request parameters.
	 *
	 * @return array
	 *
	 * @throws Exception If payment method is not properly configured.
	 * @throws ApiException If response status code is invalid.
	 */
	public function request( $method, $path, $params = array() ) {
		if ( ! $this->gateway->is_available() ) {
			throw new Exception( __( 'Postpay is not properly configured.', 'postpay' ) );
		}

		try {
			$response = $this->client->request( $method, $path, $params );
		} catch ( ApiException $e ) {
			$response = $e->getResponse();
			WC_Postpay::log( $path . ': ' . $e->getMessage(), 'critical' );
			throw $e;
		} finally {
			if ( $this->gateway->debug ) {
				$log = array(
					'path'     => $path,
					'request'  => $params,
					'response' => $response->json(),
				);
				WC_Postpay::log( wc_print_r( $log, true ), 'debug' );
			}
		}
		return $response->json();
	}

	/**
	 * Send a POST request and return the response.
	 *
	 * @param string $path   Path of the url.
	 * @param array  $params Request parameters.
	 *
	 * @return array
	 *
	 * @throws Exception If payment method is not properly configured.
	 * @throws ApiException If response status code is invalid.
	 */
	public function post( $path, $params = array() ) {
		return $this->request( 'POST', $path, $params );
	}

	/**
	 * Create a checkout using given parameters.
	 *
	 * @param string $order_id Order id.
	 *
	 * @return array
	 *
	 * @throws Exception If payment method is not properly configured.
	 * @throws ApiException If response status code is invalid.
	 */
	public function checkout( $order_id ) {
		require_once WC_POSTPAY_DIR_PATH . 'includes/request/class-wc-postpay-request-checkout.php';
		return $this->post( '/checkouts', WC_Postpay_Request_Checkout::build( $order_id, $this->gateway ) );
	}

	/**
	 * Capture an order.
	 *
	 * @param string $id Transaction id.
	 *
	 * @return array
	 *
	 * @throws Exception If payment method is not properly configured.
	 * @throws ApiException If response status code is invalid.
	 */
	public function capture( $id ) {
		return $this->post( '/orders/' . $id . '/capture' );
	}

	/**
	 * Refund a capture transaction.
	 *
	 * @param string $id          Transaction id.
	 * @param string $refund_id   Refund id.
	 * @param float  $amount      Amount to refund.
	 * @param string $description Refund description.
	 *
	 * @return array
	 *
	 * @throws Exception If payment method is not properly configured.
	 * @throws ApiException If response status code is invalid.
	 */
	public function refund( $id, $refund_id, $amount, $description ) {
		if ( null !== $amount ) {
			$amount = self::decimal( $amount );
		}
		$params = array(
			'refund_id'   => $refund_id,
			'amount'      => $amount,
			'description' => $description,
		);
		return $this->post( '/orders/' . $id . '/refunds', $params );
	}

	/**
	 * Convert float to JSON serializable instance.
	 *
	 * @param float $value Float value.
	 *
	 * @return Decimal
	 */
	public static function decimal( $value ) {
		return \Postpay\Serializers\Decimal::fromFloat( $value );
	}

	/**
	 * Convert datetime to JSON serializable instance.
	 *
	 * @param string $value Datetime value.
	 *
	 * @return Date
	 */
	public static function datetime( $value ) {
		return \Postpay\Serializers\Date::fromDateTime( new DateTime( $value ) );
	}
}
