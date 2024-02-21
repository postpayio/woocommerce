<?php
/**
 * Plugin Name: WooCommerce Postpay Payment Gateway
 * Version: 0.2.4
 * Plugin URI: https://github.com/postpayio/woocommerce
 * Description: Buy now and pay later with zero interest and zero fees.
 * Author: Postpay
 * Author URI: https://postpay.io
 * Developer: mongkok
 * Developer URI: https://github.com/mongkok
 *
 * Requires at least: 4.4
 * Tested up to: 6.4
 * WC requires at least: 3.0
 * WC tested up to: 4.1.1
 *
 * Text Domain: postpay
 * Domain Path: /languages
 *
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) || exit;

/**
 * Postpay main class.
 */
class WC_Postpay {

	/**
	 * Payment gateway id.
	 *
	 * @var string
	 */
	const PAYMENT_GATEWAY_ID = 'postpay';

	/**
	 * Payment gateway settings.
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * A log object returned by wc_get_logger().
	 *
	 * @var WC_Logger
	 */
	public static $log;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );

		define( 'WC_POSTPAY_FILE', __FILE__ );
		define( 'WC_POSTPAY_DIR_PATH', plugin_dir_path( __FILE__ ) );
		define( 'WC_POSTPAY_DIR_URL', plugin_dir_url( __FILE__ ) );
		define( 'WC_POSTPAY_VERSION', $plugin_data['Version'] );

		$this->settings = get_option( 'woocommerce_' . self::PAYMENT_GATEWAY_ID . '_settings' );
		$this->enabled  = 'yes' === $this->settings['enabled'] && ! empty( $this->settings['merchant_id'] );

		if ( ! class_exists( '\\Postpay\\Postpay' ) ) {
			require_once WC_POSTPAY_DIR_PATH . 'vendor/autoload.php';
		}

		require_once WC_POSTPAY_DIR_PATH . 'includes/wc-postpay-functions.php';
		require_once WC_POSTPAY_DIR_PATH . 'includes/http/class-wc-postpay-adapter.php';

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'plugin_action_links' ) );
		add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'load_gateways' ) );

		load_plugin_textdomain( 'postpay', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'woocommerce_single_product_summary', array( $this, 'product_widget' ), 20 );
		add_action( 'woocommerce_after_cart_totals', array( $this, 'cart_widget' ), 20 );
	}

	/**
	 * Add Postpay payment gateway.
	 *
	 * @param array $methods List of payment methods.
	 *
	 * @return array
	 */
	public static function load_gateways( $methods ) {
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			return;
		}

		include_once WC_POSTPAY_DIR_PATH . 'includes/gateways/class-wc-postpay-gateway.php';
		include_once WC_POSTPAY_DIR_PATH . 'includes/gateways/class-wc-postpay-pay-now.php';
		include_once WC_POSTPAY_DIR_PATH . 'includes/gateways/class-wc-postpay-split-payment.php';

		array_push( $methods, 'WC_Postpay_Pay_Now', 'WC_Postpay_Split_Payment' );
		return $methods;
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url(
				'admin.php?page=wc-settings&tab=checkout&section=' . self::PAYMENT_GATEWAY_ID
			) . '">' . __( 'Settings', 'postpay' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * Register/queue frontend scripts.
	 */
	public function load_scripts() {
		if ( $this->enabled && ! is_checkout() ) {
			wc_postpay_js( $this->settings );
		}
	}

	/**
	 * Render product widget.
	 */
	public function product_widget() {
		if ( $this->enabled && 'yes' === $this->settings['product_widget'] ) {
			wc_get_postpay_template( 'widgets/product.php' );
		}
	}

	/**
	 * Render cart widget.
	 */
	public function cart_widget() {
		if ( $this->enabled && 'yes' === $this->settings['cart_widget'] ) {
			wc_get_postpay_template( 'widgets/cart.php' );
		}
	}

	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param string $level   Optional. Default 'info'.
	 */
	public static function log( $message, $level = 'info' ) {
		if ( ! isset( self::$log ) ) {
			self::$log = wc_get_logger();
		}

		self::$log->log( $level, $message, array( 'source' => self::PAYMENT_GATEWAY_ID ) );
	}
}

new WC_Postpay();
