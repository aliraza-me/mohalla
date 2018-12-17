<?php
/**
 * Hooks for template nav menus
 *
 * @package MrBara
 */

/**
 * Add a walder object for all nav menu
 *
 * @since  1.0.0
 *
 * @param  array $args The default args
 *
 * @return array
 */
function mrbara_nav_menu_args( $args ) {

	if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
		if ( in_array( mrbara_theme_option( 'header_style' ), array( '1', '8', '11', '9', '10', '12', '13' ) ) ) {
			$args['walker'] = new MrBara_Mega_Menu_Walker;
		} else {
			if ( $args['theme_location'] != 'primary' ) {
				$args['walker'] = new MrBara_Mega_Menu_Walker;
			}
		}
	} else {
		if ( $args['theme_location'] != 'primary' ) {
			$args['walker'] = new MrBara_Mega_Menu_Walker;
		}
	}

	return $args;
}

add_filter( 'wp_nav_menu_args', 'mrbara_nav_menu_args' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since 1.0
 *
 * @param array $args Configuration arguments.
 *
 * @return array
 */
function mrbara_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

add_filter( 'wp_page_menu_args', 'mrbara_page_menu_args' );

/**
 * Add extra items to the end of primary menu
 *
 * @since  1.0.0
 *
 * @param  string $items Items list
 * @param  object $args  Menu options
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_nav_menu_extra_items' ) ) :
	function mrbara_nav_menu_extra_items( $items, $args ) {

		if ( has_nav_menu( 'mobile' ) ) {
			if ( 'mobile' != $args->theme_location ) {
				return $items;
			}
		} elseif ( has_nav_menu( 'primary' ) ) {
			if ( 'primary' != $args->theme_location ) {
				return $items;
			}
		}

		$css_class = 'no-woocommerce';
		$extras = mrbara_menu_extra();
		if ( function_exists( 'is_woocommerce' ) && $extras && in_array( 'account', $extras ) ) {
			if ( is_user_logged_in() ) {
				$orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
				$account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
				if ( $orders ) {
					$account .= '/' . $orders;
				}

				$user_id = get_current_user_id();

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

				$items .= sprintf(
					'<li class="extra-menu-item menu-item-account menu-item-has-children">
						<a href="%s">%s <span class="menu-title">%s</span></a>
						<ul class="sub-menu">
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
					get_avatar( get_the_author_meta( 'ID', $user_id ), 50 ),
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
				$register = '';
				if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
					$register = sprintf(
						'<li><a href="%s" class="item-register">%s</a></li>',
						esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
						esc_html__( 'Sign Up', 'mrbara' )
					);
				}

				$items .= sprintf(
					'<li class="extra-menu-item menu-item-account">
				<ul class="login-items">
					<li><a href="%s" class="item-login">%s</a></li>
					%s
				</ul>
			</li>',
					esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
					esc_html__( 'Log in', 'mrbara' ),
					$register
				);
			}

			$css_class = '';
		}

		$currency = mrbara_currency_switcher();

		if ( $currency ) {
			$items .= sprintf(
				'<li class="extra-menu-item menu-item-currency menu-item-has-children %s">
				%s
			</li>',
				esc_attr( $css_class ),
				$currency
			);

			$css_class = '';
		}

		$language = mrbara_language_switcher( true );
		$language = apply_filters( 'mrbara_header_mobile_language', $language );

		if ( $language ) {
			$items .= sprintf(
				'<li class="extra-menu-item menu-item-language menu-item-has-children %s">
				%s
			</li>',
				esc_attr( $css_class ),
				$language
			);

			$css_class = '';
		}

		$items .= sprintf(
			'<li class="extra-menu-item menu-item-search %s">
				<i class="t-icon ion-ios-search-strong"></i>
				<form class="search-form" method="get" action="%s">
					<input type="text" placeholder="%s" name="s" class="search-field">
					<input type="hidden" name="post_type" value="product">
					<input type="submit" class="btn-submit">
				</form>
			</li>',
			esc_attr( $css_class ),
			esc_url( home_url( '/' ) ),
			esc_attr__( 'Type here', 'mrbara' )
		);


		return $items;
	}
endif;

add_filter( 'wp_nav_menu_items', 'mrbara_nav_menu_extra_items', 10, 2 );