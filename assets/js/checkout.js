/**
 * Initializes In-Context Checkout.
 */

/* global wc_postpay_checkout_params */
jQuery( document ).ready(
	function( $ ) {
		postpay.checkout( wc_postpay_checkout_params.token );
	}
);
