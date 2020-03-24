<?php
/**
 * Product widget.
 */

defined( 'ABSPATH' ) || exit;

global $product;

$price = WC_Postpay_Adapter::decimal(
	wc_get_price_including_tax( $product )
);
?>

<div
	class="postpay-widget"
	data-type="product"
	data-amount="<?php echo $price->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
