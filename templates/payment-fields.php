<?php
/**
 * Postpay payment fields.
 */

defined( 'ABSPATH' ) || exit;

// TODO: Instalment plan info WC()->cart->total.
?>

<p><?php echo wpautop( wptexturize( $gateway->get_description() ) ); // @codingStandardsIgnoreLine. ?></p>
