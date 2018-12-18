<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see           http://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post, $woocommerce;

if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {

	do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<table cellspacing="0" class="group_table">
			<thead>
			<tr>
				<th><?php esc_html_e( 'Product name', 'mrbara' ); ?></th>
				<th><?php esc_html_e( 'Price', 'mrbara' ); ?></th>
				<th><?php esc_html_e( 'Quantity', 'mrbara' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$quantites_required = false;

			foreach ( $grouped_products as $grouped_product ) {
				$post_object        = get_post( $grouped_product->get_id() );
				$quantites_required = $quantites_required || ( $grouped_product->is_purchasable() && ! $grouped_product->has_options() );

				setup_postdata( $GLOBALS['post'] =& $post_object );
				?>
				<tr id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
					<td class="product-name">
						<label for="product-<?php echo $grouped_product->get_id(); ?>">
							<?php echo $product->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $grouped_product->get_id() ) ) . '">' . get_the_title() . '</a>' : get_the_title(); ?>
						</label>
					</td>
					<td class="product-price">
						<?php
						echo $grouped_product->get_price_html();
						echo wc_get_stock_html( $grouped_product );
						?>
					</td>
					<td class="product-qty">
						<?php if ( ! $grouped_product->is_purchasable() || $grouped_product->has_options() ) : ?>
							<?php woocommerce_template_loop_add_to_cart(); ?>

						<?php elseif ( $grouped_product->is_sold_individually() ) : ?>
							<input type="checkbox" name="<?php echo esc_attr( 'quantity[' . $grouped_product->get_id() . ']' ); ?>" value="1" class="wc-grouped-product-add-to-cart-checkbox" />

						<?php else : ?>
							<?php
							/**
							 * @since 3.0.0.
							 */
							do_action( 'woocommerce_before_add_to_cart_quantity' );

							woocommerce_quantity_input(
								array(
									'input_name'  => 'quantity[' . $grouped_product->get_id() . ']',
									'input_value' => isset( $_POST['quantity'][$grouped_product->get_id()] ) ? wc_stock_amount( $_POST['quantity'][$grouped_product->get_id()] ) : 0,
									'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product ),
									'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product ),
								)
							);

							/**
							 * @since 3.0.0.
							 */
							do_action( 'woocommerce_after_add_to_cart_quantity' );
							?>
						<?php endif; ?>
					</td>
					<?php do_action( 'woocommerce_grouped_product_list_before_price', $grouped_product ); ?>
				</tr>
				<?php
			}
			wp_reset_postdata();
			?>
			</tbody>
		</table>

		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

		<?php if ( $quantites_required ) : ?>

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<div class="single-add-to-cart-btn">
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
				<span class="loading-icon">
					<span class="bubble">
						<span class="dot"></span>
					</span>
					<span class="bubble">
						<span class="dot"></span>
					</span>
					<span class="bubble">
						<span class="dot"></span>
					</span>
				</span>
			</div>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<?php endif; ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' );

} else {

	$parent_product_post = $post;

	do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<table cellspacing="0" class="group_table">
			<thead>
			<tr>
				<th><?php esc_html_e( 'Product name', 'mrbara' ); ?></th>
				<th><?php esc_html_e( 'Price', 'mrbara' ); ?></th>
				<th><?php esc_html_e( 'Quantity', 'mrbara' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $grouped_products as $product_id ) :
				if ( ! $product = wc_get_product( $product_id ) ) {
					continue;
				}

				if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && ! $product->is_in_stock() ) {
					continue;
				}

				$post = $product->post;
				setup_postdata( $post );
				?>
				<tr>
					<td class="product-name">
						<label for="product-<?php echo esc_attr( $product_id ); ?>">
							<?php echo $product->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $product_id ) ) . '">' . esc_html( get_the_title() ) . '</a>' : esc_html( get_the_title() ); ?>
						</label>
					</td>

					<?php do_action( 'woocommerce_grouped_product_list_before_price', $product ); ?>

					<td class="product-price">
						<?php
						echo $product->get_price_html();
						?>
					</td>

					<td class="product-qty">
						<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
							<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php else : ?>
							<?php
							$quantites_required = true;
							woocommerce_quantity_input(
								array(
									'input_name'  => 'quantity[' . $product_id . ']',
									'input_value' => ( isset( $_POST['quantity'][$product_id] ) ? wc_stock_amount( $_POST['quantity'][$product_id] ) : 0 ),
									'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
									'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
								)
							);
							?>
						<?php endif; ?>
					</td>

				</tr>
				<?php
			endforeach;

			// Reset to parent grouped product
			$post    = $parent_product_post;
			$product = wc_get_product( $parent_product_post->ID );
			setup_postdata( $parent_product_post );
			?>
			</tbody>
		</table>

		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

		<?php if ( $quantites_required ) : ?>

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<?php endif; ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php } ?>