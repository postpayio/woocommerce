<?php
/**
 * Postpay payment fields.
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( $gateway->widget && ! isset( $_GET['pay_for_order'] ) ) : ?>
	<div
		class="<?php echo $gateway->id; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>-widget"
		data-type="payment-summary"
		data-amount="<?php echo WC_Postpay_Adapter::decimal( WC()->cart->total )->jsonSerialize(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-currency="<?php echo get_woocommerce_currency(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-country="<?php echo WC()->customer->get_billing_country(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-locale="<?php echo get_locale(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-hide-if-invalid="<?php echo $gateway->css; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-merchant-id="<?php echo $gateway->get_option( 'merchant_id' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-sandbox="<?php echo $gateway->sandbox; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		data-theme="<?php echo $gateway->theme; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		<?php if ( null !== $gateway::NUM_INSTALMENTS ) : ?>
		data-num-instalments="<?php echo $gateway::NUM_INSTALMENTS; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>"
		<?php endif; ?>
	></div>

	<script>
	jQuery( document ).ready(
		function( $ ) {
			postpay.ui.refresh( '.<?php echo $gateway->id; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>-widget' );
		}
	);
	</script>
<?php else : ?>
	<p><?php echo wpautop( wptexturize( $gateway->get_description() ) ); // @codingStandardsIgnoreLine. ?></p>
<?php endif; ?>
