<?php
/**
 * Cart widget.
 */

defined( 'ABSPATH' ) || exit;

$amount = WC_Postpay_Adapter::decimal( WC()->cart->total );
?>

<div
	class="postpay-widget"
	data-type="cart"
	data-amount="<?php echo $amount->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
