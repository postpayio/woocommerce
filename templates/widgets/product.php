<?php
/**
 * Product widget.
 */

defined( 'ABSPATH' ) || exit;
?>

<div
	class="postpay-widget"
	data-type="product"
	data-amount="<?php echo WC_Postpay_Adapter::decimal( $price )->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
