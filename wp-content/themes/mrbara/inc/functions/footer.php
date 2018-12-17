<?php
/**
 * Custom functions for footer.
 *
 * @package Mrbara
 */

/**
 * Display socials in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_socials' ) ) :
	function mrbara_footer_socials( $show_text = false, $show_social = true ) {
		$footer_social = mrbara_theme_option( 'footer_socials' );

		$socials = mrbara_get_socials();
		if ( $footer_social ) {

			printf( '<div class="socials">' );
			if ( $show_text ) {
				echo '<h2>' . esc_html__( 'Follow us on social', 'mrbara' ) . '</h2>';
			}
			foreach ( $footer_social as $social ) {
				foreach ( $socials as $name => $label ) {
					$link_url = $social['link_url'];
					if ( preg_match( '/' . $name . '/', $link_url ) ) {

						if ( $name == 'google' ) {
							$name = 'googleplus';
						}

						if ( $show_social ) {
							if ( $name == 'vk' ) {
								printf( '<a href="%s" target="_blank" class="font-fa"><i class="social fa fa-%s"></i></a>', esc_url( $link_url ), esc_attr( $name ) );
							} else {
								printf( '<a href="%s" target="_blank"><i class="social social_%s"></i></a>', esc_url( $link_url ), esc_attr( $name ) );
							}
						} else {
							printf( '<a href="%s" target="_blank">%s</a>', esc_url( $link_url ), $label );
						}


						break;
					}
				}
			}
			printf( '</div>' );
		}
	}

endif;

/**
 * Display newsletter in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_newsletter' ) ) :
	function mrbara_footer_newsletter() {
		echo do_shortcode( wp_kses( mrbara_theme_option( 'footer_news_letter' ), wp_kses_allowed_html( 'post' ) ) );
	}
endif;

/**
 * Display logo in footer
 *
 * $default_logo
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_logo' ) ) :
	function mrbara_footer_logo( $default_logo, $class = '' ) {
		$footer_logo = mrbara_theme_option( 'footer_logo' );

		$footer_logo = empty( $footer_logo ) ? $default_logo : $footer_logo;

		printf( '<div class="footer-logo %s"><img alt="logo" src="%s" /></div>', esc_attr( $class ), esc_url( $footer_logo ) );
	}
endif;

/**
 * Display copyright in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_copyright' ) ) :
	function mrbara_footer_copyright() {
		echo '<div class="text-copyright">';
		echo do_shortcode( wp_kses( mrbara_theme_option( 'footer_copyright' ), wp_kses_allowed_html( 'post' ) ) );
		echo '</div>';
	}
endif;

/**
 * Display payment in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_payment' ) ) :
	function mrbara_footer_payment() {
		echo do_shortcode( wp_kses( mrbara_theme_option( 'footer_payment' ), wp_kses_allowed_html( 'post' ) ) );
	}
endif;

/**
 * Display menu in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_menu' ) ) :
	function mrbara_footer_menu() {
		if ( has_nav_menu( 'footer' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1
				)
			);
		}
	}
endif;

/**
 * Display widget in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_widget' ) ) :
	function mrbara_footer_widget() {

		$footer_widget_columns = mrbara_theme_option( 'footer_widget_columns' );
		if ( mrbara_theme_option( 'footer_layout' ) == '9' ) {
			$footer_widget_columns = mrbara_theme_option( 'footer_widget_columns_2' );
		}

		$columns   = max( 1, absint( $footer_widget_columns ) );
		$count     = floor( 12 / $columns );
		$css_class = sprintf( 'col-xs-12 col-sm-%1$s col-md-%1$s', esc_attr( $count ) );

		for ( $i = 1; $i <= $columns; $i ++ ) :

			$col_class = $css_class;

			if ( $columns == '4' ) {
				$col_class = 'mrbara-col-2 col-xs-12';
				if ( $i == 1 ) {
					$col_class = 'mrbara-col-4 col-xs-12';
				} elseif ( $i == 4 ) {
					$col_class = 'mrbara-col-3 col-xs-12';
				}
			} elseif ( $columns == '5' ) {
				$col_class = sprintf( 'col-xs-12 col-sm-6 col-md-4 col-lg-%1$s', esc_attr( $count ) );
				if ( $i == 1 || $i == 5 ) {
					$col_class = 'col-xs-12 col-sm-6 col-md-4';
				}

			} elseif ( $columns == '6' ) {
				$col_class = sprintf( 'col-xs-12 col-sm-6 col-md-4 col-lg-%1$s', esc_attr( $count ) );
			}
			?>
			<div class="footer-sidebar footer-<?php echo esc_attr( $i ) ?> <?php echo esc_attr( $col_class ) ?>">
				<?php dynamic_sidebar( "footer-sidebar-$i" ); ?>
			</div>
		<?php endfor;
	}
endif;

/**
 * Display language in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_language' ) ) :
	function mrbara_footer_language() {
		$language = mrbara_language_switcher();
		if ( $language ) {
			$language = sprintf( '<ul><li>%s</li></ul>', $language );
		}
		$language = apply_filters( 'mrbara_footer_language', $language );
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
 * Display currency in footer
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_footer_currency' ) ) :
	function mrbara_footer_currency() {
		$currency = mrbara_currency_switcher();;
		if ( $currency ) {
			$currency = sprintf( '<ul><li>%s</li></ul>', $currency );
		}
		$currency = apply_filters( 'mrbara_footer_currency', $currency );
		if ( $currency ) {
			?>
			<div class="widget-mr-currency-switcher">
				<?php echo $currency; ?>
			</div>
			<?php
		}
	}
endif;

/**
 * Get search popular keywords
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mrbara_popular_keywords' ) ) :
	function mrbara_popular_keywords() {
		$header_style = mrbara_theme_option( 'header_style' );
		$keywords     = '';

		if ( mrbara_theme_option( 'header_layout' ) == 'header-top' ) {
			if ( in_array( $header_style, array( '1' ) ) ) {
				$keywords = mrbara_theme_option( 'popular_keywords' );
			} elseif ( in_array( $header_style, array( '7', '10' ) ) ) {
				$keywords = mrbara_theme_option( 'popular_keywords_2' );
			}
		} else {
			$keywords = mrbara_theme_option( 'popular_keywords_3' );
		}

		return wp_kses( $keywords, wp_kses_allowed_html( 'post' ) );
	}
endif;