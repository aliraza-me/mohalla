<?php
/**
 * Hooks for template header
 *
 * @package MrBara
 */

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function mrbara_enqueue_scripts() {
	/**
	 * Register and enqueue styles
	 */
	wp_register_style( 'mrbara-fonts', mrbara_fonts_url(), array(), '20160802' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.3' );
	wp_register_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), '2.0' );
	wp_register_style( 'eleganticons', get_template_directory_uri() . '/css/eleganticons.css', array(), '1.0' );
	wp_register_style( 'linearicons', get_template_directory_uri() . '/css/linearicons.css', array(), '1.0' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.2' );
	wp_register_style( 'photoswipe', get_theme_file_uri( 'css/photoswipe.css' ), array(), '4.1.1' );
	wp_enqueue_style( 'mrbara', get_template_directory_uri() . '/style.css', array( 'mrbara-fonts', 'font-awesome', 'ionicons', 'eleganticons', 'linearicons', 'bootstrap' ), '20161116' );

	if ( intval( mrbara_theme_option( 'responsiveness' ) ) ) {
		wp_enqueue_style( 'mrbara-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '20161116' );
	}

	wp_add_inline_style( 'mrbara', mrbara_header_styles() );

	/**
	 * Register and enqueue scripts
	 */
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js', array(), '3.7.2' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	wp_register_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	if ( is_singular( 'post' ) || is_home() ) {
		wp_enqueue_script( 'magnific-popup' );
	}

	wp_register_script( 'photoswipe', get_theme_file_uri( 'js/photoswipe.min.js' ), array(), '4.1.1', true );
	wp_register_script( 'photoswipe-ui', get_theme_file_uri( 'js/photoswipe-ui.min.js' ), array( 'photoswipe' ), '4.1.1', true );

	if ( is_singular( 'product' ) ) {

		$photoswipe_skin = 'photoswipe-default-skin';
		if ( wp_style_is( $photoswipe_skin, 'registered' ) && ! wp_style_is( $photoswipe_skin, 'enqueued' ) ) {
			wp_enqueue_style( $photoswipe_skin );
		}

		wp_enqueue_style( 'photoswipe' );
		wp_enqueue_script( 'photoswipe-ui' );
	}

	wp_register_script( 'mrbara-plugins', get_template_directory_uri() . "/js/plugins$min.js", array( 'jquery', 'jquery-ui-autocomplete', 'imagesloaded' ), '20160802', true );
	wp_enqueue_script( 'mrbara', get_template_directory_uri() . "/js/scripts$min.js", array( 'mrbara-plugins' ), '20160802', true );
	wp_add_inline_script( 'mrbara', mrbara_footer_scripts() );

	$script_name = 'wc-add-to-cart-variation';
	if ( wp_script_is( $script_name, 'registered' ) && ! wp_script_is( $script_name, 'enqueued' ) ) {
		wp_enqueue_script( $script_name );
	}

	$days                = intval( wp_kses( mrbara_theme_option( 'newsletter_days' ), wp_kses_allowed_html( 'post' ) ) );
	$product_item_layout = 'product-item-layout-' . mrbara_theme_option( 'product_item_layout' );
	$cross_columns       = intval( mrbara_theme_option( 'crosssells_products_columns' ) );
	$newsletter_seconds  = intval( mrbara_theme_option( 'newsletter_seconds' ) );
	$newsletter_seconds  = $newsletter_seconds ? $newsletter_seconds * 1000 : 3000;

	$product_zoom = 0;
	if ( in_array( mrbara_theme_option( 'product_page_layout' ), array( '1', '2', '8', '9', '12' ) ) ) {
		$product_zoom = intval( mrbara_theme_option( 'product_zoom' ) );
	}

	$product_add_to_cart_ajax = intval( mrbara_theme_option( 'product_add_to_cart_ajax' ) );

	wp_localize_script(
		'mrbara', 'mrbara', array(
			'lightbox'                    => 'yes',
			'ajax_url'                    => admin_url( 'admin-ajax.php' ),
			'nonce'                       => wp_create_nonce( '_mrbara_nonce' ),
			'next'                        => esc_html__( 'Next', 'mrbara' ),
			'prev'                        => esc_html__( 'Prev', 'mrbara' ),
			'mrbara_back'                 => esc_html__( 'Back', 'mrbara' ),
			'mrbara_filter_by'            => esc_html__( 'Filter By', 'mrbara' ),
			'days'                        => $days,
			'product_item_layout'         => $product_item_layout,
			'crosssells_products_columns' => $cross_columns,
			'newsletter_seconds'          => $newsletter_seconds,
			'direction'                   => is_rtl() ? 'rtl' : '',
			'product_zoom'                => $product_zoom,
			'product_add_to_cart_ajax'    => $product_add_to_cart_ajax,
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'mrbara_enqueue_scripts' );


/**
 * Don't Load JS on VC Addons
 *
 */
add_filter( 'mrbara_addons_plugins', '__return_false', 20 );


/**
 * Custom styles on header
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'mrbara_header_styles' ) ) :
	function mrbara_header_styles() {
		/**
		 * All Custom CSS rules
		 */
		$inline_css = '';

		// Background
		if ( intval( mrbara_theme_option( 'boxed_layout' ) ) ) {

			$bg_color = mrbara_theme_option( 'background_color' );
			$bg_image = mrbara_theme_option( 'background_image' );


			$bg_css = ! empty( $bg_color ) ? "background-color: {$bg_color};" : '';

			if ( ! empty( $bg_image ) ) {


				$bg_css .= "background-image: url({$bg_image});";

				$bg_repeats = mrbara_theme_option( 'background_repeats' );
				$bg_css .= "background-repeat: {$bg_repeats};";

				$bg_vertical   = mrbara_theme_option( 'background_vertical' );
				$bg_horizontal = mrbara_theme_option( 'background_horizontal' );
				$bg_css .= "background-position: {$bg_horizontal} {$bg_vertical};";

				$bg_attachments = mrbara_theme_option( 'background_attachments' );
				$bg_css .= "background-attachment: {$bg_attachments};";

				$bg_size = mrbara_theme_option( 'background_size' );
				$bg_css .= "background-size: {$bg_size};";
			}

			if ( $bg_css ) {
				$inline_css .= 'body.boxed {' . $bg_css . '}';
			}
		}

		// Logo
		$logo_size_width = intval( mrbara_theme_option( 'logo_width' ) );
		$logo_css        = $logo_size_width ? 'width:' . $logo_size_width . 'px; ' : '';

		$logo_size_height = intval( mrbara_theme_option( 'logo_height' ) );
		$logo_css .= $logo_size_height ? 'height:' . $logo_size_height . 'px; ' : '';

		$logo_margin = mrbara_theme_option( 'logo_margins' );
		$logo_css .= $logo_margin['top'] ? 'margin-top:' . $logo_margin['top'] . '; ' : '';
		$logo_css .= $logo_margin['right'] ? 'margin-right:' . $logo_margin['right'] . '; ' : '';
		$logo_css .= $logo_margin['bottom'] ? 'margin-bottom:' . $logo_margin['bottom'] . '; ' : '';
		$logo_css .= $logo_margin['left'] ? 'margin-left:' . $logo_margin['left'] . '; ' : '';

		if ( ! empty( $logo_css ) ) {
			$inline_css .= '.site-header .logo img ' . ' {' . $logo_css . '}';
		}

		if ( intval( mrbara_theme_option( 'promotion' ) ) ) {
			$promotion_bg_color = mrbara_theme_option( 'promotion_bg_color' );
			$promotion_bg_image = mrbara_theme_option( 'promotion_bg_image' );

			$promo_css = ! empty( $promotion_bg_color ) ? "background-color: {$promotion_bg_color};" : '';

			if ( ! empty( $promotion_bg_image ) ) {


				$promo_css .= "background-image: url({$promotion_bg_image});";

				$promo_bg_repeats = mrbara_theme_option( 'promotion_bg_repeats' );
				$promo_css .= "background-repeat: {$promo_bg_repeats};";

				$promo_bg_vertical   = mrbara_theme_option( 'promotion_bg_vertical' );
				$promo_bg_horizontal = mrbara_theme_option( 'promotion_bg_horizontal' );
				$promo_css .= "background-position: {$promo_bg_horizontal} {$promo_bg_vertical};";

				$promo_bg_attachments = mrbara_theme_option( 'promotion_bg_attachments' );
				$promo_css .= "background-attachment: {$promo_bg_attachments};";

				$promo_bg_size = mrbara_theme_option( 'promotion_bg_size' );
				$promo_css .= "background-size: {$promo_bg_size};";
			}

			if ( $promo_css ) {
				$inline_css .= '.top-promotion {' . $promo_css . '}';
			}

		}

		if ( is_404() ) {
			$bg_404 = mrbara_theme_option( 'bg_404' );
			if ( $bg_404 ) {
				$inline_css .= " .error404 .site-content { background-image: url($bg_404); } ";
			}
		}

		if ( mrbara_is_account_transparent() ) {
			if ( $login_image = mrbara_theme_option( 'login_page_image' ) ) {
				$inline_css .= ".woocommerce-account .site { background-image: url($login_image); }";
			}
		} elseif ( $banner_image = mrbara_page_header_bg() ) {

			if ( mrbara_is_catalog() ) {
				if ( mrbara_theme_option( 'page_header_layout_shop' ) == '5' ) {
					$inline_css .= ".site-banner .page-header-content { background-image: url($banner_image); }";
				} else {
					$inline_css .= ".site-banner { background-image: url($banner_image); }";
				}
			} else {
				$inline_css .= ".site-banner { background-image: url($banner_image); }";
			}

		}


		// bg menu left
		if ( mrbara_theme_option( 'header_layout' ) == 'header-left' ) {
			if ( $bg_menu = mrbara_theme_option( 'bg_header_left' ) ) {
				$inline_css .= ".primary-left-nav .menu { background-image: url($bg_menu); }";
			}
		}

		$color_scheme_option = mrbara_theme_option( 'color_scheme' );
		$preloader_color     = mrbara_theme_option( 'preloader_color' );

		if ( intval( mrbara_theme_option( 'custom_color_scheme' ) ) ) {
			$color_scheme_option = mrbara_theme_option( 'custom_color' );
		}
		// Don't do anything if the default color scheme is selected.
		if ( $color_scheme_option ) {
			$inline_css .= mrbara_get_color_scheme_css( $color_scheme_option, $preloader_color );
		}

		$body_typo = mrbara_theme_option( 'body_typo' );
		if ( $body_typo ) {
			if ( isset( $body_typo['font-family'] ) && strtolower( $body_typo['font-family'] ) !== 'poppins' ) {
				$inline_css .= mrbara_get_typography_css( $body_typo['font-family'] );
			}
		}

		if ( is_page_template( 'template-home-split.php' ) ) {
			$sections = get_pages(
				array(
					'sort_column'  => 'menu_order',
					'hierarchical' => 0,
					'parent'       => get_the_ID(),
				)
			);

			if ( $sections ) {
				foreach ( $sections as $index => $section ) {
					$shortcodes_custom_css = get_post_meta( $section->ID, '_wpb_shortcodes_custom_css', true );
					if ( ! empty( $shortcodes_custom_css ) ) {
						$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
						$inline_css .= $shortcodes_custom_css;
					}

					$post_custom_css = get_post_meta( $section->ID, '_wpb_post_custom_css', true );
					if ( ! empty( $post_custom_css ) ) {
						$post_custom_css = strip_tags( $post_custom_css );
						$inline_css .= $post_custom_css;
					}
				}
			}
		}

		// Custom CSS from singular post/page
		$css_custom = mrbara_theme_option( 'custom_css' );
		if ( ! empty( $css_custom ) ) {
			$inline_css .= $css_custom;
		}

		return $inline_css;

	}
endif;

/**
 * Custom script on header
 *
 * @since  1.0.0
 */

if ( ! function_exists( 'mrbara_footer_scripts' ) ) :
	function mrbara_footer_scripts() {
		/**
		 * All Custom JS rules
		 */

		return mrbara_theme_option( 'custom_footer_js' );
	}
endif;

/**
 * Display reloader
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_preloader' ) ) :
	function mrbara_preloader() {
		if ( mrbara_theme_option( 'preloader' ) ) : ?>
			<div id="loader" class="mr-loader">
				<div class="preloader">
					<svg class="circular" viewBox="25 25 50 50">
						<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
					</svg>
				</div>
			</div>
		<?php endif;
	}
endif;

add_action( 'mrbara_before_header', 'mrbara_preloader' );

/**
 * Display promotion section at the top of site
 *
 * @since 1.0
 */
if ( ! function_exists( 'mrbara_promotion' ) ) :
	function mrbara_promotion() {
		if ( ! intval( mrbara_theme_option( 'promotion' ) ) ) {
			return;
		}

		if ( is_404() ) {
			return;
		}

		if ( is_page_template( 'template-home-split.php' ) ) {
			return;
		}

		if ( intval( mrbara_theme_option( 'promotion_home_only' ) ) && ! is_front_page() ) {
			return;
		}

		$css_class = '';
		if ( ! intval( mrbara_theme_option( 'promotion_mobile' ) ) ) {
			$css_class = 'disable-promo-mobile';
		}

		printf(
			'<div id="top-promotion" class="top-promotion promotion %s">
			<div class="container">
				<div class="promotion-content">
					<span class="close"><span>%s</span><i class="ion-android-close"></i></span>
					%s
				</div>
			</div>
		</div>',
			esc_attr( $css_class ),
			esc_html__( 'Close', 'mrbara' ),
			do_shortcode( wp_kses( mrbara_theme_option( 'promotion_content' ), wp_kses_allowed_html( 'post' ) ) )
		);
	}
endif;

/**
 * Display promotion section at the top of site
 *
 * @since 1.0
 */
if ( ! function_exists( 'mrbara_promotion_header_top' ) ) :
	function mrbara_promotion_header_top() {
		if ( ( mrbara_theme_option( 'header_layout' ) != 'header-top' ) ) {
			return;
		}
		mrbara_promotion();
	}
endif;

add_action( 'mrbara_before_page', 'mrbara_promotion_header_top', 5 );

/**
 * Display promotion section at the top of site for header left
 *
 * @since 1.0
 */
if ( ! function_exists( 'mrbara_promotion_header_left' ) ) :
	function mrbara_promotion_header_left() {
		if ( ( mrbara_theme_option( 'header_layout' ) != 'header-left' ) ) {
			return;
		}
		mrbara_promotion();
	}
endif;

add_action( 'mrbara_before_header', 'mrbara_promotion_header_left', 5 );


/**
 * Display the site header
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_show_header' ) ) :
	function mrbara_show_header() {
		if ( 'header-top' == mrbara_theme_option( 'header_layout' ) ):

			$header_style = mrbara_theme_option( 'header_style' );
			if ( in_array( $header_style, array( '12', '13' ) ) ) {
				$header_style = '11';
			}
			get_template_part( 'parts/headers/top-style', $header_style );
		else:
			get_template_part( 'parts/headers/left-style', mrbara_theme_option( 'header_left_style' ) );
		endif;
	}
endif;
add_action( 'mrbara_header', 'mrbara_show_header' );


/**
 * Display the site header sep
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_header_sticky_step' ) ) :
	function mrbara_header_sticky_step() {
		if ( 'header-top' == mrbara_theme_option( 'header_layout' ) ):
			if ( intval( mrbara_theme_option( 'header_sticky' ) ) ) {
				printf( '<div class="header-sticky-sep"></div>' );
			}

		endif;
	}
endif;

add_action( 'mrbara_before_header', 'mrbara_header_sticky_step', 30 );

/**
 * Display the top bar
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_show_topbar' ) ) :
	function mrbara_show_topbar() {
		if ( 'header-top' != mrbara_theme_option( 'header_layout' ) ) {
			return;
		}

		if ( ! in_array( mrbara_theme_option( 'header_style' ), array( '8', '9', '10', '11', '12', '13' ) ) ) {
			return;
		}

		if ( ! intval( mrbara_theme_option( 'topbar' ) ) ) {
			return;
		}

		get_template_part( 'parts/headers/top-bar' );
	}
endif;

add_action( 'mrbara_before_header', 'mrbara_show_topbar' );

/**
 * Show a title area
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_show_page_header' ) ) :
	function mrbara_show_page_header() {

		if ( is_404() ) {
			return;
		}

		if ( function_exists( 'is_account_page' ) && is_account_page() && mrbara_theme_option( 'login_page_layout' ) ) {
			return;
		}

		if ( mrbara_is_homepage() ) {
			return;
		}

		if ( is_singular( 'portfolio_project' ) ) {
			if ( get_post_meta( get_the_ID(), '_project_type', true ) == 'image' ) {
				return;
			}
		}


		if ( mrbara_is_catalog() ) {
			get_template_part( 'parts/page-headers/shop' );

		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			get_template_part( 'parts/page-headers/product' );
		} elseif ( is_page() ) {
			get_template_part( 'parts/page-headers/page' );
		} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			get_template_part( 'parts/page-headers/portfolio' );
		} else {
			get_template_part( 'parts/page-headers/default' );
		}


		?>
		<?php
	}
endif;

add_action( 'mrbara_after_header', 'mrbara_show_page_header', 20 );

/**
 * Show a page header layout 4
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_page_header_shop' ) ) :
	function mrbara_page_header_shop() {
		get_template_part( 'parts/page-headers/shop', '2' );
	}
endif;

add_action( 'mrbara_before_content', 'mrbara_page_header_shop', 5 );

/**
 * Show a page header for single portfolio image
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_page_header_portfolio' ) ) :
	function mrbara_page_header_portfolio() {

		if ( ! is_singular( 'portfolio_project' ) ) {
			return;
		}

		if ( get_post_meta( get_the_ID(), '_project_type', true ) != 'image' ) {
			return;
		}

		get_template_part( 'parts/page-headers/default' );
	}
endif;

add_action( 'mrbara_before_portfolio_content', 'mrbara_page_header_portfolio', 5 );

/**
 * Change archive label for shop page
 *
 * @since  1.0.0
 *
 * @param  array $args
 *
 * @return array
 */
if ( ! function_exists( 'mrbara_breadcrumbs_labels' ) ) :
	function mrbara_breadcrumbs_labels( $args ) {
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			$args['labels']['archive'] = esc_html__( 'Shop', 'mrbara' );
		}

		return $args;
	}
endif;

add_filter( 'mrbara_breadcrumbs_args', 'mrbara_breadcrumbs_labels' );

if ( ! function_exists( 'mrbara_shop_topbar' ) ) :
	function mrbara_shop_topbar() {
		if ( ! mrbara_theme_option( 'product_shop_topbar' ) ) {
			return;
		}

		if ( mrbara_is_catalog() ) {
			$container_class = 'container';
			if ( intval( mrbara_theme_option( 'shop_topbar_width' ) ) ) {
				$container_class = 'mr-container-fluid';
			}
			?>
			<aside id="shop-topbar" class="widgets-area shop-topbar">
				<div class="<?php echo esc_attr( $container_class ); ?>">
					<div class="shop-topbar-content">
						<?php dynamic_sidebar( 'shop-topbar' ) ?>
					</div>
				</div>
			</aside><!-- #secondary -->
			<?php
		}
	}
endif;

add_action( 'mrbara_after_header', 'mrbara_shop_topbar', 25 );


/**
 * Returns CSS for the color schemes.
 *
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function mrbara_get_color_scheme_css( $colors, $preloader_color ) {
	return <<<CSS
	/* Color Scheme */

	/* Color */
	a,
	.header-top-style-4 .menu-extra #lang_sel ul li a,
	.header-top-style-4 .menu-extra #lang_sel ul li ul a:hover,
	.left-sidebar .left-widgets .widget_nav_menu .menu li:hover > a,.left-sidebar .left-widgets .widget_nav_menu .menu li.current-menu-item > a,
	.left-sidebar .left-widgets .widget_nav_menu .menu li.show-children > a,
	.left-sidebar .left-widgets .social-links a:hover i,
	.header-transparent .primary-nav > ul > li.current-menu-parent > a,.header-transparent .primary-nav > ul > li.current-menu-item > a,.header-transparent .primary-nav > ul > li.current-menu-item .header-transparent .primary-nav > ul > li.current-menu-ancestor > a,.header-transparent .primary-nav > ul > li:hover > a,
	.header-sticky .site-header.minimized .primary-nav > ul > li.current-menu-parent > a,.header-sticky .site-header.minimized .primary-nav > ul > li.current-menu-item > a,.header-sticky .site-header.minimized .primary-nav > ul > li.current-menu-item .header-sticky .site-header.minimized .primary-nav > ul > li.current-menu-ancestor > a,.header-sticky .site-header.minimized .primary-nav > ul > li:hover > a,
	.header-text-dark.header-top-style-4 .menu-extra #lang_sel ul li ul a:hover,
	.header-text-dark.header-top-style-4 .primary-nav > ul > li.current-menu-parent > a,.header-text-dark.header-top-style-4 .primary-nav > ul > li.current-menu-item > a,.header-text-dark.header-top-style-4 .primary-nav > ul > li.current-menu-ancestor > a,.header-text-dark.header-top-style-4 .primary-nav > ul > li:hover > a,
	.header-text-dark.header-top-style-4 .widget_icl_lang_sel_widget #lang_sel ul li a,
	.header-text-dark.header-top-style-4 .widget_icl_lang_sel_widget #lang_sel ul li ul a:hover,
	.mini-cart.woocommerce .cart_list .mini_cart_item a:hover,
	.off-canvas-panel .widget-panel-header a:hover,
	.ui-autocomplete .ui-menu-item:hover a,
	.site-banner .breadcrumbs,
	.page-header-portfolio-layout-1 .page-header .desc .primary-color,.page-header-portfolio-layout-2 .page-header .desc .primary-color,
	.primary-nav > ul > li.current-menu-parent > a,.primary-nav > ul > li.current-menu-item > a,.primary-nav > ul > li.current-menu-ancestor > a,.primary-nav > ul > li:hover > a,
	.blog-wapper .entry-footer .readmore:hover,
	.entry-format.format-link .link-block:hover,
	.entry-format.format-quote blockquote cite a:hover,
	.entry-footer .footer-socials .social-links a:hover,
	.error404 .not-found .page-content p a,
	.page-template-template-coming-soon .coming-socials a:hover,
	.rev_slider .primary-color,
	.rev_slider .mr-social .mr-link1:hover,
	.rev_slider .mr-btn-buy:after,
	.rev_slider .mr-btn-buy:hover,
	.woocommerce ul.products li.product .product-inner:hover h3 a,
	.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover:before,.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover:before,.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover:before,
	.woocommerce div.product .woocommerce-product-rating .woocommerce-review-link:hover,
	.woocommerce div.product .share .social-links a:hover,
	.woocommerce div.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,.woocommerce div.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before,
	.woocommerce div.product form.cart .group_table .product-name a:hover,
	.woocommerce.woocommerce-wishlist .wishlist_table tbody td.product-price ins .amount,
	.woocommerce .shop-topbar .widget.soo-product-filter-widget .product-filter .filter-swatches .swatch-label.selected,
	.woocommerce #customer_login form.login .lost_password a:hover,.woocommerce #customer_login form.register .lost_password a:hover,
	.woocommerce-account .woocommerce .woocommerce-MyAccount-content .woocommerce-Addresses .woocommerce-Address .woocommerce-Address-edit .edit:hover,
	.my-account-page-transparent .woocommerce #customer_login form.login .form-row .mr-forgot a:hover,.my-account-page-transparent .woocommerce #customer_login form.register .form-row .mr-forgot a:hover,
	.my-account-page-transparent .woocommerce .woocommerce-MyAccount-content .woocommerce-Addresses .woocommerce-Address .woocommerce-Address-edit .edit:hover,
	.product-item-layout-2 ul.products li.product .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-2 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward:hover,
	.product-item-layout-2 ul.products li.product .product-content-thumbnails .compare-button a:hover,.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist a:hover,.product-item-layout-2 ul.products li.product .product-content-thumbnails .product-quick-view:hover,
	.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
	.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,.product-item-layout-2 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
	.product-item-layout-4 ul.products li.product .product-content-thumbnails .compare-button a:hover,
	.product-item-layout-4 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover:before,.product-item-layout-4 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover:before,.product-item-layout-4 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover:before,
	.product-item-layout-4 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,.product-item-layout-4 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before,
	.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .added_to_cart.wc-forward:hover,
	.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover:before,.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover:before,.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover:before,
	.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before,
	.product-item-layout-6 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,.product-item-layout-6 ul.products li.product .product-inner .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before,
	.product-item-layout-7 ul.products li.product .product-inner:hover .product-content-thumbnails .footer-product .btn-add-to-cart,.product-item-layout-7 ul.products li.product .product-inner:hover .product-content-thumbnails .footer-product .added_to_cart.wc-forward,
	.product-item-layout-7 ul.products li.product .product-inner .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-7 ul.products li.product .product-inner .product-content-thumbnails .added_to_cart.wc-forward:hover,
	.product-item-layout-10 ul.products li.product .product-content-thumbnails .btn-add-to-cart,.product-item-layout-10 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward,
	.product-item-layout-10 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,.product-item-layout-10 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,.product-item-layout-10 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
	.product-item-layout-10 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,.product-item-layout-10 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
	.woocommerce-checkout .woocommerce .woocommerce-info .showlogin:hover,.woocommerce-checkout .woocommerce .woocommerce-info .showcoupon:hover,
	.shop-toolbar .products-found span,
	.filters-product-cat ul li a.selected,.filters-product-cat ul li a:hover,
	.product-page-layout-3 div.product .product-layout-3 div.product-details .product-toolbar .back-home:hover,
	.product-page-layout-5 div.product .product-layout-5 .product-toolbar .back-home:hover,
	.product-page-layout-7 div.product .product-layout-7 div.product-details .product-toolbar .back-home:hover,
	.product-page-layout-11 div.product .product-layout-11 div.product-details .product-toolbar .back-home:hover,
	.widget_categories li a:hover,.widget_archive li a:hover,
	.vc_wp_custommenu.style2 .menu > li > a:hover,
	.vc_wp_custommenu.style3 .menu > li > a:hover,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads .shop-link:hover,.primary-sidebar .menu li .mega-menu-content .menu-ads .shop-link:hover,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads .shop-link:after,.primary-sidebar .menu li .mega-menu-content .menu-ads .shop-link:after,
	.footer-layout-1.gray-skin .widget a:hover,
	.footer-layout-1.light-skin .widget a:hover,
	.footer-layout-5 .socials a:hover,
	.footer-layout-5 #lang_sel > ul li a:hover,
	.footer-layout-5 #lang_sel > ul ul li a:hover,
	.footer-layout-8 .social-links a:hover,
	.footer-layout-8 .social-links a:hover i,
	.login-popup.popup-login-2 .login-content .message,
	 .header-sticky.header-top-style-4 .site-header.minimized .widget-mr-language-switcher ul li a:hover,
	.blog-wapper.sticky .entry-title:before,
	.header-top-style-11 .site-header .products-cats-menu.style-3 .menu > li:hover > a,
	.header-top-style-11 .site-header .products-cats-menu.style-2 .menu > li:hover > a,
	.header-top-style-11 .site-header .products-cats-menu.style-4 .menu>li:hover>a,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads .shop-link:after,
	.primary-sidebar .menu li .mega-menu-content .menu-ads .shop-link:after,
	.products-cats-menu .menu li .mega-menu-content .menu-ads .shop-link:after,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads .shop-link:hover,
	.primary-sidebar .menu li .mega-menu-content .menu-ads .shop-link:hover,
	.products-cats-menu .menu li .mega-menu-content .menu-ads .shop-link:hover{
		color: {$colors};
	}

	.header-transparent.header-top-style-1 .primary-nav > ul > li.current-menu-parent > a,
	.header-transparent.header-top-style-1 .primary-nav > ul > li.current-menu-item > a,
	.header-transparent.header-top-style-1 .primary-nav > ul > li.current-menu-ancestor > a,
	.header-transparent.header-top-style-1 .primary-nav > ul > li:hover > a {
		color: #fff;
	}

	.header-text-dark.header-top-style-1 .primary-nav > ul > li.current-menu-parent > a,
	.header-text-dark.header-top-style-1 .primary-nav > ul > li.current-menu-item > a,
	.header-text-dark.header-top-style-1 .primary-nav > ul > li.current-menu-ancestor > a,
	.header-text-dark.header-top-style-1 .primary-nav > ul > li:hover > a {
		color: #000;
	}

	/* BackGround Color */

	.site-header .menu-extra .extra-menu-item.menu-item-cart .mini-cart-counter,
	.header-top-style-8 .site-header .menu-sidebar .search-submit,
	.header-top-style-8 .site-header .menu-sidebar .menu-sideextra .menu-item-cart .mini-cart-counter,
	.header-top-style-9 .site-header .menu-sidebar .menu-sideextra .menu-item-cart .mini-cart-counter,
	.mini-cart.woocommerce .buttons a,
	.mini-cart.woocommerce .buttons .checkout:hover,
	.display-cart .site-header .toggle-cart .cart-icon,
	.rev_slider .mr-button3:hover:before,
	.woocommerce button.button,.woocommerce a.button,.woocommerce input.button,.woocommerce #respond input#submit,
	.woocommerce button.button.alt,.woocommerce a.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,
	.woocommerce .widget_shopping_cart_content .wc-forward,
	.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .btn-add-to-cart,.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward,
	.woocommerce.shop-view-list ul.products li.product .product-content-thumbnails .product-quick-view:hover,
	.woocommerce .products-links .nav-previous a:hover,.woocommerce .products-links .nav-next a:hover,
	.woocommerce div.product p.cart .button,
	.woocommerce div.product form.cart .button,
	.woocommerce div.product form.cart .compare-button .compare:hover,
	.woocommerce div.product form.cart .compare-button .compare:hover:before,
	.woocommerce div.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button .add_to_wishlist:hover,
	.woocommerce div.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,.woocommerce div.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
	.woocommerce.woocommerce-wishlist .wishlist_table tbody td.product-add-to-cart .button:hover,
	.woocommerce form .form-row .button,
	.woocommerce .cart-collaterals .cart_totals .wc-proceed-to-checkout .checkout-button,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce .yith-woocommerce-ajax-product-filter ul.yith-wcan-label li a:hover,
	.woocommerce .yith-woocompare-widget a.compare.button,
	.woocommerce .widget.widget_shopping_cart .widget_shopping_cart_content .buttons .button,
	.woocommerce .widget.widget_shopping_cart .widget_shopping_cart_content .buttons .button.checkout:hover,
	.woocommerce .woocommerce-error .button,
	.woocommerce .woocommerce-message .button,
	.woocommerce.shop-widget-title-style-2 .shop-sidebar .widget .widget-title,
	.woocommerce.shop-widget-title-style-2 .shop-sidebar .widget .widget-title:before,
	.woocommerce .soo-product-filter-widget .filter-slider .ui-slider-range,
	.woocommerce table.my_account_orders .order-actions .button,
	.woocommerce #customer_login form.login .form-row .btn-log .button,.woocommerce #customer_login form.register .form-row .btn-log .button,.woocommerce #customer_login form.login .form-row .btn-regis .button,.woocommerce #customer_login form.register .form-row .btn-regis .button,
	.woocommerce .shop-widget-info ul li:hover .w-icon,
	.woocommerce-account .woocommerce .shop_table .order-actions .button,
	.woocommerce-account.woocommerce-edit-address .woocommerce .woocommerce-MyAccount-content .address-form .button,.woocommerce-account.woocommerce-edit-account .woocommerce .woocommerce-MyAccount-content .address-form .button,.woocommerce-account.woocommerce-edit-address .woocommerce .woocommerce-MyAccount-content .edit-account .button,.woocommerce-account.woocommerce-edit-account .woocommerce .woocommerce-MyAccount-content .edit-account .button,
	.woocommerce-account.woocommerce-lost-password form.lost_reset_password .form-row.reset-btn .button,
	.my-account-page-transparent .woocommerce #customer_login form.login .form-row .btn-log .button,.my-account-page-transparent .woocommerce #customer_login form.register .form-row .btn-log .button,.my-account-page-transparent .woocommerce #customer_login form.login .form-row .btn-regis .button,.my-account-page-transparent .woocommerce #customer_login form.register .form-row .btn-regis .button,
	.product-item-layout-3 ul.products li.product .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-9 ul.products li.product .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-3 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist:hover,.product-item-layout-9 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist:hover,.product-item-layout-3 ul.products li.product .product-content-thumbnails .product-quick-view:hover,.product-item-layout-9 ul.products li.product .product-content-thumbnails .product-quick-view:hover,.product-item-layout-3 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward:hover,.product-item-layout-9 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward:hover,.product-item-layout-3 ul.products li.product .product-content-thumbnails .compare-button a:hover,.product-item-layout-9 ul.products li.product .product-content-thumbnails .compare-button a:hover,
	.product-item-layout-4 ul.products li.product .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-4 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward:hover,
	.product-item-layout-8 ul.products li.product .product-content-thumbnails .yith-wcwl-add-to-wishlist:hover,.product-item-layout-8 ul.products li.product .product-content-thumbnails .product-quick-view:hover,.product-item-layout-8 ul.products li.product .product-content-thumbnails .compare-button:hover,.product-item-layout-8 ul.products li.product .product-content-thumbnails .btn-add-to-cart:hover,.product-item-layout-8 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward:hover,
	.product-item-layout-8 ul.products li.product .product-content-thumbnails .compare-button a:hover,
	.woocommerce-cart table.shop_table tr .actions .button:hover,.woocommerce-cart table.shop_table tr .actions .btn-shop:hover,
	.tooltip-inner,
	.shop-filter-mobile,
	.newsletter-popup.newsletter-2 .newletter-content .n-form input[type="submit"],
	.login-popup .login-content .form-row .button,
	.login-popup.popup-login-2 .login-content .login-row,
	.backtotop,
	.woocommerce .shop-topbar .widget.soo-product-filter-widget .shop-filter-mobile,
	.comment-respond .form-submit .submit,
	.woocommerce.woocommerce-wishlist .wishlist_table tbody td.product-add-to-cart .button,
	.post-password-required .post-password-form input[type="submit"],
	.page-links .page-number,
	.page-links a > .page-number:hover,
	.search-no-results .no-results .search-form .search-submit,
	.header-top-style-11 .site-header .menu-sidebar .search-submit,
	.header-top-style-11 .site-header .products-cats-menu .cats-menu-title,
	.header-top-style-11 .site-header .menu-sideextra .menu-item-yith .mini-yith-counter,
	.header-top-style-11 .site-header .menu-sideextra .menu-item-cart .mini-cart-counter{
		background-color: {$colors};
	}

	.woocommerce.woocommerce-wishlist .wishlist_table tbody td.product-add-to-cart .button:hover,
	.page-links a > .page-number {
		background-color: #333;
	}

	.header-sticky.header-top-style-8 .site-header .primary-nav > ul > li.current-menu-parent > a,
	.header-sticky.header-top-style-8 .site-header .primary-nav > ul > li.current-menu-item > a,
	.header-sticky.header-top-style-8 .site-header .primary-nav > ul > li.current-menu-ancestor > a,
	.header-sticky.header-top-style-8 .site-header .primary-nav > ul > li:hover > a {
		color: #999;
	}

	.header-sticky.header-top-style-9 .site-header .primary-nav > ul > li.current-menu-parent > a,
	.header-sticky.header-top-style-9 .site-header .primary-nav > ul > li.current-menu-item > a,
	.header-sticky.header-top-style-9 .site-header .primary-nav > ul > li.current-menu-ancestor > a,
	.header-sticky.header-top-style-9 .site-header .primary-nav > ul > li:hover > a {
		color: #999;
	}

	.header-sticky.header-top-style-10 .site-header .primary-nav > ul > li.current-menu-parent > a,
	.header-sticky.header-top-style-10 .site-header .primary-nav > ul > li.current-menu-item > a,
	.header-sticky.header-top-style-10 .site-header .primary-nav > ul > li.current-menu-ancestor > a,
	.header-sticky.header-top-style-10 .site-header .primary-nav > ul > li:hover > a {
		color: #999;
	}

	/* Border Color */
	.display-cart .site-header .toggle-cart .cart-icon:before,
	.product-page-layout-4 div.product .product-layout-4 .thumbnails a.active:after,
	.product-page-layout-4 .related-products ul.products li.product .product-content-thumbnails a:hover,
	.product-page-layout-10 .related-products ul.products li.product .product-content-thumbnails a:hover,
	.error404 .not-found .page-content p a,
	 .header-top-style-11 .site-header .products-cats-menu.style-4 .toggle-product-cats {
		border-color: {$colors};
	}

	.tooltip.top .tooltip-arrow {
		border-top-color: {$colors};
	}

	blockquote {
		border-left-color: {$colors};
	}

	@keyframes pre-loader-color {
		100%,
		0% {
			stroke: {$preloader_color['color1']};
		}
		40% {
			stroke: {$preloader_color['color2']};
		}
		66% {
			stroke: {$preloader_color['color3']};
		}
		80%,
		90% {
			stroke: {$preloader_color['color4']};
		}
	}

	.mr-loader .path {
		animation: dash 1.5s ease-in-out infinite, pre-loader-color 6s ease-in-out infinite;
	}


CSS;
}


/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function mrbara_get_typography_css( $body_typo ) {
	return <<<CSS
	.mini-cart.woocommerce .buttons a,
	.topbar #lang_sel > ul > li a,.topbar #lang_sel > ul > li a:visited,
	.topbar .widget-woocommerce-currency-switcher .woocommerce-currency-switcher-form .wSelect-option-icon,
	.related-post .related-title,
	.page-header-default-layout .site-banner .breadcrumbs i:before,
	.page-header-page-layout-11 .site-banner .breadcrumbs i:before,
	.page-header-portfolio-layout-1 .page-header .breadcrumbs i:before,.page-header-portfolio-layout-2 .page-header .breadcrumbs i:before,
	.error404 .not-found .page-content h3,
	.portfolio-wapper .entry-footer .portfolio-title,
	.post-password-required .post-password-form input[type="submit"],
	.search-no-results .no-results .search-form .search-submit,
	.comments-title,
	.split-scroll h1, .split-scroll h2, .split-scroll h3, .split-scroll h4, .split-scroll h5,
	.split-scroll .section-content h5,
	.comment-respond .comment-reply-title,
	.comment-respond .form-submit .submit,
	.woocommerce button.button,.woocommerce a.button,.woocommerce input.button,.woocommerce #respond input#submit,
	.woocommerce button.button.alt,.woocommerce a.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,
	.woocommerce .widget_shopping_cart_content .wc-forward,
	.woocommerce ul.products li.product h3 a,
	.woocommerce ul.products li.product-category h3,
	.woocommerce div.product .product_title,
	.woocommerce div.product form.cart div.quantity .qty,
	.woocommerce div.product form.cart .button,
	.woocommerce div.product form.cart table.group_table tbody tr td,
	.woocommerce div.product form.cart .group_table .product-price,
	.woocommerce div.product form.cart .group_table .product-qty .qty,
	.woocommerce .upsells h2,.woocommerce .related h2,
	.woocommerce form .form-row .button,
	.woocommerce .cart-collaterals .cart_totals .wc-proceed-to-checkout .checkout-button,
	.woocommerce .cross-sells > h2,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce .yith-woocompare-widget a.compare.button,
	.woocommerce .widget.widget_shopping_cart .widget_shopping_cart_content .buttons .button,
	.woocommerce .woocommerce-error .button,
	.woocommerce .woocommerce-message .button,
	.woocommerce table.my_account_orders .order-actions .button,
	.woocommerce #customer_login form.login .form-row .btn-log .button,.woocommerce #customer_login form.register .form-row .btn-log .button,.woocommerce #customer_login form.login .form-row .btn-regis .button,.woocommerce #customer_login form.register .form-row .btn-regis .button,
	.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li a,
	.my-account-page-transparent .woocommerce h2,
	.my-account-page-transparent .woocommerce #customer_login form.login .input-text,.my-account-page-transparent .woocommerce #customer_login form.register .input-text,
	.my-account-page-transparent .woocommerce #customer_login form.login .form-row .btn-log .button,.my-account-page-transparent .woocommerce #customer_login form.register .form-row .btn-log .button,.my-account-page-transparent .woocommerce #customer_login form.login .form-row .btn-regis .button,.my-account-page-transparent .woocommerce #customer_login form.register .form-row .btn-regis .button,
	.product-item-layout-4 ul.products li.product .product-content-thumbnails .btn-add-to-cart,.product-item-layout-4 ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward,
	.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .btn-add-to-cart,.product-item-layout-5 ul.products li.product .product-inner .product-content-thumbnails .added_to_cart.wc-forward,
	.product-item-layout-6 ul.products li.product .product-inner .product-content-thumbnails .btn-add-to-cart,.product-item-layout-6 ul.products li.product .product-inner .product-content-thumbnails .added_to_cart.wc-forward,
	.product-item-layout-6 ul.products li.product .product-inner h3 a,
	.product-item-layout-7 ul.products li.product .product-inner .product-content-thumbnails .btn-add-to-cart,.product-item-layout-7 ul.products li.product .product-inner .product-content-thumbnails .added_to_cart.wc-forward,
	.woocommerce-cart h3.cart-title,
	.woocommerce-order-received h2,.woocommerce-order-received h3,
	.woocommerce .order-info + h2,
	.woocommerce header h2,.woocommerce header h3,
	.select2-container--default .select2-results .select2-results__option,
	.vc_wp_custommenu .menu li.is-mega-menu .dropdown-submenu .menu-item-mega > a,.primary-sidebar .menu li.is-mega-menu .dropdown-submenu .menu-item-mega > a,.products-cats-menu .menu li.is-mega-menu .dropdown-submenu .menu-item-mega > a,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads h2,.primary-sidebar .menu li .mega-menu-content .menu-ads h2,.products-cats-menu .menu li .mega-menu-content .menu-ads h2,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads h4,.primary-sidebar .menu li .mega-menu-content .menu-ads h4,.products-cats-menu .menu li .mega-menu-content .menu-ads h4,
	.vc_wp_custommenu .menu li .mega-menu-content .menu-ads h3,.primary-sidebar .menu li .mega-menu-content .menu-ads h3,.products-cats-menu .menu li .mega-menu-content .menu-ads h3,
	.newsletter-popup .newletter-content .n-title,
	.newsletter-popup.newsletter-2 .newletter-content .n-form input[type="submit"],
	.login-popup .login-content .login-title,
	.login-popup .login-content h3,
	.login-popup .login-content .form-row .button,
	.login-popup.popup-login-2 .login-content .login-row,
	.blog-wapper .entry-title a,
	.filters-dropdown ul li,
	.post-pagination .navigation .page-numbers,
	.woocommerce nav.woocommerce-pagination ul li span,
	.woocommerce nav.woocommerce-pagination ul li a,
	.woocommerce ul.products li.product .product-content-thumbnails .btn-add-to-cart,
	.woocommerce ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward,
	.header-left .site-header .menu-footer .widget-mr-currency-switcher > ul ul li a,
	.header-left .site-header .menu-footer .widget-mr-language-switcher > ul ul li a,
	.modal .modal-header .navbars-title,
	.header-top-style-2 .site-header .header-main .menu-extra .menu-item-search .search-form,
	.menu .hot-badge,.menu .new-badge,.menu .trending-badge,
	.single-post-format .format-gallery-slider .owl-carousel div,
	.single-post-format .format-gallery-slider .owl-carousel div span,
	.blog-navigation-ajax .post-pagination .navigation .page-numbers.next,.portfolio-navigation-ajax .post-pagination .navigation .page-numbers.next,
	.rev_slider .tp-tab .tp-tab-desc,
	.portfolio-masonry .paging.type-ajax .page-numbers.next,
	.woocommerce ul.products li.product .product-content-thumbnails .btn-add-to-cart,.woocommerce ul.products li.product .product-content-thumbnails .added_to_cart.wc-forward,
	.woocommerce div.product form.cart table.group_table thead tr th,
	.woocommerce nav.woocommerce-pagination ul li span,.woocommerce nav.woocommerce-pagination ul li a,
	.woocommerce.shop-widget-title-style-2 .shop-sidebar .widget .widget-title,
	.woocommerce ul.order_details li strong,
	.shipping td ul#shipping_method li label,
	.woocommerce-checkout .woocommerce form.checkout .order-review .woocommerce-checkout-review-order #payment ul.payment_methods li label,
	.shop-filter-mobile .filter-title,
	.tabs-widget .tabs-nav li a,
	#lang_sel > ul > li a,#lang_sel > ul > li a:visited,
	.widget-woocommerce-currency-switcher .woocommerce-currency-switcher-form .wSelect-option-icon {
		  font-family: {$body_typo}, Arial, sans-serif;
	}
CSS;
}