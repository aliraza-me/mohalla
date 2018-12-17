<?php
/**
 * Hooks for displaying elements on footer
 *
 * @package Mrbara
 */
if ( ! function_exists( 'mrbara_show_footer' ) ) :
	function mrbara_show_footer() {
		if ( is_404() || mrbara_is_account_transparent() ) {
			return;
		}

		if ( mrbara_theme_option( 'header_layout' ) == 'header-left' ) {
			return;
		}

		$footer_layout = mrbara_theme_option( 'footer_layout' );
		$footer_layout = $footer_layout == '9' ? '8' : $footer_layout;

		get_template_part( 'parts/footers/layout', $footer_layout );
	}
endif;

add_action( 'mrbara_footer', 'mrbara_show_footer' );

/**
 * Add sidebar to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_sidebar' ) ) :
	function mrbara_sidebar() {
		$header_layout = mrbara_theme_option( 'header_layout' );
		$header_style  = mrbara_theme_option( 'header_style' );

		if ( $header_layout != 'header-top' ) {
			return;
		}

		if ( $header_style != '2' ) {
			return;
		}
		?>

		<div class="widgets-area left-sidebar" id="left-sidebar">
			<div class="sidebar-logo">
				<?php
				get_template_part( 'parts/logo' );
				?>
			</div>
			<div class="left-widgets">
				<?php
				dynamic_sidebar( 'leftbar' )
				?>
			</div>
		</div><!-- #secondary -->
		<?php
	}
endif;

add_action( 'mrbara_after_footer', 'mrbara_sidebar' );

/**
 * Add off canvas shopping cart to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_off_canvas_cart' ) ) :
	function mrbara_off_canvas_cart() {
		if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
			return;
		}

		?>
		<div id="cart-panel" class="mr-cart-panel cart-panel woocommerce mini-cart off-canvas-panel">
			<div class="widget-cart-header  widget-panel-header">
				<a href="#" class="close-canvas-panel"><span aria-hidden="true" class="icon_close"></span><?php esc_html_e( 'Close', 'mrbara' ); ?>
				</a>

				<h2><?php esc_html_e( 'Cart', 'mrbara' ); ?></h2>
			</div>
			<div class="widget_shopping_cart_content">
				<?php woocommerce_mini_cart(); ?>
			</div>
			<div class="mini-cart-loading"><span class="mini-loader"></span></div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_off_canvas_cart' );

/**
 * Add off canvas search to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_off_canvas_search' ) ) :
	function mrbara_off_canvas_search() {

		$menu_extra = mrbara_menu_extra();

		if ( ! $menu_extra ) {
			return;
		}

		if ( ! in_array( 'search', $menu_extra ) ) {
			return;
		}

		if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
			if ( mrbara_search_style() != '3' ) {
				return;
			}
		}

		$custom_search_textbox = mrbara_theme_option( 'custom_search_textbox' );

		?>
		<div id="search-panel" class="search-panel woocommerce fade">
			<div class="search-content">
				<div class="search-panel-con">
					<h2><?php esc_html_e( 'Search', 'mrbara' ); ?></h2>

					<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="instance-search">
						<input type="text" id="search-field-auto" name="s" placeholder="<?php echo esc_attr( $custom_search_textbox ); ?>..." class="search-field">
						<input type="hidden" name="post_type" value="product">
						<input type="submit" class="search-submit">
					</form>
					<?php if ( $keywords = mrbara_popular_keywords() ) { ?>
						<div class="search-panel-foot"><?php esc_html_e( 'Top popular keywords', 'mrbara' ); ?>: <?php echo wp_kses( $keywords, wp_kses_allowed_html( 'post' ) ); ?> </div>
					<?php } ?>
				</div>

			</div>
			<a href="#" class="search-panel-close" id="search-panel-close"><i class="ion-ios-close-empty"></i> </a>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_off_canvas_search' );

/**
 * Add a modal on the footer, for displaying footer modal
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_modal' ) ) :
	function mrbara_footer_modal() {
		?>
		<div id="modal" class="modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog woocommerce product-page-thumbnail-carousel product-page-layout-1">
				<div class="modal-content product">
					<div class="modal-header">
						<div class="close mr-close-modal">
							<i class="icon_close"></i>
						</div>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
			<div class="ajax-loading"><i class="ion-load-c"></i></div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_footer_modal' );

/**
 * Add newsletter popup on the footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_newsletter_popup' ) ) :
	function mrbara_newsletter_popup() {
		if ( ! mrbara_theme_option( 'newsletter_popup' ) ) {
			return;
		}

		$css_class  = '';
		$css_column = 'col-md-12 col-sm-12';
		if ( $layout = mrbara_theme_option( 'newsletter_layout' ) ) {
			$css_class  = $layout;
			$css_column = 'col-md-7 col-sm-7';
		}
		$output = array();

		if ( $title = wp_kses( mrbara_theme_option( 'newsletter_title' ), wp_kses_allowed_html( 'post' ) ) ) {
			$output[] = sprintf( '<h2 class="n-title">%s</h2>', $title );
		}

		$image = mrbara_theme_option( 'newsletter_image' );

		if ( ! $layout ) {
			if ( $image ) {
				$output[] = sprintf( '<img class="n-image" alt="newsletter" src="%s">', esc_url( $image ) );
			}

		}

		if ( $desc = wp_kses( mrbara_theme_option( 'newsletter_desc' ), wp_kses_allowed_html( 'post' ) ) ) {
			$desc     = str_replace( "\n", "<br>", $desc );
			$output[] = sprintf( '<div class="n-desc">%s</div>', $desc );
		}

		if ( $form = wp_kses( mrbara_theme_option( 'newsletter_form' ), wp_kses_allowed_html( 'post' ) ) ) {
			$output[] = sprintf( '<div class="n-form">%s</div>', do_shortcode( $form ) );
		}

		if ( $show = intval( mrbara_theme_option( 'newsletter_show' ) ) ) {
			$output[] = sprintf( '<a href="#" class="n-close">%s</a>', esc_html__( 'Don\'t show this popup again', 'mrbara' ) );
		}

		?>
		<div id="newsletter-popup" class="modal newsletter-popup <?php echo esc_attr( $css_class ); ?>" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="close mr-close-modal">
							<i class="icon_close"></i>
						</div>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="<?php echo esc_attr( $css_column ); ?>">
								<div class="newletter-content">
									<?php echo implode( '', $output ) ?>
								</div>
							</div>
						</div>
						<?php
						if ( $layout ) {
							if ( $image ) {
								printf( '<img class="n-image" alt="newsletter" src="%s">', esc_url( $image ) );
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="ajax-loading"><i class="ion-load-c"></i></div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_newsletter_popup' );

/**
 * Add off canvas menu to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_off_canvas_menu' ) ) :
	function mrbara_off_canvas_menu() {
		if ( mrbara_theme_option( 'header_layout' ) != 'header-top' ) {
			return;
		}

		if ( in_array( mrbara_theme_option( 'header_style' ), array( '1', '3', '4' ) ) ) {
			return;
		}


		?>
		<div id="nav-panel" class="main-nav modal fade">

			<div class="container">
				<div class="modal-content">
					<div class="modal-body">
						<div class="main-nav-content">
							<?php if ( has_nav_menu( 'primary' ) ) : ?>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'container'      => false,
										'depth'          => 3
									)
								);
								?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php
	}
endif;

add_action( 'mrbara_after_footer', 'mrbara_off_canvas_menu' );

/**
 * Add off canvas menu to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_off_canvas_menu_left' ) ) :
	function mrbara_off_canvas_menu_left() {

		if ( mrbara_theme_option( 'header_layout' ) != 'header-left' ) {
			return;
		}

		?>
		<div class="primary-nav nav primary-left-nav">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'walker'         => new MrBara_Menu_Walker(),
						'depth'          => 3
					)
				);
			}
			?>

		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_off_canvas_menu_left' );


/**
 * Add off mobile menu to footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_off_canvas_mobile_menu' ) ) :
	function mrbara_off_canvas_mobile_menu() {
		?>
		<div class="primary-mobile-nav" id="primary-mobile-nav">
			<a href="#" class="close-canvas-mobile-panel">
			<span class="mnav-icon ion-android-close">
			</span>
			</a>
			<?php

			$location = '';
			if ( has_nav_menu( 'mobile' ) ) {
				$location = 'mobile';
			} elseif ( has_nav_menu( 'primary' ) ) {
				$location = 'primary';
			}

			if ( $location ) {
				wp_nav_menu(
					array(
						'theme_location' => $location,
						'container'      => false,
						'walker'         => new MrBara_Menu_Walker()
					)
				);
			}
			?>

		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_off_canvas_mobile_menu' );

/**
 * Display a layer to close canvas panel everywhere inside page
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_site_canvas_layer' ) ) :
	function mrbara_site_canvas_layer() {
		?>
		<div id="off-canvas-layer" class="off-canvas-layer"></div>
		<?php
	}
endif;
add_action( 'wp_footer', 'mrbara_site_canvas_layer' );


/**
 * Dispaly back to top
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_back_to_top' ) ) :
	function mrbara_back_to_top() {

		if ( mrbara_theme_option( 'back_to_top' ) ) : ?>
			<a id="scroll-top" class="backtotop" href="#page-top">
				<i class="fa fa-angle-up"></i>
			</a>
		<?php endif; ?>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_back_to_top' );

/**
 * Add off canvas login to footer
 *
 * @since 1.0.0
 */


if ( ! function_exists( 'mrbara_off_canvas_login' ) ) :
	function mrbara_off_canvas_login() {

		if ( is_user_logged_in() ) {
			return;
		}

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return;
		}

		$extras = mrbara_menu_extra();

		if ( ! $extras ) {
			return;
		}

		if ( ! in_array( 'account', $extras ) ) {
			return;
		}

		$css_column1 = 'col-md-12 col-sm-12';
		$css_column2 = 'col-md-12 col-sm-12';
		$remember    = esc_html__( 'Remember', 'mrbara' );
		if ( $layout = mrbara_theme_option( 'login_layout' ) ) {
			$css_column1 = 'col-md-8 col-sm-8';
			$css_column2 = 'col-md-4 col-sm-4';
			$layout      = 'popup-' . $layout;
			$remember    = esc_html__( 'Keep me logged in', 'mrbara' );
		}

		?>
		<div id="login-popup" class="modal login-popup <?php echo esc_attr( $layout ); ?>" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="close mr-close-modal">
							<i class="icon_close"></i>
						</div>
					</div>
					<div class="modal-body">

						<div class="login-content ">
							<div class="row">
								<?php if ( mrbara_theme_option( 'login_layout' ) ) { ?>
									<div class=" <?php echo esc_attr( $css_column2 ); ?>">
										<div class="login-bar ">
											<?php
											if ( $image = mrbara_theme_option( 'login_image' ) ) {
												printf( '<div class="log-image"> <img  src="%s" alt="login"></div>', esc_url( $image ) );
											}
											?>
											<div class="login-heading">
												<a href="#" class="login-tab"><?php esc_html_e( ' Log in', 'mrbara' ); ?></a>
												<a href="#" class="register-tab"><?php esc_html_e( ' Register', 'mrbara' ); ?></a>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="login-tabs <?php echo esc_attr( $css_column1 ); ?>">
									<div class="login-form">
										<h2 class="login-title"><?php esc_html_e( 'Log in', 'mrbara' ); ?></h2>

										<h3><?php esc_html_e( 'Log in your account', 'mrbara' ); ?></h3>

										<form method="post" action="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ?>" class="login">

											<p class="form-row form-row-wide">
												<?php $username_text = apply_filters( 'mrbara_username_text_login_popup', esc_html__( 'Username or email address', 'mrbara' ) ); ?>
												<input type="text" class="input-text username" placeholder="<?php echo esc_attr( $username_text ); ?>" name="username" value="<?php if ( ! empty( $_POST['username'] ) ) {
													echo esc_attr( $_POST['username'] );
												} ?>" />
											</p>

											<p class="form-row form-row-wide">
												<input class="input-text password" placeholder="<?php esc_html_e( 'Password', 'mrbara' ); ?>" type="password" name="password" />
											</p>

											<p class="form-row">
												<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
												<label for="remember" class="rememberme">
													<input name="rememberme" class="input-checkbox rememberme" type="checkbox" id="remember" value="forever" />
													<span><?php echo esc_attr( $remember ); ?></span>
												</label>
												<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'mrbara' ); ?></a>
											</p>

											<p class="form-row login-row">
												<input type="submit" id="mr-login" class="button" name="login" value="<?php esc_attr_e( 'Log in', 'mrbara' ); ?>" />
											</p>
											<?php
											if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) :
												?>
												<p class="form-row login-col">
													<?php esc_html_e( 'Not a member?', 'mrbara' ); ?>
													<a href="#" class="register-tab"><?php esc_html_e( ' Register now', 'mrbara' ); ?></a>
												</p>
												<?php
											endif;
											?>
											<div class="col-login-social">
												<?php do_action( 'woocommerce_login_form' ); ?>
											</div>
											<?php do_action( 'woocommerce_login_form_end' ); ?>
										</form>
									</div>
									<?php
									if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) :
										?>
										<div class="login-form register-form">
											<h2 class="login-title"><?php esc_html_e( 'Register', 'mrbara' ); ?></h2>

											<h3><?php esc_html_e( 'Become a member', 'mrbara' ); ?></h3>

											<form method="post" action="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ?>" class="register">
												<?php do_action( 'woocommerce_register_form_start' ); ?>
												<p class="form-row form-row-wide">
													<input type="text" class="input-text username" placeholder="<?php esc_html_e( 'Username', 'mrbara' ); ?>" name="username" />
												</p>

												<p class="form-row form-row-wide">
													<input type="email" class="input-text email" placeholder="<?php esc_html_e( 'Email Address', 'mrbara' ); ?>" name="email" />
												</p>

												<p class="form-row form-row-wide">
													<input type="password" class="input-text password" placeholder="<?php esc_html_e( 'Password', 'mrbara' ); ?>" name="password" />
												</p>
												<?php do_action( 'woocommerce_register_form' ); ?>

												<div class="col-login-social">
													<?php do_action( 'register_form' ); ?>
												</div>

												<p class="form-row">
													<label for="terms" class="rememberme">
														<input name="terms terms" class="input-checkbox" type="checkbox" id="terms" />
														<span><?php esc_html_e( 'Agree to the', 'mrbara' ); ?></span>
														<a class="terms_conditions" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_terms_page_id' ) ) ) ?>"><?php esc_html_e( 'Terms and Conditions', 'mrbara' ); ?></a>
													</label>
												</p>

												<div class="form-row">
													<div class="login-row">
														<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
														<input type="submit" id="mr-register" class="button" name="register" value="<?php esc_html_e( 'Register', 'mrbara' ); ?>" />
													</div>
												</div>
												<p class="form-row login-col">
													<?php esc_html_e( 'A member?', 'mrbara' ); ?>
													<a href="#" class="login-tab"><?php esc_html_e( ' Log in now', 'mrbara' ); ?></a>
												</p>


											</form>
										</div>
										<?php
									endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_off_canvas_login' );

/**
 * Adds photoSwipe dialog element
 */

if ( ! function_exists( 'mrbara_product_images_lightbox' ) ) :
	function mrbara_product_images_lightbox() {
		if (  ! is_singular( array( 'product' ) ) ) {
			return;
		}

		?>
		<div id="pswp" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

			<div class="pswp__bg"></div>

			<div class="pswp__scroll-wrap">

				<div class="pswp__container">
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
				</div>

				<div class="pswp__ui pswp__ui--hidden">

					<div class="pswp__top-bar">


						<div class="pswp__counter"></div>

						<button class="pswp__button pswp__button--close" title="<?php esc_attr_e( 'Close (Esc)', 'mrbara' ) ?>"></button>

						<button class="pswp__button pswp__button--share" title="<?php esc_attr_e( 'Share', 'mrbara' ) ?>"></button>

						<button class="pswp__button pswp__button--fs" title="<?php esc_attr_e( 'Toggle fullscreen', 'mrbara' ) ?>"></button>

						<button class="pswp__button pswp__button--zoom" title="<?php esc_attr_e( 'Zoom in/out', 'mrbara' ) ?>"></button>

						<div class="pswp__preloader">
							<div class="pswp__preloader__icn">
								<div class="pswp__preloader__cut">
									<div class="pswp__preloader__donut"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
						<div class="pswp__share-tooltip"></div>
					</div>

					<button class="pswp__button pswp__button--arrow--left" title="<?php esc_attr_e( 'Previous (arrow left)', 'mrbara' ) ?>">
					</button>

					<button class="pswp__button pswp__button--arrow--right" title="<?php esc_attr_e( 'Next (arrow right)', 'mrbara' ) ?>">
					</button>

					<div class="pswp__caption">
						<div class="pswp__caption__center"></div>
					</div>

				</div>

			</div>

		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'mrbara_product_images_lightbox' );