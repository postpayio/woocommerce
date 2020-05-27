<?php
/**
 * Product widget.
 */

defined( 'ABSPATH' ) || exit;

global $product;

$price = wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) );
?>

<div
	class="postpay-widget"
	data-type="product"
	data-amount="<?php echo WC_Postpay_Adapter::decimal( $price )->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
