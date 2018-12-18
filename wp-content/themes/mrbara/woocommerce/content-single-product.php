<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

$col_left            = 'col-md-5 col-sm-5 col-xs-12';
$col_right           = 'col-md-7 col-sm-7 col-xs-12';
$container           = 'container-full';
$product_page_layout = mrbara_theme_option( 'product_page_layout' );
if(  mrbara_theme_option( 'product_columns_mobile' ) == '2' ) {
	$col_left            = 'col-md-5 col-sm-12 col-xs-12';
	$col_right           = 'col-md-7 col-sm-12 col-xs-12';
}

if ( $product_page_layout == '3' ) {
	$col_left  = 'col-md-8 col-sm-12 col-xs-12';
	$col_right = 'col-md-4 col-sm-12 col-xs-12';
} elseif ( in_array( $product_page_layout, array( '4', '10' ) ) ) {
	$col_left  = 'col-md-6 col-sm-6 col-xs-12';
	$col_right = 'col-md-6 col-sm-6 col-xs-12';
} elseif ( $product_page_layout == '5' ) {
	$col_left  = 'col-md-12 col-sm-12 col-xs-12';
	$col_right = 'col-md-12 col-sm-12 col-xs-12';
} elseif ( $product_page_layout == '6' ) {
	$container = 'container';
	$col_left  = 'col-md-7 col-sm-7 col-xs-12';
	$col_right = 'col-md-5 col-sm-5 col-xs-12';
} elseif ( in_array( $product_page_layout, array( '7', '11' ) ) ) {
	$col_left  = 'col-md-5 col-sm-5 col-xs-12';
	$col_right = 'col-md-5 col-md-offset-2 col-sm-7 col-xs-12';
} elseif ( $product_page_layout == '8' ) {
	$col_left  = 'col-md-4 col-sm-4 col-xs-12';
	$col_right = 'col-md-8 col-sm-8 col-xs-12';
} elseif ( in_array( $product_page_layout, array( '9', '12' ) ) ) {
	$col_left  = 'col-md-6 col-sm-6 col-xs-12';
	$col_right = 'col-md-6 col-sm-6 col-xs-12';
}
$classes = '';

$class_layout = ' product-layout-' . mrbara_theme_option( 'product_page_layout' );

?>
<div itemscope id="product-<?php the_ID(); ?>" <?php function_exists('wc_product_class') ? wc_product_class( $classes ) : post_class( $classes ); ?>>
	<div class=" <?php echo esc_attr( $class_layout ); ?>">
		<div class="product-details">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="row">
					<div class="<?php echo esc_attr( $col_left ); ?> col-xs-12 product-images">
						<div class="product-images-content">
							<?php
							/**
							 * woocommerce_before_single_product_summary hook
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>
					</div>

					<div class="<?php echo esc_attr( $col_right ); ?> summary entry-summary ">
						<div class="entry-summary-content">
							<div class="entry-summary-sticky">
								<?php
								/**
								 * woocommerce_single_product_summary hook
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 */
								do_action( 'woocommerce_single_product_summary' );
							?>
							</div>


						</div>

					</div>
					<!-- .summary -->
				</div>
			</div>
		</div>


		<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</div>
<!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
