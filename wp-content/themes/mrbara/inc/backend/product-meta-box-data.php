<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package MrBara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mrbara_Meta_Box_Product_Data class.
 */
class Mrbara_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_meta_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {
		$product_data_tabs['attributes_extra'] = array(
			'label'  => esc_html__( 'Extra', 'mrbara' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;
		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';
		$this->create_product_meta_fields( $post->ID );
		echo '</div>';
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {
		if ( isset( $_POST['attributes_extra'] ) ) {
			$woo_data = $_POST['attributes_extra'];
			update_post_meta( $post_id, 'attributes_extra', $woo_data );
		}

		if ( isset( $_POST['custom_badges_text'] ) ) {
			$woo_data = $_POST['custom_badges_text'];
			update_post_meta( $post_id, 'custom_badges_text', $woo_data );
		}
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_meta_fields( $post_id ) {
		// Get attributes
		$attributes         = maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );
		$custom_badges_text = maybe_unserialize( get_post_meta( $post_id, 'custom_badges_text', true ) );

		if ( ! $attributes ) : ?>
			<div id="message" class="inline notice woocommerce-message">
				<p><?php esc_html_e( 'You need to add attributes on the Attributes tab.', 'mrbara' ); ?></p>
			</div>

		<?php else :
			$default_attributes = maybe_unserialize( get_post_meta( $post_id, 'attributes_extra', true ) );
			echo '<div class="options_group">';
			echo '<p class="form-field"><label>' . esc_html__( 'Product Attribute', 'mrbara' ) . '</label>' . wc_help_tip( esc_html__( 'Show the attribute in shop grid layout', 'mrbara' ) );
			echo '</p>';
			echo '<div class="mr-attribute-list" style="float: left; width: 100%"><ul class="wc-radios short">';
			echo '<li><input
				name="attributes_extra"
				value=""
				type="radio"
				' . checked( esc_attr( $default_attributes ), '', false ) . '
				/> ' . esc_html__( 'Default', 'mrbara' ) . '</li>';

			echo '<li><input
				name="attributes_extra"
				value="none"
				type="radio"
				' . checked( esc_attr( $default_attributes ), 'none', false ) . '
				/> ' . esc_html__( 'None', 'mrbara' ) . '</li>';

			foreach ( $attributes as $attribute ) {
				$options[sanitize_title( $attribute['name'] )] = wc_attribute_label( $attribute['name'] );

				echo '<li><input
				name="attributes_extra"
				value="' . sanitize_title( $attribute['name'] ) . '"
				type="radio"
				' . checked( esc_attr( $default_attributes ), sanitize_title( $attribute['name'] ), false ) . '
				/> ' . wc_attribute_label( $attribute['name'] ) . '</li>';
			}

			echo '</ul></div>';



			echo '</div>';

			echo '<div class="options_group">';
			echo '<p class="form-field"><label>' . esc_html__( 'Custom Badge Text', 'mrbara' ) . '</label>' . wc_help_tip( esc_html__( 'Enter this optional to show your badges.', 'mrbara' ) );

			echo '<input
				name="custom_badges_text"
				value="' . esc_attr($custom_badges_text) . '"
				type="text"
				class="short"/> ';
			echo '</p>';
			echo '</div>';

		endif;
	}
}