<?php
/**
 * Postpay scripts
 */

defined( 'ABSPATH' ) || exit;

return array(
	'wc-postpay-js'       => array(
		'src'     => 'https://cdn.postpay.io/v1/js/postpay.js',
		'deps'    => array(),
		'version' => WC_POSTPAY_VERSION,
	),
	'wc-postpay-init'     => array(
		'src'     => WC_POSTPAY_DIR_URL . 'assets/js/postpay.js',
		'deps'    => array( 'wc-postpay-js', 'jquery' ),
		'version' => WC_POSTPAY_VERSION,
	),
	'wc-postpay-checkout' => array(
		'src'     => WC_POSTPAY_DIR_URL . 'assets/js/checkout.js',
		'deps'    => array( 'wc-postpay-init' ),
		'version' => WC_POSTPAY_VERSION,
	),
);
