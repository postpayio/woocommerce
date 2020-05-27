<?php
/**
 * Postpay client
 */

defined( 'ABSPATH' ) || exit;

use Postpay\Exceptions\PostpayException;
use Postpay\Http\Request;
use Postpay\Http\Response;
use Postpay\HttpClients\ClientInterface;

/**
 * Postpay HTTP client class.
 */
class WC_Postpay_Client implements ClientInterface {

	/**
	 * Sends a request to the server and returns the response.
	 *
	 * @param \Postpay\Http\Request $request Request to send.
	 * @param int|null              $timeout The timeout for the request.
	 *
	 * @return Response
	 *
	 * @throws PostpayException If response status code is invalid.
	 */
	public function send( Request $request, $timeout = null ) {
		$options = array(
			'method'  => $request->getMethod(),
			'headers' => array_merge(
				array(
					'Authorization' => 'Basic ' . base64_encode(
						implode( ':', $request->getAuth() )
					),
				),
				$request->getHeaders()
			),
			'body'    => wp_json_encode( $request->json() ),
			'timeout' => $timeout,
		);

		$response = wp_remote_request( $request->getUrl(), $options );

		if ( is_wp_error( $response ) ) {
			throw new PostpayException(
				$response->get_error_message(),
				$response->get_error_code()
			);
		}

		return new Response(
			$request,
			wp_remote_retrieve_response_code( $response ),
			wp_remote_retrieve_headers( $response )->getAll(),
			wp_remote_retrieve_body( $response )
		);
	}
}
