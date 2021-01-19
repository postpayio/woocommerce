<?php
/**
 * Cart widget.
 */

defined( 'ABSPATH' ) || exit;
?>

<div
	class="postpay-widget"
	data-type="cart"
	data-amount="<?php echo WC_Postpay_Adapter::decimal( WC()->cart->total )->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
