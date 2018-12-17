<?php
/**
 * The template part for displaying the main logo on header
 *
 * @package MrBara
 */

$logo = '';

$header_layout = mrbara_theme_option( 'header_layout' );
$header_style  = mrbara_theme_option( 'header_style' );
if ( in_array( $header_style, array( '12', '13' ) ) ) {
	$header_style = '11';
}

if ( mrbara_is_catalog() ) {
	if ( mrbara_theme_option( 'page_header_layout_shop' ) == '2' ) {
		$logo = mrbara_theme_option( 'logo_shop' );
		if ( $header_layout == 'header-top' && ! in_array( $header_style, array( '2', '9', '8', '10', '11' ) ) ) {
			if ( ! $logo ) {
				if ( intval( mrbara_theme_option( 'header_transparent' ) ) && mrbara_theme_option( 'header_text_color' ) == 'light' ) {
					$logo = mrbara_theme_option( 'logo_transparent' );
				}
			}
		}
	}
} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {

	$product_logo = '';
	if ( mrbara_theme_option( 'page_header_layout_product' ) == '3' ) {
		$product_logo = mrbara_theme_option( 'product_logo' );

		if ( $header_layout == 'header-top' && ! in_array( $header_style, array( '2', '9', '8', '10', '11' ) ) ) {

			if ( ! $product_logo ) {
				if ( intval( mrbara_theme_option( 'header_transparent' ) ) && mrbara_theme_option( 'header_text_color' ) == 'light' ) {
					$product_logo = mrbara_theme_option( 'logo_transparent' );
				}
			}
		}
	}
	if ( intval( get_post_meta( get_the_ID(), 'custom_page_header_layout', true ) ) ) {
		if ( get_post_meta(get_the_ID(), 'page_header_layout', true ) == '3' ) {
			$logo = $product_logo;
			$product_header_logo = get_post_meta(get_the_ID(), 'page_header_logo', true );
			if ( $product_header_logo ) {
				$banner       = wp_get_attachment_image_src( $product_header_logo, 'full' );
				$banner_image = $banner ? $banner[0] : '';

				$logo = $banner_image;
			}
		}
	} else {
		$logo = $product_logo ? $product_logo : $logo;
	}

} elseif ( is_page() ) {
	if ( mrbara_is_account_transparent() ) {
		$logo = mrbara_theme_option( 'logo_transparent' );
	}

	if ( mrbara_is_homepage() && intval( mrbara_theme_option( 'header_transparent' ) ) ) {
		$logo = mrbara_theme_option( 'logo_transparent' );
	} elseif ( mrbara_is_account_transparent() ) {
		$logo = mrbara_theme_option( 'logo_transparent' );
	}


	$custom_logo = get_post_meta( get_the_ID(), 'custom_page_logo', true );

	if( $custom_logo ) {
		$custom_logo = wp_get_attachment_image_src( $custom_logo, 'full' );
		if( $custom_logo ) {
			$logo = $custom_logo[0];
		}
	}

} elseif ( is_404() ) {
	$logo = mrbara_theme_option( 'logo_transparent' );
}
$logo_sticky = '';
if ( ! $logo ) {
	$logo = mrbara_theme_option( 'logo' );
}


if ( ! $logo ) {
	$logo = get_template_directory_uri() . '/img/logo/logo.png';

	if ( $header_layout == 'header-top' ) {
		if ( $header_style == '2' ) {
			$logo = get_template_directory_uri() . '/img/logo/logo-2.png';
		} else {

			if ( $header_style == '4' ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
			} elseif ( $header_style == '5' ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-6.png';
			} elseif ( in_array( $header_style, array( '8', '9', '11' ) ) ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
			} elseif ( in_array( $header_style, array( '10' ) ) ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
				if ( mrbara_theme_option( 'header_skin' ) == 'dark' ) {
					$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
				}
			} elseif ( $header_style == '1' ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
			}

			if ( mrbara_is_catalog() ) {
				if ( mrbara_theme_option( 'page_header_layout_shop' ) == '2' ) {
					if ( $header_style == '4' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';

					} elseif ( $header_style == '5' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-6-light.png';

					} elseif ( in_array( $header_style, array( '8', '9', '11' ) ) ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
					} elseif ( in_array( $header_style, array( '10' ) ) ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
						if ( mrbara_theme_option( 'header_skin' ) == 'dark' ) {
							$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
						}
					} elseif ( $header_style == '1' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
					} else {
						$logo = get_template_directory_uri() . '/img/logo/logo-light.png';

					}
				}
			} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {
				if ( in_array( mrbara_theme_option( 'page_header_layout_product' ), array( '3' ) ) ) {
					if ( $header_style == '4' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';

					} elseif ( $header_style == '5' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-6-light.png';

					} elseif ( in_array( $header_style, array( '8', '9', '11' ) ) ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
					} elseif ( in_array( $header_style, array( '10' ) ) ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
						if ( mrbara_theme_option( 'header_skin' ) == 'dark' ) {
							$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
						}
					} elseif ( $header_style == '1' ) {
						$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
					} else {
						$logo = get_template_directory_uri() . '/img/logo/logo-light.png';

					}
				}

			} elseif ( is_page() ) {
				if ( mrbara_is_homepage() ) {
					if ( mrbara_theme_option( 'header_transparent' ) ) {
						if ( mrbara_theme_option( 'header_text_color' ) == 'light' ) {
							if ( $header_style == '4' ) {
								$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';

							} elseif ( $header_style == '5' ) {
								$logo = get_template_directory_uri() . '/img/logo/logo-6-light.png';

							} elseif ( in_array( $header_style, array( '8', '9', '11' ) ) ) {
								$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
							} elseif ( in_array( $header_style, array( '10' ) ) ) {
								$logo = get_template_directory_uri() . '/img/logo/logo-5.png';
								if ( mrbara_theme_option( 'header_skin' ) == 'dark' ) {
									$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
								}
							} elseif ( $header_style == '1' ) {
								$logo = get_template_directory_uri() . '/img/logo/logo-5-light.png';
							} else {
								$logo = get_template_directory_uri() . '/img/logo/logo-light.png';

							}
						}
					}
				} elseif ( mrbara_is_account_transparent() ) {
					$logo = get_template_directory_uri() . '/img/logo/logo-light.png';
				}
			} elseif ( is_404() ) {
				$logo = get_template_directory_uri() . '/img/logo/logo-light.png';
			}

		}
	} else {
		if ( mrbara_theme_option( 'header_left_style' ) == '1' ) {
			$logo = get_template_directory_uri() . '/img/logo/logo-left-small.png';
		} else {
			$logo = get_template_directory_uri() . '/img/logo/logo-6.png';
		}
	}
}

if ( $header_layout == 'header-top' && ! in_array( $header_style, array( '2', '9', '8', '10', '11' ) ) ) {
	if ( intval( mrbara_theme_option( 'header_sticky' ) ) ) {
		$logo_sticky = mrbara_theme_option( 'logo' );

		if ( ! $logo_sticky ) {
			$logo_sticky = get_template_directory_uri() . '/img/logo/logo.png';
		}
	}
}

if ( $header_layout == 'header-top' && in_array( $header_style, array( '10' ) ) && mrbara_theme_option( 'header_skin' ) == 'dark' ) {
	if ( intval( mrbara_theme_option( 'header_sticky' ) ) ) {
		$logo_sticky = mrbara_theme_option( 'logo_sticky' );

		if ( ! $logo_sticky ) {
			$logo_sticky = get_template_directory_uri() . '/img/logo/logo-5.png';
		}
	}
}

$css_class = '';

if ( $logo_sticky && $logo_sticky != $logo ) {
	$css_class = 'has-logo-sticky';
}


?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo <?php echo esc_attr( $css_class ); ?>">
	<img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $logo ); ?>" />
	<?php if ( $logo_sticky && $logo_sticky != $logo ) { ?>
		<img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo-sticky" src="<?php echo esc_url( $logo_sticky ); ?>" />
	<?php } ?>
</a>

<?php
printf(
	'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
	is_home() || is_front_page() ? 'h1' : 'p',
	esc_url( home_url( '/' ) ),
	get_bloginfo( 'name' )
);
?>
<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
