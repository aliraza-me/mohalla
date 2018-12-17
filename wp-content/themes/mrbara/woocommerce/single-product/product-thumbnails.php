<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$attachment_ids = '';
if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
} else {
	$attachment_ids = $product->get_gallery_attachment_ids();
}

$video_position   = intval( get_post_meta( $product->get_id(), 'video_position', true ) );
$video_width      = 960;
$video_height     = 720;
$video_thumb      = get_post_meta( $product->get_id(), 'video_thumbnail', true );
$video_url        = get_post_meta( $product->get_id(), 'video_url', true );
$video_html       = '';
if ( $video_thumb ) {
	$video_thumb = wp_get_attachment_image( $video_thumb, 'shop_single' );
	// If URL: show oEmbed HTML
	if ( filter_var( $video_url, FILTER_VALIDATE_URL ) ) {
		$atts = array(
			'width'  => $video_width,
			'height' => $video_height
		);
		if ( $oembed = @wp_oembed_get( $video_url, $atts ) ) {
			$video_html = $oembed;
		} else {
			$atts = array(
				'src'    => $video_url,
				'width'  => $video_width,
				'height' => $video_height
			);

			$video_html = wp_video_shortcode( $atts );
		}
	}
	if ( $video_html ) {
		$video_html = '<div class="video-wrapper">' . $video_html . '</div>';
	}

	if ( $video_thumb ) {
		$video_html = sprintf(
			'<div class="woocommerce-product-gallery__image"><a href="#" data-href="%s" class="photoswipe video">%s</a></div>',
			esc_attr( $video_html ),
			$video_thumb
		);
	}
}

if ( ( $attachment_ids && has_post_thumbnail() ) || $video_thumb ) {
	$loop = 1;
	foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$image_title     = get_post_field( 'post_excerpt', $attachment_id );

		if ( intval( $video_position ) == $loop + 1 ) {
			echo $video_html;
		}

		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		$html = '<div class="woocommerce-product-gallery__image"><a class="photoswipe" href="' . esc_url( $full_size_image[0] ) . '">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
		$html .= '</a></div>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );

		$loop ++;
	}

	if ( $video_position > count( $attachment_ids ) ) {
		echo $video_html;
	}
}
