/**
 * Initializes Postpay instance.
 */

/* global wc_postpay_init_params */
jQuery( document ).ready(
	function( $ ) {
		postpay.init( wc_postpay_init_params );
	}
);
