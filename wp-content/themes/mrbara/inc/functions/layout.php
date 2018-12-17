<?php
/**
 * Custom functions for layout.
 *
 * @package MrBara
 */

/**
 * Get layout base on current page
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_get_layout' ) ) :
	function mrbara_get_layout() {
		$layout = mrbara_theme_option( 'default_layout' );

		if ( is_singular() && get_post_meta( get_the_ID(), 'custom_layout', true ) ) {
			$layout = get_post_meta( get_the_ID(), 'layout', true );
		} elseif ( mrbara_is_catalog() ) {
			$layout = mrbara_theme_option( 'shop_layout' );
		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			$layout = 'full-content';
			if ( mrbara_theme_option( 'product_page_layout' ) == '1' ) {
				$layout = 'content-sidebar';
			} elseif ( mrbara_theme_option( 'product_page_layout' ) == '2' ) {
				$layout = 'sidebar-content';
			}
		} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			$layout = mrbara_theme_option( 'portfolio_layout' );
		} elseif ( is_page() ) {
			$layout = mrbara_theme_option( 'page_layout' );
		} elseif ( is_404() ) {
			$layout = 'full-content';
		} elseif ( is_search() ) {
			$layout = 'full-content';
		}

		return $layout;
	}
endif;

/**
 * Get Bootstrap column classes for content area
 *
 * @since  1.0
 *
 * @return array Array of classes
 */
if ( ! function_exists( 'mrbara_get_content_columns' ) ) :
	function mrbara_get_content_columns( $layout = null ) {
		$layout = $layout ? $layout : mrbara_get_layout();

		$classes = array( 'col-md-9', 'col-sm-12', 'col-xs-12' );

		if ( mrbara_class_full_width() == 'mr-container-fluid' ) {
			$classes = array( 'col-md-10', 'col-sm-12', 'col-xs-12' );
		}

		if ( mrbara_is_catalog() ) {
			$classes = array( 'col-lg-9', 'col-md-12', 'col-sm-12', 'col-xs-12' );
			if ( mrbara_class_full_width() == 'mr-container-fluid' ) {
				$classes = array( 'col-lg-10', 'col-md-12', 'col-sm-12', 'col-xs-12' );
			}

		} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {
			if ( 'full-content' != $layout ) {
				if ( mrbara_theme_option( 'product_columns_mobile' ) == '2' ) {
					if ( 'sidebar-content' == $layout ) {
						$classes = array( 'col-md-8 col-md-offset-1', 'col-sm-6', 'col-xs-7' );
					} else {
						$classes = array( 'col-md-9', 'col-sm-6', 'col-xs-7' );
					}
				} else {
					if ( 'sidebar-content' == $layout ) {
						$classes = array( 'col-md-8 col-md-offset-1', 'col-sm-12', 'col-xs-12' );
					}
				}
			}


		}

		if ( 'full-content' == $layout ) {
			$classes = array( 'col-md-12' );
		}

		return $classes;
	}
endif;

/**
 * Echos Bootstrap column classes for content area
 *
 * @since 1.0
 */
if ( ! function_exists( 'mrbara_content_columns' ) ) :
	function mrbara_content_columns( $layout = null ) {
		echo implode( ' ', mrbara_get_content_columns( $layout ) );
	}
endif;

/**
 * Get Bootstrap column classes for products
 *
 * @since  1.0
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_wc_content_columns' ) ) :
	function mrbara_wc_content_columns( $columns ) {
		$col = array( 'col-xs-12' );
		if ( ! empty( $columns ) ) {
			if ( 5 == $columns ) {
				$col[] = 'col-md-5ths col-sm-3';
			} elseif ( 2 == $columns || 3 == $columns || 4 == $columns ) {

				$column = floor( 12 / $columns );
				$col[]  = 'col-sm-' . $column . ' col-md-' . $column;
			}
		}
		$col[] = 'col-product';

		echo implode( ' ', $col );
	}
endif;

/**
 * Get classes for content area
 *
 * @since  1.0
 *
 * @return string of classes
 */
if ( ! function_exists( 'mrbara_class_full_width' ) ) :
	function mrbara_class_full_width() {
		if ( is_page_template( 'template-home-cosmetic.php' ) ) {
			return 'mr-container-fluid';
		} elseif ( is_page_template( 'template-full-width.php' ) || mrbara_is_homepage() || is_page_template( 'template-coming-soon.php' ) ||
			is_404()
		) {
			return 'container-fluid';
		} elseif ( mrbara_is_catalog() ) {
			if ( intval( mrbara_theme_option( 'shop_width' ) ) == 2 ) {
				return 'mr-container-fluid';
			} elseif ( intval( mrbara_theme_option( 'shop_width' ) ) == 1 ) {
				return 'mr-container-large';
			}
		} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			if ( mrbara_theme_option( 'portfolios_view' ) == 'masonry' && intval( mrbara_theme_option( 'portfolio_columns' ) ) == 4 ) {
				return 'mr-container-fluid';
			}
		} elseif ( is_singular( 'portfolio_project' ) ) {
			if ( get_post_meta( get_the_ID(), '_project_type', true ) == 'gallery' ) {
				return 'container-fluid';
			}
		} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {
			if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '3' ) ) ) {
				return 'mr-container-fluid';
			} elseif ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '4', '10' ) ) ) {
				return 'container-fluid';
			} elseif ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '6', '5' ) ) ) {
				return 'container-fluid';
			}
		}

		return 'container';
	}
endif;


/**
 * Get layout page header for pages
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_page_header_layout' ) ) :
	function mrbara_page_header_layout() {

		$layout = '';
		if ( ! mrbara_is_homepage() ) {

			if ( intval( get_post_meta( get_the_ID(), 'custom_page_header_layout', true ) ) ) {
				$layout = get_post_meta( get_the_ID(), 'page_header_layout', true );
			}

			if ( ! $layout ) {
				$layout = mrbara_theme_option( 'page_header_layout_pages' );
			}
		}

		return $layout;
	}
endif;