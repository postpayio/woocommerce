<?php
/**
 * Postpay payment fields.
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( $gateway->widget ) : ?>
	<div
		class="postpay-widget"
		data-type="payment-summary"
		data-amount="<?php echo WC_Postpay_Adapter::decimal( WC()->cart->total )->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-country="<?php echo WC()->customer->get_shipping_country(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-hide-if-invalid="<?php echo $gateway->css; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
	></div>

	<script>
	jQuery( document ).ready(
		function( $ ) {
			postpay.ui.refresh();
		}
	);
	</script>
<?php else : ?>
	<p><?php echo wpautop( wptexturize( $gateway->get_description() ) ); // @codingStandardsIgnoreLine. ?></p>
<?php endif; ?>
