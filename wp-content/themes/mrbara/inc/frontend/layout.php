<?php
/**
 * Hooks for frontend display
 *
 * @package MrBara
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function mrbara_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add a class of layout style
	if ( intval( mrbara_theme_option( 'boxed_layout' ) ) && mrbara_theme_option( 'header_layout' ) != 'header-left' ) {
		$classes[] = 'boxed';

		if ( $boxed_width = mrbara_theme_option( 'boxed_layout_width' ) ) {
			$classes[] = 'boxed-' . $boxed_width;
		}
	}

	if ( mrbara_theme_option( 'mini_cart_button' ) == '2' ) {
		$classes[] = 'mini-cart-button-lines';
	}

	// Add a class of layout
	$classes[] = mrbara_get_layout();

	if ( is_home() && ! is_front_page() ) {
		$classes[] = 'blog-view-' . mrbara_theme_option( 'blog_view' );

		$classes[] = 'blog-navigation-' . mrbara_theme_option( 'blog_nav_type' );

		if ( mrbara_theme_option( 'blog_nav_type' ) == 'links' ) {
			$classes[] = 'blog-nav-view-' . mrbara_theme_option( 'blog_nav_view' );
		}
	}


	if ( mrbara_is_catalog() || ( function_exists( 'is_product' ) && is_product() ) || is_singular() ) {
		$product_item_layout = mrbara_theme_option( 'product_item_layout' );
		if ( function_exists( 'is_woocommerce' ) && $product_item_layout ) {

			$show_view = '';
			if ( mrbara_is_catalog() ) {
				$show_view = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : mrbara_theme_option( 'shop_view' );
			}

			if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
				$show_view = 'list';
			}

			if ( $show_view != 'list' ) {
				$classes[] = 'woocommerce product-item-layout-' . $product_item_layout;

				if ( $product_item_layout == 8 ) {
					if ( ! intval( mrbara_theme_option( 'product_item_cat' ) ) ) {
						$classes[] = 'disable-product-item-cat';
					}

					if ( ! intval( mrbara_theme_option( 'product_item_shadow' ) ) ) {
						$classes[] = 'disable-product-item-shadow';
					}
				}
			}

			if ( $product_item_layout == 3 && intval( mrbara_theme_option( 'product_item_center' ) ) ) {
				$classes[] = 'product-item-center';
			}
		}

		if ( mrbara_theme_option( 'product_grid_columns_mobile' ) == '2' ) {
			$classes[] = 'product-multi-columns-mobile';
		}
	}


	$header_layout = mrbara_theme_option( 'header_layout' );
	$header_style  = mrbara_theme_option( 'header_style' );
	if ( in_array( $header_style, array( '12', '13' ) ) ) {
		$header_style = '11';
	}
	if ( mrbara_is_homepage() ) {
		$classes[] = 'mrbara-template-homepage';
	}

	if ( $header_layout == 'header-top' ) {
		if ( $header_style == '2' ) {
			$classes[] = 'has-leftbar';
		} else {
			$header_search_type = mrbara_search_style();
			if ( $header_search_type ) {
				$classes[] = 'header-search-style-' . $header_search_type;
			}

			if ( mrbara_is_homepage() && ! in_array( $header_style, array( '8', '9', '10', '11' ) ) ) {
				if ( mrbara_theme_option( 'header_transparent' ) ) {

					$classes[] = 'header-transparent';

					if ( mrbara_theme_option( 'header_text_color' ) == 'dark' ) {
						$classes[] = 'header-text-dark';
					}
				}
			}


		}

		if ( in_array( $header_style, array( '8', '9', '10', '11' ) ) ) {
			if ( intval( mrbara_theme_option( 'topbar' ) ) ) {
				if ( mrbara_theme_option( 'topbar_skin' ) ) {
					$classes[] = 'topbar-dark';
				} else {
					$classes[] = 'topbar-light';
				}
			}
		}

		if ( $header_style == '10' ) {
			if ( $header_skin = mrbara_theme_option( 'header_skin' ) ) {
				$classes[] = 'header-skin-' . $header_skin;
			}
		}

		if ( $header_style == '5' ) {
			if ( $header_skin = mrbara_theme_option( 'header_width' ) == '2' ) {
				$classes[] = 'header-top-normal';
			}
		}

		$classes[] = 'header-top-style-' . $header_style;

		if ( mrbara_theme_option( 'header_sticky' ) ) {
			$classes[] = 'header-sticky';
		}

		if ( intval( mrbara_theme_option( 'promotion' ) ) ) {
			$classes[] = 'has-promotion';
		}

	} else {
		$header_style = mrbara_theme_option( 'header_left_style' );
		$classes[]    = 'header-left';
		$classes[]    = 'header-left-style-' . $header_style;
	}

	if ( mrbara_theme_option( 'mini_cart_content' ) || mrbara_theme_option( 'header_layout' ) == 'header-left' ) {
		$classes[] = 'header-cart-click';
	}

	if ( mrbara_is_catalog() ) {
		$classes[] = 'shop-navigation-' . mrbara_theme_option( 'navigation_type' );
		if ( $shop_skin = mrbara_theme_option( 'shop_skin' ) ) {
			$classes[] = 'shop-' . $shop_skin . '-skin';
		}

		if ( $widget_style = mrbara_theme_option( 'swidget_title_style' ) ) {
			$classes[] = 'shop-widget-title-style-' . $widget_style;
		}

		if ( $filter_layout = mrbara_theme_option( 'filter_layout' ) ) {
			$classes[] = 'shop-filter-layout-' . $filter_layout;
		}

		if ( intval( mrbara_theme_option( 'shop_width' ) ) == 2 ) {
			$classes[] = 'shop-full-width';
		}

		if ( is_shop() ) {
			if ( get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
				$classes[] = 'shop-subcategories';
				if ( mrbara_theme_option( 'shop_categories_layout' ) == 'grid' ) {
					$classes[] = 'shop-subcategories-grid';
				}
			} else {
				$view      = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : mrbara_theme_option( 'shop_view' );
				$classes[] = 'shop-view-' . $view;
			}
		} else {
			$view      = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : mrbara_theme_option( 'shop_view' );
			$classes[] = 'shop-view-' . $view;
		}

		if ( intval( mrbara_theme_option( 'product_cat_filter' ) ) ) {

			if ( is_product_category() ) {
				$queried_object = get_queried_object();
				if ( $queried_object ) {
					$term_id = $queried_object->term_id;
					$args    = array(
						'parent' => $term_id,
					);

					$categories = get_terms( 'product_cat', $args );

					if ( $categories ) {
						$classes[] = 'product-cat-filter';
					}
				}
			} elseif ( is_shop() ) {
				$classes[] = 'product-cat-filter';
			}
		}

		if ( $page_header_layout_shop = mrbara_theme_option( 'page_header_layout_shop' ) ) {
			$classes[] = 'page-header-shop-layout-' . $page_header_layout_shop;
		}

		$hide_page_header = false;
		if ( ( function_exists( 'is_shop' ) && is_shop() ) ) {
			$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
			if ( get_post_meta( $post_id, 'hide_page_header', true ) ) {
				$hide_page_header = true;
			}
		}

		if ( ! intval( mrbara_theme_option( 'page_header_shop' ) ) ) {
			$hide_page_header = true;
		}

		if ( $hide_page_header ) {
			$classes[] = 'post-no-page-header';
		} elseif ( mrbara_theme_option( 'page_header_layout_shop' ) == '2' && ! in_array( $header_style, array( '2', '8', '9', '10', '11' ) ) && $header_layout == 'header-top' ) {
			$classes[] = 'header-transparent';
		}

	} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {

		$classes[] = ' product-page-layout-' . mrbara_theme_option( 'product_page_layout' );

		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2', '4', '5', '6', '8', '9', '10', '12' ) ) ) {
			$classes[] = 'product-page-thumbnail-carousel';
		}

		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2', '8', '9', '12' ) ) ) {
			if ( intval( mrbara_theme_option( 'product_zoom' ) ) ) {
				$classes[] = ' product-page-images-zoom';
			}
		}

		$header_product_layout = mrbara_theme_option( 'page_header_layout_product' );
		$custom_header_product = intval( get_post_meta( get_the_ID(), 'hide_page_header', true ) );
		$header_product        = $custom_header_product ? ! $custom_header_product : intval( mrbara_theme_option( 'page_header_product' ) );

		if ( intval( get_post_meta( get_the_ID(), 'custom_page_header_layout', true ) ) ) {
			$header_product_layout = get_post_meta( get_the_ID(), 'page_header_layout', true );

		}

		if ( $header_product ) {
			if ( $header_product_layout == '3' && ! in_array( $header_style, array( '2', '8', '9', '10', '11' ) ) && $header_layout == 'header-top' ) {
				$classes[] = 'header-transparent';
			}
		}


		if ( intval( mrbara_theme_option( 'page_header_product' ) ) ) {
			$classes[] = 'page-header-product-layout-' . $header_product_layout;
		}

		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2' ) ) && mrbara_theme_option( 'product_columns_mobile' ) == '2' ) {
			$classes[] = ' product-page-mobile-2-columns';
		}

	} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
		$portfolio_layout = 'page-header-portfolio-layout-1';

		if ( mrbara_theme_option( 'portfolios_view' ) == 'grid' ) {
			$portfolio_layout = 'page-header-portfolio-layout-2';
		}

		$classes[] = $portfolio_layout;

		$classes[] = 'portfolio-' . mrbara_theme_option( 'portfolios_view' );
		$classes[] = 'portfolio-navigation-' . mrbara_theme_option( 'portfolio_nav_type' );

	} elseif ( is_page() ) {

		if ( $layout = mrbara_page_header_layout() ) {
			$classes[] = 'page-header-page-layout-' . $layout;

			if ( mrbara_page_header_bg() ) {
				$classes[] = 'page-header-page-has-background';
			}
		}

		if ( ! mrbara_is_homepage() ) {
			if ( intval( get_post_meta( get_the_ID(), 'hide_page_header', true ) ) ) {
				$classes[] = 'post-no-page-header';
			} elseif ( ! intval( mrbara_theme_option( 'page_header_pages' ) ) ) {
				$classes[] = 'post-no-page-header';
			}

			if ( mrbara_is_account_transparent() ) {
				$classes[] = 'my-account-page-transparent';
				$classes[] = 'header-transparent';
			}

			if ( intval( get_post_meta( get_the_ID(), 'header_transparent_page', true ) ) ) {
				$classes[] = 'header-transparent';
			}
		}

	} else {

		if ( is_404() && $header_layout == 'header-top' ) {
			$classes[] = 'header-transparent';
		} else {
			$classes[] = 'page-header-default-layout';
		}

		if ( ! is_singular( 'post' ) ) {
			if ( ! intval( mrbara_theme_option( 'page_header' ) ) ) {
				$classes[] = 'post-no-page-header';
			}
		}

		if ( is_singular( 'portfolio_project' ) ) {
			$portfolio_type = get_post_meta( get_the_ID(), '_project_type', true );
			$classes[]      = 'single-portfolio-type-' . $portfolio_type;
		}
	}

	// show newsletter popup
	if ( mrbara_theme_option( 'newsletter_popup' ) ) {
		$classes[] = 'show-newsletter-popup';
	}

	return $classes;
}

add_filter( 'body_class', 'mrbara_body_classes' );

/**
 * Print the open tags of site content container
 */
if ( ! function_exists( 'mrbara_open_site_content_container' ) ) :
	function mrbara_open_site_content_container() {
		if ( is_page_template( 'template-home-split.php' ) ) {
			return;
		}

		printf( '<div class="%s"><div class="row">', esc_attr( apply_filters( 'mrbara_site_content_container_class', mrbara_class_full_width() ) ) );
	}
endif;

add_action( 'mrbara_after_site_content_open', 'mrbara_open_site_content_container' );

/**
 * Print the close tags of site content container
 */
if ( ! function_exists( 'mrbara_close_site_content_container' ) ) :
	function mrbara_close_site_content_container() {
		if ( is_page_template( 'template-home-split.php' ) ) {
			return;
		}

		echo '</div></div><!-- .container -->';
	}
endif;

add_action( 'mrbara_before_site_content_close', 'mrbara_close_site_content_container' );