<?php

/**
 * Class for all WooCommerce template modification
 *
 * @version 1.0
 */
class MrBara_WooCommerce {
	/**
	 * @var string Layout of current page
	 */
	public $layout;

	/**
	 * @var string shop view
	 */
	public $shop_view;

	/**
	 * @var string custom shop categories
	 */
	public $shop_cat;

	/**
	 * @var string product attribute
	 */
	public $default_attribute;

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return mrbara_WooCommerce
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return false;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'hooks' ) );

		// Need an early hook to ajaxify update mini shop cart
		if ( $this->woocommerce_version( '3.0.0' ) ) {
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
		} else {
			add_filter( 'add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
		}

		add_action( 'wp_ajax_update_wishlist_count', array( $this, 'update_wishlist_count' ) );
		add_action( 'wp_ajax_nopriv_update_wishlist_count', array( $this, 'update_wishlist_count' ) );

		remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );

	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function hooks() {
		$this->layout       = mrbara_get_layout();
		$this->new_duration = mrbara_theme_option( 'product_newness' );
		$this->shop_view    = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : mrbara_theme_option( 'shop_view' );
		if ( mrbara_theme_option( 'product_attribute' ) != 'none' ) {
			$this->default_attribute = 'pa_' . sanitize_title( mrbara_theme_option( 'product_attribute' ) );
		}


		// WooCommerce Styles
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'wc_styles' ) );

		// Remove breadcrumb, use theme's instead
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// remove category description
		if ( ! intval( mrbara_theme_option( 'show_category_desc' ) ) ) {
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
		}

		// Remove product link
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

		// Add product title link
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'products_title' ), 10 );

		// Add categories filter
		add_action( 'mrbara_before_content', array( $this, 'woocommerce_categories_filter' ), 10 );

		// Change next and prev icon
		add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );

		// Add toolbars for shop page
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_toolbar' ) );

		// Change shop columns
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ), 20 );

		// Change catalog orderby
		add_filter( 'woocommerce_catalog_orderby', array( $this, 'catalog_orderby' ), 20 );

		// remove products upsell display
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

		// remove products related display
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// remove product images
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '3', '4', '7', '10', '11' ) ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		}

		// Add product toolbar
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '3' ) ) ) {
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_toolbar' ), 5 );
		}

		// Add product thumnails
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2', '5', '8', '9', '12' ) ) ) {
			add_action( 'mrbara_after_single_product_image', array( $this, 'product_thumbnails' ), 10 );
		}

		// Add product toolbar
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '5', '7', '11' ) ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'product_toolbar' ), 0 );
		}

		// Add back top home
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '4', '10' ) ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'back_top_home' ), 0 );
		}

		// Add related and upsell products
		if ( ! in_array( mrbara_theme_option( 'product_page_layout' ), array( '7', '11' ) ) ) {
			if ( intval( mrbara_theme_option( 'related_products' ) ) ) {
				add_action( 'woocommerce_after_single_product', array( $this, 'related_products' ) );
			}
		}

		if ( ! in_array( mrbara_theme_option( 'product_page_layout' ), array( '4', '7', '10', '11' ) ) ) {
			if ( intval( mrbara_theme_option( 'upsells_products' ) ) ) {
				add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_products' ), 15 );
			}
		}

		// Add related and upsell products
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '7', '11' ) ) ) {
			if ( intval( mrbara_theme_option( 'upsells_products' ) ) ) {
				add_action( 'woocommerce_single_product_summary', array( $this, 'upsell_products' ), 100 );
			}

			if ( intval( mrbara_theme_option( 'related_products' ) ) ) {
				add_action( 'woocommerce_single_product_summary', array( $this, 'related_products' ), 110 );
			}
		}

		// Add prev/next product
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2', '8', '9', '12' ) ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'products_links' ), 0 );
		}


		// Add Bootstrap classes
		add_filter( 'post_class', array( $this, 'product_class' ), 30, 3 );

		// Show view detail after view cart button, will be displayed in quick view modal.
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'view_detail_button' ), 20 );
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'yith_button' ) );

		// add product attribute
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product_attribute' ), 100 );


		// Wrap product loop content
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'open_product_inner' ), 1 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_product_inner' ), 50 );

		// Add badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

		if ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
			// add class product categpry
			add_filter( 'product_cat_class', array( $this, 'cat_class' ), 30 );
			// Add category thumbnail
			add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'category_thumbnail_size' ) );

			if ( mrbara_theme_option( 'shop_categories_layout' ) == 'masonry' ) {
				$cats = wp_kses( mrbara_theme_option( 'shop_categories' ), wp_kses_allowed_html( 'post' ) );
				if ( $cats ) {
					$cats           = explode( '-', $cats );
					$this->shop_cat = array();
					$i              = 1;
					foreach ( $cats as $cat ) {
						$key                  = intval( $cat );
						$value                = str_replace( $key, '', $cat );
						$this->shop_cat[ $i ] = $value;
						$i ++;
					}
				}
			}


		}

		// Add secondary image to product thumbnail
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_content_thumbnail' ) );

		// product category
		if ( in_array( mrbara_theme_option( 'product_item_layout' ), array( '8' ) ) ) {
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_category' ) );
		}

		// Display product excerpt and subcategory description for list view
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5 );
		add_action( 'woocommerce_after_subcategory', array( $this, 'show_cat_desc' ) );

		// Change number of related products
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sells_columns' ) );
		add_filter( 'woocommerce_cross_sells_total', array( $this, 'cross_sells_numbers' ) );

		// Show share icons
		add_action( 'woocommerce_single_product_summary', array( $this, 'share' ), 50 );

		// Change length of description
		add_filter( 'mrbara_short_description', array( $this, 'short_description' ) );
		add_filter( 'mrbara_short_description', 'wptexturize' );
		add_filter( 'mrbara_short_description', 'convert_smilies' );
		add_filter( 'mrbara_short_description', 'convert_chars' );
		add_filter( 'mrbara_short_description', 'wpautop' );
		add_filter( 'mrbara_short_description', 'shortcode_unautop' );
		add_filter( 'mrbara_short_description', 'prepend_attachment' );
		add_filter( 'mrbara_short_description', 'do_shortcode', 11 ); // AFTER wpautop()
		add_filter( 'mrbara_short_description', 'wc_format_product_short_description', 9999999 );

		// Change product rating html
		add_filter( 'woocommerce_product_get_rating_html', array( $this, 'product_rating_html' ), 10, 2 );

		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		// Change product stock html
		if ( $this->woocommerce_version( '3.0.0' ) ) {
			add_filter( 'woocommerce_get_stock_html', array( $this, 'product_get_stock_html' ), 10, 2 );
		} else {
			add_filter( 'woocommerce_stock_html', array( $this, 'product_stock_html' ), 10, 3 );
		}

		// Change add to cart link
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

		// Orders account
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_orders', 5 );
		// Add orders title
		add_action( 'woocommerce_before_account_orders', array( $this, 'orders_title' ), 10, 1 );

		// billing address
		add_action( 'woocommerce_account_dashboard', 'woocommerce_account_edit_address', 15 );

		// product ribbons
		add_action( 'mrbara_product_list_thumbnail', array( $this, 'product_ribbons' ) );

		add_filter( 'woocommerce_get_availability_text', array( $this, 'product_availability_text' ), 20, 2 );

		add_filter( 'woocommerce_gallery_image_size', array( $this, 'gallery_image_size' ) );

	}

	/**
	 * Ajaxify update cart viewer
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function add_to_cart_fragments( $fragments ) {
		global $woocommerce;

		if ( empty( $woocommerce ) ) {
			return $fragments;
		}

		ob_start();
		$css_class = '';
		if ( mrbara_theme_option( 'header_style' ) == '11' ) {
			$css_class = 'icon-mini-cart';
		}
		$icon_cart = sprintf( '<i class="%s ion-bag" data-original-title="%s"></i>', esc_attr( $css_class ), esc_html__( 'My Cart', 'mrbara' ) );
		$icon_cart = apply_filters( 'mrbara_icon_cart', $icon_cart );
		?>

        <a href="<?php echo esc_url( wc_get_cart_url() ) ?>" class="cart-contents">
			<?php echo $icon_cart; ?>
            <span class="mini-cart-counter"><?php echo intval( $woocommerce->cart->cart_contents_count ) ?></span>
			<?php echo $woocommerce->cart->get_cart_total() ?>
        </a>

		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Ajaxify update count wishlist
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function update_wishlist_count() {
		if ( ! function_exists( 'YITH_WCWL' ) ) {
			return;
		}

		wp_send_json( YITH_WCWL()->count_products() );

	}


	/**
	 * Remove default woocommerce styles
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function wc_styles( $styles ) {
		// unset( $styles['woocommerce-general'] );
		unset( $styles['woocommerce-layout'] );
		unset( $styles['woocommerce-smallscreen'] );

		return $styles;
	}

	/**
	 * Ddd product toolbar
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_toolbar() {

		echo '<div class="product-toolbar">';

		$this->back_top_home();

		$this->products_links();

		echo '</div>';
	}

	/**
	 * Add back top home
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function back_top_home() {
		printf( '<a class="back-home" href="%s" >%s</a>', esc_url( home_url( '/' ) ), esc_html__( 'Back to Home', 'mrbara' ) );
	}

	/**
	 * Display categories filter
	 *
	 * @since 1.0
	 *
	 *
	 * @return array
	 */
	function woocommerce_categories_filter() {

		if ( ! mrbara_is_catalog() ) {
			return;
		}

		if ( ! mrbara_theme_option( 'product_cat_filter' ) ) {
			return;
		}


		echo mrbara_taxs_filter( 'product_cat' );
	}

	/**
	 * Add product title link
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function products_title() {
		printf( '<h3><a href="%s">%s</a></h3>', esc_url( get_the_permalink() ), get_the_title() );
	}

	/**
	 * Chnage length of  product description
	 *
	 * @since  1.0
	 *
	 * @param  string $desc
	 *
	 * @return string
	 */
	function short_description( $desc ) {
		global $post;
		if ( mrbara_is_catalog() ) {
			return mrbara_content_limit( $desc, 15, false );
		} elseif ( is_singular( 'product' ) ) {
			if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '3', '4', '6', '7', '10', '11' ) ) ) {
				if ( $post->post_content ) {
					return $post->post_content;
				}
			}
		}


		return $desc;
	}

	/**
	 * Display a tool bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_toolbar() {
		if ( apply_filters( 'ta_get_theme_option', get_option( 'woocommerce_shop_page_display' ), 'woocommerce_shop_page_display' ) == 'subcategories' ) {
			return;
		}

		$show_shop_bar = mrbara_theme_option( 'show_shop_bar' );
		$count         = count( $show_shop_bar );

		if ( ! $show_shop_bar ) {
			return;
		}

		$found     = 'col-lg-4 col-md-12 col-sm-12';
		$sort      = 'col-lg-5 col-md-12 col-sm-12';
		$show      = 'col-lg-3 col-md-12 col-sm-12';
		$css_right = 'col-md-12 col-sm-12';
		if ( in_array( 'view', $show_shop_bar ) ) {
			if ( $count == 3 ) {
				$show = $sort = $found = 'col-lg-6 col-md-12 col-sm-12';
			} elseif ( $count == 2 ) {
				$show = $sort = $found = 'col-lg-12 col-md-12';
			}
			$css_right = 'col-xs-12 col-sm-12 col-md-12 col-lg-10';

			if ( intval( mrbara_theme_option( 'shop_width' ) ) != 2 && mrbara_get_layout() != 'full-content' ) {
				$css_right = 'col-xs-12 col-sm-12 col-md-12 col-lg-9';
			}

		} else {
			if ( $count == 2 ) {
				$show = $sort = $found = 'col-lg-6 col-md-12 col-sm-12';
			} elseif ( $count == 1 ) {
				$show = $sort = $found = 'col-md-12 col-sm-12 text-center';
			}
		}

		$view = 'col-xs-12 col-sm-12 col-md-12 col-lg-2';
		if ( intval( mrbara_theme_option( 'shop_width' ) ) != 2 && mrbara_get_layout() != 'full-content' ) {
			$view = 'col-xs-12 col-sm-12 col-md-12 col-lg-3';
			$show = $sort = $found = 'col-lg-6 col-md-12 col-sm-12';
		}

		$show_per_page = true;
		if ( ! in_array( 'per_page', $show_shop_bar ) || ( intval( mrbara_theme_option( 'shop_width' ) ) != 2 && mrbara_get_layout() != 'full-content' ) ) {
			$show_per_page = false;
		}

		global $wp_query;

		$sort_by = true;
		if ( 1 === (int) $wp_query->found_posts || ! woocommerce_products_will_display() || $wp_query->is_search() ) {
			$sort_by = false;
		}

		?>
        <div class="shop-filter-mobile">
            <a href="#" class="filter-title"><i
                        class="ion-android-menu"></i><span><?php esc_html_e( 'Filter By', 'mrbara' ); ?></span></a>
        </div>
        <div class="shop-toolbar">
            <div class="row">
                <div class="col-left <?php echo esc_attr( $css_right ); ?>">
                    <div class="row">
						<?php if ( in_array( 'found', $show_shop_bar ) ) : ?>
                            <div class="products-found <?php echo esc_attr( $found ); ?>">
								<?php global $wp_query;
								if ( $wp_query && isset( $wp_query->found_posts ) ) {
									echo '<span>' . $wp_query->found_posts . '</span>' . esc_html__( ' products found', 'mrbara' );
								}
								?>
                            </div>
						<?php endif; ?>

						<?php if ( in_array( 'sort_by', $show_shop_bar ) && $sort_by ) : ?>
                            <div class="sort-by <?php echo esc_attr( $sort ); ?>">
								<?php
								echo '<span>' . esc_html__( 'Sort By', 'mrbara' ) . '</span>';
								woocommerce_catalog_ordering()
								?>
                            </div>
						<?php endif; ?>

						<?php if ( $show_per_page ) : ?>
                            <div class="show_per_page <?php echo esc_attr( $show ); ?>">
                                <form class="shop-products-number" method="get">
									<?php
									$default = intval( mrbara_theme_option( 'product_number' ) );
									$default = $default ? $default : 12;

									$shop_per_page = wp_kses( mrbara_theme_option( 'shop_per_page' ), wp_kses_allowed_html( 'post' ) );

									$numbers = array();
									if ( ! empty( $show_per_page ) ) {
										$shop_per_page = explode( "\n", $shop_per_page );
										foreach ( $shop_per_page as $shop_number ) {
											if ( ! empty( $shop_number ) && intval( $shop_number ) > 0 ) {
												$numbers[] = $shop_number;
											}
										}
									}

									if ( sizeof( $numbers ) > 0 ) {
										$numbers[] = $default;
									} else {
										$numbers = array( $default, 12, 24, 36 );
									}

									$numbers = array_unique( $numbers );
									sort( $numbers );

									$numbers   = apply_filters( 'mrbara_shop_product_numbers', $numbers );
									$options   = array();
									$showposts = get_query_var( 'posts_per_page' );

									foreach ( $numbers as $number ) {
										$css_class = $number == $showposts ? 'active' : '';
										$options[] = sprintf(
											'<li class="%s"><input class="input-number" type="radio" name="showposts" id="num-%s" value="%s" /><label for="num-%s" >%s</label></li>',
											esc_attr( $css_class ),
											esc_attr( $number ),
											esc_attr( $number ),
											esc_attr( $number ),
											$number
										);
									}
									?>
                                    <span><?php esc_html_e( 'Show', 'mrbara' ) ?></span>
                                    <ul class="show-number">
										<?php echo implode( '', $options ); ?>
                                    </ul>
									<?php
									foreach ( $_GET as $name => $value ) {
										if ( 'showposts' != $name ) {
											printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $name ), esc_attr( $value ) );
										}
									}
									?>
                                </form>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
				<?php if ( in_array( 'view', $show_shop_bar ) ) : ?>
                    <div class="<?php echo esc_attr( $view ); ?> text-right shop-view">
						<?php
						$list_current = $this->shop_view == 'list' ? 'current' : '';
						$grid_current = $this->shop_view == 'grid' ? 'current' : '';
						?>
                        <a href="#" class="list-view <?php echo esc_attr( $list_current ) ?>" data-view="list"><i
                                    class="ion-android-menu"></i></a>
                        <a href="#" class="grid-view <?php echo esc_attr( $grid_current ) ?>" data-view="grid"><i
                                    class="ion-android-apps"></i></a>
                        <span><?php esc_html_e( 'View', 'mrbara' ) ?></span>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
	}


	/**
	 * Change the shop columns
	 *
	 * @since  1.0.0
	 *
	 * @param  int $columns The default columns
	 *
	 * @return int
	 */
	function shop_columns( $columns ) {
		$columns = apply_filters( 'mrbara_shop_columns', intval( mrbara_theme_option( 'product_columns' ) ) );


		return $columns;
	}

	/**
	 * Change the catalog orderby
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function catalog_orderby() {
		$catalog_orderby_options = array(
			'menu_order' => esc_html__( 'Default', 'mrbara' ),
			'popularity' => esc_html__( 'Popularity', 'mrbara' ),
			'rating'     => esc_html__( 'Average rating', 'mrbara' ),
			'date'       => esc_html__( 'Newness', 'mrbara' ),
			'price'      => esc_html__( 'Price: low to high', 'mrbara' ),
			'price-desc' => esc_html__( 'Price: high to low', 'mrbara' )
		);

		return $catalog_orderby_options;
	}

	/**
	 * Add Bootstrap's column classes for product
	 *
	 * @since 1.0
	 *
	 * @param array $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	function product_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || get_post_type( $post_id ) !== 'product' || is_single( $post_id ) ) {
			return $classes;
		}
		global $woocommerce_loop;

		if ( ! is_search() ) {
			$classes[] = 'col-sm-6 col-xs-6';
			$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
			$classes[] = 'fd-col-' . $woocommerce_loop['columns'];
		} else {
			if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
				$classes[] = 'col-sm-6 col-xs-6';
				$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
				$classes[] = 'fd-col-' . $woocommerce_loop['columns'];
			}
		}

		return $classes;
	}

	/**
	 * Wrap product content
	 * Open a div
	 *
	 * @since 1.0
	 */
	function open_product_inner() {
		echo '<div class="product-inner  clearfix">';
	}

	/**
	 * Wrap product content
	 * Close a div
	 *
	 * @since 1.0
	 */
	function close_product_inner() {
		echo '</div>';
	}

	/**
	 * Display badge for new product or featured product
	 *
	 * @since 1.0
	 */
	function product_ribbons() {
		global $product;

		if ( intval( mrbara_theme_option( 'show_badges' ) ) ) {
			$output = array();
			$badges = mrbara_theme_option( 'badges' );
			// Change the default sale ribbon

			$custom_badges = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_badges_text', true ) );

			if ( $custom_badges ) {

				$output[] = '<span class="custom ribbon">' . esc_html( $custom_badges ) . '</span>';

			} else {

				$stock_status = '';

				if ( method_exists( $product, 'get_stock_status' ) ) {
					$stock_status = $product->get_stock_status();
				} else {
					$stock_status = $product->stock_status;
				}

				if ( $stock_status == 'outofstock' && in_array( 'outofstock', $badges ) ) {
					$outofstock = mrbara_theme_option( 'outofstock_text' );
					if ( ! $outofstock ) {
						$outofstock = esc_html__( 'Out Of Stock', 'mrbara' );
					}
					$output[] = '<span class="out-of-stock ribbon">' . esc_html( $outofstock ) . '</span>';
				} elseif ( $product->is_on_sale() && in_array( 'sale', $badges ) ) {
					$sale = mrbara_theme_option( 'sale_text' );
					if ( ! $sale ) {
						$sale = esc_html__( 'Sale', 'mrbara' );
					}
					$output[] = '<span class="onsale ribbon">' . esc_html( $sale ) . '</span>';
				} elseif ( $product->is_featured() && in_array( 'hot', $badges ) ) {
					$hot = mrbara_theme_option( 'hot_text' );
					if ( ! $hot ) {
						$hot = esc_html__( 'Hot', 'mrbara' );
					}
					$output[] = '<span class="featured ribbon">' . esc_html( $hot ) . '</span>';
				} elseif ( ( time() - ( 60 * 60 * 24 * $this->new_duration ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) ) {
					$new = mrbara_theme_option( 'new_text' );
					if ( ! $new ) {
						$new = esc_html__( 'New', 'mrbara' );
					}
					$output[] = '<span class="newness ribbon">' . esc_html( $new ) . '</span>';
				}

			}

			if ( $output ) {
				printf( '<span class="ribbons">%s</span>', implode( '', $output ) );
			}


		}


	}

	/**
	 * WooCommerce Loop Product Content Thumbs
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_content_thumbnail() {
		global $product;

		$attachment_ids = '';
		if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
			$attachment_ids = $product->get_gallery_image_ids();
		} else {
			$attachment_ids = $product->get_gallery_attachment_ids();
		}

		$secondary_thumb = true;
		if ( in_array( mrbara_theme_option( 'product_item_layout' ), array( '1', '2', '4', '7', '8', '10' ) ) ) {
			$secondary_thumb = intval( mrbara_theme_option( 'disable_secondary_thumb' ) );
		}

		if ( count( $attachment_ids ) == 0 || $secondary_thumb ) {
			echo '<div class="product-content-thumbnails product-thumbnail-single">';
		} else {
			echo '<div class="product-content-thumbnails">';
		}

		echo '<a href ="' . get_the_permalink() . '">';
		if ( $product->get_image() ) {
			echo woocommerce_get_product_thumbnail();
		}

		if ( ! $secondary_thumb ) {
			if ( count( $attachment_ids ) > 0 && isset ( $attachment_ids[0] ) ) {
				echo wp_get_attachment_image( $attachment_ids[0], 'shop_catalog' );
			}

		}

		$this->product_ribbons();
		echo '</a>';

		if ( mrbara_theme_option( 'product_item_layout' ) == '4' ) {
			echo '<div class="quick-view-out"><span data-href="' . $product->get_permalink() . '"  class="product-quick-view"><i class="ion-ios-eye-outline"' . ' data-original-title="' . esc_attr__( 'Quick View', 'mrbara' ) . '" rel="tooltip"></i></span></div>';
		}

		echo '<div class="footer-product">';

		$css_class = '';
		if ( class_exists( 'YITH_Woocompare' ) ) {
			global $yith_woocompare;
			$product_ids = $yith_woocompare->obj->products_list;
			if ( in_array( $product->get_id(), $product_ids ) ) {
				$css_class = 'compare-added';
			}
		}
		echo '<div class="footer-product-button ' . esc_attr( $css_class ) . ' ">';

		$product_type = '';
		if ( method_exists( $product, 'get_type' ) ) {
			$product_type = $product->get_type();
		} else {
			$product_type = $product->product_type;
		}

		if ( intval( mrbara_theme_option( 'product_add_to_cart' ) ) ) {
			printf(
				'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="btn-add-to-cart button %s product_type_%s %s"><i class="ion-ios-plus-empty" data-original-title="%s" rel="tooltip"></i><span class="add-to-cart-title">%s</span> </a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				esc_attr( $product_type ),
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				esc_html( $product->add_to_cart_text() ),
				esc_html( $product->add_to_cart_text() )

			);
		}


		if ( shortcode_exists( 'yith_compare_button' ) ) {
			echo do_shortcode( '[yith_compare_button]' );
		}

		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}

		if ( mrbara_theme_option( 'product_item_layout' ) != '4' ) {
			echo '<span data-href="' . $product->get_permalink() . '"  class="product-quick-view"><i class="ion-ios-eye-outline"' . ' data-original-title="' . esc_attr__( 'Quick View', 'mrbara' ) . '" rel="tooltip"></i></span>';
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * WooCommerce category Thumbs
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function category_thumbnail_size( $size ) {
		global $woocommerce_loop;
		$size = 'mrbara-category-thumbnail';
		if ( mrbara_theme_option( 'shop_categories_layout' ) == 'masonry' ) {
			if ( ! empty( $woocommerce_loop['loop'] ) ) {
				$loop = $woocommerce_loop['loop'];
				if ( $this->shop_cat && isset( $this->shop_cat[ $loop ] ) ) {
					if ( strtoupper( $this->shop_cat[ $loop ] ) == 'F' ) {
						$size = 'mrbara-category-full';
					} elseif ( strtoupper( $this->shop_cat[ $loop ] ) == 'L' ) {
						$size = 'mrbara-category-long';
					} elseif ( strtoupper( $this->shop_cat[ $loop ] ) == 'W' ) {
						$size = 'mrbara-category-wide';
					}
				} else {
					$mod = $woocommerce_loop['loop'] % 10;
					if ( $mod == 1 ) {
						$size = 'mrbara-category-full';
					} elseif ( $mod == 2 || $mod == 4 ) {
						$size = 'mrbara-category-long';
					} elseif ( $mod == 3 || $mod == 5 || $mod == 6 || $mod == 7 || $mod == 8 || $mod == 0 ) {
						$size = 'mrbara-category-thumbnail';
					} elseif ( $mod == 9 ) {
						$size = 'mrbara-category-wide';
					}
				}
			}
		}

		return $size;
	}

	/**
	 * Category class
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function cat_class( $classes ) {
		global $woocommerce_loop;
		$css_class = 'category-thumbnail';
		if ( mrbara_theme_option( 'shop_categories_layout' ) == 'masonry' ) {
			if ( ! empty( $woocommerce_loop['loop'] ) ) {
				$loop = $woocommerce_loop['loop'];
				if ( $this->shop_cat && isset( $this->shop_cat[ $loop ] ) ) {
					if ( strtoupper( $this->shop_cat[ $loop ] ) == 'F' ) {
						$css_class = 'category-full';
					} elseif ( strtoupper( $this->shop_cat[ $loop ] ) == 'L' ) {
						$css_class = 'category-long';
					} elseif ( strtoupper( $this->shop_cat[ $loop ] ) == 'W' ) {
						$css_class = 'category-wide';
					}
				} else {
					$mod = $woocommerce_loop['loop'] % 10;

					if ( $mod == 1 ) {
						$css_class = 'category-full';
					} elseif ( $mod == 2 || $mod == 4 ) {
						$css_class = 'category-long';
					} elseif ( $mod == 3 || $mod == 5 || $mod == 6 || $mod == 7 || $mod == 8 || $mod == 0 ) {
						$css_class = 'category-thumbnail';
					} elseif ( $mod == 9 ) {
						$css_class = 'category-wide';
					}
				}

			}
		}

		$classes[] = $css_class;

		return $classes;
	}

	/**
	 * WooCommerce Single Product Category
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function product_category() {
		global $product;
		$terms = get_the_terms( $product->get_id(), 'product_cat' );

		if ( $terms && isset( $terms[0] ) ) {
			printf( '<a href="%s" class="product-cat">%s</a>', esc_url( get_term_link( $terms[0]->slug, 'product_cat' ) ), $terms[0]->name );
		}
	}


	/**
	 * Display description of sub-category in list view
	 *
	 * @param  object $category
	 */
	function show_cat_desc( $category ) {
		printf( '<div class="category-desc"\>%s</div>', $category->description );
	}

	/**
	 * Change related products args to display in correct grid
	 *
	 * @param  array $args
	 *
	 * @return array
	 */
	function related_products_args( $args ) {

		$related_numbers = intval( mrbara_theme_option( 'related_products_numbers' ) );
		$related_columns = intval( mrbara_theme_option( 'related_products_columns' ) );

		$args['posts_per_page'] = apply_filters( 'mrbara_related_pre_page', $related_numbers );;
		$args['columns'] = apply_filters( 'mrbara_related_columns', $related_columns );

		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '4', '10' ) ) ) {
			$args['posts_per_page'] = apply_filters( 'mrbara_related_pre_page', 4 );
			$args['columns']        = apply_filters( 'mrbara_related_columns', 1 );
		}

		return $args;
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cl
	 *
	 * @return int
	 */
	function cross_sells_columns( $cross_columns ) {
		$cross_columns = intval( mrbara_theme_option( 'crosssells_products_columns' ) );

		return apply_filters( 'mrbara_cross_sells_columns', $cross_columns );
	}

	/**
	 * Change number of columns when display cross sells products
	 *
	 * @param  int $cl
	 *
	 * @return int
	 */
	function cross_sells_numbers( $cross_numbers ) {
		$cross_numbers = intval( mrbara_theme_option( 'crosssells_products_numbers' ) );

		return apply_filters( 'mrbara_cross_sells_total', $cross_numbers );
	}

	/**
	 * Change next and previous icon of pagination nav
	 *
	 * @since  1.0
	 */
	function pagination_args( $args ) {
		$args['prev_text'] = '<span class="arrow_carrot-2left"></span>';
		$args['next_text'] = '<span class="arrow_carrot-2right"></span>';

		if ( mrbara_theme_option( 'navigation_type' ) != 'links' ) {
			$args['prev_text'] = '';
			$args['next_text'] = '<span id="mr-products-loading" class="dots-loading"><span>.</span><span>.</span><span>.</span>' . esc_html__( 'Loading', 'mrbara' ) . '<span>.</span><span>.</span><span>.</span></span>';
		}

		return $args;
	}


	/**
	 * Display product rating
	 *
	 * @since 1.0
	 */
	function product_rating_html( $rating_html, $rating ) {
		$rating_html = '<div class="star-rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'mrbara' ), $rating ) . '">';
		$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'mrbara' ) . '</span>';
		$rating_html .= '</div>';

		return $rating_html;
	}

	/**
	 * Display product stock
	 *
	 * @since 1.0
	 */
	function product_stock_html( $availability_html, $availability, $product ) {
		$availability      = $product->get_availability();
		$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html__( 'Availability: ', 'mrbara' ) . '<span>' . esc_html( $availability['availability'] ) . '</span>' . '</p>';

		return $availability_html;
	}

	function product_get_stock_html( $availability_html, $product ) {
		$availability      = $product->get_availability();
		$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html__( 'Availability: ', 'mrbara' ) . '<span>' . esc_html( $availability['availability'] ) . '</span>' . '</p>';

		return $availability_html;
	}

	/**
	 * Display upsell products
	 *
	 * @since 1.0
	 */
	function upsell_products() {

		$col       = 'col-sm-12 col-md-12';
		$container = 'container-full';

		if ( mrbara_theme_option( 'product_page_layout' ) == '3' ) {
			$col = 'col-sm-8 col-md-8';
		} elseif ( mrbara_theme_option( 'product_page_layout' ) == '6' ) {
			$container = 'container';
		}
		$upsell_numbers = intval( mrbara_theme_option( 'upsells_products_numbers' ) );
		$upsell_columns = intval( mrbara_theme_option( 'upsells_products_columns' ) );
		?>
        <div id="mr-upsells-products" class="upsell-products" data-columns="<?php echo esc_attr( $upsell_columns ); ?>">
            <div class="<?php echo esc_attr( $container ); ?>">
                <div class="row">
                    <div class="<?php echo esc_attr( $col ); ?>">
						<?php woocommerce_upsell_display( apply_filters( 'mrbara_upsell_per_page', $upsell_numbers ), apply_filters( 'mrbara_upsell_columns', $upsell_columns ) ); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php

	}

	/**
	 * Display related products
	 *
	 * @since 1.0
	 */
	function related_products() {
		$container = 'container';
		$col       = 'col-sm-12 col-md-12';

		if ( mrbara_theme_option( 'product_page_layout' ) == '3' ) {
			$container = 'container-full';
			$col       = 'col-sm-12 col-md-8';
		} elseif ( mrbara_theme_option( 'product_page_layout' ) == '5' ) {
			$container = 'container-full';
		}
		$related_columns = intval( mrbara_theme_option( 'related_products_columns' ) );

		?>
        <div id="mr-related-products" class="related-products"
             data-columns="<?php echo esc_attr( $related_columns ); ?>">
            <div class="<?php echo esc_attr( $container ); ?>">
                <div class="row">
                    <div class=" <?php echo esc_attr( $col ); ?>">
						<?php woocommerce_output_related_products(); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}


	/**
	 * Display Addthis sharing
	 *
	 * @since 1.0
	 */
	function share() {

		if ( ! in_array( 'share', mrbara_theme_option( 'show_product_extra' ) ) ) {
			return;
		}

		if ( ! mrbara_theme_option( 'product_social_icons' ) ) {
			return;
		}

		if ( function_exists( 'mrbara_share_link_socials' ) ) {
			global $product;
			printf( '<div class="share"><span>%s</span>', esc_html__( 'Share:', 'mrbara' ) );
			$image_id   = $product->get_image_id();
			$image_link = '';
			if ( $image_id ) {
				$image_link = wp_get_attachment_url( $image_id );
			}
			echo mrbara_share_link_socials( $product->get_title(), $product->get_permalink(), $image_link );
			printf( '</div>' );
		}

	}


	/**
	 * Display products link
	 *
	 * @since 1.0
	 */
	function products_links() {
		if ( function_exists( 'is_product' ) && ! is_product() ) {
			return;
		}

		$prev_link = '<span class="ion-ios-arrow-back"></span>';
		$next_link = '<span class="ion-ios-arrow-forward"></span>';
		if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '8', '9' ) ) ) {
			$next_post = get_next_post();
			if ( $next_post ) {
				$nextthumbnail = get_the_post_thumbnail( $next_post->ID, apply_filters( 'mrbara_product_link_thumbnail', 'shop_thumbnail' ) );
				$next_link     .= $nextthumbnail;
			}

			$prev_post = get_previous_post();
			if ( $prev_post ) {
				$nextthumbnail = get_the_post_thumbnail( $prev_post->ID, apply_filters( 'mrbara_product_link_thumbnail', 'shop_thumbnail' ) );
				$prev_link     .= $nextthumbnail;
			}

		}

		?>
        <div class="products-links">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', $prev_link );
			next_post_link( '<div class="nav-next">%link</div>', $next_link );
			?>
        </div>
		<?php
	}


	/**
	 * Display product images
	 *
	 * @since 1.0
	 */
	function product_thumbnails() {
		global $post, $product, $woocommerce;

		$attachment_ids = '';
		if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
			$attachment_ids = $product->get_gallery_image_ids();
		} else {
			$attachment_ids = $product->get_gallery_attachment_ids();
		}
		$video_position = intval( get_post_meta( $product->get_id(), 'video_position', true ) );
		$video_thumb    = get_post_meta( $product->get_id(), 'video_thumbnail', true );
		if ( $video_thumb ) {
			$video_thumb = wp_get_attachment_image( $video_thumb, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		}

		if ( $attachment_ids || $video_thumb ) {
			$loop    = 1;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			?>
            <div class="product-thumbnails" id="product-thumbnails">
				<?php

				$image_thumb = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

				if ( $image_thumb ) {

					printf(
						'<div>%s</div>',
						$image_thumb
					);

				}

				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {

						if ( $video_thumb ) {
							if ( intval( $video_position ) == $loop + 1 ) {
								printf(
									'<div class="video-thumb">%s</div>',
									$video_thumb
								);
							}
						}

						$props = wc_get_product_attachment_props( $attachment_id, $post );

						if ( ! $props['url'] ) {
							continue;
						}

						echo apply_filters(
							'woocommerce_single_product_image_thumbnail_html',
							sprintf(
								'<div>%s</div>',
								wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
							),
							$attachment_id,
							$post->ID
						);

						$loop ++;
					}
				}

				if ( $video_thumb ) {
					if ( $video_position > count( $attachment_ids ) + 1 ) {
						printf(
							'<div class="video-thumb">%s</div>',
							$video_thumb
						);
					}
				}

				?>
            </div>
			<?php
		}
	}

	/**
	 * Display view detail button
	 *
	 * @since 1.0
	 */
	function view_detail_button() {
		global $product;
		printf(
			'<a href="%s" class="view-detail-button">%s</a>',
			esc_url( $product->get_permalink() ),
			esc_html__( 'View Detail', 'mrbara' )
		);
	}

	/**
	 * Display wishlist_button
	 *
	 * @since 1.0
	 */
	function yith_button() {
		if ( get_option( 'yith_wcwl_button_position' ) == 'shortcode' || get_option( 'yith_wcwl_button_position' ) == 'add-to-cart' ) {
			if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			}
		}

		if ( shortcode_exists( 'yith_compare_button' ) ) {
			echo do_shortcode( '[yith_compare_button]' );
		}
	}

	/**
	 * Display orders tile
	 *
	 * @since 1.0
	 */
	function orders_title( $has_orders ) {
		if ( $has_orders ) {
			printf( '<h2 class="orders-title">%s</h2>', esc_html__( 'Orders History', 'mrbara' ) );
		}
	}

	/**
	 * Out of stock text
	 */
	function product_availability_text( $availability, $object ) {
		if ( ! $object->is_in_stock() ) {
			$outofstock_text = mrbara_theme_option( 'outofstock_text' );
			$availability    = $outofstock_text ? $outofstock_text : $availability;
		}

		return $availability;
	}

	/**
	 * Display product attribute
	 *
	 * @since 1.0
	 */
	function product_attribute() {

		if ( mrbara_theme_option( 'product_item_layout' ) != '10' ) {
			return '';
		}

		if ( $this->default_attribute == '' ) {
			return '';
		}

		global $product;
		$attributes         = maybe_unserialize( get_post_meta( $product->get_id(), '_product_attributes', true ) );
		$product_attributes = maybe_unserialize( get_post_meta( $product->get_id(), 'attributes_extra', true ) );

		if ( $product_attributes == 'none' ) {
			return '';
		}

		if ( $product_attributes == '' ) {
			$product_attributes = $this->default_attribute;
		}

		$variations = $this->get_variations( $product_attributes );

		if ( $attributes ) {
			foreach ( $attributes as $attribute ) {
				$product_type = '';
				if ( method_exists( $product, 'get_type' ) ) {
					$product_type = $product->get_type();
				} else {
					$product_type = $product->product_type;
				}

				if ( $product_type == 'variable' ) {
					if ( ! $attribute['is_variation'] ) {
						continue;
					}
				}

				if ( sanitize_title( $attribute['name'] ) == $product_attributes ) {

					echo '<div class="attr-swatches">';
					if ( $attribute['is_taxonomy'] ) {
						$post_terms = wp_get_post_terms( $product->get_id(), $attribute['name'] );

						$attr_type = '';

						if ( function_exists( 'Soo_Product_Attribute_Swatches' ) ) {
							$attr = Soo_Product_Attribute_Swatches()->get_tax_attribute( $attribute['name'] );
							if ( $attr ) {
								$attr_type = $attr->attribute_type;
							}
						}
						$found = false;
						foreach ( $post_terms as $term ) {
							$css_class = '';
							$img_src   = '';
							if ( is_wp_error( $term ) ) {
								continue;
							}
							if ( $variations && isset( $variations[ $term->slug ] ) ) {
								$attachment_id = $variations[ $term->slug ];
								$attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );

								if ( $attachment_id == get_post_thumbnail_id() && ! $found ) {
									$css_class .= ' selected';
									$found     = true;
								}

								if ( $attachment ) {
									$css_class .= ' swatch-variation-image';
									$img_src   = $attachment[0];
								}

							}
							echo $this->swatch_html( $term, $attr_type, $img_src, $css_class );
						}
					} else {
						$options = wc_get_text_attributes( $attribute['value'] );

						foreach ( $options as $option ) {
							printf(
								'<span class="swatch swatch-label" title="%s">%s</span>',
								esc_attr( $option ),
								esc_html( $option )
							);
						}
					}
					echo '</div>';
					break;
				}
			}
		}
	}

	/**
	 * Print HTML of a single swatch
	 *
	 * @param $html
	 * @param $term
	 * @param $attr
	 *
	 * @return string
	 */
	public function swatch_html( $term, $attr_type, $img_src, $css_class ) {

		$html = '';
		$name = $term->name;

		switch ( $attr_type ) {
			case 'color':
				$color = get_term_meta( $term->term_id, 'color', true );
				list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
				$html = sprintf(
					'<span class="swatch swatch-color %s" data-src="%s" title="%s"><span class="sub-swatch" style="background-color:%s;color:%s;"></span> </span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $name ),
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)"
				);
				break;

			case 'image':
				$image = get_term_meta( $term->term_id, 'image', true );
				if ( $image ) {
					$image = wp_get_attachment_image_src( $image );
					$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					$html  = sprintf(
						'<span class="swatch swatch-image %s" data-src="%s" title="%s"><img src="%s" alt="%s"></span>',
						esc_attr( $css_class ),
						esc_url( $img_src ),
						esc_attr( $name ),
						esc_url( $image ),
						esc_attr( $name )
					);
				}

				break;

			default:
				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch-label %s" data-src="%s" title="%s">%s</span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $name ),
					esc_html( $label )
				);
				break;


		}

		return $html;
	}

	function get_variations( $default_attribute ) {
		global $product;

		$variations = array();

		$product_type = '';
		if ( method_exists( $product, 'get_type' ) ) {
			$product_type = $product->get_type();
		} else {
			$product_type = $product->product_type;
		}

		if ( $product_type == 'variable' ) {
			$args = array(
				'post_parent' => $product->get_id(),
				'post_type'   => 'product_variation',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
				'post_status' => 'publish',
				'numberposts' => - 1
			);

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				);
			}

			$thumbnail_id = get_post_thumbnail_id();

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				$attachment_id = get_post_thumbnail_id( $post_id );
				$attribute     = $this->get_variation_attributes( $post_id, 'attribute_' . $default_attribute );

				if ( ! $attachment_id ) {
					$attachment_id = $thumbnail_id;
				}

				if ( $attribute ) {
					$variations[ $attribute[0] ] = $attachment_id;
				}

			}

		}

		return $variations;
	}

	public function get_variation_attributes( $child_id, $attribute ) {
		global $wpdb;

		$values = array_unique(
			$wpdb->get_col(
				$wpdb->prepare(
					"SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND post_id IN (" . $child_id . ")",
					$attribute
				)
			)
		);

		return $values;
	}

	public function woocommerce_version( $version ) {
		global $woocommerce;
		if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Change gallery image size.
	 *
	 * @return string
	 */
	public function gallery_image_size() {
		return 'woocommerce_single';
	}

}