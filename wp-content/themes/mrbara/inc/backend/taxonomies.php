<?php
/**
 * Functions and Hooks for taxonomies
 *
 * @package MrBara
 */

if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Admin_Taxonomies class.
 */
class MrBara_Taxonomies {

	/**
	 * @var string placeholder image
	 */
	public $placeholder_img_src;

	/**
	 * Constructor.
	 */
	public function __construct() {

		if( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}

		$this->placeholder_img_src = get_template_directory_uri() . '/img/placeholder.png';
		// Add form
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 20, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 20, 3 );
	}

	/**
	 * Category thumbnail fields.
	 */
	public function add_category_fields() {
		?>
		<div class="form-field mr-product-cat-bg" id="product-cat-bg">
			<label><?php esc_html_e( 'Page Header Background', 'mrbara' ); ?></label>
			<div id="product_cat_bg" class="product-cat-img" data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>"><img src="<?php echo esc_url( $this->placeholder_img_src ); ?>" width="60px" height="60px" /></div>
			<div class="product-cat-bg-box">
				<input type="hidden" id="product_cat_bg_id" name="product_cat_bg_id" />
				<button type="button" class="upload_bg_image_button button"><?php esc_html_e( 'Upload/Add image', 'mrbara' ); ?></button>
				<button type="button" class="remove_bg_image_button button"><?php esc_html_e( 'Remove image', 'mrbara' ); ?></button>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Edit category thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public function edit_category_fields( $term ) {

		$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'page_header_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = $this->placeholder_img_src;
		}
		?>
		<tr class="form-field mr-product-cat-bg" id="product-cat-bg">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Page Header Background', 'mrbara' ); ?></label></th>
			<td>
				<div id="product_cat_bg" class="product-cat-img" data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>">
					<img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" />
				</div>
				<div class="product-cat-bg-box">
					<input type="hidden" id="product_cat_bg_id" name="product_cat_bg_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
					<button type="button" class="upload_bg_image_button button"><?php esc_html_e( 'Upload/Add image', 'mrbara' ); ?></button>
					<button type="button" class="remove_bg_image_button button"><?php esc_html_e( 'Remove image', 'mrbara' ); ?></button>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}

	/**
	 * save_category_fields function.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param string $taxonomy
	 */
	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['product_cat_bg_id'] ) && 'product_cat' === $taxonomy ) {
			update_woocommerce_term_meta( $term_id, 'page_header_id', absint( $_POST['product_cat_bg_id'] ) );
		}
	}
}