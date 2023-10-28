<?php
/**
 * Product widget.
 */

defined( 'ABSPATH' ) || exit;
?>

<div
    class="postpay-widget"
    data-type="product-one"
    data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
></div>
