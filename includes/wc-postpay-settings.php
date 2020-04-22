<?php
/**
 * Settings for Postpay Gateway
 */

defined( 'ABSPATH' ) || exit;

return array(
	'enabled'            => array(
		'title'   => __( 'Enable/Disable', 'postpay' ),
		'type'    => 'checkbox',
		'label'   => __( 'Enable Postpay', 'postpay' ),
		'default' => 'yes',
	),
	'title'              => array(
		'title'       => __( 'Title', 'postpay' ),
		'type'        => 'text',
		'description' => __( 'This controls the title which the user sees during checkout.', 'postpay' ),
		'default'     => __( 'Postpay', 'postpay' ),
		'desc_tip'    => true,
	),
	'description'        => array(
		'title'       => __( 'Description', 'postpay' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the description which the user sees during checkout.', 'postpay' ),
		'default'     => __( 'Buy now and pay later with zero interest and zero fees.', 'postpay' ),
	),
	'merchant_id'        => array(
		'title'       => __( 'Merchant ID', 'postpay' ),
		'type'        => 'text',
		'description' => __( 'Get your Merchant ID from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'secret_key'         => array(
		'title'       => __( 'Secret Key', 'postpay' ),
		'type'        => 'password',
		'description' => __( 'Get your Secret Key from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'sandbox_secret_key' => array(
		'title'       => __( 'Sandbox Secret Key', 'postpay' ),
		'type'        => 'password',
		'description' => __( 'Get your Sandbox Secret Key from Postpay.', 'postpay' ),
		'default'     => '',
		'desc_tip'    => true,
	),
	'sandbox'            => array(
		'title'       => __( 'Postpay Sandbox', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Postpay Sandbox', 'postpay' ),
		'default'     => 'yes',
		'description' => __( 'Postpay sandbox can be used to test payments.', 'postpay' ),
	),
	'in_context'         => array(
		'title'       => __( 'In-Context Checkout', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable In-Context Checkout', 'postpay' ),
		'default'     => 'no',
		'description' => __( 'Checkout flow that keeps customers local to your website.', 'postpay' ),
	),
	'min_amount'         => array(
		'title'       => __( 'Minimum Order Amount', 'postpay' ),
		'type'        => 'number',
		'description' => __( 'Set a minimum order amount for Postpay checkout.', 'postpay' ),
	),
	'max_amount'         => array(
		'title'       => __( 'Maximum Order Amount', 'postpay' ),
		'type'        => 'number',
		'description' => __( 'Set a maximum order amount for Postpay checkout.', 'postpay' ),
	),
	'debug'              => array(
		'title'       => __( 'Debug log', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable logging', 'postpay' ),
		'default'     => 'no',
		'description' => __( 'Log Postpay events, such as HTTP requests.', 'postpay' ),
	),
	'product_widget'     => array(
		'title'       => __( 'Product Widget', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Product Widget', 'postpay' ),
		'default'     => 'no',
		'description' => __( 'Show a promotional message on product pages.', 'postpay' ),
	),
	'cart_widget'        => array(
		'title'       => __( 'Cart Widget', 'postpay' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable Cart Widget', 'postpay' ),
		'default'     => 'no',
		'description' => __( 'Show a promotional message on cart page.', 'postpay' ),
	),
);
