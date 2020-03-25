<?php
/**
 * Postpay functions
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the script and inject parameters.
 *
 * @param string     $handle Script handle the data will be attached to.
 * @param array|null $params Parameters injected.
 */
function wc_postpay_script( $handle, $params = null ) {
	$script = ( include 'wc-postpay-scripts.php' )[ $handle ];

	wp_enqueue_script( $handle, $script['src'], $script['deps'], $script['version'], true );

	if ( null !== $params ) {
		wp_localize_script( $handle, str_replace( '-', '_', $handle ) . '_params', $params );
	}
}

/**
 * Get Postpay template.
 *
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 */
function wc_get_postpay_template( $template_name, $args = array(), $template_path = '' ) {
	wc_get_template( $template_name, $args, $template_path, WC_POSTPAY_DIR_PATH . 'templates/' );
}
