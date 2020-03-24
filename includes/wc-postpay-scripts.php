<?php
/**
 * Scripts for Postpay Gateway
 */

defined( 'ABSPATH' ) || exit;

return array(
	'wc-postpay-js'       => array(
		'src'     => 'https://cdn.postpay.io/v1/js/postpay.js',
		'deps'    => array(),
		'version' => WC_POSTPAY_VERSION,
	),
	'wc-postpay-init'     => array(
		'src'     => plugin_dir_url( WC_POSTPAY_FILE ) . 'assets/js/postpay.js',
		'deps'    => array( 'wc-postpay-js', 'jquery' ),
		'version' => WC_POSTPAY_VERSION,
	),
	'wc-postpay-checkout' => array(
		'src'     => plugin_dir_url( WC_POSTPAY_FILE ) . 'assets/js/checkout.js',
		'deps'    => array( 'wc-postpay-init' ),
		'version' => WC_POSTPAY_VERSION,
	),
);
