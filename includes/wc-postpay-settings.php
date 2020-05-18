<?php
/**
 * Settings for Postpay Gateway
 */

defined( 'ABSPATH' ) || exit;

return array(
	'enabled'               => array(
		'title'   => __( 'Enable/Disable', 'postpay' ),
		'type'    => 'checkbox',
		'label'   => __( 'Enable Postpay', 'postpay' ),
		'default' => 'yes',
	),
	'title'                 => array(
		'title'       => __( 'Title', 'postpay' ),
		'type'        => 'text',
		'description' => __( 'This controls the title which the user sees during checkout.', 'postpay' ),
		'default'     => __( 'Instalments with Postpay', 'postpay' ),
		'desc_tip'    => true,
	),
	'description'           => array(
		'title'       => __( 'Description', 'postpay' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the description which the user sees during checkout.', 'postpay' ),
		'default'     => __( 'Buy now and pay later with zero interest and zero fees.', 'postpay' ),
	),
	'theme'                 => array(
		'title'       => __( 'Theme', 'postpay' ),
		'type'        => 'select',
		'desc_tip'    => true,
		'description' => __( 'This controls the color to coordinate and contrast with different backgrounds.', 'postpay' ),
		'default'     => 'light',
		'options'     => array(
			'light' => __( 'Light', 'postpay' ),
			'dark'  => __( 'Dark', 'postpay' ),
		),
	),
	'merchant_id'           => array(
		'title'       => __( 'Merchant ID', 'postpay' ),
		'type'        => 'text',
		'description' => __( 'Get your Merchant ID from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'secret_key'            => array(
		'title'       => __( 'Secret Key', 'postpay' ),
		'type'        => 'password',
		'description' => __( 'Get your Secret Key from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'sandbox_secret_key'    => array(
		'title'       => __( 'Sandbox Secret Key', 'postpay' ),
		'type'        => 'password',
		'description' => __( 'Get your Sandbox Secret Key from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'sandbox'               => array(
		'title'       => __( 'Postpay Sandbox', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Postpay Sandbox', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Postpay sandbox can be used to test payments.', 'postpay' ),
	),
	'in_context'            => array(
		'title'       => __( 'In-Context Checkout', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable In-Context Checkout', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Checkout flow that keeps customers local to your website.', 'postpay' ),
	),
	'debug'                 => array(
		'title'       => __( 'Debug log', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable logging', 'postpay' ),
		'default'     => 'no',
		'description' => __( 'Log Postpay events, such as HTTP requests.', 'postpay' ),
	),
	'product_widget'        => array(
		'title'       => __( 'Product Widget', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Product Widget', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Show a promotional message on product pages.', 'postpay' ),
	),
	'cart_widget'           => array(
		'title'       => __( 'Cart Widget', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Cart Widget', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Show a promotional message on cart page.', 'postpay' ),
	),
	'payment_summary_widget' => array(
		'title'       => __( 'Payment summary widget', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable payment summary widget', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Show the payment summary on the payment method selection.', 'postpay' ),
	),
	'css'                   => array(
		'title'       => __( 'CSS selector', 'postpay' ),
		'type'        => 'text',
		'description' => __( 'Selector to hide the payment method if it is not available.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
);
