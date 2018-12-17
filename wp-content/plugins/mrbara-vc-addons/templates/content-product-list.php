<?php
	global $product;
?>

<li  class="col-md-12 col-sm-12 col-xs-12">
	<div class="product-list">
		<a class="product-thumbnail" href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php echo $product->get_image( apply_filters( 'mrbara_product_vertical_size', 'shop_catalog' ) ); ?>
			<?php do_action( 'mrbara_product_list_thumbnail' ) ?>
		</a>
		<div class="product-content">
		<?php
			$cat   = '';
			$terms = get_the_terms( get_the_ID(), 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$cat = sprintf( '<a href="%s" class="cat-link">%s</a>', esc_url( get_term_link( $terms[0]->term_id ), 'product_cat' ), $terms[0]->name );
			}
		?>
			<div class="product-cat"><?php echo $cat ?></div>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-title"><?php  echo $product->get_title(); ?></a>


		<?php
			if( function_exists( 'woocommerce_template_loop_price' ) ) {
				woocommerce_template_loop_price();
			}
		?>
		</div>
		<?php
			printf(
				'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="btn-add-to-cart button %s product_type_%s %s"><i class="ion-ios-plus-empty" data-original-title="%s" rel="tooltip"></i><span class="add-to-cart-title">%s</span></a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				esc_attr( $product->get_type() ),
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				esc_html( $product->add_to_cart_text() ),
				esc_html( $product->add_to_cart_text() )
			);
		?>
	</div>
</li>