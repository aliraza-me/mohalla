<?php
/**
 * Plugin Name: Soo Product Attribute Swatches
 * Plugin URI: http://soothemes.com/plugin/wc-product-attribute-swatches
 * Description: An extension of WooCommerce to make variation products more beauty and friendly with users.
 * Version: 1.0.3
 * Author: SooThemes
 * Author URI: http://soothemes.com/
 * Requires at least: 4.4
 * Tested up to: 4.5
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Soo_Product_Attribute_Swatch' ) ) :

/**
 * The main plugin class
 */
class Soo_Product_Attribute_Swatches {
	/**
	 * The single instance of the class
	 *
	 * @var Soo_Product_Attribute_Swatches
	 */
	protected static $instance = null;

	/**
	 * Extra attribute types
	 *
	 * @var array
	 */
	public $types = array();

	/**
	 * Main instance
	 *
	 * @return Soo_Product_Attribute_Swatches
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->types = array(
			'color' => esc_html__( 'Color', 'soopas' ),
			'image' => esc_html__( 'Image', 'soopas' ),
			'label' => esc_html__( 'Label', 'soopas' ),
		);

		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		require_once 'includes/class-admin.php';
		require_once 'includes/class-frontend.php';
	}

	/**
	 * Initialize hooks
	 */
	public function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );

		add_filter( 'product_attributes_type_selector', array( $this, 'add_attribute_types' ) );

		if ( is_admin() ) {
			add_action( 'init', array( 'Soo_Product_Attribute_Swatch_Admin', 'instance' ) );
		} else {
			add_action( 'init', array( 'Soo_Product_Attribute_Swatch_Frontend', 'instance' ) );
		}
	}

	/**
	 * Load plugin text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'soopas', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Add extra attribute types
	 * Add color, image and label type
	 *
	 * @param array $types
	 *
	 * @return array
	 */
	public function add_attribute_types( $types ) {
		$types = array_merge( $types, $this->types );

		return $types;
	}

	/**
	 * Get attribute's properties
	 *
	 * @param string $taxonomy
	 *
	 * @return object
	 */
	public function get_tax_attribute( $taxonomy ) {
		global $wpdb;

		$attr = substr( $taxonomy, 3 );
		$attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );

		return $attr;
	}

	/**
	 * Instance of admin
	 *
	 * @return Soo_Product_Attribute_Swatch_Admin
	 */
	public function admin() {
		return Soo_Product_Attribute_Swatch_Admin::instance();
	}

	/**
	 * Instance of frontend
	 *
	 * @return Soo_Product_Attribute_Swatch_Frontend
	 */
	public function frontend() {
		return Soo_Product_Attribute_Swatch_Frontend::instance();
	}
}

endif;

/**
 * Main instance of plugin
 *
 * @return Soo_Product_Attribute_Swatches
 */
function Soo_Product_Attribute_Swatches() {
	return Soo_Product_Attribute_Swatches::instance();
}

/**
 * Create global instance of plugin
 */
add_action( 'plugins_loaded', function() {
	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', function() {
			?>

			<div class="error">
				<p><?php esc_html_e( 'Soo Product Attribute Swatches is enabled but not effective. It requires WooCommerce in order to work.', 'soopas' ); ?></p>
			</div>

			<?php
		} );
	} else {
		Soo_Product_Attribute_Swatches();
	}
} );

