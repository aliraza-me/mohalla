<?php
/**
 * Custom functions for header.
 *
 * @package MrBara
 */

/**
 * Get header class
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_header_classes' ) ) :
	function mrbara_header_classes() {
		$classes = '';
		if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
			if ( mrbara_theme_option( 'header_sticky' ) ) {
				if ( $sticky_type = mrbara_theme_option( 'header_sticky_type' ) ) {
					$classes .= ' header-sticky-' . $sticky_type;
				}
			}
		}

		echo esc_attr( $classes );
	}
endif;

/**
 * Get Icon Menu Mobile
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_icon_menu' ) ) :
	function mrbara_icon_menu() {
		printf(
			'<div class="navbar-toggle">
			<span class="ion-navicon m-navbar-icon">
			</span>
		</div>'
		);

	}
endif;


/**
 * Get Menu extra Account
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_account' ) ) :
	function mrbara_extra_account() {
		$extras = mrbara_menu_extra();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'account', $extras ) ) {
			return $items;
		}

		$header_layout = mrbara_theme_option( 'header_layout' );
		$header_style  = mrbara_theme_option( 'header_style' );

		$wishlist = '';
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			$wishlist = sprintf(
				'<li>
				<a href="%s">%s</a>
			</li>',
				esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
				esc_html__( 'My Wishlist', 'mrbara' )
			);
		}


		if ( is_user_logged_in() ) {
			$orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
			$account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			if ( $orders ) {
				$account .= $orders;
			}

			$user_id = get_current_user_id();

			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account logined">
				<a href="%s"><span class="t-text"> %s <span>%s</span></span><i class="t-icon ion-person"></i></a>
				<ul>
					%s
					<li>
						<a href="%s">%s</a>
					</li>
					<li>
						<a href="%s">%s</a>
					</li>
					<li>
						<a href="%s">%s</a>
					</li>
				</ul>
			</li>',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				get_avatar( get_the_author_meta( 'ID', $user_id ), 40 ),
				esc_html__( 'Hi ! ', 'mrbara' ) . get_the_author_meta( 'display_name', $user_id ),
				$wishlist,
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Account Settings', 'mrbara' ),
				esc_url( $account ),
				esc_html__( 'Orders History', 'mrbara' ),
				esc_url( wp_logout_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ),
				esc_html__( 'Logout', 'mrbara' )
			);
		} else {

			$register      = '';
			$register_text = esc_html__( 'Sign Up', 'mrbara' );
			$or_text       = '';
			if ( in_array( $header_style, array( '8', '9', '11', '12', '13' ) ) ) {
				$register_text = esc_html__( 'Register', 'mrbara' );
				$or_text       = sprintf( '<span>%s</span>', esc_html__( 'or', 'mrbara' ) );
			}
			if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
				$register = sprintf(
					'%s<a href="%s" class="item-register" id="menu-extra-register">%s</a>',
					$or_text,
					esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
					$register_text
				);
			}

			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account">
				<a href="%s" class="item-login" id="menu-extra-login"><span class="t-text">%s</span><i class="t-icon ion-person"></i></a>
				%s
			</li>',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Log in', 'mrbara' ),
				$register
			);
		}

		echo $items;

	}
endif;


/**
 * Get Menu extra cart
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_menu' ) ) :
	function mrbara_extra_menu() {
		printf(
			'<a href="#" id="toggle-nav" class="item-menu-nav toggle-nav">
			<span class="navbars-icon">
				<span class="navbars-line"></span>
			</span>
			<span class="navbars-title">%s</span>
		</a>',
			esc_html__( 'Menu', 'mrbara' )
		);
	}
endif;


/**
 * Get Menu extra cart
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_cart' ) ) :
	function mrbara_extra_cart() {
		$extras = mrbara_menu_extra();

		if ( empty( $extras ) || ! in_array( 'cart', $extras ) ) {
			return '';
		}

		if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
			return '';
		}
		global $woocommerce;
		$mini_content = '';

		if ( ! mrbara_theme_option( 'mini_cart_content' ) && mrbara_theme_option( 'header_layout' ) != 'header-left' ) {
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();

			$mini_content = sprintf( '	<div class="widget_shopping_cart_content">%s</div>', $mini_cart );
		}

		$css_class = '';
		if ( mrbara_theme_option( 'header_style' ) == '11' ) {
			$css_class = 'icon-mini-cart';
		}

		$icon_cart = sprintf( '<i class="%s ion-bag" data-original-title="%s"></i>', esc_attr( $css_class ), esc_html__( 'My Cart', 'mrbara' ) );
		$icon_cart = apply_filters( 'mrbara_icon_cart', $icon_cart );

		printf(
			'<li class="extra-menu-item menu-item-cart mini-cart woocommerce mr-cart-panel"">
			<a class="cart-contents" id="icon-cart-contents" href="%s">
				%s
				<span class="mini-cart-counter">
					%s
				</span>
				%s
			</a>
			%s
		</li>',
			esc_url( wc_get_cart_url() ),
			$icon_cart,
			intval( $woocommerce->cart->cart_contents_count ),
			$woocommerce->cart->get_cart_total(),
			$mini_content
		);

	}
endif;

/**
 * Get Menu extra wishlist
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_wislist' ) ) :
	function mrbara_extra_wislist() {
		$extras = mrbara_menu_extra();

		if ( empty( $extras ) || ! in_array( 'wishlist', $extras ) ) {
			return '';
		}

		if ( ! function_exists( 'YITH_WCWL' ) ) {
			return '';
		}

		$count = YITH_WCWL()->count_products();

		printf(
			'<li class="extra-menu-item menu-item-wishlist menu-item-yith">
			<a class="yith-contents" id="icon-wishlist-contents" href="%s">
				<i class="ion-android-favorite-outline" data-original-title="%s" rel="tooltip"></i>
				<span class="mini-yith-counter">
					%s
				</span>
			</a>
		</li>',
			esc_url( esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ),
			esc_html__( 'My Wishlist', 'mrbara' ),
			intval( $count )
		);

	}
endif;

/**
 * Get Menu extra wishlist
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_compare' ) ) :
	function mrbara_extra_compare() {
		$extras = mrbara_menu_extra();


		if ( empty( $extras ) || ! in_array( 'compare', $extras ) ) {
			return '';
		}

		if ( ! class_exists( 'YITH_Woocompare' ) ) {
			return '';
		}


		global $yith_woocompare;

		$count = $yith_woocompare->obj->products_list;


		printf(
			'<li class="extra-menu-item menu-item-compare menu-item-yith">
			<a class="yith-contents yith-woocompare-open" href="#">
				<i class="ion-stats-bars" data-original-title="%s" rel="tooltip"></i>
				<span class="mini-yith-counter" id="mini-compare-counter">
					%s
				</span>
			</a>
		</li>',
			esc_html__( 'My Compare', 'mrbara' ),
			sizeof( $count )
		);

	}
endif;


/**
 * Get Menu extra search
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_search' ) ) :
	function mrbara_extra_search() {
		$extras = mrbara_menu_extra();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'search', $extras ) ) {
			return $items;
		}

		$header_layout          = mrbara_theme_option( 'header_layout' );
		$header_style           = mrbara_theme_option( 'header_style' );
		$custom_categories_text = mrbara_theme_option( 'custom_categories_text' );
		$custom_search_textbox  = mrbara_theme_option( 'custom_search_textbox' );

		if ( $header_layout == 'header-top' ) {
			if ( $header_style == '2' ) {
				$items .= sprintf(
					'<li class="extra-menu-item menu-item-search">
					<form class="search-form" method="get" action="%s">
						<input type="text" placeholder="%s" name="s" class="search-field" id="search-field-auto">
						<input type="hidden" name="post_type" value="product">
						<input type="submit" class="search-submit">
						<i class="t-icon ion-ios-search-strong"></i>
					</form>
				</li>',
					esc_url( home_url( '/' ) ),
					esc_attr( $custom_search_textbox )
				);
			} elseif ( in_array( $header_style, array( '8', '11', '12', '13' ) ) ) {
				$cat                  = '';
				$custom_search_button = mrbara_theme_option( 'custom_search_button' );
				if ( taxonomy_exists( 'product_cat' ) ) {
					$cat = wp_dropdown_categories(
						array(
							'name'            => 'product_cat',
							'taxonomy'        => 'product_cat',
							'orderby'         => 'NAME',
							'hierarchical'    => 1,
							'hide_empty'      => 0,
							'echo'            => 0,
							'value_field'     => 'slug',
							'show_option_all' => esc_html( $custom_categories_text )
						)
					);
				}
				$items .= sprintf(
					'<form class="products-search" method="get" action="%s">
					<input type="text" name="s" id="search-field-auto" class="search-field" placeholder="%s">
					<input type="hidden" name="post_type" value="product">
					<div class="product-cat">%s</div>
					<input type="submit" value="%s" class="search-submit">
				</form>',
					esc_url( home_url( '/' ) ),
					esc_attr( $custom_search_textbox ),
					$cat,
					esc_attr( $custom_search_button )
				);

			} else {
				$search = '';
				if ( in_array( $header_style, array( '7' ) ) ) {
					$search = esc_attr__( 'Search', 'mrbara' );
				}

				$id        = 'toggle-search';
				$cat       = '';
				$form      = '';
				$css_class = '';
				if ( ! mrbara_search_style() ) {
					if ( taxonomy_exists( 'product_cat' ) ) {
						$cat = wp_dropdown_categories(
							array(
								'name'            => 'product_cat',
								'taxonomy'        => 'product_cat',
								'hierarchical'    => 1,
								'hide_empty'      => 0,
								'echo'            => 0,
								'value_field'     => 'slug',
								'show_option_all' => esc_html( $custom_categories_text )
							)
						);

						$cat       = '<div class="product-cat">' . $cat . '</div>';
						$css_class = 'has-categories';
					}
				}

				if ( mrbara_search_style() == '3' ) {
					$id = 'toggle-search-popup';
				} else {
					$form = sprintf(
						'<form class="search-form" method="get" action="%s">
						<div class="search-content %s">
								%s
							<input type="text" placeholder="%s" name="s" class="search-field" id="search-field-auto">
							<input type="hidden" name="post_type" value="product">
							<input type="submit" class="search-submit">
						</div>
					</form>',
						esc_url( home_url( '/' ) ),
						esc_attr( $css_class ),
						$cat,
						esc_attr( $custom_search_textbox )
					);
				}

				$items .= sprintf(
					'<li class="extra-menu-item menu-item-search">
					<a id="%s" href="#"><span class="t-icon search"><span class="t-line1"></span><span class="t-line2"></span> </span>%s</a>
					%s
				</li>',
					esc_attr( $id ),
					$search,
					$form

				);
			}
		} else {
			$items .= '<li class="extra-menu-item menu-item-search">
						<a id="toggle-search-popup" href="#"><i class=" t-icon ion-ios-search-strong"></i></a>
					</li>';
		}

		echo $items;
	}
endif;


/**
 * Get Menu extra shop
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_extra_shop' ) ) :
	function mrbara_extra_shop() {
		$extras = mrbara_menu_extra();

		if ( ! $extras || ! in_array( 'shop', $extras ) ) {
			return '';
		}

		printf(
			'<li class="extra-menu-item menu-item-shop">
			<a href="%s">%s<i class="t-icon ion-grid"></i></a>
		</li>',
			get_permalink( get_option( 'woocommerce_shop_page_id' ) ),
			esc_attr__( 'Shop', 'mrbara' )
		);

	}
endif;

/**
 * Get header menu
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_header_menu' ) ) :
	function mrbara_header_menu() {
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'walker'         => new MrBara_Mega_Menu_Walker()
				)
			);
		}
	}
endif;

/**
 * Display language in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_header_language' ) ) :
	function mrbara_header_language() {
		$language = mrbara_language_switcher();
		$language = apply_filters( 'mrbara_header_language', $language );
		if ( $language ) {
			?>
			<div class="widget-mr-language-switcher">
				<?php echo $language; ?>
			</div>
			<?php
		}
	}
endif;

/**
 * Get menu extra
 *
 * @since  1.0.0
 *
 *
 * @return string
 */

if ( ! function_exists( 'mrbara_menu_extra' ) ) :
	function mrbara_menu_extra() {
		$menu_extra   = mrbara_theme_option( 'menu_extra' );
		$header_style = mrbara_theme_option( 'header_style' );

		if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
			if ( in_array( $header_style, array( '7' ) ) ) {
				$menu_extra = mrbara_theme_option( 'menu_extra_1' );
			} elseif ( in_array( $header_style, array( '6', '9' ) ) ) {
				$menu_extra = mrbara_theme_option( 'menu_extra_2' );
			} elseif ( in_array( $header_style, array( '11', '13' ) ) ) {
				$menu_extra = mrbara_theme_option( 'menu_extra_4' );
			} elseif ( $header_style == '12' ) {
				$menu_extra = mrbara_theme_option( 'menu_extra_5' );
			}
		} else {
			$menu_extra = mrbara_theme_option( 'menu_extra_3' );
		}

		return $menu_extra;
	}
endif;

/**
 * Get menu extra
 *
 * @since  1.0.0
 *
 *
 * @return string
 */

if ( ! function_exists( 'mrbara_search_style' ) ) :
	function mrbara_search_style() {
		$header_style = mrbara_theme_option( 'header_style' );

		$search_style = '';

		if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
			if ( in_array( $header_style, array( '1' ) ) ) {
				$search_style = mrbara_theme_option( 'header_search_type' );
			} elseif ( in_array( $header_style, array( '7', '10' ) ) ) {
				$search_style = mrbara_theme_option( 'header_search_type_2' );
			}
		} else {
			$search_style = '3';
		}

		return $search_style;
	}
endif;

/**
 * Get socials
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_get_socials' ) ) :
	function mrbara_get_socials() {
		$socials = array(
			'facebook'   => esc_html__( 'Facebook', 'mrbara' ),
			'twitter'    => esc_html__( 'Twitter', 'mrbara' ),
			'google'     => esc_html__( 'Google', 'mrbara' ),
			'tumblr'     => esc_html__( 'Tumblr', 'mrbara' ),
			'flickr'     => esc_html__( 'Flickr', 'mrbara' ),
			'vimeo'      => esc_html__( 'Vimeo', 'mrbara' ),
			'youtube'    => esc_html__( 'Youtube', 'mrbara' ),
			'linkedin'   => esc_html__( 'LinkedIn', 'mrbara' ),
			'pinterest'  => esc_html__( 'Pinterest', 'mrbara' ),
			'dribbble'   => esc_html__( 'Dribbble', 'mrbara' ),
			'spotify'    => esc_html__( 'Spotify', 'mrbara' ),
			'instagram'  => esc_html__( 'Instagram', 'mrbara' ),
			'tumbleupon' => esc_html__( 'Tumbleupon', 'mrbara' ),
			'wordpress'  => esc_html__( 'WordPress', 'mrbara' ),
			'rss'        => esc_html__( 'Rss', 'mrbara' ),
			'deviantart' => esc_html__( 'Deviantart', 'mrbara' ),
			'share'      => esc_html__( 'Share', 'mrbara' ),
			'skype'      => esc_html__( 'Skype', 'mrbara' ),
			'picassa'    => esc_html__( 'Picassa', 'mrbara' ),
			'blogger'    => esc_html__( 'Blogger', 'mrbara' ),
			'delicious'  => esc_html__( 'Delicious', 'mrbara' ),
			'myspace'    => esc_html__( 'Myspace', 'mrbara' ),
			'vk'         => esc_html__( 'VK', 'mrbara' ),
		);

		$socials = apply_filters( 'mrbara_elegan_socials', $socials );

		return $socials;
	}
endif;


/**
 * Print HTML of currency switcher
 * It requires plugin WooCommerce Currency Switcher installed
 */
if ( ! function_exists( 'mrbara_currency_switcher' ) ) :
	function mrbara_currency_switcher( $show_desc = false ) {
		$currency_dd = '';
		if ( class_exists( 'WOOCS' ) ) {
			global $WOOCS;

			$key_cur = 'name';
			if ( $show_desc ) {
				$key_cur = 'description';
			}

			$currencies    = $WOOCS->get_currencies();
			$currency_list = array();
			foreach ( $currencies as $key => $currency ) {
				if ( $WOOCS->current_currency == $key ) {
					array_unshift(
						$currency_list, sprintf(
							'<li class="actived"><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s</a></li>',
							esc_attr( $currency[$key_cur] ),
							esc_html( $currency[$key_cur] )
						)
					);
				} else {
					$currency_list[] = sprintf(
						'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s</a></li>',
						esc_attr( $currency[$key_cur] ),
						esc_html( $currency[$key_cur] )
					);
				}
			}

			$currency_dd = sprintf(
				'<span class="current">%s<span class="i-icon arrow_carrot-down"></span></span>' .
				'<ul>%s</ul>',
				$currencies[$WOOCS->current_currency][$key_cur],
				implode( "\n\t", $currency_list )
			);


		}

		return $currency_dd;
	}
endif;

/**
 * Print HTML of language switcher
 * It requires plugin WPML installed
 */
if ( ! function_exists( 'mrbara_language_switcher' ) ) :
	function mrbara_language_switcher( $show_name = false ) {
		$language_dd = '';
		if ( function_exists( 'icl_get_languages' ) ) {
			$languages = icl_get_languages();
			if ( $languages ) {
				$lang_list = array();
				$current   = '';
				foreach ( (array) $languages as $code => $language ) {
					if ( ! $language['active'] ) {
						$lang_list[] = sprintf(
							'<li class="%s"><a href="%s">%s</a></li>',
							esc_attr( $code ),
							esc_url( $language['url'] ),
							$show_name ? esc_html( $language['translated_name'] ) : esc_html( $code )
						);
					} else {
						$current = $language;
						array_unshift(
							$lang_list, sprintf(
								'<li class="active %s"><a href="%s">%s</a></li>',
								esc_attr( $code ),
								esc_url( $language['url'] ),
								$show_name ? esc_html( $language['translated_name'] ) : esc_html( $code )
							)
						);
					}
				}

				$language_dd = sprintf(
					'<span class="current">%s<span class="i-icon arrow_carrot-down"></span></span>' .
					'<ul>%s</ul>',
					$show_name ? esc_html( $current['translated_name'] ) : esc_html( $current['language_code'] ),
					implode( "\n\t", $lang_list )
				);
			}
		}

		return $language_dd;
		?>

		<?php
	}
endif;

