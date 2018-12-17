<?php
/**
 * Hooks for template search
 *
 * @package MrBara
 */

/**
 * Search products
 *
 * @since 1.0
 */
function mrbara_instance_search_result() {
	check_ajax_referer( '_mrbara_nonce', 'mbnonce' );

	$args_sku = array(
		'post_type'      => 'product',
		'posts_per_page' => 30,
		'meta_query'     => array(
			array(
				'key'     => '_sku',
				'value'   => trim( $_POST['term'] ),
				'compare' => 'like',
			),
		),
		'suppress_filters' => 0
	);

	$args_variation_sku = array(
		'post_type'      => 'product_variation',
		'posts_per_page' => 30,
		'meta_query'     => array(
			array(
				'key'     => '_sku',
				'value'   => trim( $_POST['term'] ),
				'compare' => 'like',
			),
		),
		'suppress_filters' => 0
	);

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 30,
		's'              => trim( $_POST['term'] ),
		'suppress_filters' => 0
	);

	if ( isset( $_POST['cat'] ) && $_POST['cat'] != '0' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $_POST['cat'],
			),
		);

		$args_sku['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $_POST['cat'],
			),
		);
	}

	$products_sku = get_posts( $args_sku );
	$products_s = get_posts( $args );
	$products_variation_sku = get_posts( $args_variation_sku );

	$response    = array();
	$products    = array_merge( $products_sku, $products_s, $products_variation_sku );
	$product_ids = array();
	foreach ( $products as $product ) {
		$id = $product->ID;
		if ( ! in_array( $id, $product_ids ) ) {
			$product_ids[] = $id;

			$productw   = new WC_Product( $id );
			$response[] = array(
				'label' => $productw->get_title(),
				'value' => $productw->get_permalink(),
				'price' => $productw->get_price_html(),
				'rate'  => $productw->get_rating_html(),
				'thumb' => $productw->get_image( 'shop_thumbnail' ),
			);
		}
	}


	if ( empty( $response ) ) {
		$response[] = array(
			'label' => esc_html__( 'Nothing found', 'mrbara' ),
			'value' => '#',
			'price' => '',
			'rate'  => '',
			'thumb' => '',
		);
	}

	wp_send_json_success( $response );
	die();
}

add_action( 'wp_ajax_search_products', 'mrbara_instance_search_result' );
add_action( 'wp_ajax_nopriv_search_products', 'mrbara_instance_search_result' );