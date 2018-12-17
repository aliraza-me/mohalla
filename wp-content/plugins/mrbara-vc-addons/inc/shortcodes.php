<?php

/**
 * Define theme shortcodes
 *
 * @package mrbara
 */
class MrBara_Shortcodes {
	/**
	 * Store variables for js
	 *
	 * @var array
	 */
	public $l10n = array();

	public $maps = array();

	public $api_key = '';
	/**
	 * Store variables for sliders
	 *
	 * @var array
	 */
	public $sliders = array();
	/**
	 * Store variables for banners
	 *
	 * @var array
	 */
	public $banners = array();
	/**
	 * Store variables for info banner
	 *
	 * @var array
	 */
	public $info_banners = array();
	/**
	 * Store variables for rev slider
	 *
	 * @var array
	 */
	public $rev_sliders = array();

	/**
	 * Store variables for sliders
	 *
	 * @var array
	 */
	public $has_left_side = false;
	/**
	 * Check if WooCommerce plugin is actived or not
	 *
	 * @var bool
	 */
	private $wc_actived = false;

	/**
	 * Construction
	 *
	 * @return Mrbara_Shortcodes
	 */
	function __construct() {
		$this->wc_actived = function_exists( 'is_woocommerce' );

		$shortcodes = array(
			'instagram',
			'products_carousel',
			'products_carousel_2',
			'products',
			'hot_deal_product',
			'products_picks',
			'products_ads',
			'newsletter',
			'sliders',
			'slider',
			'section_title',
			'section_title_ver',
			'single_image',
			'feature_box',
			'info_box',
			'image_box',
			'video',
			'about',
			'about_2',
			'about_3',
			'about_4',
			'icon_box_1',
			'icon_box_2',
			'icon_list',
			'divider',
			'facts_box',
			'team',
			'image_carousel',
			'products_images_carousel',
			'gmaps',
			'coming_soon',
			'heading',
			'counter',
			'cta',
			'sliders_banners',
			'revslider',
			'banner_grid',
			'info_banners',
			'info_section_title',
			'info_newsletter',
			'countdown',
			'posts',
			'ver_line_2',
			'products_tabs',
			'products_tabs_2',
			'pricing',
			'product_detail',
			'link',
			'vertical_line',
			'pa_swatches',
			'testimonials',
			'testimonials_2',
			'cta_2',
			'banner',
			'banner_large',
			'portfolio_slider',
			'button',
			'progressbar_circle',
			'pie_chart',
			'contact_form',
			'promotion_medium',
			'promotion_large',
			'product_category_box',
			'product_category_box_2',
			'promotion_content_1',
			'promotion_content_2',
			'promotion_content_3',
			'promotion_content_4',
			'posts_carousel',

		);

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( 'mrbara_' . $shortcode, array( $this, $shortcode ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'header' ) );
		add_action( 'wp_footer', array( $this, 'footer' ) );
		add_action( 'wp_footer', array( $this, 'mrbara_left_side_menu' ) );
	}

	/**
	 * Add off canvas right slide menu to footer
	 *
	 * @since 1.0.0
	 */
	function mrbara_left_side_menu() {
		if ( ! $this->has_left_side ) {
			return '';
		}
		?>
		<div class="left-side-menu-icon" id="left-side-menu-icon">
			<ul></ul>
		</div>
		<?php
	}

	/**
	 * Load custom js in footer
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function footer() {

		// Load Google maps only when needed
		if ( isset( $this->l10n['map'] ) ) {
			echo '<script>if ( typeof google !== "object" || typeof google.maps !== "object" )
				document.write(\'<script src="//maps.google.com/maps/api/js?sensor=false&key=' . $this->api_key . '"><\/script>\')</script>';
		}

		global $post;
		wp_register_style( 'font-great-vibes', $this->mrbara_font_great_vibes_url() );

		if ( is_singular() && has_shortcode( $post->post_content, 'mrbara_section_title' ) ) {
			wp_enqueue_style( 'font-great-vibes' );
		}

		wp_register_script( 'circle-progress', MRBARA_ADDONS_URL . '/assets/js/circle-progress.min.js', array(), '1.2.0' );
		wp_register_script( 'sly', MRBARA_ADDONS_URL . '/assets/js/sly.min.js', array(), '1.6.1' );
		wp_register_script( 'flipclock', MRBARA_ADDONS_URL . '/assets/js/flipclock.min.js', array(), '1.1.0' );
		wp_register_script( 'mrbara-addons-plugins', MRBARA_ADDONS_URL . '/assets/js/plugins.js', array(), '20161115' );
		if ( apply_filters( 'mrbara_addons_plugins', true ) ) {
			wp_enqueue_script( 'mrbara-addons-plugins' );
		}
		wp_enqueue_script( 'mrbara-shortcodes', MRBARA_ADDONS_URL . '/assets/js/frontend.js', array(
			'jquery',
			'circle-progress',
			'sly',
			'flipclock',
		), '20161115', true );

		$this->l10n['days']      = esc_html__( 'days', 'mrbara' );
		$this->l10n['hours']     = esc_html__( 'hours', 'mrbara' );
		$this->l10n['minutes']   = esc_html__( 'minutes', 'mrbara' );
		$this->l10n['seconds']   = esc_html__( 'seconds', 'mrbara' );
		$this->l10n['direction'] = is_rtl() ? 'rtl' : '';

		wp_localize_script( 'mrbara-shortcodes', 'mrbaraShortCode', $this->l10n );
	}

	/**
	 * Get URL of font Great Vibes from Google
	 *
	 * @return string
	 */
	public function mrbara_font_great_vibes_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Great Vibes, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Great Vibes font: on or off', 'mrbara' ) ) {
			$font_families = 'Great+Vibes';

			$query_args = array(
				'family' => $font_families,
				'subset' => 'latin-ext',
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Load CSS in header
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function header() {
		wp_enqueue_style( 'mrbara-shortcodes', MRBARA_ADDONS_URL . '/assets/css/frontend.css', array(), '20161115' );

		$color_scheme_option = '';
		$body_typo           = '';
		if ( function_exists( 'mrbara_theme_option' ) ) {
			$color_scheme_option = mrbara_theme_option( 'color_scheme' );
			if ( intval( mrbara_theme_option( 'custom_color_scheme' ) ) ) {
				$color_scheme_option = mrbara_theme_option( 'custom_color' );
			}
			if ( intval( mrbara_theme_option( 'responsiveness' ) ) ) {
				wp_enqueue_style( 'mrbara-shortcodes-responsive', MRBARA_ADDONS_URL . '/assets/css/responsive.css', array(), '20161116' );
			}

			$body_typo = mrbara_theme_option( 'body_typo' );
		} else {
			$color_scheme_option = get_theme_mod( 'color_scheme', '' );
			if ( intval( get_theme_mod( 'custom_color_scheme', '' ) ) ) {
				$color_scheme_option = get_theme_mod( 'custom_color', '' );
			}

			$body_typo = get_theme_mod( 'body_typo', '' );
		}

		$inline_css = '';
		if ( $color_scheme_option ) {
			$inline_css = $this->mrbara_get_color_scheme_css( $color_scheme_option );
		}

		if ( $body_typo ) {
			if ( isset( $body_typo['font-family'] ) && strtolower( $body_typo['font-family'] ) !== 'poppins' ) {
				$inline_css .= $this->mrbara_get_typography_css( $body_typo['font-family'] );
			}
		}

		if ( $inline_css ) {
			wp_add_inline_style( 'mrbara-shortcodes', $inline_css );
		}

	}


	/**
	 * Get instagram shortcode
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function instagram( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'user_id'         => '',
				'numbers'         => 6,
				'image_grayscale' => '',
				'pagination'      => true,
				'autoplay'        => '0',
				'class_name'      => '',
			), $atts
		);


		if ( empty( $atts['user_id'] ) ) {
			return '';
		}

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$columns = 6;
		if ( intval( $atts['numbers'] ) < 6 ) {
			$columns = intval( $atts['numbers'] );
		}

		$id                                     = uniqid( 'instagram-carousel-' );
		$this->l10n['instagramCarousel'][ $id ] = array(
			'autoplay'   => $autoplay,
			'pagination' => intval( $atts['pagination'] ) ? true : false,
			'number'     => $columns,
		);


		if ( $atts['image_grayscale'] ) {
			$atts['class_name'] .= ' gray-scale';
		}

		$output    = '';
		$instagram = $this->scrape_instagram( $atts['user_id'] );

		if ( is_wp_error( $instagram ) ) {
			return $instagram->get_error_message();
		}

		$count = 1;
		foreach ( $instagram as $data ) {

			if ( $count > intval( $atts['numbers'] ) ) {
				break;
			}

			$output .= '<li><a target="_blank" href="' . esc_url( $data['link'] ) . '"><img src="' . esc_url( $data['large'] ) . '" alt="' . esc_attr( $data['description'] ) . '"></a></li>';

			$count++;
		}

		return sprintf(
			'<div class="mrbara-instagram %s" id="%s"><ul class="ins-list clearfix">%s</ul></div>',
			esc_attr( $atts['class_name'] ),
			esc_attr( $id ),
			$output
		);
	}

	/**
	 * Get Instagram images
	 *
	 * @param string $username
	@param int    $limit
	 *
	 * @return array|WP_Error
	 **/
	function scrape_instagram( $username ) {
		$username      = trim( strtolower( $username ) );
		$username      = ltrim( $username, '@' );
		$transient_key = 'mrbara_instagram-' . sanitize_title_with_dashes( $username );

		if ( false === ( $images = get_transient( $transient_key ) ) ) {
			$url = 'https://instagram.com/' . trim( $username );

			$profile = wp_remote_get( $url );

			if ( is_wp_error( $profile ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'mrbara' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $profile ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'mrbara' ) );
			}

			$shared = explode( 'window._sharedData = ', $profile['body'] );
			$data   = explode( ';</script>', $shared[1] );
			$data   = json_decode( $data[0], true );

			if ( ! $data ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'mrbara' ) );
			}

			if ( isset( $data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$nodes = $data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif ( isset( $data['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$nodes = $data['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'mrbara' ) );
			}

			if ( ! is_array( $nodes ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'mrbara' ) );
			}

			$images = array();
			foreach ( $nodes as $node ) {
				$node = $node['node'];

				if ( isset( $node['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
					$caption = $node['edge_media_to_caption']['edges'][0]['node']['text'];
				} else {
					$caption = '';
				}

				$images[] = array(
					'description' => $caption,
					'link'        => trailingslashit( '//instagram.com/p/' . $node['shortcode'] ),
					'time'        => $node['taken_at_timestamp'],
					'comments'    => $node['edge_media_to_comment']['count'],
					'likes'       => $node['edge_media_preview_like']['count'],
					'thumbnail'   => $node['thumbnail_resources'][0]['src'],
					'small'       => $node['thumbnail_resources'][2]['src'],
					'large'       => $node['thumbnail_src'],
					'original'    => $node['display_url'],
					'type'        => $node['is_video'] ? 'video' : 'image',
				);
			}

			$images = serialize( $images );
			set_transient( $transient_key, $images, 2 * 3600 );
		}

		if ( ! empty( $images ) ) {
			return unserialize( $images );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'mrbara' ) );
		}
	}


	/**
	 * Products shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function product_category_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'cat_slug'      => '',
				'cat_color'     => '',
				'cat_icon'      => '',
				'cat_left_side' => true,
				'subcat_slug'   => '',
				'link'          => '',
				'images'        => '',
				'custom_links'  => '',
				'autoplay'      => false,
				'pagination'    => true,
				'products'      => 'recent',
				'per_page'      => 6,
				'columns'       => 3,
				'orderby'       => '',
				'order'         => '',
				'layout'        => 'list',
				'el_class'      => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output    = array();
		$cats_html = array();
		$images    = array();
		$cat_color = $atts['cat_color'];
		$cat_id    = '';
		if ( $atts['cat_slug'] ) {
			$atts['categories'] = $atts['cat_slug'];
			$category           = get_term_by( 'slug', $atts['cat_slug'], 'product_cat' );
			if ( ! is_wp_error( $category ) && $category ) {
				$cat_link    = get_term_link( $category->term_id, 'product_cat' );
				$style       = $cat_color ? 'style="color:' . esc_attr( $cat_color ) . '"' : '';
				$cat_name    = $category->name;
				$cat_id      = 'mrbara-' . sanitize_title( $cat_name );
				$cats_html[] = sprintf( '<h2><a href="%s" class="cat-title" %s>%s</a></h2>', esc_url( $cat_link ), $style, esc_html( $cat_name ) );
				$style_bg    = $cat_color ? 'style="background-color:' . esc_attr( $cat_color ) . '"' : '';
				if ( intval( $atts['cat_left_side'] ) ) {
					$this->has_left_side = true;
					$cats_html[]         = sprintf( '<ul class="right-cat-icon hidden"><li><a href="%s" class="%s" %s> <i class="cat-icon %s"></i><span class="cat-title" %s> %s</span></a></li></ul> ', esc_attr( $cat_id ), esc_attr( $cat_id ), $style_bg, esc_attr( $atts['cat_icon'] ), $style_bg, esc_html( $cat_name ) );
				}
			}
		}

		$subcats_html = array();
		if ( $atts['subcat_slug'] ) {
			$subcats = explode( ',', $atts['subcat_slug'] );
			foreach ( $subcats as $subcat ) {
				$category = get_term_by( 'slug', $subcat, 'product_cat' );
				if ( ! is_wp_error( $category ) && $category ) {
					$cat_link       = get_term_link( $category->term_id, 'product_cat' );
					$cat_name       = $category->name;
					$subcats_html[] = sprintf( '<li><a href="%s" class="subcat-title">%s</a></li>', esc_url( $cat_link ), esc_html( $cat_name ) );
				}
			}

			if ( $subcats_html ) {
				$cats_html[] = sprintf( '<ul class="sub-cats">%s</ul>', implode( ' ', $subcats_html ) );
			}

		}

		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$cats_html[] = sprintf(
					'<div class="footer-link"><a href="%s" class="link" %s%s>%s</a></div>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		$style_border = $cat_color ? 'style="border-color:' . esc_attr( $cat_color ) . '"' : '';

		$output[] = sprintf( '<div class="cats-info" %s>%s</div>', $style_border, implode( ' ', $cats_html ) );

		$custom_links = '';
		if ( function_exists( 'vc_value_from_safe' ) ) {
			$custom_links = vc_value_from_safe( $atts['custom_links'] );
			$custom_links = explode( ',', $custom_links );
		}

		$images_id = $atts['images'] ? explode( ',', $atts['images'] ) : '';

		if ( $images_id ) {
			$i = 0;
			foreach ( $images_id as $attachment_id ) {
				$image = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( $image ) {
					$link = '';
					if ( $custom_links && isset( $custom_links[ $i ] ) ) {
						$link = preg_replace( '/<br \/>/iU', '', $custom_links[ $i ] );
						$link = 'href="' . esc_url( $link ) . '"';

					}
					$images[] = sprintf(
						'<div class="image-item"><a %s ><img alt="%s"  src="%s"></a></div>',
						$link,
						esc_attr( $attachment_id ),
						esc_url( $image[0] )
					);
				}
				$i++;
			}

			$autoplay = intval( $atts['autoplay'] );
			if ( ! $autoplay ) {
				$autoplay = false;
			}

			$id                                     = uniqid( 'product-cats-images' );
			$this->l10n['productCatsImages'][ $id ] = array(
				'autoplay'   => $autoplay,
				'pagination' => intval( $atts['pagination'] ) ? true : false,
			);

			if ( $images ) {
				$output[] = sprintf( '<div class="images-slider" id="%s">%s</div>', esc_attr( $id ), implode( ' ', $images ) );
			}
		}

		$output[] = sprintf( '<div class="products-box" %s>%s</div>', $style_border, $this->get_products( $atts ) );

		return sprintf(
			'<div class="product-category-box woocommerce %s" id="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $cat_id ),
			implode( '', $output )
		);

	}


	/**
	 * Products shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function product_category_box_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'cat_slug'      => '',
				'cat_color'     => '',
				'cat_icon'      => '',
				'banner'        => '',
				'autoplay'      => false,
				'pagination'    => true,
				'cat_left_side' => true,
				'el_class'      => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();
		$images = array();
		$banner = '';

		$images_id = $atts['banner'] ? explode( ',', $atts['banner'] ) : '';

		if ( $images_id ) {
			$i = 0;
			foreach ( $images_id as $attachment_id ) {
				$image = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( $image ) {
					$images[] = sprintf(
						'<div class="image-item"><img alt="%s"  src="%s"></div>',
						esc_attr( $attachment_id ),
						esc_url( $image[0] )
					);
				}
				$i++;
			}

			$autoplay = intval( $atts['autoplay'] );
			if ( ! $autoplay ) {
				$autoplay = false;
			}

			$id                                     = uniqid( 'product-cats-images' );
			$this->l10n['productCatsImages'][ $id ] = array(
				'autoplay'   => $autoplay,
				'pagination' => intval( $atts['pagination'] ) ? true : false,
			);

			if ( $images ) {
				$banner = sprintf( '<div class="images-slider" id="%s">%s</div>', esc_attr( $id ), implode( ' ', $images ) );
			}
		}


		$cats_html = array();
		$cat_color = $atts['cat_color'];
		$cat_id    = '';

		if ( $atts['cat_slug'] ) {
			$atts['categories'] = $atts['cat_slug'];
			$category           = get_term_by( 'slug', $atts['cat_slug'], 'product_cat' );
			if ( ! is_wp_error( $category ) && $category ) {
				$cat_link    = get_term_link( $category->term_id, 'product_cat' );
				$style_bg    = $cat_color ? 'style="background-color:' . esc_attr( $cat_color ) . '"' : '';
				$cat_name    = $category->name;
				$cat_id      = 'mrbara-' . sanitize_title( $cat_name );
				$cats_html[] = sprintf( '<div class="cat-box"><a href="%s"><span class="cat-title" %s><i class="cat-icon %s"></i> %s</span></a>%s</div>', esc_url( $cat_link ), $style_bg, esc_attr( $atts['cat_icon'] ), esc_html( $cat_name ), $banner );

				if ( intval( $atts['cat_left_side'] ) ) {
					$this->has_left_side = true;
					$cats_html[]         = sprintf( '<ul class="right-cat-icon hidden"><li><a href="%s" class="%s" %s> <i class="cat-icon %s"></i><span class="cat-title" %s> %s</span></a></li></ul> ', esc_attr( $cat_id ), esc_attr( $cat_id ), $style_bg, esc_attr( $atts['cat_icon'] ), $style_bg, esc_html( $cat_name ) );
				}
			}
		}

		if ( $cats_html ) {
			$output[] = implode( ' ', $cats_html );
		} else {
			$output[] = $banner;
		}

		return sprintf(
			'<div class="product-category-box product-category-box-2 woocommerce %s" id="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $cat_id ),
			implode( '', $output )
		);

	}

	/**
	 * Products shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_carousel( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'      => '1',
				'title'      => '',
				'products'   => 'recent',
				'categories' => '',
				'per_page'   => 12,
				'number'     => 4,
				'orderby'    => '',
				'order'      => '',
				'link'       => '',
				'autoplay'   => 0,
				'paginated'  => '',
				'el_class'   => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'style-' . $atts['style'];
		}

		$css_class[] = 'columns-' . $atts['number'];

		$output = array();

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$nav  = false;
		$pavi = false;

		if ( $atts['style'] == '1' ) {
			if ( $atts['paginated'] == 'navi' ) {
				$nav         = true;
				$pavi        = true;
				$css_class[] = 'has-navigation';
			} elseif ( $atts['paginated'] == 'pagi' ) {
				$css_class[] = 'has-pagination';
				$pavi        = true;
			}
		}
		$atts['columns'] = $atts['number'];
		if ( $atts['style'] == '2' ) {
			$atts['columns'] = 1;
			$atts['views']   = 3;
			$atts['number']  = 1;
			$atts['layout']  = 'list';
			$nav             = true;
		}

		$output[] = sprintf( '<div class="title">%s</div>', $atts['title'] );

		$output[] = $this->get_products( $atts );

		$id                                    = uniqid( 'products-carousel-' );
		$this->l10n['productsCarousel'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => $nav,
			'pagination' => $pavi,
			'number'     => intval( $atts['number'] ),
		);

		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$output[] = sprintf(
					'<div class="footer-link"><a href="%s" class="link" %s%s>%s</a></div>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		return sprintf(
			'<div class="product-carousel woocommerce %s" id="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			implode( '', $output )
		);
	}

	/**
	 * Helper function, get products for shortcodes
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function get_products( $atts ) {
		global $woocommerce_loop;

		if ( ! $this->wc_actived ) {
			return '';
		}

		$atts = shortcode_atts(
			array(
				'products'       => 'recent',
				'category'       => '',
				'categories'     => '',
				'per_page'       => '',
				'columns'        => '',
				'orderby'        => '',
				'order'          => '',
				'ads'            => '',
				'hide_ads'       => '',
				'ads_subtitle'   => '',
				'ads_image'      => '',
				'ads_image_size' => 'full',
				'ads_title'      => '',
				'ads_link'       => '',
				'layout'         => '',
				'views'          => '',
				'cats_filter'    => false,
			), $atts
		);


		$output     = '';
		$meta_query = WC()->query->get_meta_query();
		$tax_query  = '';

		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
		);

		if ( $atts['categories'] ) {

			$categories        = explode( ',', $atts['categories'] );
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms'    => $categories,
					'field'    => 'slug',
				),
			);
		}

		if ( $atts['products'] == 'recent' ) {
			$args['orderby'] = 'date';
			$args['order']   = 'desc';
		} elseif ( $atts['products'] == 'featured' ) {
			$args['orderby'] = $atts['orderby'];
			$args['order']   = $atts['order'];

			$tax_query   = WC()->query->get_tax_query();
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);

		} elseif ( $atts['products'] == 'best_selling' ) {
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'desc';
			$args['meta_key'] = 'total_sales';
		} elseif ( $atts['products'] == 'top_rated' ) {
			$args['orderby'] = $atts['orderby'];
			$args['order']   = $atts['order'];

			add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
		} elseif ( $atts['products'] == 'sale' ) {
			$args['orderby'] = $atts['orderby'];
			$args['order']   = $atts['order'];

			$product_ids_on_sale   = wc_get_product_ids_on_sale();
			$args['post__in']      = array_merge( array( 0 ), $product_ids_on_sale );
			$args['no_found_rows'] = 1;
		}

		$args['meta_query'] = $meta_query;

		if ( $tax_query ) {
			$args['tax_query'][] = $tax_query;
		}

		ob_start();

		$paged         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args['paged'] = $paged;


		$lines = 0;
		if ( ! empty( $atts['views'] ) && ! empty( $atts['columns'] ) ) {
			$lines = ceil( $atts['views'] / $atts['columns'] );
		}
		$index = 0;
		$cats  = array();


		$products                    = new WP_Query( $args );
		$woocommerce_loop['columns'] = absint( $atts['columns'] );

		if ( function_exists( 'wc_set_loop_prop' ) ) {
			wc_set_loop_prop( 'columns', absint( $atts['columns'] ) );
		}
		if ( $products->have_posts() ) :

			woocommerce_product_loop_start();

			$this->get_banner( $atts );

			while ( $products->have_posts() ) : $products->the_post();

				if ( intval( $atts['cats_filter'] ) ) {
					$post_categories = wp_get_post_terms( get_the_ID(), 'product_cat' );
					foreach ( $post_categories as $cat ) {
						if ( empty( $cats[ $cat->slug ] ) ) {
							$cats[ $cat->slug ] = array( 'name' => $cat->name, 'slug' => $cat->slug, );
						}
					}
				}

				if ( $lines > 1 && $index % $lines == 0 ) : ?>
					<li class="<?php $this->mrbara_wc_content_columns( $atts['columns'] ); ?>">
					<ul class="mrbara-products">
				<?php endif;
				if ( $atts['layout'] == 'list' ) {
					$this->get_template_part( 'content-product', 'list' );
				} else {
					wc_get_template_part( 'content', 'product' );
				}

				if ( $lines > 1 && $index % $lines == $lines - 1 ) {
					echo '</ul></li>';
				} elseif ( $lines > 1 && $index == $products->post_count - 1 ) {
					echo '</ul></li>';
				}

				$index++;
			endwhile; // end of the loop.

			woocommerce_product_loop_end();

		endif;

		wp_reset_postdata();

		remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

		$output .= ob_get_clean();

		$filter_html = '';
		if ( $cats && intval( $atts['cats_filter'] ) ) {

			$filter = array(
				'<li><a href="#filter" class="selected" data-option-value="*"> ' . esc_html__( 'All', 'mrbara' ) . '</a></li>',
			);
			foreach ( $cats as $category ) {
				$filter[] = sprintf( '<li><a href="#filter" data-option-value=".product_cat-%s">%s</a></li>', esc_attr( $category['slug'] ), esc_html( $category['name'] ) );
			}

			$filter_html = '<div class="filters-dropdown"><ul class="option-set" data-option-key="filter">' . implode( "\n", $filter ) . '</ul></div>';

		}

		return $filter_html . $output;
	}

	/**
	 * @param $atts
	 */
	function get_banner( $atts ) {
		if ( ! $atts['hide_ads'] && $atts['ads'] ) {

			$ads_html = array();
			if ( $atts['ads_image'] ) {
				if ( function_exists( 'wpb_getImageBySize' ) ) {
					$image = wpb_getImageBySize(
						array(
							'attach_id'  => $atts['ads_image'],
							'thumb_size' => $atts['ads_image_size'],
						)
					);

					if ( $image['thumbnail'] ) {
						$ads_html[] = $image['thumbnail'];
					} elseif ( $image['p_img_large'] ) {
						$ads_html[] = sprintf(
							'<img alt="" src="%s">',
							esc_attr( $image['p_img_large'][0] )
						);
					}

				}
			}
			if ( empty ( $image ) ) {
				$image = wp_get_attachment_image_src( $atts['ads_image'], 'full' );
				if ( $image ) {
					$ads_html[] = sprintf(
						'<img alt="%s" src="%s">',
						esc_attr( $atts['ads_image'] ),
						esc_url( $image[0] )
					);
				}
			}

			if ( $atts['ads_subtitle'] ) {
				$ads_html[] = sprintf( '<div class="ads-subtitle">%s</div>', $atts['ads_subtitle'] );
			}

			if ( $atts['ads_title'] ) {
				$ads_html[] = sprintf( '<div class="ads-title">%s</div>', $atts['ads_title'] );
			}

			$atts['ads_link'] = ( '||' === $atts['ads_link'] ) ? '' : $atts['ads_link'];
			if ( function_exists( 'vc_build_link' ) ) {

				if ( $atts['ads_link'] ) {
					$link1  = vc_build_link( $atts['ads_link'] );
					$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
					$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
					$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

					$ads_html[] = sprintf( '<a class="ads-link" href="%s" target="%s">%s</a>', esc_url( $url ), esc_attr( $target ), $text );
				}
			}

			$col_ads = 'col-md-6';

			if ( $atts['columns'] == '3' ) {
				$col_ads = 'col-md-8';
			}

			printf( '<li class="product fd-first fd-col-%1$s "></li><li class="%2$s col-sm-6 product fd-col-%1$s ads-item"><div class="ads-banner">%3$s</div></li>', esc_attr( $atts['columns'] ), esc_attr( $col_ads ), implode( '', $ads_html ) );
		}
	}

	/**
	 * Get Bootstrap column classes for products
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	function mrbara_wc_content_columns( $columns ) {

		$col = array( 'col-xs-12' );
		if ( ! empty( $columns ) ) {
			$col[] = sprintf( 'col-sm-%1$s col-md-%1$s', floor( 12 / $columns ) );
		}
		$col[] = 'col-product';

		echo implode( ' ', $col );
	}

	function get_template_part( $slug, $name = '' ) {
		$template = '';

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( MRBARA_ADDONS_DIR . "/templates/{$slug}-{$name}.php" ) ) {
			$template = MRBARA_ADDONS_DIR . "/templates/{$slug}-{$name}.php";
		}

		$template = apply_filters( 'mrbara_get_template_part', $template, $slug, $name );

		if ( $template ) {
			load_template( $template, false );
		}
	}

	/**
	 * Products shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_carousel_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'       => '1',
				'products'    => 'recent',
				'categories'  => '',
				'per_page'    => 12,
				'number'      => 4,
				'orderby'     => '',
				'order'       => '',
				'link'        => '',
				'autoplay'    => 0,
				'navigation'  => true,
				'el_class'    => '',
				'cats_filter' => false,
			), $atts
		);

		if ( $atts['style'] ) {
			$css_class[] = ' carousel-style-' . $atts['style'];
		}

		$atts['columns'] = $atts['number'];

		$css_class[] = $atts['el_class'];

		$css_class[] = 'columns-' . $atts['number'];

		$output = array();

		$speed    = '3000';
		$autoplay = false;
		if ( intval( $atts['autoplay'] ) ) {
			$autoplay = true;
			$speed    = intval( $atts['autoplay'] );
		}

		$icon_left  = '';
		$icon_right = '';

		if ( in_array( $atts['style'], array( '2', '3' ) ) ) {
			$icon_left  = 'ion-ios-arrow-left';
			$icon_right = 'ion-ios-arrow-right';
		} else {
			$icon_left  = 'ion-ios-arrow-thin-left';
			$icon_right = 'ion-ios-arrow-thin-right';
		}

		$nav = intval( $atts['navigation'] );
		if ( $nav ) {
			$css_class[] = 'has-navigation';
		}
		$id                                     = uniqid( 'products-carousel2-' );
		$this->l10n['productsCarousel2'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => $nav ? true : false,
			'number'     => intval( $atts['number'] ),
			'speed'      => $speed,
			'prev'       => sprintf( '<i class="slick-arrow slick-arrow-left %s"></i>', esc_attr( $icon_left ) ),
			'next'       => sprintf( '<i class="slick-arrow slick-arrow-right %s"></i>', esc_attr( $icon_right ) ),
		);

		$output[] = $this->get_products( $atts );
		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$output[] = sprintf(
					'<div class="view-all"><a href="%s" class="link" %s%s>%s</a></div>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		return sprintf(
			'<div class="products-carousel-2 woocommerce %s" id="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			implode( '', $output )
		);
	}

	/**
	 * Products shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'layout'      => '',
				'products'    => 'recent',
				'categories'  => '',
				'per_page'    => 8,
				'columns'     => 4,
				'orderby'     => '',
				'order'       => '',
				'link'        => '',
				'font_weight' => '',
				'el_class'    => '',
				'cats_filter' => false,
			), $atts
		);

		$output = array();
		$link   = '';

		$atts['link'] = ( '||' === $atts['link'] ) ? '' : $atts['link'];
		if ( function_exists( 'vc_build_link' ) ) {

			if ( $atts['link'] ) {
				$link1  = vc_build_link( $atts['link'] );
				$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
				$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
				$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

				$link = sprintf( '<a class="link" href="%s" target="%s">%s</a>', esc_url( $url ), esc_attr( $target ), $text );
			}
		}


		if ( $atts['font_weight'] ) {
			$atts['el_class'] .= 'font-' . $atts['font_weight'];
		}

		if ( $atts['layout'] == 'list' ) {
			$atts['columns']  = 1;
			$atts['el_class'] .= ' mrbara-product-list';
		} else {
			$atts['el_class'] .= ' mrbara-grid-cats';
		}


		$output[] = $this->get_products( $atts );

		if ( ! $atts['layout'] ) {
			$output[] = sprintf( '<div class="grid-link">%s</div>', $link );
		}


		return sprintf(
			'<div class="mrbara-products woocommerce %s ">%s</div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Products - ads shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_ads( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'link'           => '',
				'el_class'       => '',
				'ads'            => true,
				'hide_ads'       => '',
				'ads_image'      => '',
				'ads_image_size' => ' full',
				'ads_title'      => '',
				'ads_link'       => '',
				'products'       => 'recent',
				'categories'     => '',
				'per_page'       => 6,
				'columns'        => 4,
				'orderby'        => '',
				'order'          => '',
			), $atts
		);

		$output = array();

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$atts['ads_subtitle'] = $content;
		}

		$output[] = $this->get_products( $atts );

		$atts['link'] = ( '||' === $atts['link'] ) ? '' : $atts['link'];
		if ( function_exists( 'vc_build_link' ) ) {

			if ( $atts['link'] ) {
				$link1  = vc_build_link( $atts['link'] );
				$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
				$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
				$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

				$output[] = sprintf( '<a class="link" href="%s" target="%s">%s</a>', esc_url( $url ), esc_attr( $target ), $text );
			}
		}

		return sprintf(
			'<div class="mrbara-products-ads woocommerce %s ">%s</div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 * Display icon box 1 shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function icon_box_1( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'        => '1',
				'text_align'   => '',
				'css'          => '',
				'icon'         => '',
				'icon_color'   => '',
				'icon_opacity' => '',
				'subtitle'     => '',
				'link'         => '',
				'el_class'     => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];
		$css_class[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		if ( vc_shortcode_custom_css_has_property( $atts['css'], array( 'background' ) ) ) {
			$css_class[] = 'cta-has-fill';
		}

		$css_class[] = 'text-' . $atts['text_align'];

		if ( $atts['style'] ) {
			$css_class[] = 'icon-box-style' . $atts['style'];
		}

		if ( $atts['style'] == '1' ) {
			if ( $atts['icon_opacity'] ) {
				$css_class[] = 'icon-opacity';
			}
		}

		if ( in_array( $atts['style'], array( '2', '5' ) ) ) {
			if ( $atts['icon_color'] ) {
				$css_class[] = 'icon-' . $atts['icon_color'];
			}
		}

		$link         = '';
		$atts['link'] = ( '||' === $atts['link'] ) ? '' : $atts['link'];
		if ( function_exists( 'vc_build_link' ) ) {

			if ( $atts['link'] ) {
				$link1  = vc_build_link( $atts['link'] );
				$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
				$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

				$link = sprintf( '<a class="link" href="%s" target="%s"></a>', esc_url( $url ), esc_attr( $target ) );
			}
		}

		$output = array();
		$icon   = '';
		if ( $atts['icon'] ) {
			$icon = sprintf( ' <span class="i-icon %s"></span>', $atts['icon'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="b-content">%s</div>', $content );
		}

		if ( in_array( $atts['style'], array( '2', '3', '4', '5' ) ) ) {
			if ( $atts['subtitle'] ) {
				$output[] = sprintf( '<div class="sub-title">%s</div>', $atts['subtitle'] );
			}
		}

		return sprintf(
			'<div class="mrbara-icon-box %s">
				<div class="icon-box-wapper">
					%s
					<div class="icon-box-content">
						%s
					</div>
				</div>
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$icon,
			implode( '', $output ),
			$link
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 * Display icon box 1 shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function icon_box_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'      => '',
				'icon'       => '',
				'icon_color' => '',
				'el_class'   => '',
			), $atts
		);

		$output = array();

		$icon_color = '';
		if ( $atts['icon_color'] ) {
			$icon_color = sprintf( 'style="color: %s"', esc_attr( $atts['icon_color'] ) );
		}

		if ( $atts['icon'] ) {
			$output[] = sprintf( '<div class="b-icon"><span class="%s" %s></span></div>', $atts['icon'], $icon_color );
		}

		if ( $atts['title'] ) {
			$output[] = sprintf( '<div class="b-title">%s</div>', $atts['title'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="b-content">%s</div>', $content );
		}


		return sprintf(
			'<div class="mrbara-icon-box-2 %s">
				%s
			</div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 * Display icon box 1 shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function icon_list( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'    => 'style1',
				'icon'     => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];


		if ( $atts['style'] ) {
			$css_class[] = 'icon-' . $atts['style'];
		}

		$output = array();
		if ( $atts['icon'] ) {
			$output[] = sprintf( ' <span class="icon %s"></span>', esc_attr( $atts['icon'] ) );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="desc">%s</div>', $content );
		}

		return sprintf(
			'<div class="mrbara-icon-list %s">
				%s
			</div>',
			esc_attr( implode( '', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 * Display icon box 1 shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function divider( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'      => '',
				'light_skin' => '',
				'box_shadow' => '',
				'el_class'   => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];
		if ( $atts['light_skin'] ) {
			$css_class[] = 'light-skin';
		}
		if ( $atts['box_shadow'] ) {
			$css_class[] = 'box-shadow';
		}

		$output = array();
		if ( $atts['title'] ) {
			$output[] = sprintf( ' <span class="title">%s</span>', esc_attr( $atts['title'] ) );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="desc">%s</div>', $content );
		}

		return sprintf(
			'<div class="mrbara-divider %s">
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 * Display icon box 1 shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function facts_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'number'     => '',
				'icon'       => '',
				'icon_color' => '',
				'el_class'   => '',
			), $atts
		);

		$output = array();

		$icon_color = '';
		if ( $atts['icon_color'] ) {
			$icon_color = sprintf( 'style="color: %s"', esc_attr( $atts['icon_color'] ) );
		}

		if ( $atts['icon'] ) {
			$output[] = sprintf( '<div class="b-icon"><span class="%s" %s></span></div>', $atts['icon'], $icon_color );
		}

		if ( $atts['number'] ) {
			$output[] = sprintf( '<div class="number">%s</div>', $atts['number'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="b-content">%s</div>', $content );
		}


		return sprintf(
			'<div class="mrbara-facts-box %s">
				%s
			</div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display contact form
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function contact_form( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'form'      => '',
				'dark_skin' => '',
				'el_class'  => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];
		if ( $atts['dark_skin'] ) {
			$css_class[] = 'dark-skin';
		}

		return sprintf(
			'<div class="mrbara-contact-form %s">
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			do_shortcode( '[contact-form-7 id="' . esc_attr( $atts['form'] ) . '"]' )
		);
	}

	/**
	 * Shortcode to display newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function newsletter( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'             => 'style1',
				'title_font_size'   => '',
				'light_skin'        => '',
				'textbox_skin'      => 'light',
				'sub_title'         => '',
				'bg_color'          => '',
				'title'             => '',
				'title-pc'          => esc_html__( 'get|10%|discount', 'mrbara' ),
				'bg_image'          => '',
				'form'              => '',
				'title_font_family' => '',
				'title_font_style'  => '',
				'el_class'          => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'newsletter-' . $atts['style'];
		}

		if ( ! in_array( $atts['style'], array( 'style1', 'style3', 'style4' ) ) ) {
			$css_class[] = 'textbox-' . $atts['textbox_skin'];
		}

		if ( $atts['light_skin'] ) {
			$css_class[] = 'light-skin';
		}

		$bg_style = '';

		if ( in_array( $atts['style'], array( 'style7', 'style10' ) ) ) {

			$bg_style = 'style="background-color: transparent;"';
			if ( $atts['bg_color'] ) {
				$bg_style = sprintf( 'style="background-color: %s;"', esc_attr( $atts['bg_color'] ) );
			}
		}

		if ( $atts['style'] == 'style10' ) {
			if ( ! empty( $atts['bg_image'] ) ) {
				$bg_image = wp_get_attachment_image_src( intval( $atts['bg_image'] ), 'full' );
				if ( $bg_image ) {
					$bg_style = sprintf( 'style="background-image: url(%s);"', esc_url( $bg_image[0] ) );
				}
			}
		}

		$output = array();
		if ( $atts['style'] == 'style3' ) {
			if ( $atts['sub_title'] ) {
				$output[] = sprintf( '<div class="sub-title">%s</div>', $atts['sub_title'] );
			}
		}

		$arr = array(
			'font_size'   => $atts['title_font_size'],
			'font_family' => $atts['title_font_family'],
			'font_style'  => $atts['title_font_style'],
		);

		$title_style = $this->get_style_attr( $arr );

		if ( ! in_array( $atts['style'], array( 'style2', 'style9' ) ) ) {
			if ( $atts['style'] != 'style4' && $atts['title'] ) {
				$output[] = sprintf( '<div class="title" %s>%s</div>', $title_style, $atts['title'] );
			}
		} else {
			if ( $atts['title-pc'] ) {
				$title = explode( '|', $atts['title-pc'] );
				if ( sizeof( $title ) > 2 ) {
					$output[] = sprintf( '<div class="title" %s>%s <span>%s </span>%s</div>', $title_style, $title[0], $title[1], $title[2] );
				} elseif ( sizeof( $title ) > 1 ) {
					$output[] = sprintf( '<div class="title" %s>%s <span>%s </span></div>', $title_style, array_shift( $title ), implode( ' ', $title ) );
				} else {
					$output[] = sprintf( '<div class="title" %s>%s</div>', $title_style, $atts['title-pc'] );
				}
			}
		}

		if ( ! in_array( $atts['style'], array( 'style1', 'style2' ) ) ) {
			if ( $content ) {
				if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
					$content = wpb_js_remove_wpautop( $content, true );
				}
				$output[] = sprintf( '<div class="desc">%s</div>', $content );
			}
		}

		$col_left  = 'col-md-4 col-sm-12 col-xs-12';
		$col_right = 'col-md-8 col-sm-12 col-xs-12';

		if ( $atts['style'] == 'style6' ) {
			$col_left  = 'col-md-5 col-sm-12 col-xs-12';
			$col_right = 'col-md-7 col-sm-12 col-xs-12';
		} elseif ( $atts['style'] == 'style7' ) {
			$col_left  = 'col-md-offset-1 col-md-5 col-sm-12 col-xs-12';
			$col_right = 'col-md-5 col-sm-12 col-xs-12';
		} elseif ( $atts['style'] == 'style9' ) {
			$col_left  = 'col-md-12 col-sm-12 col-xs-12';
			$col_right = 'col-md-12 col-sm-12 col-xs-12';
		} elseif ( $atts['style'] == 'style10' ) {
			$col_left  = 'col-md-4 col-sm-12 col-md-offset-1  col-xs-12';
			$col_right = 'col-md-5 col-sm-12 col-md-offset-1  col-xs-12';
		}

		return sprintf(
			'<div class="mrbara-newletter %s" %s>
				<div class="container">
	                <div class="row">
	                    <div class="%s b-content">
	                        %s
	                    </div>
	                    <div class="%s b-form">
	                    	<div class="letter-fied">
	  	                        %s
							</div>
	                    </div>
	                </div>
	            </div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$bg_style,
			$col_left,
			implode( '', $output ),
			$col_right,
			do_shortcode( '[mc4wp_form id="' . esc_attr( $atts['form'] ) . '"]' )
		);
	}

	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public function get_style_attr( $atts ) {
		$style = array();
		if ( $atts['font_size'] ) {
			$style[] = 'font-size:' . $atts['font_size'];
		}

		if ( $atts['font_family'] ) {
			$style[] = 'font-family:' . $atts['font_family'] . ',"Times New Roman", serif';
		}

		if ( $atts['font_style'] ) {
			$style[] = 'font-weight:' . $atts['font_style'];
		}

		if ( isset( $atts['line_height'] ) && $atts['line_height'] ) {
			$style[] = 'line-height:' . $atts['line_height'];
		}

		if ( isset( $atts['letter_spacing'] ) && $atts['letter_spacing'] ) {
			$style[] = 'letter-spacing:' . $atts['letter_spacing'];
		}

		if ( isset( $atts['color'] ) && $atts['color'] ) {
			$style[] = 'color:' . $atts['color'];
		}

		if ( $style ) {
			return 'style="' . esc_attr( implode( ';', $style ) ) . '"';
		}

		return '';


	}

	/**
	 * Shortcode to display newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function image_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'             => '1',
				'image'             => '',
				'image_size'        => 'full',
				'link'              => '',
				'title_font_size'   => '',
				'title_font_family' => '',
				'title_font_style'  => '',
				'box_shadow'        => '',
				'el_class'          => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];
		if ( $atts['style'] ) {
			$css_class[] = ' style' . $atts['style'];
		}

		if ( intval( $atts['title_font_size'] >= 48 ) ) {
			$css_class[] = 'text-big';
		} elseif ( intval( $atts['title_font_size'] >= 36 ) ) {
			$css_class[] = 'text-large';
		} elseif ( intval( $atts['title_font_size'] >= 24 ) ) {
			$css_class[] = 'text-normal';
		} elseif ( intval( $atts['title_font_size'] < 24 ) ) {
			$css_class[] = 'text-small';
		}

		if ( $atts['box_shadow'] ) {
			$css_class[] = ' box-shadow';
		}

		$output = array();
		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="desc">%s</div>', $content );
		}
		$view_more = '';
		$link      = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link      = vc_build_link( $atts['link'] );
			$view_more = sprintf(
				'<a class="view-info" href="%s"%s%s>',
				esc_url( $link['url'] ),
				! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
				! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : ''

			);
		}

		$title_style = $this->get_style_attr(
			array(
				'font_size'   => $atts['title_font_size'],
				'font_family' => $atts['title_font_family'],
				'font_style'  => $atts['title_font_style'],
			)
		);

		$image_src = $this->get_image_src( $atts['image'], $atts['image_size'] );

		return sprintf(
			'<div class="mrbara-image-box %s">' .
			'	%s' .
			'		%s' .
			'		<span class="sep"></span>' .
			'		<span class="title" %s>%s</span>' .
			'	</a>' .
			'	%s' .
			'</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$view_more,
			$image_src,
			$title_style,
			isset( $link['title'] ) ? $link['title'] : '',
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function cta( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'link'     => '',
				'el_class' => '',
			), $atts
		);

		$atts['link'] = ( '||' === $atts['link'] ) ? '' : $atts['link'];
		if ( function_exists( 'vc_build_link' ) ) {

			if ( $atts['link'] ) {
				$link1  = vc_build_link( $atts['link'] );
				$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
				$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
				$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

				$link = sprintf( '<a class="link cta-btn" href="%s" target="%s">%s</a>', esc_url( $url ), esc_attr( $target ), $text );
			}
		}

		return sprintf(
			'<div class="mrbara-cta %s">
				<div class="container">
	                <div class="row">
	                    <div class="col-md-12 col-sm-12 col-xs-12">
	                    	<div class="cta-content">
	                    	 	<span class="cta-title">%s</span>%s
							</div>
	                    </div>
	                </div>
	            </div>
			</div>',
			esc_attr( $atts['el_class'] ),
			esc_attr( $atts['title'] ),
			$link
		);
	}

	/**
	 * Sliders shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function sliders( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'autoplay'     => '',
				'navigation'   => true,
				'scrollbar'    => true,
				'el_class'     => '',
				'active_slide' => 0,
			), $atts
		);

		$autoplay = intval( $atts['autoplay'] );
		$speed    = '5000';

		if ( ! $autoplay ) {
			$autoplay = true;
		} else {
			$speed    = $autoplay;
			$autoplay = false;
		}

		$id                                   = uniqid( 'sliders-carousel-' );
		$this->l10n['slidersCarousel'][ $id ] = array(
			'autoplay'     => $autoplay,
			'speed'        => $speed,
			'active_slide' => intval( $atts['active_slide'] ),
		);


		if ( ! intval( $atts['navigation'] ) ) {
			$atts['el_class'] .= ' hide-navigation';
		}

		if ( ! intval( $atts['scrollbar'] ) ) {
			$atts['el_class'] .= ' hide-scrollbar';
		}

		$this->sliders = array();
		do_shortcode( $content );

		if ( empty( $this->sliders ) ) {
			return '';
		}

		$output = array();
		$total  = count( $this->sliders );

		if ( ! $total ) {
			return '';
		}

		$i = 0;
		foreach ( $this->sliders as $index => $slider ) {
			$item  = array();
			$image = '';
			if ( $slider['bg_image'] ) {
				if ( $slider['bg_image_size'] ) {
					if ( function_exists( 'wpb_getImageBySize' ) ) {
						$image = wpb_getImageBySize(
							array(
								'attach_id'  => $slider['bg_image'],
								'thumb_size' => $slider['bg_image_size'],
							)
						);

						if ( $image['thumbnail'] ) {
							$item[] = sprintf(
								'<div class="slider-image">%s</div>', $image['thumbnail']
							);
						} elseif ( $image['p_img_large'] ) {
							$item[] = sprintf(
								'<div class="slider-image"> <img alt="" src="%s"></div>',
								esc_attr( $image['p_img_large'][0] )
							);
						}
					}
				}
				if ( empty ( $image ) ) {
					$image = wp_get_attachment_image_src( $slider['bg_image'], 'full' );
					if ( $image ) {
						$item[] = sprintf(
							'<div class="slider-image"><img alt="%s" src="%s"></div>',
							esc_attr( $slider['bg_image'] ),
							esc_url( $image[0] )
						);
					}
				}
			}

			$item[] = "<div class='s-content'>";

			if ( in_array( $slider['style'], array( '2', '3' ) ) ) {
				if ( $slider['subtitle'] ) {
					$item[] = sprintf( '<div class="s-subtitle">%s</div>', $slider['subtitle'] );
				}
			}


			if ( $slider['title'] ) {
				$title = $slider['title'];
				if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
					$title = wpb_js_remove_wpautop( $title, true );
				}

				$item[] = sprintf( '<div class="s-title">%s</div>', $title );
			}
			if ( in_array( $slider['style'], array( '1', '2' ) ) ) {

				if ( $slider['desc'] ) {
					$item[] = sprintf( '<div class="s-desc">%s</div>', $slider['desc'] );
				}
			}

			if ( in_array( $slider['style'], array( '1' ) ) ) {
				if ( $slider['category'] ) {
					$item[] = sprintf( '<div class="s-cat">%s</div>', $slider['category'] );
				}
			}

			$link_image     = '';
			$slider['link'] = ( '||' === $slider['link'] ) ? '' : $slider['link'];
			if ( function_exists( 'vc_build_link' ) ) {

				if ( $slider['link'] ) {
					$link1  = vc_build_link( $slider['link'] );
					$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
					$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
					$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

					if ( $text ) {
						$item[] = sprintf( '<a class="s-link" href="%s" target="%s"><span>%s</span><i class="ion-android-arrow-forward"></i> </a>', esc_url( $url ), esc_attr( $target ), $text );
					}
					if ( $slider['link_image'] ) {
						$link_image = sprintf( '<a class="link-image" href="%s" target="%s">%s</a>', esc_url( $url ), esc_attr( $target ), $text );
					}
				}
			}

			$item[] = "</div>";

			$item[] = $link_image;

			$output[] = sprintf( '<div class="mr-slider slider-style-%s">%s</div>', esc_attr( $slider['style'] ), implode( '', $item ) );


			$i++;
		}

		return sprintf(
			'
            <div class="mr-sliders %s" id="%s">
            	<div class="loading"><i class="ion-load-c"></i></div>
			    <div class="sliders-frame"><div class="sliders-list">%s</div></div>
			    <div class="navigation">
			    	 <div class="container">
			    	 	 <div class="btn-prev"><i class="ion-ios-arrow-left"></i></div>
                   		 <div class="btn-next"><i class="ion-ios-arrow-right"></i></div>
			    	 </div>
			    </div>
			    <div class="container">
			        <div class="scrollbar">
                        <div class="handle">
                            <div class="mousearea"></div>
                        </div>
			        </div>
			        <ul class="pages">
			        </ul>
                </div>

			</div>',
			esc_attr( $atts['el_class'] ),
			esc_attr( $id ),
			implode( '', $output )
		);
	}

	/**
	 * Icon box tab shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function slider( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'bg_image'      => '',
				'bg_image_size' => '1170x644',
				'desc'          => '',
				'category'      => '',
				'link'          => '',
				'link_image'    => '',
				'subtitle'      => '',
				'style'         => '1',
			), $atts
		);

		$this->sliders[] = array(
			'bg_image'      => $atts['bg_image'],
			'bg_image_size' => apply_filters( 'mrbara_sliders_image_size', $atts['bg_image_size'] ),
			'title'         => $content,
			'desc'          => $atts['desc'],
			'category'      => $atts['category'],
			'link'          => $atts['link'],
			'link_image'    => $atts['link_image'],
			'subtitle'      => $atts['subtitle'],
			'style'         => $atts['style'],

		);

		return '';
	}

	/**
	 * Full Height Grid shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function sliders_banners( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'el_class' => '',
			), $atts
		);

		$this->banners = array();
		do_shortcode( $content );

		if ( empty( $this->banners ) ) {
			return '';
		}

		$output = array();

		$i = 0;
		foreach ( $this->banners as $index => $banner ) {

			$css_class = 'banner-normal';
			if ( $i % 5 == 0 ) {
				$css_class = 'banner-full';
			} elseif ( $i % 5 == 1 ) {
				$css_class = 'banner-long';
			} elseif ( $i % 5 == 3 ) {
				$css_class = 'banner-wide';
			} elseif ( $i % 5 == 4 ) {
				$css_class = 'banner-thumb';
			}
			$i++;
			if ( isset( $banner['alias'] ) ) {
				if ( $banner['alias'] ) {
					$output[] = sprintf( '<div class="%s banner-item">%s</div>', esc_attr( $css_class ), do_shortcode( '[rev_slider_vc alias="' . $banner['alias'] . '"]' ) );
				}
				continue;
			} else {
				$output[] = sprintf( '<div class="%s banner-item">%s</div>', esc_attr( $css_class ), $banner['b_content'] );
			}

		}

		return sprintf( '<div class="mr-sliders-banners">%s</div>', implode( '', $output ) );

	}

	/**
	 * Promotion shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function banner_grid( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'      => '',
				'image_size' => 'full',
				'desc'       => '',
				'bg_color'   => '',
				'link'       => '',
				'link_hover' => '',
				'dark_skin'  => '',
			), $atts
		);

		$output   = array();
		$output[] = $this->get_image_src( $atts['image'], $atts['image_size'] );

		$output[] = '<div class="banner-content">';


		$output[] = '<div class="banner-desc">';
		if ( $content ) {
			$output[] = sprintf(
				'<div class="b-title">%s</div>',
				$content
			);
		}

		if ( $atts['desc'] ) {
			$content = $atts['desc'];
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf(
				'<div class="desc">%s</div>',
				$content
			);
		}
		$output[] = '</div>';

		$atts['link'] = ( '||' === $atts['link'] ) ? '' : $atts['link'];
		if ( function_exists( 'vc_build_link' ) ) {

			if ( $atts['link'] ) {
				$link1  = vc_build_link( $atts['link'] );
				$url    = strlen( $link1['url'] ) > 0 ? $link1['url'] : '';
				$text   = strlen( $link1['title'] ) > 0 ? $link1['title'] : '';
				$target = strlen( $link1['target'] ) > 0 ? $link1['target'] : '_self';

				$output[] = sprintf( '<a class="link" href="%s" target="%s">%s<i class="ion-ios-arrow-thin-right"></i> </a>', esc_url( $url ), esc_attr( $target ), $text );
			}
		}

		$style = '';
		if ( $atts['bg_color'] ) {
			$style = 'style="background-color:' . esc_attr( $atts['bg_color'] ) . '"';
		}

		$output[] = '</div>';

		$css_class = '';

		if ( $atts['link_hover'] ) {
			$css_class = 'link-hover';
		}

		if ( $atts['dark_skin'] ) {
			$css_class .= ' dark-skin';
		}

		$b_content = sprintf( '<div class="banner-grid %s" %s>%s</div>', esc_attr( $css_class ), $style, implode( ' ', $output ) );

		$this->banners[] = array(
			'b_content' => $b_content,
		);

		$this->info_banners[] = array(
			'b_content' => $b_content,
		);

		return '';
	}

	/**
	 * @param $atts
	 * @param $output
	 *
	 * @return array
	 */
	public function get_image_src( $image, $image_size ) {
		$output = '';
		if ( $image_size != 'full' ) {
			if ( $image ) {
				if ( function_exists( 'wpb_getImageBySize' ) ) {
					$image = wpb_getImageBySize(
						array(
							'attach_id'  => $image,
							'thumb_size' => $image_size,
						)
					);

					if ( $image['thumbnail'] ) {
						$output = $image['thumbnail'];
					} elseif ( $image['p_img_large'] ) {
						$output = sprintf(
							'<img alt="" src="%s">',
							esc_attr( $image['p_img_large'][0] )
						);
					}

				}
			}
		}

		if ( empty ( $output ) ) {
			$image = wp_get_attachment_image_src( $image, 'full' );
			if ( $image ) {
				$output = sprintf(
					'<img alt="" src="%s">',
					esc_url( $image[0] )
				);

			}

		}

		return $output;
	}

	/**
	 * Revoluion Slider shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function revslider( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'alias' => '0',
			), $atts
		);

		if ( $atts['alias'] != '0' ) {
			$this->banners[] = array(
				'alias' => $atts['alias'],
			);
		}

		return '';
	}

	/**
	 * Shortcode to display info newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function info_newsletter( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'bg_color'  => '',
				'title'     => esc_html__( 'Get|10%|Discount', 'mrbara' ),
				'form'      => '',
				'dark_skin' => '',
			), $atts
		);

		$output    = array();
		$css_class = 'no-image';
		$output[]  = '<div class="newsletter-content">';

		if ( $atts['title'] ) {
			$title = explode( '|', $atts['title'] );
			if ( sizeof( $title ) > 2 ) {
				$output[] = sprintf( '<div class="nl-title">%s <span>%s </span>%s</div>', $title[0], $title[1], $title[2] );
			} elseif ( sizeof( $title ) > 1 ) {
				$output[] = sprintf( '<div class="nl-title">%s <span>%s </span></div>', array_shift( $title ), implode( ' ', $title ) );
			} else {
				$output[] = sprintf( '<div class="nl-title">%s</div>', $atts['title'] );
			}
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="nl-desc">%s</div>', $content );
		}

		if ( $atts['form'] ) {
			$output[] = do_shortcode( '[mc4wp_form id="' . esc_attr( $atts['form'] ) . '"]' );
		}

		$output[] = '</div>';

		$style = '';
		if ( $atts['bg_color'] ) {
			$style = 'style="background-color:' . esc_attr( $atts['bg_color'] ) . '"';
		}

		if ( $atts['dark_skin'] ) {
			$css_class .= ' dark-skin';
		}

		$this->info_banners[] = array(
			'newsletter' => 1,
			'nl_content' => sprintf( '<div class="banner-grid %s" %s>%s</div>', esc_attr( $css_class ), $style, implode( '', $output ) ),
		);

		return '';

	}

	/**
	 * Shortcode to display info newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function info_section_title( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'bg_color'  => '',
				'title'     => '',
				'dark_skin' => '',
			), $atts
		);

		$output = array();

		$css_class = 'no-image';
		$output[]  = '<div class="sc-content">';

		if ( $atts['title'] ) {
			$output[] = sprintf( '<div class="sc-title">%s</div>', $atts['title'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="sc-desc">%s</div>', $content );
		}

		$output[] = '</div>';

		$style = '';
		if ( $atts['bg_color'] ) {
			$style = 'style="background-color:' . esc_attr( $atts['bg_color'] ) . '"';
		}

		if ( $atts['dark_skin'] ) {
			$css_class .= ' dark-skin';
		}

		$this->info_banners[] = array(
			'section_title' => 1,
			'sc_content'    => sprintf( '<div class="banner-grid %s" %s>%s</div>', esc_attr( $css_class ), $style, implode( '', $output ) ),
		);

		return '';

	}

	/**
	 * Info Banners shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function info_banners( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'desc'     => '',
				'style'    => '',
				'el_class' => '',
			), $atts
		);

		$this->info_banners = array();
		do_shortcode( $content );

		if ( empty( $this->info_banners ) ) {
			return '';
		}

		if ( $atts['style'] ) {
			$atts['el_class'] .= 'style-' . $atts['style'];
		}

		$output  = array();
		$heading = '';

		if ( $atts['title'] ) {
			$heading = sprintf( '<div class="info-title">%s</div>', $atts['title'] );
		}

		if ( $atts['desc'] ) {
			$heading .= sprintf( '<div class="info-desc">%s</div>', $atts['desc'] );
		}

		if ( $heading ) {
			$output[] = sprintf( '<div class="heading">%s</div>', $heading );
		}

		$output[] = sprintf( '<div class="info-banners-content">' );
		$i        = 0;
		foreach ( $this->info_banners as $banner ) {

			$css_class = 'info-banner-normal';
			$mode      = $i % 10;
			if ( $mode == 0 ) {
				$css_class = 'banner-full';
			} elseif ( $mode == 1 || $mode == 3 ) {
				$css_class = 'banner-long';
			} elseif ( $mode == 8 ) {
				$css_class = 'banner-wide';
			}


			$i++;
			if ( isset( $banner['section_title'] ) ) {
				if ( $banner['section_title'] ) {
					$output[] = sprintf( '<div class="%s banner-item">%s</div>', esc_attr( $css_class ), $banner['sc_content'] );
				}
			} elseif ( isset( $banner['newsletter'] ) ) {
				if ( $banner['newsletter'] ) {
					$output[] = sprintf( '<div class="%s banner-item">%s</div>', esc_attr( $css_class ), $banner['nl_content'] );
				}
			} else {

				$output[] = sprintf( '<div class="%s banner-item">%s</div>', esc_attr( $css_class ), $banner['b_content'] );
			}


		}

		$output[] = sprintf( '<div class="banner-sizer"></div>' );

		$output[] = sprintf( '</div>' );

		return sprintf( '<div class="mr-info-banners %s">%s</div>', esc_attr( $atts['el_class'] ), implode( '', $output ) );

	}

	/**
	 * Shortcode to display section title
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function section_title( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'                => '1',
				'title'                => '',
				'subtitle'             => '',
				'subtitle_2'           => esc_html__( 'Subtitle text|extra', 'mrbara' ),
				'light_skin'           => '',
				'text_align'           => 'text-left',
				'el_class'             => '',
				'title_font_family'    => '',
				'title_font_style'     => '',
				'title_font_size'      => '',
				'title_line_height'    => '',
				'title_letter_spacing' => '',
			), $atts
		);

		$css_class[] = 'style-' . $atts['style'];

		if ( $atts['light_skin'] ) {
			$css_class[] = 'light-skin';
		}

		if ( $atts['style'] != '4' ) {
			if ( $atts['text_align'] ) {
				$css_class[] = $atts['text_align'];
			}
		}

		if ( intval( $atts['title_font_size'] >= 48 ) ) {
			$css_class[] = 'text-big';
		} elseif ( intval( $atts['title_font_size'] >= 36 ) ) {
			$css_class[] = 'text-large';
		} elseif ( intval( $atts['title_font_size'] >= 24 ) ) {
			$css_class[] = 'text-normal';
		} elseif ( intval( $atts['title_font_size'] < 24 ) ) {
			$css_class[] = 'text-small';
		}

		if ( intval( $atts['title_letter_spacing'] > 10 ) ) {
			$css_class[] = 'letter-spacing-large';
		}

		$output = array();

		if ( $atts['style'] == '2' ) {
			if ( ! empty( $atts['subtitle_2'] ) ) {
				$subtitle = explode( '|', $atts['subtitle_2'] );
				$output[] = sprintf(
					'<p class="subtitle">%s%s</p>',
					esc_html( $subtitle[0] ),
					isset( $subtitle[1] ) ? ' <span>' . esc_html( $subtitle[1] ) . '</span>' : ''
				);
			}
		} elseif ( $atts['style'] != '3' ) {
			if ( $atts['subtitle'] ) {
				$output[] = sprintf( '<div class="subtitle">%s</div>', $atts['subtitle'] );
			}
		}

		$style = $this->get_style_attr(
			array(
				'font_family'    => $atts['title_font_family'],
				'font_style'     => $atts['title_font_style'],
				'font_size'      => $atts['title_font_size'],
				'line_height'    => $atts['title_line_height'],
				'letter_spacing' => $atts['title_letter_spacing'],
			)
		);

		if ( $atts['title'] ) {
			$output[] = sprintf( '<div class="title" %s>%s</div>', $style, $atts['title'] );
		}

		if ( $atts['style'] == '3' ) {
			if ( $atts['subtitle'] ) {
				$output[] = sprintf( '<div class="subtitle">%s</div>', $atts['subtitle'] );
			}
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="desc">%s</div>', $content );
		}

		$css_class[] = $atts['el_class'];

		return sprintf(
			'<div class="section-title %s">
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display section title
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function section_title_ver( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'el_class'   => '',
				'number'     => '',
				'top'        => '',
				'align'      => '',
				'white_text' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['align'] ) {
			$css_class[] = $atts['align'];
		}

		if ( $atts['white_text'] ) {
			$css_class[] = 'white-text';
		}

		$top_css = '';
		$top     = intval( $atts['top'] );
		if ( $atts['top'] ) {
			$top_css = sprintf( 'style="top: %spx"', esc_attr( $top ) );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$content = sprintf( '<div class="title" %s>%s</div>', $top_css, $content );
		}

		if ( $atts['number'] ) {
			$content .= sprintf( '<div class="number" %s>%s</div>', $top_css, $atts['number'] );
		}

		return sprintf(
			'<div class="section-title-ver %s">
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$content
		);
	}

	/**
	 * Comming soon shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function coming_soon( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'date'     => '',
				'el_class' => '',
			), $atts
		);

		$output = array();

		$second = 0;
		if ( $atts['date'] ) {
			$second_current = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
			$date           = new DateTime( $atts['date'] );
			if ( $date ) {
				$second_discount = strtotime( date_i18n( 'Y/m/d H:i:s', $date->getTimestamp() ) );
				if ( $second_discount > $second_current ) {
					$second = $second_discount - $second_current;
				}
			}

		}

		if ( $second ) :
			$output[] = sprintf( '<div class="sale-price-date">%s</div>', $second );
		endif;

		if ( $content ) {
			$output[] = sprintf( '<div class="coming-title">%s</div>', $content );
		}

		return sprintf(
			'<div class="mrbara-coming-soon mrbara-countdown %s"><div class="text-center">%s</div></div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Comming soon shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function countdown( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'date'     => '',
				'el_class' => '',
			), $atts
		);

		$output = array();

		$second = 0;
		if ( $atts['date'] ) {
			$second_current = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
			$date           = new DateTime( $atts['date'] );
			if ( $date ) {
				$second_discount = strtotime( date_i18n( 'Y/m/d H:i:s', $date->getTimestamp() ) );
				if ( $second_discount > $second_current ) {
					$second = $second_discount - $second_current;
				}
			}

		}

		if ( $second ) :
			$output[] = sprintf( '<div class="sale-price-date">%s</div>', $second );
		endif;


		return sprintf(
			'<div class="mrbara-counters mrbara-countdown %s"><div class="text-center">%s</div></div>',
			esc_attr( $atts['el_class'] ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display about 2
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function about_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'subtitle' => '',
				'desc'     => '',
				'image'    => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();


		if ( $atts['subtitle'] ) {
			$output[] = sprintf( '<div class="sub-title">%s</div>', $atts['subtitle'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}


			$output[] = sprintf( '<div class="title">%s</div>', $content );
		}

		if ( $atts['desc'] ) {
			$output[] = sprintf( '<div class="desc">%s</div>', $atts['desc'] );
		}

		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'mrbara-service' );
			if ( $image ) {
				$output[] = sprintf(
					'<div class="about-img"><img alt="%s" src="%s"></div>',
					esc_attr( $atts['image'] ),
					esc_url( $image[0] )
				);
			}
		}


		return sprintf(
			'<div class="mrbara-about-2 %s">
				<div class="row">
					<div class="col-md-1 col-sm-1 col-xs-2 col-xs-offset-1 col-md-offset-1 col-sm-offset-1 col-left">
						<span class="mr-verticle-line"></span>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-8 col-xs-offset-1 col-md-offset-2 col-sm-offset-2 col-right"><div class="about-content">%s</div></div>
				</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display about 2
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function about_3( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'desc'     => '',
				'image'    => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();


		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="title">%s</div>', $content );
		}

		if ( $atts['desc'] ) {
			$output[] = sprintf( '<div class="desc">%s</div>', $atts['desc'] );
		}

		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'mrbara-service' );
			if ( $image ) {
				$output[] = sprintf(
					'<div class="about-img"><img alt="%s" src="%s"></div>',
					esc_attr( $atts['image'] ),
					esc_url( $image[0] )
				);
			}
		}


		return sprintf(
			'<div class="mrbara-about-3 %s">
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display about 2
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function about_4( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'subtitle' => '',
				'title'    => '',
				'image'    => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();


		if ( $atts['subtitle'] ) {
			$output[] = sprintf( '<div class="sub-title">%s</div>', $atts['subtitle'] );
		}


		if ( $atts['title'] ) {
			$output[] = sprintf( '<div class="title">%s</div>', $atts['title'] );
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="desc">%s</div>', $content );
		}

		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'mrbara-service' );
			if ( $image ) {
				$output[] = sprintf(
					'<div class="about-img"><img alt="%s" src="%s"></div>',
					esc_attr( $atts['image'] ),
					esc_url( $image[0] )
				);
			}
		}


		return sprintf(
			'<div class="mrbara-about-2 %s">
				<div class="row">
					<div class="col-md-1 col-sm-1 col-xs-2 col-xs-offset-1 col-md-offset-1 col-sm-offset-1 col-left">
						<span class="mr-verticle-line"></span>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-8 col-xs-offset-1 col-md-offset-2 col-sm-offset-2 col-right"><div class="about-content">%s</div></div>
				</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display mrbara heading
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function heading( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'          => '1',
				'font_size'      => '',
				'font_family'    => '',
				'font_style'     => '',
				'line_height'    => '',
				'letter_spacing' => '',
				'color'          => '',
				'align'          => '',
				'sub_title'      => '',
				'css'            => '',
				'el_class'       => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];
		$css_class[] = $atts['align'];
		$css_class[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		if ( vc_shortcode_custom_css_has_property( $atts['css'], array( 'background' ) ) ) {
			$css_class[] = 'cta-has-fill';
		}

		if ( intval( $atts['font_size'] >= 48 ) ) {
			$css_class[] = 'text-big';
		} elseif ( intval( $atts['font_size'] >= 36 ) ) {
			$css_class[] = 'text-large';
		} elseif ( intval( $atts['font_size'] >= 24 ) ) {
			$css_class[] = 'text-normal';
		} elseif ( intval( $atts['font_size'] < 24 ) ) {
			$css_class[] = 'text-small';
		}

		if ( intval( $atts['letter_spacing'] > 10 ) ) {
			$css_class[] = 'letter-spacing-large';
		}

		if ( $atts['style'] ) {
			$css_class[] = 'heading-style' . $atts['style'];
		}

		$line_style = '';
		if ( $atts['color'] ) {
			$line_style = 'style="background-color:' . esc_attr( $atts['color'] ) . '"';
		}

		$output = array();

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$style = $this->get_style_attr( $atts );
			if ( $atts['style'] == '3' ) {
				$output[] = sprintf( '<div class="title-behind">%s<div class="title" %s>%s</div></div>', $content, $style, $content );
			} elseif ( $atts['style'] == '4' ) {
				$output[] = sprintf(
					'<div class="row">' .
					'<div class="col-left  col-xs-2 col-md-1 col-sm-1"><div class="mr-vertical-line" %s></div></div>' .
					'<div class="col-right col-xs-10 col-md-11 col-sm-11"><div class="title" %s>%s</div></div>' .
					'</div>',
					$line_style,
					$style,
					$content
				);
			} elseif ( $atts['style'] == '6' ) {
				$output[] = sprintf(
					'<div class="row">' .
					'<div class="col-md-1 col-sm-1 col-xs-2 col-xs-offset-1 col-md-offset-1 col-sm-offset-1 col-left"><div class="mr-vertical-line" %s></div></div>' .
					'<div class="col-md-8 col-sm-8 col-xs-8 col-xs-offset-1 col-md-offset-2 col-sm-offset-2 col-right"><div class="title" %s>%s</div></div>' .
					'</div>',
					$line_style,
					$style,
					$content
				);
			} else {
				$output[] = sprintf( '<div class="title" %s>%s <div class="mr-vertical-line" %s></div></div>', $style, $content, $line_style );
			}
		}


		return sprintf(
			'<div class="mrbara-heading %s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Display call to action shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function counter( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'    => 'style1',
				'title'    => '',
				'number'   => '',
				'step'     => '5',
				'bold'     => '',
				'el_class' => '',
			), $atts
		);

		$output = array();

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'counter-' . $atts['style'];
		}

		if ( $atts['bold'] ) {
			$css_class[] = 'bold-text';
		}

		if ( $atts['number'] ) {
			$output[] = sprintf( ' <span class="counter-number">%s</span>', $atts['number'] );
		}

		if ( $atts['title'] ) {
			$output[] = sprintf( '  <div class="counter-title">%s</div>', $atts['title'] );
		}

		return sprintf(
			'<div class="mrbara-counter %s" data-step="%s">
               %s
            </div>
            ',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( intval( $atts['step'] ) ),
			implode( '', $output )
		);
	}

	/**
	 * Images team shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function team( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'total'    => '3',
				'columns'  => '3',
				'category' => '',
				'el_class' => '',
			), $atts
		);


		$css_class[] = $atts['el_class'];


		$output = array();


		$query_args = array(
			'posts_per_page' => $atts['total'],
			'post_type'      => 'team_member',
		);

		if ( $atts['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'team_group',
					'field'    => 'slug',
					'terms'    => $atts['category'],
				),

			);
		}

		$item_class = 'col-md-4 col-sm-6 col-xs-6';
		if ( $atts['columns'] == '4' ) {
			$item_class = 'col-md-3 col-sm-4 col-xs-6';
		} elseif ( $atts['columns'] == '6' ) {
			$item_class = 'col-md-2 col-sm-4 col-xs-6';
		}


		$query = new WP_Query( $query_args );
		while ( $query->have_posts() ) : $query->the_post();
			$image = get_the_post_thumbnail( get_the_ID(), 'team-member' );

			$output[] = sprintf(
				'<div class="%s">
                    <div class="team-item">
						<a href="%s" class="team-img">%s</a>
						<div class="team-content">
							<a href="%s" class="t-name" >%s</a>
							<span class="t-job">%s</span>
						</div>
				    </div>
				 </div><!-- end team -->
				',
				esc_attr( $item_class ),
				esc_url( get_the_permalink() ),
				$image,
				esc_url( get_the_permalink() ),
				get_the_title(),
				get_post_meta( get_the_ID(), '_team_member_job', true )
			);
		endwhile;

		wp_reset_postdata();

		return sprintf(
			'<div class="mrbara-team %s">
                            <div class="container">
                                <div class="row">
                                     %s
                                </div>
                            </div>
                        </div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Images shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function image_carousel( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'               => '1',
				'images'              => '',
				'image_opacity'       => '',
				'image_size'          => 'thumbnail',
				'number'              => '6',
				'custom_links'        => '',
				'custom_links_target' => '_self',
				'autoplay'            => '',
				'el_class'            => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$css_class[] = 'style-' . $atts['style'];

		if ( $atts['style'] == '1' ) {
			if ( $atts['image_opacity'] ) {
				$css_class[] = 'image-opacity';
			}

		}
		$pause = 1000;

		$autoplay = intval( $atts['autoplay'] );
		if ( ! $autoplay ) {
			$autoplay = false;
		} else {
			$pause = $autoplay;
		}

		$custom_links = '';
		if ( function_exists( 'vc_value_from_safe' ) ) {
			$custom_links = vc_value_from_safe( $atts['custom_links'] );
			$custom_links = explode( ',', $custom_links );
		}

		$output = array();
		$images = $atts['images'] ? explode( ',', $atts['images'] ) : '';

		$number = intval( $atts['number'] );
		if ( $images ) {
			$count = count( $images );
			if ( $count < 6 ) {
				$number = $count;
			}

			$i = 0;
			foreach ( $images as $attachment_id ) {
				$image = wp_get_attachment_image_src( $attachment_id, $atts['image_size'] );
				if ( $image ) {
					$link = '';
					if ( $custom_links && isset( $custom_links[ $i ] ) ) {
						$link = preg_replace( '/<br \/>/iU', '', $custom_links[ $i ] );
						$link = 'href="' . esc_url( $link ) . '"';

					}
					$output[] = sprintf(
						'<div class="image-item"><a %s target="%s"><img alt="%s"  src="%s"></a></div>',
						$link,
						esc_attr( $atts['custom_links_target'] ),
						esc_attr( $attachment_id ),
						esc_url( $image[0] )
					);
				}
				$i++;
			}
		}

		$id         = uniqid( 'images-carousel-' );
		$custom_nav = '';
		if ( $atts['style'] == '1' ) {
			$this->l10n['imagesCarousel'][ $id ] = array(
				'autoplay' => $autoplay,
				'number'   => $number,
			);
		} else {
			$this->l10n['imagesCarouselVertical'][ $id ] = array(
				'pause'    => $pause,
				'autoplay' => intval( $autoplay ) ? true : false,
			);
		}

		return sprintf(
			'<div class="mrbara-image-carousel %s"><div class="mrbara-owl-list" id="%s">%s</div></div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			implode( '', $output )
		);
	}

	/**
	 * Images shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_images_carousel( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'ids'        => '',
				'autoplay'   => '',
				'columns'    => '1',
				'navigation' => true,
				'el_class'   => '',
				'layout'     => 'list',
			), $atts
		);

		$css_class[] = $atts['el_class'];


		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$id                                          = uniqid( 'products-images-carousel-' );
		$this->l10n['productsimagesCarousel'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => intval( $atts['navigation'] ) ? true : false,
		);

		$output = array();

		$output[] = $this->get_products_picks( $atts );

		return sprintf(
			'<div class="mrbara-products-images-carousel %s">' .
			'       <div class="mrbara-owl-list" id="%s">' .
			'           %s' .
			'       </div>' .
			'</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			implode( '', $output )
		);
	}

	/**
	 * Helper function, get products for shortcodes
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function get_products_picks( $atts ) {

		if ( ! $this->wc_actived ) {
			return '';
		}

		if ( ! $atts['ids'] ) {
			return '';
		}


		$ids = explode( ',', $atts['ids'] );

		$lines = 0;
		if ( ! empty( $atts['views'] ) && ! empty( $atts['columns'] ) ) {
			$lines = ceil( $atts['views'] / $atts['columns'] );
		}
		$index = 0;
		ob_start();
		$products = new WP_Query(
			array(
				'post_type'           => 'product',
				'posts_per_page'      => '-1',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'post__in'            => $ids,
			)
		);

		$columns = intval( $atts['columns'] ) ? absint( $atts['columns'] ) : 4;

		if ( function_exists( 'wc_set_loop_prop' ) ) {
			wc_set_loop_prop( 'columns', $columns );
		}

		if ( $products->have_posts() ) :

			woocommerce_product_loop_start();

			while ( $products->have_posts() ) : $products->the_post();
				if ( $lines > 1 && $index % $lines == 0 ) : ?>
				<li class="<?php $this->mrbara_wc_content_columns( $atts['columns'] ); ?>">
						<ul class="mrbara-products">
				<?php endif;
				if ( $atts['layout'] == 'list' ) {
					$this->get_template_part( 'content-product', 'list' );
				} else {
					wc_get_template_part( 'content', 'product' );
				}

				if ( $lines > 1 && $index % $lines == $lines - 1 ) {
					echo '</ul></li>';
				} elseif ( $lines > 1 && $index == $products->post_count - 1 ) {
					echo '</ul></li>';
				}
				$index++;
			endwhile; // end of the loop.

			woocommerce_product_loop_end();

		endif;
		wp_reset_postdata();

		return ob_get_clean();

	}

	/**
	 * Image shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function single_image( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'    => '',
				'align'    => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$css_class[] = $atts['align'];

		if ( ! $atts['image'] ) {
			return;
		}

		$image = wp_get_attachment_image_src( $atts['image'], 'full' );

		if ( ! $image ) {
			return;
		}

		$image = sprintf( '<img alt="" src="%s">', esc_url( $image[0] ) );

		return sprintf(
			'<div class="mrbara-single-image %s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$image
		);
	}

	/**
	 * Shortcode to display section title
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function feature_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'desc'        => '',
				'el_class'    => '',
				'style'       => '1',
				'title'       => '',
				'title_color' => '',
				'desc_color'  => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();
		$title  = '';
		if ( $atts['style'] == '1' ) {
			if ( $content ) {
				if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
					$content = wpb_js_remove_wpautop( $content, true );
				}

				$title = $content;
			}
		} else {
			$title = $atts['title'];
		}
		if ( $title ) {
			$title_style = '';
			if ( $atts['title_color'] ) {
				$title_style = sprintf( 'style="color: %s"', esc_attr( $atts['title_color'] ) );
			}
			$output[] = sprintf( '<div class="title" %s>%s</div>', $title_style, $title );
		}

		if ( $atts['desc'] ) {
			$desc_style = '';
			if ( $atts['desc_color'] ) {
				$desc_style = sprintf( 'style="color: %s"', esc_attr( $atts['desc_color'] ) );
			}
			$output[] = sprintf( '<div class="desc" %s>%s</div>', $desc_style, $atts['desc'] );
		}

		if ( $atts['style'] ) {
			$css_class[] = 'style-' . $atts['style'];
		}

		return sprintf(
			'<div class="feature-box %s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode to display section title
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function info_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'link'     => '',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();

		if ( $atts['title'] ) {
			$title = explode( '|', $atts['title'] );
			if ( sizeof( $title ) > 1 ) {
				$output[] = sprintf( '<div class="info-title"><span>%s</span><span>%s</span></div>', array_shift( $title ), implode( ' ', $title ) );
			} else {
				$output[] = sprintf( '<div class="info-title">%s</div>', $atts['title'] );
			}
		}

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="info-desc">%s</div>', $content );
		}

		$button = '';
		if ( function_exists( 'vc_build_link' ) ) {
			if ( ! empty( $atts['link'] ) ) {
				$link   = vc_build_link( $atts['link'] );
				$button = sprintf(
					'<a href="%s" class="mr-button btn"%s%s>%s</a>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		return sprintf(
			'<div class="mrbara-info-box %s">%s %s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output ),
			$button
		);
	}

	/**
	 * Video banner shortcode
	 *
	 * @since  1.0
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function about( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'skin'              => '',
				'title'             => '',
				'title_font_size'   => '',
				'title_font_family' => '',
				'title_font_style'  => '',
				'bg_color_overlay'  => '',
				'desc'              => '',
				'name'              => '',
				'job'               => '',
				'video'             => '',
				'image'             => '',
				'mute'              => '',
				'height'            => 'auto',
				'el_class'          => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$abouts = array();

		if ( $atts['title'] ) {

			$attr = array(
				'font_family' => $atts['title_font_family'],
				'font_style'  => $atts['title_font_style'],
				'font_size'   => $atts['title_font_size'],
			);

			$style = $this->get_style_attr( $attr );

			$abouts[] = sprintf( '<div class="title" %s>%s</div>', $style, $atts['title'] );
		}


		if ( $atts['skin'] ) {
			$css_class[] = $atts['skin'] . '-skin';
		}


		if ( $atts['desc'] ) {
			$abouts[] = sprintf( '<div class="desc">%s</div>', $atts['desc'] );
		}

		if ( $atts['name'] ) {
			$abouts[] = sprintf( '<div class="about-info"><div class="name">%s</div>-<div class="job">%s</div></div>', $atts['name'], $atts['job'] );
		}

		$style = '';
		if ( $atts['bg_color_overlay'] ) {
			$style = 'style="background-color:' . esc_attr( $atts['bg_color_overlay'] ) . '"';
		}

		$v_title = '';
		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$v_title = sprintf( '<div class="video-title">%s</div>', $content );
		}
		$ext     = wp_check_filetype( $atts['video'] );
		$image   = wp_get_attachment_image_src( intval( $atts['image'] ), 'full' );
		$video   = array();
		$video[] = sprintf(
			'<div class="video-banner">' .
			'<div class="bg-overlay" %s></div> ' .
			'<video height="%d" preload="none" poster="%s" loop %s>' .
			'<source src="%s" type="%s">' .
			'</video>' .
			'<div class="status"> %s' .
			' <h3 class="text-play">%s</h3>' .
			'<h3 class="text-pause">%s</h3>' .
			'<i class="ion-ios-play"></i>' .
			' </div>' .
			'</div>',
			$style,
			esc_attr( $atts['height'] ),
			esc_url( $image[0] ),
			! empty( $atts['mute'] ) ? 'muted' : '',
			esc_url( $atts['video'] ),
			esc_attr( $ext['type'] ),
			$v_title,
			esc_html__( 'Play', 'mrbara' ),
			esc_html__( 'Pause', 'mrbara' )
		);

		$output = array();
		if ( $atts['video'] ) {
			$output[] = sprintf(
				'<div class="about-bg">
					<div class="row">
					 <div class="col-lg-1 hidden-md hidden-sm"></div>
	                    <div class="col-lg-6 col-md-12 col-sm-12 col-left">
	                        <div class="about-content">%s</div>
	                    </div>
	                    <div class="col-lg-5 col-md-12 col-sm-12 col-right">
	                        <div class="video-content">%s</div>
	                    </div>
                    </div>
                </div>',
				implode( '', $abouts ),
				implode( '', $video )
			);
		}
		if ( empty( $atts['video'] ) ) {
			$css_class[] = 'no-video';
			$output[]    = sprintf(
				'<div class="about-content">%s</div>',
				implode( '', $abouts )
			);
		}

		return sprintf(
			'<div class="mrbara-about %s">
                %s
            </div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Video banner shortcode
	 *
	 * @since  1.0
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function video( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'style'    => 'style1',
				'video'    => '',
				'image'    => '',
				'mute'     => '',
				'title'    => '',
				'height'   => 'auto',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'video-' . $atts['style'];
		}

		if ( empty( $atts['video'] ) ) {
			return '';
		}

		$text_status = '';
		if ( in_array( $atts['style'], array( 'style1', 'style3' ) ) ) {
			$text_status = sprintf( '<h3 class="text-play">%s</h3><h3 class="text-pause">%s</h3>', esc_html__( 'Play', 'mrbara' ), esc_html__( 'Pause', 'mrbara' ) );
		}

		$ext   = wp_check_filetype( $atts['video'] );
		$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'full' );

		$desc   = '';
		$status = sprintf(
			'<div class="status">
				%s
				<i class="ion-ios-play"></i>
			</div>', $text_status
		);

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );

			}

			$content = sprintf( '<div class="v-desc">%s</div>', $content );
		}
		if ( in_array( $atts['style'], array( 'style4' ) ) ) {
			$desc = sprintf( '<div class="video-desc">%s</div>', $content . $status );
		} elseif ( in_array( $atts['style'], array( 'style2' ) ) ) {
			$desc = sprintf( '<div class="video-desc">%s</div> %s', $content, $status );
		} else {
			$desc = $status;
		}

		$title1 = '';
		if ( in_array( $atts['style'], array( 'style2' ) ) ) {
			if ( $atts['title'] ) {
				$title1 = sprintf( '<div class="video-title">%s</div>', $atts['title'] );
			}
		}


		return sprintf(
			'<div class="video-banner %s">
				<div class="banner-content">
					<video height="%d" preload="none" poster="%s" loop %s>
						<source src="%s" type="%s">
					</video>
					%s  %s
                </div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $atts['height'] ),
			esc_url( $image[0] ),
			! empty( $atts['mute'] ) ? 'muted' : '',
			esc_url( $atts['video'] ),
			esc_attr( $ext['type'] ),
			$title1,
			$desc

		);
	}

	/**
	 * Posts shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function posts( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'          => '1',
				'total'          => 3,
				'show_excerpt'   => '',
				'excerpt_length' => '30',
				'category'       => '',
				'el_class'       => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'mr-post-style' . $atts['style'];
		}

		$col_class = 'col-blog col-md-12 col-sm-12 col-xs-12';
		if ( in_array( $atts['style'], array( '2', '4', '5', '6' ) ) ) {
			$col_class = 'col-md-4 col-sm-4 col-xs-12';
		}

		$output = array();

		$query_args = array(
			'posts_per_page'      => $atts['total'],
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
		);
		if ( ! empty( $atts['category'] ) ) {
			$query_args['category_name'] = $atts['category'];
		}
		$query = new WP_Query( $query_args );

		while ( $query->have_posts() ) : $query->the_post();

			$article        = array();
			$comments_count = wp_count_comments( get_the_ID() );
			$categories     = get_the_category();
			if ( ! empty( $categories ) ) {
				$cat = sprintf(
					'<a class="p-cat" href="%s">%s</a>',
					esc_url( get_category_link( $categories[0]->term_id ) ),
					esc_html( $categories[0]->name )
				);
			}

			if ( in_array( $atts['style'], array( '1', '3' ) ) ) {
				$article[] = sprintf(
					'
	                <div class="blog-date">
	                    <span class="p-date">%s</span>
	                    <span class="p-month">%s</span>
	                </div>
					<div class="blog-content">
						 <h3 class="post-title"><a class="post-link" href="%s">%s</a></h3>
					     <div class="post-meta">
	                        <a class="p-author" href="%s" title="%s" rel="author">%s</a>%s<span class="p-comment">%s <span>%s</span></span>
	                     </div>
					</div>',
					get_the_date( 'd' ),
					get_the_date( 'M' ),
					esc_url( get_permalink() ),
					get_the_title(),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( get_the_author() ),
					get_the_author(),
					$cat,
					intval( $comments_count->total_comments ),
					esc_html__( 'Comments', 'mrbara' )
				);

			} else {

				$time_string   = '<time class="e-date" datetime="%1$s">%2$s</time>';
				$time_string   = sprintf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				);
				$archive_year  = get_the_time( 'Y' );
				$archive_month = get_the_time( 'm' );
				$archive_day   = get_the_time( 'd' );
				$posted_on     = '<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" class="entry-date" rel="bookmark">' . $time_string . '</a>';

				$desc_html = '';
				if ( $atts['show_excerpt'] ) {
					$desc_html = sprintf( '<div class="desc">%s</div>', mrbara_content_limit( get_the_excerpt(), intval( $atts['excerpt_length'] ), false, false ) );
				}

				$article[] = sprintf(
					'<header class="post-header">
						<div class="entry-format">
							<a class="entry-image" href="%1$s" title="%2$s">
								%3$s
							</a>
						</div>
					</header>
					%5$s
					<h2 class="post-title">
						<a class="p-title" href="%1$s" title="%2$s">%2$s</a>
					</h2>
					%6$s
					<footer class="post-footer">
						<a class="readmore" href="%1$s" title="%2$s">%4$s</a>
					</footer>
					',
					esc_url( get_permalink() ),
					get_the_title(),
					get_the_post_thumbnail( get_the_ID(), 'mrbara-posts-grid' ),
					in_array( $atts['style'], array( '2' ) ) ? esc_html__( 'Read more', 'mrbara' ) : esc_html__( 'Continue', 'mrbara' ),
					$posted_on,
					$desc_html
				);

			}

			$output[] = sprintf(
				'<div class="%s">
					<div class="single_blog_item">%s</div>
				</div>',
				esc_attr( $col_class ),
				implode( '', $article )
			);
		endwhile;
		wp_reset_postdata();

		return sprintf(
			'<div class="mrbara-posts %s">
			<div class="row">
				%s
			</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Posts carousel shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function posts_carousel( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'      => '',
				'category'   => '',
				'total'      => 12,
				'autoplay'   => 0,
				'el_class'   => '',
				'views'      => 2,
				'columns'    => 1,
				'image_size' => 'thumbnail',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$id                                 = uniqid( 'posts-carousel-' );
		$this->l10n['postsCarousel'][ $id ] = array(
			'autoplay' => $autoplay,
			'number'   => 1,
		);

		$lines = 0;
		$views = intval( $atts['views'] );
		if ( ! empty( $views ) && ! empty( $atts['columns'] ) ) {
			$lines = ceil( $views / $atts['columns'] );
		}

		$output = array();

		$query_args = array(
			'posts_per_page'      => $atts['total'],
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
		);
		if ( ! empty( $atts['category'] ) ) {
			$query_args['category_name'] = $atts['category'];
		}
		$query = new WP_Query( $query_args );
		$index = 0;
		while ( $query->have_posts() ) : $query->the_post();

			$article       = array();
			$time_string   = '<time class="e-date" datetime="%1$s">%2$s</time>';
			$time_string   = sprintf(
				$time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
			$archive_year  = get_the_time( 'Y' );
			$archive_month = get_the_time( 'm' );
			$archive_day   = get_the_time( 'd' );
			$posted_on     = '<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" class="entry-date" rel="bookmark">' . $time_string . '</a>';

			$image_html = '';
			if ( function_exists( 'wpb_getImageBySize' ) ) {
				$image = wpb_getImageBySize(
					array(
						'attach_id'  => get_post_thumbnail_id( get_the_ID() ),
						'thumb_size' => $atts['image_size'],
					)
				);

				if ( $image['thumbnail'] ) {
					$image_html = $image['thumbnail'];
				} elseif ( $image['p_img_large'] ) {
					$image_html = sprintf(
						'<img alt="" src="%s">',
						esc_attr( $image['p_img_large'][0] )
					);
				}

			}

			if ( ! $image_html ) {
				$image_html = get_the_post_thumbnail( get_the_ID(), $atts['image_size'] );
			}

			$article[] = sprintf(
				'<a class="entry-image" href="%1$s">
					%3$s
				</a>
				<h2 class="post-title">
					<a class="p-title" href="%1$s" title="%2$s">%2$s</a>
					%4$s
				</h2>
				',
				esc_url( get_permalink() ),
				get_the_title(),
				$image_html,
				$posted_on
			);

			if ( $lines > 1 && $index % $lines == 0 ) :
				$output[] = '<div class="group-blog-item">';
			endif;

			$output[] = sprintf(
				'<div class="single_blog_item">%s</div>',
				implode( '', $article )
			);

			if ( $lines > 1 && $index % $lines == $lines - 1 ) {
				$output[] = '</div>';
			} elseif ( $lines > 1 && $index == $query->post_count - 1 ) {
				$output[] = '</div>';
			}
			$index++;
		endwhile;
		wp_reset_postdata();

		return sprintf(
			'<div class="posts-carousel %s" id="%s"><div class="title">%s</div> <div class="posts-list"> %s</div></div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			$atts['title'],
			implode( '', $output )
		);
	}

	function hot_deal_product( $atts ) {
		$atts = shortcode_atts(
			array(
				'border'     => '',
				'height'     => '',
				'product'    => '',
				'autoplay'   => 0,
				'navigation' => true,
				'class_name' => '',
			), $atts
		);

		if ( ! $this->wc_actived ) {
			return '';
		}

		if ( $atts['border'] ) {
			$atts['class_name'] .= ' has-border';
		}

		$output = array();

		if ( ! $atts['product'] ) {
			return '';
		}

		$ids = explode( ',', $atts['product'] );

		if ( count( $ids ) > 1 ) {
			if ( intval( $atts['navigation'] ) ) {
				$atts['class_name'] .= ' has-navigation';
			}
		}

		$style_box = '';
		if ( $atts['height'] ) {
			$style_box = sprintf( 'style="height: %spx;overflow: hidden"', intval( $atts['height'] ) );
		}

		foreach ( $ids as $id ) {
			$product = wc_get_product( $id );

			if ( ! $product ) {
				return '';
			}

			$article = array();
			$cat     = '';
			$terms   = get_the_terms( $atts['product'], 'product_cat' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$cat = sprintf( '<a href="%s" class="cat-link">%s</a>', get_term_link( $terms[0]->term_id, 'product_cat' ), $terms[0]->name );
			}

			$stock  = '';
			$status = sprintf( '<span class="out-stock">%s</span>', esc_html__( 'Out of Stock', 'mrbara' ) );
			if ( $product->get_stock_status() == 'instock' ) {
				if ( $product->managing_stock() ) {
					$stock .= sprintf(
						'<div class="total-stock">' .
						esc_html__( 'Only', 'mrbara' ) .
						'<span class="number">%s</span>' .
						esc_html__( 'left', 'mrbara' ) .
						'</div>',
						$product->get_stock_quantity()
					);
				}
				$status = sprintf( '<span class="in-stock">%s</span>', esc_html__( 'In Stock', 'mrbara' ) );
			}

			$stock .= sprintf( '<span class="step"></span> <span class="availalbe">%s </span><span class="stock-status">%s</span>', esc_html__( 'Available:', 'mrbara' ), $status );

			$article[] = sprintf(
				'<div class="product-content">' .
				'   <a href="%1$s" class="product-thumbnail">' .
				'       %2$s' .
				'   </a>' .
				'   %4$s' .
				'   <a href="%1$s" class="product-title">' .
				'       %3$s' .
				'   </a>' .
				'   <div class="product-price">%5$s' .
				'   </div>' .
				'   <div class="product-stock">' .
				'       %6$s' .
				'   </div>' .
				'   <a class="product-link" href="%1$s">%7$s</a>' .
				'</div>',
				$product->get_permalink(),
				$product->get_image( apply_filters( 'mrbara_hot_deal_product_size', 'shop_catalog' ) ),
				$product->get_title(),
				$cat,
				$product->get_price_html(),
				$stock,
				esc_html__( 'Buy Now', 'mrbara' )

			);


			$sale_price_dates_to = 0;

			if ( $product->get_type() == 'variable' ) {
				$available_variations = $product->get_available_variations();

				for ( $i = 0; $i < count( $available_variations ); $i++ ) {
					$variation_id = $available_variations[ $i ]['variation_id'];
					$price_dates  = get_post_meta( $variation_id, '_sale_price_dates_to', true );
					if ( $price_dates ) {
						$price_dates = date_i18n( 'Y/m/d H:i:s', $price_dates );
						if ( strtotime( $price_dates ) > strtotime( $sale_price_dates_to ) ) {
							$sale_price_dates_to = strtotime( $price_dates );
						}
					}

				}
			} else {
				$sale_price_dates_to = ( $date = get_post_meta( $id, '_sale_price_dates_to', true ) ) ? strtotime( date_i18n( 'Y/m/d H:i:s', $date ) ) : '';
			}

			$second = 0;
			if ( $sale_price_dates_to ) {
				$second_current = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
				if ( $sale_price_dates_to > $second_current ) {
					$second = $sale_price_dates_to - $second_current;
				}

			}

			if ( $second ) :
				$article[] = sprintf( '<span class="time-offer">%s:</span>', esc_html__( 'Offer ends in', 'mrbara' ) );
				$article[] = sprintf( '<div class="sale-price-date">%s</div>', esc_attr( $second ) );
			endif;

			$output[] = sprintf( '<div class="box-stock-product" %s>%s</div>', $style_box, implode( ' ', $article ) );
		}

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$id                                   = uniqid( 'products-hotdeal-' );
		$this->l10n['productsHotDeal'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => intval( $atts['navigation'] ) ? true : false,
		);

		return sprintf(
			'<div class="hot-deal-product mrbara-product-countdown %s" id="%s">' .
			'  %s' .
			'</div>',
			esc_attr( $atts['class_name'] ),
			esc_attr( $id ),
			implode( ' ', $output )
		);
	}

	/**
	 * Products tabs carousel shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_tabs( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'             => '1',
				'per_page'          => 8,
				'columns'           => 4,
				'link'              => '',
				'orderby'           => 'date',
				'order'             => 'desc',
				'el_class'          => '',
				'hide_featured'     => false,
				'featured_title'    => esc_html__( 'Featured', 'mrbara' ),
				'hide_sale'         => false,
				'sale_title'        => esc_html__( 'Hot Sale', 'mrbara' ),
				'hide_best_seller'  => false,
				'best_seller_title' => esc_html__( 'Best Seller', 'mrbara' ),
				'hide_new'          => false,
				'new_title'         => esc_html__( 'New Products', 'mrbara' ),
				'autoplay'          => 0,
				'navigation'        => true,
				'pagigation'        => true,
				'categories'        => '',

			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'products-tabs-style' . $atts['style'];
		}

		$view_more = '';
		if ( $atts['style'] != '5' ) {
			if ( function_exists( 'vc_build_link' ) ) {
				$link = array_filter( vc_build_link( $atts['link'] ) );
				if ( ! empty( $link ) ) {
					$view_more = sprintf(
						'<div class="view-more"><a href="%s" class="link"%s%s>%s</a></div>',
						esc_url( $link['url'] ),
						! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
						! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
						esc_html( $link['title'] )
					);
				}
			}
		} else {
			$atts['layout'] = 'list';
		}

		$output = array();
		$tabs   = array();
		if ( ! $atts['hide_featured'] ) {
			$atts['products'] = 'featured';
			$output[]         = sprintf(
				'<div class="tabs-panel">%s</div>',
				$this->get_products( $atts )
			);
			$tabs[]           = sprintf(
				'<li><a href="#" class="cat-link">%s</a></li>',
				$atts['featured_title']
			);
		}

		if ( ! $atts['hide_new'] ) {
			$atts['products'] = 'recent';
			$output[]         = sprintf(
				'<div class="tabs-panel">%s</div>',
				$this->get_products( $atts )
			);
			$tabs[]           = sprintf(
				'<li><a href="#" class="cat-link">%s</a></li>',
				$atts['new_title']
			);
		}

		if ( ! $atts['hide_best_seller'] ) {
			$atts['products'] = 'best_selling';
			$output[]         = sprintf(
				'<div class="tabs-panel">%s</div>',
				$this->get_products( $atts )
			);
			$tabs[]           = sprintf(
				'<li><a href="#" class="cat-link">%s</a></li>',
				$atts['best_seller_title']
			);
		}

		if ( ! $atts['hide_sale'] ) {
			$atts['products'] = 'sale';
			$output[]         = sprintf(
				'<div class="tabs-panel">%s</div>',
				$this->get_products( $atts )
			);
			$tabs[]           = sprintf(
				'<li><a href="#" class="cat-link">%s</a></li>',
				$atts['sale_title']
			);
		}

		$tabs = sprintf(
			'<ul class="tabs-nav">%s</ul>',
			implode( '', $tabs )
		);

		$autoplay    = intval( $atts['autoplay'] );
		$is_carousel = 0;

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		if ( in_array( $atts['style'], array( '3', '4', '5' ) ) ) {
			$is_carousel = 1;

			if ( in_array( $atts['style'], array( '3', '5' ) ) ) {

				if ( $atts['navigation'] ) {
					$css_class[] = 'has-navigation';
				}

			} else {
				$atts['navigation'] = false;
				if ( $atts['pagigation'] ) {
					$css_class[] = 'has-pagigation';
				}
			}
		}


		$id                                         = uniqid( 'products-tabs-carousel1-' );
		$this->l10n['productsTabsCarousel1'][ $id ] = array(
			'autoplay'    => $autoplay,
			'navigation'  => intval( $atts['navigation'] ) ? true : false,
			'is_carousel' => $is_carousel,
			'items'       => intval( $atts['columns'] ),
		);

		return sprintf(
			'<div class="mrbara-products-tabs tabs woocommerce %s" id="%s"> %s %s %s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			$tabs,
			implode( '', $output ),
			$view_more
		);
	}

	/**
	 * Products tabs carousel shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_tabs_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'      => '',
				'products'   => 'recent',
				'title'      => '',
				'per_page'   => 12,
				'orderby'    => 'date',
				'order'      => 'desc',
				'autoplay'   => 0,
				'pagination' => true,
				'columns'    => 3,
				'el_class'   => '',
				'hide_top'   => false,
				'top_title'  => esc_html__( 'Top 10', 'mrbara' ),
				'top_number' => '10',
				'categories' => '',
				'layout'     => 'list',
				'views'      => 6,
				'link'       => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$output = array();

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		if ( $atts['views'] == 4 ) {
			$atts['columns'] = 2;
		} elseif ( $atts['views'] == 8 ) {
			$atts['columns'] = 4;
		}

		if ( $atts['style'] == 2 ) {
			$atts['layout'] = '';
		}

		$id                                         = uniqid( 'products-tabs-carousel2-' );
		$this->l10n['productsTabsCarousel2'][ $id ] = array(
			'autoplay'   => $autoplay,
			'pagination' => intval( $atts['pagination'] ) ? true : false,
			'columns'    => intval( $atts['columns'] ),
		);

		$tabs       = array();
		$categories = $atts['categories'];

		if ( ! $atts['hide_top'] ) {

			$atts['per_page']   = intval( $atts['top_number'] );
			$atts['categories'] = '';

			$output[] = sprintf(
				'<div class="tabs-panel">%s</div>',
				$this->get_products( $atts )
			);
			$tabs[]   = sprintf(
				'<li><a href="#" class="cat-link">%s</a></li>',
				$atts['top_title']
			);
		}

		if ( $categories ) {
			$cats = explode( ',', $categories );

			foreach ( $cats as $cat ) {

				$atts['categories'] = $cat;
				$output[]           = sprintf(
					'<div class="tabs-panel">%s</div>',
					$this->get_products( $atts )
				);

				$category = get_term_by( 'slug', $cat, 'product_cat' );

				if ( $category ) {
					$tabs[] = sprintf(
						'<li><a href="#" class="cat-link">%s</a></li>',
						$category->name
					);
				}

			}

		}

		if ( function_exists( 'vc_build_link' ) && $atts['style'] == 2 ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$tabs[] = sprintf(
					'<li><a href="%s" class="link"%s%s>%s<i class="ion-ios-arrow-right"></i> </a></li>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}
		$tabs_html = '';
		if ( $atts['title'] ) {
			$tabs_html .= sprintf(
				'<div class="title">%s</div>',
				$atts['title']
			);
		}

		$tabs_html .= sprintf(
			'<ul class="tabs-nav">%s</ul>',
			implode( '', $tabs )
		);

		$head = sprintf( '<div class="tab-header">%s</div>', $tabs_html );

		return sprintf(
			'<div class="mrbara-products-tabs-2 mrbara-product-list tabs woocommerce %s" id="%s">%s %s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			$head,
			implode( '', $output )

		);
	}

	/**
	 * Products tabs carousel shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function products_picks( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'      => '1',
				'ids'        => '',
				'paginated'  => '',
				'autoplay'   => 0,
				'navigation' => '1',
				'pagination' => '1',
				'columns'    => 4,
				'views'      => 8,
				'el_class'   => '',
				'layout'     => '',
				'link'       => '',
			), $atts
		);

		if ( ! $this->wc_actived ) {
			return '';
		}

		if ( $atts['style'] != '1' ) {
			$atts['views'] = $atts['columns'];
		} else {
			if ( $atts['columns'] == '3' ) {
				$atts['views'] = 6;
			} elseif ( $atts['columns'] == '2' ) {
				$atts['views'] = 4;
			}
		}

		$css_class[] = $atts['el_class'];
		$css_class[] = 'style-' . $atts['style'];

		$output = array();

		$autoplay = intval( $atts['autoplay'] );

		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$col = intval( $atts['columns'] );

		$nav  = false;
		$pagi = false;

		$prev_text = '<i class="ion-ios-arrow-left"></i>';
		$next_text = '<i class="ion-ios-arrow-right"></i>';
		if ( $atts['navigation'] == '2' ) {
			$prev_text = '<i class="ion-android-arrow-back"></i><span>' . esc_html__( 'Prev', 'mrbara' ) . '</span>';
			$next_text = '<span>' . esc_html__( 'Next', 'mrbara' ) . '</span><i class="ion-android-arrow-forward"></i>';
		} elseif ( $atts['navigation'] == '3' ) {
			$prev_text = '<i class="ion-ios-arrow-thin-left"></i>';
			$next_text = '<i class="ion-ios-arrow-thin-right"></i>';
		}

		if ( $atts['paginated'] == 'navi' ) {
			$nav         = true;
			$pagi        = true;
			$css_class[] = 'has-navigation';
			$css_class[] = 'products-navi-' . $atts['navigation'];
		} elseif ( $atts['paginated'] == 'pagi' ) {
			$pagi        = true;
			$css_class[] = 'has-pagination';
			$css_class[] = 'products-pagi-' . $atts['pagination'];
		}

		$id                                 = uniqid( 'products-picks-' );
		$this->l10n['productsPicks'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => $nav,
			'pagination' => $pagi,
			'number'     => $col,
			'prev'       => $prev_text,
			'next'       => $next_text,
		);

		$output[] = $this->get_products_picks( $atts );

		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$output[] = sprintf(
					'<div class="footer-link"> <a href="%s" class="link"%s%s>%s</a></div>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}


		return sprintf(
			'<div class="mrbara-products-picks %s" id="%s">' .
			'   %s' .
			'</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( $id ),
			implode( ' ', $output )
		);
	}

	/**
	 * Shortcode to display pricing table
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function pricing( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'featured'      => '',
				'title'         => '',
				'price'         => '',
				'time_duration' => '',
				'desc'          => '',
				'link'          => '',
				'el_class'      => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		if ( $atts['featured'] ) {
			$css_class[] .= 'featured';
		}

		if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}
		$output = array();
		$link   = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$link = sprintf(
					'<a href="%s" class="link"%s%s>%s</a>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		$output[] = sprintf(
			'<div class="pricing-title">
	            <span class="title">%s</span>
	            <div class="pricing-info">
	                <span class="p-price">%s</span>
	                <span class="p-time">%s</span>
	            </div>
	            <div class="pricing-desc">%s</div>
	        </div>
	        <div class="pricing-box">
	            <div class="pricing-content">%s</div>
	            %s
	        </div>',
			esc_attr( $atts['title'] ),
			esc_attr( $atts['price'] ),
			esc_attr( $atts['time_duration'] ),
			esc_attr( $atts['desc'] ),
			$content,
			$link ? $link : ''
		);

		if ( $output ) {
			return sprintf(
				'<div class="mrbara-pricing %s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				implode( '', $output )
			);
		}

		return '';
	}

	/**
	 * Shortcode to display product detail
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function product_detail( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'      => '',
				'price'      => '',
				'link'       => '',
				'quick_view' => '',
				'el_class'   => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];


		if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}
		$output = array();
		$link   = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );

			$css_button = '';
			if ( $atts['quick_view'] ) {
				$css_button = 'product-quick-view';
			}

			if ( ! empty( $link ) ) {
				$link = sprintf(
					'<a href="%s" data-href="%s" class="link btn %s"%s%s>%s</a>',
					esc_url( $link['url'] ),
					esc_url( $link['url'] ),
					esc_attr( $css_button ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		$output[] = sprintf(
			'<div class="product-content">
	            <span class="p-title">%s</span>
	            <span class="p-price">%s</span>
	            <div class="p-desc">%s</div>
	            %s
	        </div>',
			esc_attr( $atts['title'] ),
			esc_attr( $atts['price'] ),
			$content,
			$link ? $link : ''
		);

		if ( $output ) {
			return sprintf(
				'<div class="mrbara-product-detail %s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				implode( '', $output )
			);
		}

		return '';
	}

	/**
	 * Shortcode to display progressbar circle
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function progressbar_circle( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => '',
				'value'    => '',
				'units'    => '',
				'color'    => '#cc3333',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$value = intval( $atts['value'] ) / 100;

		$id                               = uniqid( 'progress-circle-' );
		$this->l10n['progressbar'][ $id ] = array(
			'color' => $atts['color'],
			'value' => $value,
			'size'  => 140,
			'width' => 5,
		);


		$output = array();

		$output[] = sprintf(
			'<div class="progress-area">
				<div id="%s" class="progress-item">
					<div class="inner-circle" style="color: %s;">
						<span class="value">%s%s</span>
					</div>
				</div>
	            <span class="progress-title">%s</span>
	        </div>',
			esc_attr( $id ),
			esc_attr( $atts['color'] ),
			$atts['value'],
			$atts['units'],
			$atts['title']

		);

		if ( $output ) {
			return sprintf(
				'<div class="mrbara-progressbar %s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				implode( '', $output )
			);
		}

		return '';
	}

	/**
	 * Shortcode to display pie chart circle
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	function pie_chart( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'icon'     => '',
				'title'    => '',
				'value'    => '',
				'units'    => '',
				'color'    => '#cc3333',
				'el_class' => '',
			), $atts
		);

		$css_class[] = $atts['el_class'];

		$value = intval( $atts['value'] ) / 100;

		$id                               = uniqid( 'progress-circle-' );
		$this->l10n['progressbar'][ $id ] = array(
			'color' => $atts['color'],
			'value' => $value,
			'size'  => 100,
			'width' => 7,
		);


		$output = array();

		$output[] = sprintf(
			'<div class="piechart-area">
				<div id="%s" class="piechart-item">
					<div class="inner-circle" style="color: %s;">
						<i class="%s"></i>
					</div>
				</div>
	            <span class="piechart-title">%s</span>
	            <span class="value" style="color: %s;">%s%s</span>
	        </div>',
			esc_attr( $id ),
			esc_attr( $atts['color'] ),
			esc_attr( $atts['icon'] ),
			$atts['title'],
			esc_attr( $atts['color'] ),
			$atts['value'],
			$atts['units']

		);

		if ( $output ) {
			return sprintf(
				'<div class="mrbara-piechart %s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				implode( '', $output )
			);
		}

		return '';
	}

	/**
	 * Shortcode [mrbara_button]
	 * The button shortcode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function button( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'    => esc_html__( 'Text on the button', 'mrbara' ),
				'link'     => '',
				'align'    => 'inline',
				'color'    => '',
				'shadow'   => '',
				'el_class' => '',
			), $atts, 'mrbara_button'
		);

		$button = '';
		if ( ! empty( $atts['link'] ) ) {

			if ( function_exists( 'vc_build_link' ) ) {
				$link = vc_build_link( $atts['link'] );

				$button = sprintf(
					'<a href="%s" class="mrbara-button btn"%s%s>%s</a>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $atts['title'] )
				);
			}
		} else {
			$button = sprintf( '<button class="mrbara-button btn">%s</button>', esc_html( $atts['title'] ) );
		}

		return sprintf(
			'<div class="mrbara-button-container mrbara-button-%s %s%s">%s</div>',
			esc_attr( $atts['align'] ),
			esc_attr( $atts['el_class'] . ' ' . $atts['color'] ),
			$atts['shadow'] ? ' shadow' : '',
			$button
		);
	}

	/**
	 * Shortcode [mrbara_link]
	 * The button shortcode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function link( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'       => '1',
				'link'        => '',
				'font_size'   => '',
				'font_family' => '',
				'font_style'  => '',
				'line_height' => '',
				'link_icon'   => '',
				'link_color'  => 'primary',
				'italic'      => '',
				'align'       => '',
				'el_class'    => '',
			), $atts, 'mrbara_link'
		);

		$css_class   = array();
		$css_class[] = $atts['el_class'];
		$css_class[] = 'link-style-' . $atts['style'];

		if ( $atts['align'] ) {
			$css_class[] = $atts['align'];
		}

		$button = '';

		if ( $content ) {
			$content = wp_kses( $content, array( 'br' => array() ) );
		}

		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$icon_class = '';
				if ( $atts['link_icon'] ) {
					$icon_class .= ' show-icon';
				}

				if ( $atts['italic'] ) {
					$icon_class .= ' italic';
				}

				if ( $atts['link_color'] ) {
					$icon_class .= ' color-' . $atts['link_color'];
				}

				$icon_style = $this->get_style_attr( $atts );

				$button = sprintf(
					'<a href="%s" class="mrbara-link %s" %s%s%s>%s</a>',
					esc_url( $link['url'] ),
					esc_attr( $icon_class ),
					$icon_style,
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					$content
				);
			}
		}


		return sprintf(
			'<div class="mrbara-link-container %s">%s</div>',
			implode( ' ', $css_class ),
			$button
		);
	}

	/**
	 * Shortcode [mrbara_vertical_line]
	 * The vertical line displays at the center top of section
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function vertical_line( $atts ) {
		$atts = shortcode_atts(
			array(
				'offset'   => 'top',
				'el_class' => '',
			), $atts, 'mrbara_vertical_line'
		);

		return sprintf( '<div class="mrbara-vertical-line %s"></div>', esc_attr( $atts['offset'] . ' ' . $atts['el_class'] ) );
	}

	/**
	 * Shortcode [mrbara_pa_swatches]
	 * Display product attribute swatches
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function pa_swatches( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'    => esc_html__( 'Available:', 'mrbara' ),
				'el_class' => '',
			), $atts, 'mrbara_pa_swatches'
		);

		$attr_html  = array();
		$attributes = explode( "\n", $content );

		foreach ( $attributes as $attribute ) {
			$values = array_map( 'trim', explode( '|', strip_tags( $attribute ) ) );
			$html   = '';

			foreach ( $values as $value ) {
				if ( preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $value ) ) {
					$html .= '<span class="product-color product-attribute" style="background-color:' . esc_attr( $value ) . '"></span>';
				} else {
					$html .= '<span class="product-attribute">' . esc_html( $value ) . '</span>';
				}
			}
			$attr_html[] = '<span class="swatches-set">' . $html . '</span>';
		}

		$attr_html = array_filter( $attr_html );
		if ( empty( $attr_html ) ) {
			return '';
		}

		return sprintf(
			'<div class="mrbara-pa-swatches">%s%s</div>',
			! empty( $atts['title'] ) ? '<span class="swatches-sets-title">' . esc_html( $atts['title'] ) . '</span>' : '',
			implode( '<span class="sep">|</span>', $attr_html )
		);
	}

	/**
	 * Shortcode [mrbara_testimonials]
	 * Display testimonials carousel
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function testimonials( $atts ) {
		$atts = shortcode_atts(
			array(
				'number'      => 3,
				'category'    => '',
				'align'       => 'left',
				'show_stars'  => false,
				'show_nav'    => false,
				'show_avatar' => false,
				'nav_style'   => 'rounded',
				'autoplay'    => 5000,
				'el_class'    => '',
			), $atts, 'mrbara_testimonials'
		);

		if ( ! $atts['number'] ) {
			return '';
		}

		$testimonials = get_posts(
			array(
				'post_type'            => 'testimonial',
				'posts_per_page'       => intval( $atts['number'] ),
				'testimonial_category' => trim( $atts['category'] ),
			)
		);

		if ( empty( $testimonials ) ) {
			return '';
		}

		$output = array();
		foreach ( $testimonials as $testimonial ) {
			$stars = $atts['show_stars'] ? $this->star_rating( get_post_meta( $testimonial->ID, 'rating', true ), false ) : '';

			if ( $atts['show_avatar'] ) {
				$email = get_post_meta( $testimonial->ID, 'email', true );

				$output[] = sprintf(
					'<div><div class="testimonial-content">%s</div><span class="testimonial-author"><span class="avatar">%s</span><span class="name">%s</span></span>%s</div>',
					do_shortcode( apply_filters( 'the_content', $testimonial->post_content ) ),
					has_post_thumbnail( $testimonial->ID ) ? get_the_post_thumbnail( $testimonial->ID, array(
						38,
						38,
					) ) : get_avatar( $email, 38 ),
					$testimonial->post_title,
					$stars ? ' - ' . $stars : ''
				);
			} else {
				$output[] = sprintf(
					'<div>' .
					'	<div class="testimonial-content">%s</div>' .
					'	%s' .
					'	<span class="testimonial-author">' .
					'		<span>%s</span> - <span class="byline">%s</span>' .
					'	</span>' .
					'</div>',
					do_shortcode( apply_filters( 'the_content', $testimonial->post_content ) ),
					$stars,
					$testimonial->post_title,
					get_post_meta( $testimonial->ID, 'byline', true )
				);
			}
		}

		return sprintf(
			'<div class="mrbara-testimonials align-%s nav-%s %s %s">' .
			'	<div class="testimonial-carousel" data-nav="%s" data-autoplay="%s" data-avatar="%s">%s</div>' .
			'</div>',
			esc_attr( $atts['align'] ),
			esc_attr( $atts['nav_style'] ),
			$atts['show_avatar'] ? 'show-avatar' : '',
			esc_attr( $atts['el_class'] ),
			esc_attr( $atts['show_nav'] ),
			esc_attr( $atts['autoplay'] ),
			esc_attr( $atts['show_avatar'] ),
			implode( "\n", $output )
		);
	}

	/**
	 * Get stars rating HTML base on rating score
	 *
	 * @param int  $score
	 * @param bool $echo
	 *
	 * @return string
	 */
	function star_rating( $score, $echo = true ) {
		$score = min( 10, absint( $score ) );
		$full  = floor( $score / 2 );
		$half  = 0;
		$stars = array();

		for ( $i = 1; $i <= 5; $i++ ) {
			if ( $full >= $i ) {
				$stars[] = '<i class="ion-ios-star"></i>';
			} elseif ( $score % 2 && ! $half ) {
				$stars[] = '<i class="ion-ios-star-half"></i>';
				$half    = 1;
			} else {
				$stars[] = '<i class="ion-ios-star-outline"></i>';
			}
		}

		$stars = '<span class="rating">' . implode( "\n", $stars ) . '</span>';

		if ( $echo ) {
			echo $stars;
		}

		return $stars;
	}

	/**
	 * Testimonials shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function testimonials_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'      => '1',
				'number'     => '-1',
				'autoplay'   => 0,
				'navigation' => true,
				'el_class'   => '',
			), $atts
		);

		$autoplay = intval( $atts['autoplay'] );
		if ( ! $autoplay ) {
			$autoplay = false;
		}

		$css_class[] = $atts['el_class'];

		if ( $atts['style'] ) {
			$css_class[] = 'testimonial-style-' . $atts['style'];
		}

		$id                               = uniqid( 'testimonial-slider-' );
		$this->l10n['testimonial'][ $id ] = array(
			'autoplay'   => $autoplay,
			'navigation' => intval( $atts['navigation'] ) ? true : false,
		);


		$output = array();
		$args   = array(
			'post_type'      => 'testimonial',
			'posts_per_page' => $atts['number'],
		);

		$output[]  = sprintf( '<div class="testimonials_area" id= "%s">', esc_attr( $id ) );
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) :
			$the_query->the_post();

			if ( $atts['style'] == '1' ) {
				$title = sprintf(
					'<div class="testi-company-info"><h4 class="testi-name">%s</h4> - <span>%s</span></div>',
					get_the_title(), get_post_meta( get_the_ID(), 'byline', true )
				);
			} else {
				$title = sprintf(
					'<span class="testi-company-info">- %s -</span>',
					get_post_meta( get_the_ID(), 'byline', true )
				);
			}
			$output[] = sprintf(
				'
                <div class="testi-item">
                         <div class="testi-desc">%s </div>
                         %s
                </div>',
				do_shortcode( get_the_content() ),
				$title
			);
		endwhile;
		wp_reset_postdata();
		$output[] = '</div>';

		return sprintf(
			'
                        <div class="mrbara-testi-carousel-2 %s">
                         	<div class="testi-quote"><i class="ion-quote"></i></div>
                            <div class="testi-list">%s</div>
                        </div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Shortcode [mrbara_cta_2]
	 * Display call to action element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function cta_2( $atts ) {
		$atts = shortcode_atts(
			array(
				'subtitle' => '',
				'title'    => '',
				'link'     => '',
				'el_class' => '',
				'css'      => '',
			), $atts, 'mrbara_cta_2'
		);

		$css_classes   = array(
			'mrbara-cta-2',
			'text-center',
			$atts['el_class'],
		);
		$css_classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		if ( vc_shortcode_custom_css_has_property( $atts['css'], array( 'background' ) ) ) {
			$css_classes[] = 'cta-has-fill';
		}

		$button = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link   = vc_build_link( $atts['link'] );
			$button = sprintf(
				'<a href="%s" class="mrbara-button btn"%s%s>%s</a>',
				esc_url( $link['url'] ),
				! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
				! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
				esc_html( $link['title'] )
			);

		}

		return sprintf(
			'<div class="%s">' .
			'	<h4 class="subtitle">%s</h4>' .
			'	<h2 class="title">%s</h2>' .
			'	<div class="mrbara-button-container mrbara-button-center lighten shadow">' .
			'		%s' .
			'	</div>' .
			'</div>',
			esc_attr( implode( ' ', $css_classes ) ),
			esc_html( $atts['subtitle'] ),
			esc_html( $atts['title'] ),
			$button

		);
	}

	/**
	 * Shortcode [mrbara_portfolio_slider]
	 * Display portfolio slider
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function portfolio_slider( $atts ) {
		$atts = shortcode_atts(
			array(
				'excerpt_title'  => 4,
				'image'          => '',
				'number'         => 6,
				'category'       => '',
				'autoplay'       => 0,
				'pager'          => true,
				'excerpt_length' => 20,
				'el_class'       => '',
			), $atts
		);

		if ( ! $atts['number'] ) {
			return '';
		}

		$portfolio = get_posts(
			array(
				'post_type'          => 'portfolio_project',
				'posts_per_page'     => intval( $atts['number'] ),
				'portfolio_category' => trim( $atts['category'] ),
			)
		);

		if ( empty( $portfolio ) ) {
			return '';
		}

		$autoplay = intval( $atts['autoplay'] );
		$pause    = 4000;
		if ( ! $autoplay ) {
			$autoplay = false;
		} else {
			$pause    = $autoplay;
			$autoplay = true;
		}

		$pager = intval( $atts['pager'] ) ? true : false;

		$id                             = uniqid( 'portfolio-slider-' );
		$this->l10n['portfolio'][ $id ] = array(
			'autoplay' => $autoplay,
			'pause'    => $pause,
			'pager'    => $pager,
		);


		$output  = array();
		$article = array();

		foreach ( $portfolio as $port ) {

			$cat_name = '';
			if ( taxonomy_exists( 'portfolio_category' ) ) {
				$cats = wp_get_post_terms( $port->ID, 'portfolio_category' );

				if ( $cats ) {

					$cat_name = sprintf(
						'<a href="%s" class="portfolio-cat">%s</a>',
						esc_url( get_term_link( $cats[0] ) ),
						esc_attr( $cats[0]->name )
					);
				}
			}

			$article[] = sprintf(
				'<div class="portfolio-item">%s' .
				'<a href="%s" class="portfolio-title">%s</a>' .
				'<div class="portfolio-desc">%s' .
				'<a href="%s" class="view-more">%s</a></div>' .
				'</div>',
				$cat_name,
				esc_url( get_the_permalink( $port->ID ) ),
				$this->mrbara_shortcode_content_limit( $port->post_title, intval( $atts['excerpt_title'] ), '' ),
				$this->mrbara_shortcode_content_limit( get_the_excerpt( $port->ID ), intval( $atts['excerpt_length'] ) ),
				esc_url( get_the_permalink( $port->ID ) ),
				esc_html__( 'View Project', 'mrbara' )
			);
		}

		$image = wp_get_attachment_image_src( $atts['image'], 'full' );

		if ( $image ) {
			$image = sprintf( '<img class="portfolio-image" src="%s" alt="">', esc_url( $image[0] ) );
		}

		$output[] = sprintf(
			'<div class="row">' .
			'<div class="portfolio-content">' .
			'<div class="col-sm-12 col-md-6 col-port-left">%s</div>' .
			'<div class="col-sm-12 col-md-6 col-port-right"><div class="portfolio-list" id="%s">%s</div></div>' .
			'</div>' .
			'</div>',
			$image,
			esc_attr( $id ),
			implode( "\n", $article )
		);

		return sprintf(
			'<div class="mrbara-portfolio-slider %s">%s</div>',
			esc_attr( $atts['el_class'] ),
			implode( "\n", $output )
		);
	}

	/**
	 * Get or display limited words from given string.
	 * Strips all tags and shortcodes from string.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $num_words The maximum number of words
	 * @param string  $more      More link.
	 * @param bool    $echo      Echo or return output
	 *
	 * @return string|void Limited content.
	 */
	function mrbara_shortcode_content_limit( $content, $num_words, $more = '&hellip;' ) {

		// Strip tags and shortcodes so the content truncation count is done correctly
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'mrbara_content_limit_allowed_tags', '<script>,<style>' ) );

		// Remove inline styles / scripts
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		return wp_trim_words( $content, $num_words, $more );

	}

	/**
	 * Shortcode [mrbara_banner]
	 * Display banner element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function banner( $atts ) {
		$atts = shortcode_atts(
			array(
				'style'         => '1',
				'title'         => '',
				'link'          => '',
				'text'          => '',
				'text_color'    => 'primary',
				'text_position' => 'left',
				'text_top'      => 75,
				'image'         => '',
				'el_class'      => '',
				'css'           => '',
			), $atts, 'mrbara_banner'
		);

		$css_classes = array(
			'mrbara-banner',
			'text-color-' . $atts['text_color'],
			'text-position-' . $atts['text_position'],
			$atts['el_class'],
		);

		if ( $atts['style'] ) {
			$css_classes[] = 'banner-style' . $atts['style'];
		}

		$css_classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );

		$button = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = vc_build_link( $atts['link'] );
			if ( $link['url'] ) {
				$button = sprintf(
					'<a href="%s"%s%s>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : ''
				);
			}

		}

		$inner_html = '';
		if ( $button ) {
			$inner_html = sprintf(
				'%s' .
				'	%s' .
				'	<h3 class="banner-title">%s</h3>' .
				'</a>',
				$button,
				! empty( $atts['image'] ) ? wp_get_attachment_image( intval( $atts['image'] ), 'full' ) : '',
				esc_html( $atts['title'] )
			);
		} else {
			$inner_html = sprintf(
				'%s' .
				'<h3 class="banner-title">%s</h3>',
				! empty( $atts['image'] ) ? wp_get_attachment_image( intval( $atts['image'] ), 'full' ) : '',
				esc_html( $atts['title'] )
			);
		}

		return sprintf(
			'<div class="%s">' .
			'	%s' .
			'	<span class="text"><span class="sub-title"  %s>%s</span></span>' .
			'</div>',
			esc_attr( implode( ' ', $css_classes ) ),
			$inner_html,
			intval( $atts['text_top'] ) != 75 ? ' style="left:-' . intval( $atts['text_top'] ) . 'px"' : '',
			esc_html( $atts['text'] )
		);
	}

	/**
	 * Shortcode [mrbara_banner]
	 * Display banner element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function banner_large( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'font_size'        => '',
				'line_height'      => '',
				'letter_spacing'   => '',
				'font_family'      => '',
				'font_style'       => '',
				'image'            => '',
				'bg_color_overlay' => '',
				'subtitle'         => '',
				'link'             => '',
				'light_skin'       => '',
				'parallax'         => '',
				'el_class'         => '',
				'css'              => '',
			), $atts
		);

		$css_classes[] = $atts['el_class'];
		$css_classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		if ( vc_shortcode_custom_css_has_property( $atts['css'], array( 'background' ) ) ) {
			$css_classes[] = 'cta-has-fill';
		}

		if ( $atts['parallax'] ) {
			$css_classes[] = 'parallax no-parallax-mobile';
		}

		if ( $atts['light_skin'] ) {
			$css_classes[] = 'light-skin';
		}

		$output      = array();
		$title_style = $this->get_style_attr( $atts );

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$output[] = sprintf( '<div class="title" %s>%s</div>', $title_style, $content );
		}

		if ( $atts['subtitle'] ) {
			$output[] = sprintf( '<div class="sub-title">%s</div>', $atts['subtitle'] );
		}

		$view_more = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = array_filter( vc_build_link( $atts['link'] ) );
			if ( ! empty( $link ) ) {
				$view_more = sprintf(
					'<div class="view-more"><a href="%s" class="link"%s%s>%s</a></div>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '',
					esc_html( $link['title'] )
				);
			}
		}

		$bg_overlay = '';
		if ( $atts['bg_color_overlay'] ) {
			$bg_overlay = 'style="background-color:' . esc_attr( $atts['bg_color_overlay'] ) . '"';
		}


		return sprintf(
			'<div class="mrbara-banner-large %s">' .
			'   <div class="banner-overlay" %s></div>' .
			'   <div class="banner-content">' .
			'	    %s' .
			'       %s' .
			'   </div>' .
			'</div>',
			esc_attr( implode( ' ', $css_classes ) ),
			$bg_overlay,
			implode( '', $output ),
			$view_more
		);
	}

	/**
	 * Shortcode [mrbara_banner]
	 * Display banner element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function promotion_medium( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'           => '',
				'image'           => '',
				'min_height'      => '',
				'css'             => '',
				'border'          => '',
				'old_price'       => '',
				'new_price'       => '',
				'new_price_color' => '',
				'skin'            => 'light',
				'link'            => '',
				'text_position'   => 'left',
				'el_class'        => '',
			), $atts
		);

		$css_classes = array(
			'mr-promotion-medium',
			'text-position-' . $atts['text_position'],
			$atts['el_class'],
		);

		if ( $atts['style'] ) {
			$css_classes[] = 'style-' . $atts['style'];
		}

		if ( $atts['border'] ) {
			$css_classes[] = 'has-border';
		}

		$css_classes[] = $atts['skin'] . '-skin';

		$css_classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		if ( vc_shortcode_custom_css_has_property( $atts['css'], array( 'background' ) ) ) {
			$css_classes[] = 'cta-has-fill';
		}

		$style    = '';
		$style_bg = '';


		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'full' );
			if ( $image ) {
				$style .= sprintf( 'background-image:url(%s)', esc_url( $image[0] ) ) . ';';
			}
		}

		if ( $atts['min_height'] ) {
			$style .= sprintf( 'min-height: %s', $atts['min_height'] );
		}

		if ( $style ) {
			$style = 'style="' . $style . '"';
		}

		$button    = '';
		$link_text = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = vc_build_link( $atts['link'] );

			if ( $link['url'] ) {
				$button = sprintf(
					'<a class="p-link" href="%s"%s%s></a>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
					! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : ''
				);
			}

			if ( $link['title'] ) {
				$link_text = sprintf(
					'<span class="link-text">%s</span>',
					esc_html( $link['title'] )
				);
			}

		}

		$title = '';
		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$title = sprintf( '<div class="banner-title">%s</div>', $content );
		}

		$old_price = '';
		$new_price = '';
		if ( $atts['old_price'] ) {
			$old_price = sprintf( '<span class="old-price">%s</span>', $atts['old_price'] );
		}
		if ( $atts['new_price'] ) {
			$new_price_color = '';
			if ( $atts['new_price_color'] ) {
				$new_price_color = 'style="color:' . esc_attr( $atts['new_price_color'] ) . ';"';
			}
			$new_price = sprintf( '<span class="new-price" %s>%s</span>', $new_price_color, $atts['new_price'] );
		}

		return sprintf(
			'<div class="%s" %s>' .
			'<div class="promotion-content" %s>' .
			'	%s' .
			'   <div class="p-desc">' .
			'		<div class="p-content"> %s %s %s %s</div>' .
			'   </div>' .
			'   </div>' .
			'</div>',
			esc_attr( implode( ' ', $css_classes ) ),
			$style_bg,
			$style,
			$button,
			$title,
			$old_price,
			$new_price,
			$link_text

		);
	}

	/**
	 * Shortcode [mrbara_banner]
	 * Display banner element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function promotion_large( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'     => '',
				'bg_color'  => '',
				'border'    => '',
				'subtitle'  => '',
				'old_price' => '',
				'new_price' => '',
				'link'      => '',
				'el_class'  => '',
			), $atts
		);

		$css_classes = array(
			'mr-promotion-large',
			$atts['el_class'],
		);

		if ( $atts['border'] ) {
			$css_classes[] = 'has-border';
		}
		$style = '';
		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_src( intval( $atts['image'] ), 'full' );
			if ( $image ) {
				$style = sprintf( 'background-image:url(%s)', esc_url( $image[0] ) ) . ';';
			}
		}

		if ( $atts['bg_color'] ) {
			$style .= 'background-color:' . esc_attr( $atts['bg_color'] ) . ';';
		}

		if ( $style ) {
			$style = 'style="' . $style . '"';
		}


		$button = '';
		$link   = '';
		if ( function_exists( 'vc_build_link' ) ) {
			$link = vc_build_link( $atts['link'] );

			$button = sprintf(
				'<a class="p-link" href="%s"%s%s></a>',
				esc_url( $link['url'] ),
				! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
				! empty( $link['rel'] ) ? ' rel="' . esc_attr( $link['rel'] ) . '"' : ''
			);
		}

		$p_title = '';
		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
			$p_title = sprintf( '<div class="p-title">%s</div>', $content );
		}
		$s_title = '';
		if ( $atts['subtitle'] ) {
			$s_title = sprintf( '<div class="sub-title">%s</div>', $atts['subtitle'] );
		}

		$old_price = '';
		$new_price = '';
		if ( $atts['old_price'] ) {
			$old_price = sprintf( '<span class="old-price">%s</span>', $atts['old_price'] );
		}
		if ( $atts['new_price'] ) {
			$new_price = sprintf( '<span class="new-price">%s</span>', $atts['new_price'] );
		}


		return sprintf(
			'<div class="%s" %s>%s' .
			'   <div class="row"><div class="promotion-content">' .
			'       <div class="col-md-1 col-sm-1 hidden-xs"></div>' .
			'       <div class="title col-md-4 col-sm-5 col-xs-12">' .
			'              %s %s' .
			'           </div>' .
			'   	    <div class="p-content col-md-3 col-sm-6 col-xs-12">' .
			'              %s %s ' .
			'              <span class="link-text">%s</span>' .
			'           </div>' .
			'      </div></div>' .
			'</div>',
			esc_attr( implode( ' ', $css_classes ) ),
			$style,
			$button,
			$p_title,
			$s_title,
			$old_price,
			$new_price,
			isset( $link['title'] ) ? esc_html( $link['title'] ) : ''
		);
	}

	/**
	 * Map shortcode
	 *
	 * @since 1.0.0
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function gmaps( $atts, $content ) {
		$atts  = shortcode_atts(
			array(
				'api_key' => '',
				'marker'  => '',
				'address' => '',
				'width'   => '',
				'height'  => '450',
				'zoom'    => '13',
				'css'     => '',
			), $atts
		);
		$class = array(
			'mrbara-map-shortcode',
			$atts['css'],
		);

		$style = '';
		if ( $atts['width'] ) {
			$unit = 'px';
			if ( strpos( $atts['width'], '%' ) ) {
				$unit = '%;';
			}

			$atts['width'] = intval( $atts['width'] );
			$style         .= 'width: ' . $atts['width'] . $unit . ';';
		}
		if ( $atts['height'] ) {
			$unit = 'px';
			if ( strpos( $atts['height'], '%' ) ) {
				$unit = '%;';
			}

			$atts['height'] = intval( $atts['height'] );
			$style          .= 'height: ' . $atts['height'] . $unit . ';';
		}
		if ( $atts['zoom'] ) {
			$atts['zoom'] = intval( $atts['zoom'] );
		}

		$id   = uniqid( 'mrbara_map_' );
		$html = sprintf(
			'<div class="%s"><div id="%s" class="ta-map" style="%s"></div></div>',
			implode( ' ', $class ),
			$id,
			$style
		);

		$coordinates = $this->get_coordinates( $atts['address'] );

		if ( isset( $coordinates['error'] ) ) {
			return $coordinates['error'];
		}
		$marker = '';
		if ( $atts['marker'] ) {
			if ( filter_var( $atts['marker'], FILTER_VALIDATE_URL ) ) {
				$marker = $atts['marker'];
			} else {
				$attachment_image = wp_get_attachment_image_src( intval( $atts['marker'] ), 'full' );
				$marker           = $attachment_image ? $attachment_image[0] : '';
			}
		}

		$this->api_key = $atts['api_key'];

		$this->l10n['map'][ $id ] = array(
			'type'    => 'normal',
			'lat'     => $coordinates['lat'],
			'lng'     => $coordinates['lng'],
			'address' => $atts['address'],
			'zoom'    => $atts['zoom'],
			'marker'  => $marker,
			'height'  => $atts['height'],
			'info'    => $content,
		);

		return $html;
	}

	/**
	 * Shortcode [mrbara_promotion_content]
	 * Display promotion content element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function promotion_content_1( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'            => '',
				'discount_text'    => '',
				'discount_percent' => '',
			), $atts
		);

		if ( $content ) {
			if ( function_exists( 'wpb_js_remove_wpautop' ) ) {
				$content = wpb_js_remove_wpautop( $content, true );
			}
		}

		return sprintf(
			'<div class="promotion-content-1">' .
			'<div class="row">' .
			'<div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">' .
			'<div class="promo-left">' .
			'<h2>%s</h2>' .
			'%s' .
			'</div>' .
			'<div class="promo-right">' .
			'<p class="discount-text">%s</p>' .
			'<span class="discount-percent">%s</span>' .
			'</div>' .
			'</div>' .
			'</div>' .
			'</div>',
			esc_html( $atts['title'] ),
			$content,
			esc_html( $atts['discount_text'] ),
			esc_html( $atts['discount_percent'] )

		);
	}

	/**
	 * Shortcode [mrbara_promotion_content]
	 * Display promotion content element
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function promotion_content_2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'discount_text'    => '',
				'discount_percent' => '',
				'button_text'      => '',
				'button_link'      => '',
				'title'            => '',
				'date'             => '',
			), $atts
		);

		$second = 0;
		if ( $atts['date'] ) {
			$second_current = strtotime( date_i18n( 'Y/m/d H:i:s' ) );
			$date           = new DateTime( $atts['date'] );
			if ( $date ) {
				$second_discount = strtotime( date_i18n( 'Y/m/d H:i:s', $date->getTimestamp() ) );
				if ( $second_discount > $second_current ) {
					$second = $second_discount - $second_current;
				}
			}

		}

		$css_class = '';
		if ( ! $second ) {
			$css_class = 'expired-date';
		}

		return sprintf(
			'<div class="promotion-content-2 %s">' .
			'<div class="row">' .
			'<div class="col-md-3 col-sm-12 col-md-offset-4 text-center">' .
			'<div class="discount"><span class="discount-percent">%s</span><span class="discount-text">%s</span></div>' .
			'<a class="link" href="%s">%s<i class="arrow_carrot-right_alt2"></i></a>' .
			'</div>' .
			'<div class="col-md-4 col-sm-12 col-md-offset-1 promotion-counter">' .
			'<div class="promotion-title">%s</div>' .
			'<div class="promotion-date">%s</div>' .
			'</div>' .
			'</div>' .
			'</div>',
			esc_attr( $css_class ),
			esc_html( $atts['discount_percent'] ),
			esc_html( $atts['discount_text'] ),
			esc_url( $atts['button_link'] ),
			esc_html( $atts['button_text'] ),
			esc_html( $atts['title'] ),
			esc_html( $second )

		);
	}


	// Get template part

	/**
	 * Helper function to get coordinates for map
	 *
	 * @since 1.0.0
	 *
	 * @param string $address
	 * @param bool   $refresh
	 *
	 * @return array
	 */
	function get_coordinates( $address, $refresh = false ) {
		$address_hash = md5( $address );
		$coordinates  = get_transient( $address_hash );
		$results      = array( 'lat' => '', 'lng' => '' );

		if ( $refresh || $coordinates === false ) {
			$args     = array( 'address' => urlencode( $address ), 'sensor' => 'false' );
			$url      = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/geocode/json' );
			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				$results['error'] = esc_html__( 'Can not connect to Google Maps APIs', 'mrbara' );

				return $results;
			}

			$data = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $data ) ) {
				$results['error'] = esc_html__( 'Can not connect to Google Maps APIs', 'mrbara' );

				return $results;
			}

			if ( $response['response']['code'] == 200 ) {
				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {
					$coordinates = $data->results[0]->geometry->location;

					$results['lat']     = $coordinates->lat;
					$results['lng']     = $coordinates->lng;
					$results['address'] = (string) $data->results[0]->formatted_address;

					// cache coordinates for 3 months
					set_transient( $address_hash, $results, 3600 * 24 * 30 * 3 );
				} elseif ( $data->status === 'ZERO_RESULTS' ) {
					$results['error'] = esc_html__( 'No location found for the entered address.', 'mrbara' );
				} elseif ( $data->status === 'INVALID_REQUEST' ) {
					$results['error'] = esc_html__( 'Invalid request. Did you enter an address?', 'mrbara' );
				} else {
					$results['error'] = esc_html__( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'mrbara' );
				}
			} else {
				$results['error'] = esc_html__( 'Unable to contact Google API service.', 'mrbara' );
			}
		} else {
			$results = $coordinates; // return cached results
		}

		return $results;
	}

	/**
	 * Shortcode year
	 * Display current year
	 *
	 * @since 1.0
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function year( $atts, $content = null ) {
		return date( 'Y' );
	}

	/**
	 * Adjust brightness color
	 *
	 * @param  string $hex
	 * @param  int    $steps Steps should be between -255 and 255
	 *
	 * @return string
	 */
	function adjust_brightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max( -255, min( 255, $steps ) );

		// Format the hex color string
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// Adjust number of steps and keep it inside 0 to 255
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}


	/**
	 * Returns CSS for the color schemes.
	 *
	 *
	 * @param array $colors Color scheme colors.
	 *
	 * @return string Color scheme CSS.
	 */
	function mrbara_get_color_scheme_css( $colors ) {
		$lighten_5 = $this->adjust_brightness( $colors, 80 );

		return <<<CSS
		/* Color Scheme */

		/* Color */
		.product-carousel .footer-link .link:hover,
		.mrbara-products .grid-link .link:hover,
		.mrbara-newletter.newsletter-style2 .b-content .title span,
		.mrbara-newletter.newsletter-style6 .b-content:before,
		.mrbara-newletter.newsletter-style7 .b-content:before,
		.mrbara-newletter.newsletter-style8 .b-content .title,
		.mrbara-newletter.newsletter-style9 .b-content .title span,
		.mr-sliders .mr-slider .s-link:hover,
		.section-title .desc .mr-btn-buy:after,
		.section-title .desc .mr-btn-buy:hover,
		.section-title.style-1 .subtitle,
		.mrbara-icon-box.icon-box-style2 .i-icon,
		.mrbara-icon-box.icon-box-style5 .i-icon,
		.mrbara-icon-box.icon-box-style5:hover .i-icon,
		.mrbara-icon-box.icon-box-style4:hover .i-icon,
		.mrbara-icon-list.icon-style1:hover .icon,
		.mrbara-icon-list.icon-style2 .icon,
		.primary-color,
		.mrbara-products-ads .link:hover,
		.mrbara-posts.mr-post-style2 .single_blog_item:hover .post-footer .readmore,
		.mrbara-posts.mr-post-style3 .single_blog_item .blog-date,
		.mrbara-posts.mr-post-style4 .single_blog_item:hover .post-footer .readmore,
		.mrbara-products-tabs .view-more .link:hover,
		.mrbara-products-tabs.products-tabs-style3 .tabs-nav li a.active,.mrbara-products-tabs.products-tabs-style3 .tabs-nav li a:hover,
		.mrbara-products-tabs.products-tabs-style3 .view-more .link:before,
		.mrbara-products-tabs.products-tabs-style4 .view-more .link:before,
		.mrbara-link-container .mrbara-link,
		.mrbara-link-container .mrbara-link.color-dark:hover,
		.mrbara-link-container .mrbara-link.color-light:hover,
		.mrbara-link-container .mrbara-link.color-primary,
		.mrbara-testimonials.nav-plain .owl-buttons div:hover,
		.mrbara-banner .text,
		.mrbara-portfolio-slider .portfolio-content .bx-wrapper .bx-viewport .portfolio-list .portfolio-item .portfolio-cat:hover,
		.mrbara-portfolio-slider .portfolio-content .bx-wrapper .bx-viewport .portfolio-list .portfolio-item .portfolio-title:hover,
		.mrbara-portfolio-slider .portfolio-content .bx-wrapper .bx-viewport .portfolio-list .portfolio-item .view-more:hover,
		.mr-promotion-medium .p-desc .p-content .link-text:after,
		.mr-promotion-large .p-content .link-text:after,
		.mrbara-products-picks .footer-link .link:hover,
		.mrbara-products-picks.products-picks-4 .title,
		.products-carousel-2.carousel-style-1 .view-all .link:before,
		.products-carousel-2.carousel-style-3 .view-all .link:hover,
		.mr-info-banners .banner-item .banner-grid.link-hover:hover .link,
		.mr-info-banners .banner-item .banner-content .link:hover,
		.mr-info-banners .banner-item .sc-content .sc-desc ul.socials li a:hover,
		.mr-info-banners .banner-item .newsletter-content .nl-title span,
		.mrbara-cta .cta-content .cta-btn,
		.mr-sliders-banners .banner-item .banner-content .link:hover,
		.mrbara-products-tabs.products-tabs-style5 .tabs-nav li a.active,
		.mrbara-products-tabs.products-tabs-style5 .tabs-nav li a:hover,
		.top-promotion .promotion-content .promotion-content-2 .discount-percent {
			color: {$colors};
		}


		/* BackGround Color */

		.btn-primary,
		.mrbara-newletter.newsletter-style2 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style5 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style6 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style7 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style8 .b-form .mc4wp-form-fields input[type=submit],
		.mrbara-newletter.newsletter-style10 .b-form .letter-fied input[type=submit],
		.mr-sliders .mr-slider.slider-style-3.active .s-link,
		.feature-box:before,
		.mrbara-icon-list.icon-style3:hover .icon,
		.mrbara-icon-list.icon-style4 .icon,
		.mrbara-pricing .pricing-box .link,
		.btn,
		.mrbara-button-container.lighten .mrbara-button:hover,
		.mrbara-button-container.darken .mrbara-button:hover,
		.mrbara-button,
		.mrbara-link-container.link-style-1 .mrbara-link:before,
		.mrbara-testimonials .owl-controls .owl-buttons div:hover,
		.hot-deal-product .box-stock-product .product-link,
		.mrbara-products-picks.products-pagi-2 .owl-controls .owl-pagination .owl-page span:hover,
		.mrbara-products-picks.products-pagi-2 .owl-controls .owl-pagination .owl-page.active span,
		.mrbara-products-picks.products-picks-4 .owl-controls .owl-pagination .owl-page span:hover,
		.mrbara-products-picks.products-picks-4 .owl-controls .owl-pagination .owl-page.active span,
		.products-carousel-2.carousel-style-2 .view-all .link,
		.mrbara-info-box .mr-button:hover,
		.mrbara-banner-large .banner-content .view-more .link:hover,
		.mrbara-product-detail .product-content .link,
		.mrbara-product-list .products .product-list .btn-add-to-cart,
		.mrbara-product-list .products .product-list .added_to_cart.wc-forward,
		.top-promotion .promotion-content .promotion-content-2 .link {
			background-color: {$colors};
		}

		.mrbara-testimonials.nav-plain .owl-buttons div:hover {
			background-color: transparent;
		}

		.mrbara-button-container.lighten .mrbara-button,
		.mrbara-info-box .mr-button {
			background-color: {$this->adjust_brightness( $colors, 45 )};
		}

		.mrbara-button-container.darken .mrbara-button {
			background-color: {$this->adjust_brightness( $colors, -75 )};
		}

		.product-carousel .footer-link .link:hover,
		.mrbara-products .grid-link .link:hover,
		.mrbara-products-tabs .view-more .link:hover,
		.mrbara-products-picks .footer-link .link:hover,
		.products-carousel-2.carousel-style-3 .view-all .link:hover,
		.mrbara-cta .cta-content .cta-btn,
		.vc_wp_custommenu.style2 {
			border-color: {$colors};
		}

		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=email] {
			background-color: {$this->adjust_brightness( $colors, 20 )};
			color: {$lighten_5};
		}

		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=email]::-webkit-input-placeholder {
			color: {$lighten_5};
		}

		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=email]:-moz-placeholder {
			color: {$lighten_5};
		}
		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=email]::-moz-placeholder {
			color: {$lighten_5};
		}
		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=email]:-ms-input-placeholder {
			color: {$lighten_5};
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
		.mrbara-newletter.newsletter-style1 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style2 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style10 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style7 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style6 .b-form .letter-fied input[type=submit],
		.mrbara-heading.heading-style3 .title-behind,
		.mrbara-map .mr-map-info .mr-box .m-title,
		.vc_btn3,
		.btn-primary,
		.btn-secondary,
		.mrbara-products.mrbara-grid-cats .filters-dropdown ul.option-set li,
		.mrbara-newletter.newsletter-style5 .b-form .letter-fied input[type=submit],
		.mrbara-newletter.newsletter-style6 .b-content .title,
		.mr-sliders .mr-slider.slider-style-2 .s-title,
		.mr-sliders .mr-slider.slider-style-3 .s-title,
		.vc_toggle .vc_toggle_title h4,
		.mrbara-heading.heading-style3 .title-behind .title,
		.mrbara-posts .single_blog_item .blog-content .post-title,
		.mrbara-posts.mr-post-style4 .single_blog_item .post-title,
		.mrbara-testi-carousel-2 .testi-list .testi-item .testi-desc h2,
		.mrbara-pricing .pricing-title .pricing-info .p-time,
		.mrbara-pricing .pricing-box .link,
		.vc_progress_bar .vc_general.vc_single_bar .vc_label,
		.mrbara-section-layout-2 h2,
		.mrbara-cta-2 .subtitle,.mrbara-cta-2 .title,
		.mrbara-banner h3,
		.mrbara-portfolio-slider .portfolio-content .bx-wrapper .bx-viewport .portfolio-list .portfolio-item .view-more,
		.mrbara-instagram .section-title,
		.hot-deal-product .box-stock-product .sale-price-date .box .title,
		.mrbara-products-picks .title,
		.products-carousel-2.carousel-style-1 .filters-dropdown ul.option-set li,
		.products-carousel-2.carousel-style-2 .filters-dropdown ul.option-set li,
		.products-carousel-2.carousel-style-3 .filters-dropdown ul.option-set li,
		.mrbara-info-box .info-desc h5,
		.mrbara-info-box .info-desc .old-price,
		.mrbara-info-box .info-desc .new-price,
		.product-category-box.product-category-box-2 h2,
		.hot-deal-product .box-stock-product .sale-price-date .flip-wrapper .flip-clock-label {
			  font-family: {$body_typo}, Arial, sans-serif;
		}
CSS;
	}
}

