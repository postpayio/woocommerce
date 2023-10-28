<?php
/**
 * Postpay ONE
 */

defined( 'ABSPATH' ) || exit;

/**
 * Postpay ONE gateway.
 */
class WC_Postpay_ONE {

	/**
	 * Postpay gateway instance.
	 *
	 * @var WC_Postpay_Gateway
	 */
	protected $gateway;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id = WC_Postpay::PAYMENT_GATEWAY_ID . '-one';
		$gateways = WC()->payment_gateways->get_available_payment_gateways();

		if ( $gateways ) {
			foreach ( $gateways as $gateway ) {
				if ( 
					$gateway->enabled == 'yes'
					&& is_subclass_of( $gateway, WC_Payment_Gateway )
					&& $gateway->is_available()
				) {
					$this->gateway = $gateway;
					break;
				}
			}
		}

		if ( isset( $this->gateway ) ) {
			$this->product_widget = 'yes' === $this->gateway->get_option( 'product_one_widget', 'yes' );

			require_once WC_POSTPAY_DIR_PATH . 'includes/class-wc-postpay-api.php';

			new WC_Postpay_Api( $this );
			add_action( 'api_' . $this->id . '_demo', array( $this, 'demo' ), 10, 2 );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'product_widget' ), 20 );
		}
	}

	public function demo() {
		$adapter = new WC_Postpay_Adapter( $this->$gateway );
		wp_die( $this->adapter->gateway->title );
	}

	/**
	 * Render product widget.
	 */
	public function product_widget() {
		if ( $this->product_widget ) {
			wc_get_postpay_template( 'widgets/one/product.php' );
		}
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public function load_scripts() {
		if ( $this->gateway->is_available() && is_product() && $this->product_widget ) {
			wc_postpay_script(
				'wc-postpay-one-product',
				array( 'demo_url' => WC_Postpay_Api::get_url( 'demo', $this->id ) )
			);
		}
	}
}
