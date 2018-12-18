<?php
/**
 * Custom functions for entry.
 *
 * @package MrBara
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'mrbara_posted_on' ) ) :
	function mrbara_posted_on() {
		$time_string   = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string   = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$archive_year  = get_the_time( 'Y' );
		$archive_month = get_the_time( 'm' );
		$archive_day   = get_the_time( 'd' );

		$posted_on = sprintf(
			'<span class="entry-author entry-meta"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$posted_on .= sprintf(
			'<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" class="entry-meta" rel="bookmark">' . $time_string . '</a>'
		);

		ob_start();
		the_category( ', ' );
		$posted_on .= '<span class="category-links entry-meta">' . ob_get_clean() . '</span>';

		echo '<div class="entry-metas">' . $posted_on . '</div>';

	}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'mrbara_entry_footer' ) ) :
	function mrbara_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . esc_html__( 'Category %1$s', 'mrbara' ) . '</span>', $categories_list );
			}
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tags %1$s', 'mrbara' ) . '</span>', $tags_list );
			}
		}
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'mrbara' ), esc_html__( '1 Comment', 'mrbara' ), esc_html__( '% Comments', 'mrbara' ) );
			echo '</span>';
		}
		edit_post_link( esc_html__( 'Edit', 'mrbara' ), '<span class="edit-link">', '</span>' );
	}
endif;

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
function mrbara_content_limit( $content, $num_words, $more = "&hellip;", $echo = true ) {

	// Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'mrbara_content_limit_allowed_tags', '<script>,<style>' ) );

	// Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// Truncate $content to $max_char
	$content = wp_trim_words( $content, $num_words );

	if ( $more ) {
		$output = sprintf(
			'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
			$content,
			get_permalink(),
			sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'mrbara' ), the_title_attribute( 'echo=0' ) ),
			esc_html( $more )
		);
	} else {
		$output = $content;
	}

	if ( ! $echo ) {
		return $output;
	}

	echo $output;
}


/**
 * Show entry thumbnail base on its format
 *
 * @since  1.0
 */
if ( ! function_exists( 'mrbara_entry_thumbnail' ) ) :
	function mrbara_entry_thumbnail( $size = 'thumbnail', $echo = true, $has_link = true ) {
		$html      = '';
		$css_class = 'format-' . get_post_format();

		$views = mrbara_theme_option( 'blog_view' );

		$layout = mrbara_get_layout();


		if ( is_single() ) {
			if ( $size == 'thumbnail' || ! $size ) {
				$size = 'mrbara-blog-full';
			}
		} else {
			if ( $views == 'list' ) {
				if ( 'full-content' == $layout ) {
					$size = 'mrbara-blog-large-thumb';
				} else {
					$size = 'mrbara-blog-thumb';
				}
			} elseif ( $views == 'grid' ) {
				if ( $size == 'thumbnail' || ! $size ) {
					$size = 'mrbara-blog-normal';
				}
			}
		}

		switch ( get_post_format() ) {
			case 'image':
				$image = mrbara_get_image(
					array(
						'size'     => $size,
						'format'   => 'src',
						'meta_key' => 'image',
						'echo'     => false,
					)
				);

				if ( ! $image ) {
					break;
				}

				$html = sprintf(
					'<a class="entry-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>',
					esc_url( get_permalink() ),
					the_title_attribute( 'echo=0' ),
					esc_url( $image )
				);

				if ( ! $has_link ) {
					$html = sprintf(
						'<img src="%s" alt="%s">',
						esc_url( $image ),
						the_title_attribute( 'echo=0' )
					);
				}
				break;
			case 'gallery':
				$images = mrbara_get_meta( 'images', "type=image&size=$size" );

				if ( empty( $images ) ) {
					break;
				}

				$gallery = array();
				foreach ( $images as $image ) {
					$gallery[] = '<li>' . '<img src="' . esc_url( $image['url'] ) . '" alt="' . the_title_attribute( 'echo=0' ) . '">' . '</li>';
				}
				$html .= '<div class="format-gallery-slider entry-image"><ul class="slides">' . implode( '', $gallery ) . '</ul></div>';
				break;
			case 'audio':

				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
				if ( ! empty( $thumb ) ) {
					$html .= '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';
					$css_class .= ' has-thumb';
				}

				$audio = get_post_meta( get_the_ID(), 'audio', true );
				if ( ! $audio ) {
					break;
				}

				// If URL: show oEmbed HTML or jPlayer
				if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
					// Try oEmbed first
					if ( $oembed = @wp_oembed_get( $audio ) ) {
						$html .= $oembed;
					} // Use audio shortcode
					else {
						$html .= '<div class="audio-player">' . wp_audio_shortcode( array( 'src' => $audio ) ) . '</div>';
					}
				} // If embed code: just display
				else {
					$html .= $audio;
				}
				break;

			case 'video':
				$video = get_post_meta( get_the_ID(), 'video', true );
				if ( ! $video ) {
					break;
				}

				$thumb = mrbara_get_image( 'echo=0&size=' . $size );
				if ( ! empty( $thumb ) ) {
					$html .= '<div class="entry-image">' . $thumb . '</div>';
					$css_class .= ' has-thumb';
				}

				$html .= '<a href="' . esc_url( $video ) . '" class="status video-play"><i class="ion-play"></i> </a>';


				break;

			case 'link':
				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
				if ( ! empty( $thumb ) ) {
					$html .= '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';
					$css_class .= ' has-thumb';
				}

				$link = mrbara_get_meta( 'url' );
				$text = mrbara_get_meta( 'url_text' );

				if ( ! $link ) {
					break;
				}

				$html .= sprintf( '<a href="%s" class="link-block">%s</a>', esc_url( $link ), $text ? $text : $link );

				break;
			case 'quote':

				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
				if ( ! empty( $thumb ) ) {
					$html .= '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';
					$css_class .= ' has-thumb';
				}

				$quote      = mrbara_get_meta( 'quote' );
				$author     = mrbara_get_meta( 'quote_author' );
				$author_url = mrbara_get_meta( 'author_url' );

				if ( ! $quote ) {
					break;
				}

				$html .= sprintf(
					'<blockquote>%s<cite>%s</cite></blockquote>',
					esc_html( $quote ),
					empty( $author_url ) ? $author : '<a href="' . esc_url( $author_url ) . '"> - ' . $author . '</a>'
				);

				break;

			default:
				$thumb = mrbara_get_image(
					array(
						'size'     => $size,
						'meta_key' => 'image',
						'echo'     => false,
					)
				);
				if ( empty( $thumb ) ) {
					break;
				}

				$html = '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';

				if ( ! $has_link ) {
					$html = $thumb;
				}
				break;
		}

		if ( $html = apply_filters( __FUNCTION__, $html, get_post_format() ) ) {
			$css_class = esc_attr( $css_class );

			if ( $echo ) {
				echo "<div class='entry-format $css_class'>$html</div>";

			} else {
				return "<div class='entry-format $css_class'>$html</div>";

			}

		}
	}
endif;

/**
 * Show portfolio thumbnail base on its format
 *
 * @since  1.0
 */
if ( ! function_exists( 'mrbara_portfolio_thumbnail' ) ) :
	function mrbara_portfolio_thumbnail( $size = 'thumbnail' ) {
		$image = mrbara_get_image(
			array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			)
		);

		if ( ! $image ) {
			return;
		}

		printf(
			'<a class="entry-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>',
			esc_url( get_permalink() ),
			the_title_attribute( 'echo=0' ),
			esc_url( $image )
		);

	}
endif;


/**
 * Share link socials
 *
 * @since  1.0
 */
if ( ! function_exists( 'mrbara_share_link_socials' ) ) :
	function mrbara_share_link_socials( $title, $link, $media ) {
		$socials = array();
		if ( is_singular( 'post' ) ) {
			$socials = mrbara_theme_option( 'post_social_icons' );
		} elseif ( is_singular( 'product' ) ) {
			$socials = mrbara_theme_option( 'product_social_icons' );
		} elseif ( is_singular( 'portfolio_project' ) ) {
			$socials = mrbara_theme_option( 'portfolio_social_icons' );
		}

		$socials_html = '';
		if ( $socials ) {
			if ( in_array( 'twitter', $socials ) ) {
				$socials_html = sprintf(
					'<a class="share-twitter mrbara-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="ion-social-twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'facebook', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-facebook mrbara-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="ion-social-facebook"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'google', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-google-plus mrbara-google-plus" href="https://plus.google.com/share?url=%s&text=%s" title="%s" target="_blank"><i class="ion-social-googleplus"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'pinterest', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-pinterest mrbara-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="ion-social-pinterest"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'linkedin', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-twitter mrbara-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="ion-social-linkedin"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'vkontakte', $socials ) ) {
				$socials_html .= sprintf(
					'<a class="share-vkontakte mrbara-vkontakte" href="http://vk.com/share.php?url=%s&title=%s&image=%s" title="%s" target="_blank"><i class="fa fa-vk"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $media ),
					urlencode( $title )
				);
			}

		}

		if ( $socials_html ) {
			printf( '<div class="social-links">%s</div>', $socials_html );
		}
		?>
		<?php
	}
endif;


/**
 * Get author role
 */
function mrbara_get_user_role( $id ) {
	$user = new WP_User( $id );

	return array_shift( $user->roles );
}

/**
 * show categories filter
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_taxs_filter' ) ) :
	function mrbara_taxs_filter( $taxonomy = 'category' ) {

		$nav_type = 'ajax';
		$id       = 'category-filter';
		if ( $taxonomy == 'category' ) {
			if ( ! mrbara_theme_option( 'show_cat_filter' ) ) {
				return '';
			}

			$nav_type = mrbara_theme_option( 'blog_nav_type' );
		} elseif ( $taxonomy == 'portfolio_category' ) {
			if ( ! mrbara_theme_option( 'portfolio_cat_filter' ) ) {
				return '';
			}

			$nav_type = mrbara_theme_option( 'portfolio_nav_type' );
			$id       = 'portfolio-category-filters';
		} elseif ( $taxonomy == 'product_cat' ) {
			$nav_type = mrbara_theme_option( 'navigation_type' );
			$id       = 'filters-product-cat';
		}

		$filters = '';
		$output  = array();
		$number  = apply_filters( sprintf( 'mrbara_%s_number', $taxonomy ), 4 );

		if ( $nav_type == 'links' ) {
			$cats = array();
			global $wp_query;

			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$post_categories = wp_get_post_terms( get_the_ID(), $taxonomy );


				foreach ( $post_categories as $cat ) {
					if ( empty( $cats[$cat->term_id] ) ) {
						$cats[$cat->term_id] = array( 'name' => $cat->name, 'slug' => $cat->slug, );
					}
				}
			}

			$i = 1;
			foreach ( $cats as $category ) {
				if ( $i > $number ) {
					break;
				}
				$i ++;
				$filters .= sprintf( '<li><a href="#filter" data-option-value=".%s-%s">%s</a></li>', esc_attr( $taxonomy ), esc_attr( $category['slug'] ), esc_html( $category['name'] ) );
			}
		} else {
			$term_id = 0;

			if ( is_tax( $taxonomy ) ) {

				$queried_object = get_queried_object();
				if ( $queried_object ) {
					$term_id = $queried_object->term_id;
				}
			}

			$args       = array(
				'parent'  => $term_id,
				'number'  => $number,
				'orderby' => 'count',
				'order'   => 'desc'
			);
			$categories = get_terms( $taxonomy, $args );


			if ( $categories ) {
				foreach ( $categories as $cat ) {
					$filters .= sprintf( '<li><a href="#filter" data-option-value=".%s-%s">%s</a></li>', esc_attr( $taxonomy ), esc_attr( $cat->slug ), esc_html( $cat->name ) );
				}
			}
		}

		if ( $filters ) {
			$output[] = sprintf(
				'<ul class="option-set" data-option-key="filter">
				<li><a href="#filter" class="selected" data-option-value="*">%s</a></li>
				 %s
			</ul>',
				esc_html__( 'All', 'mrbara' ),
				$filters
			);
		}


		return '<div id="' . esc_attr( $id ) . '" class="filters-dropdown">' . implode( "\n", $output ) . '</div>';

	}
endif;

/**
 * Check background for page header
 *
 * @return bool
 */
if ( ! function_exists( 'mrbara_page_header_bg' ) ) :
	function mrbara_page_header_bg() {

		if ( mrbara_is_homepage() ) {
			return true;
		}


		if ( mrbara_is_account_transparent() ) {
			return true;
		}

		// Title Area
		if ( mrbara_is_catalog() ) {
			$banner_shop = mrbara_theme_option( 'page_header_bg_shop' );


			if ( ! mrbara_theme_option( 'page_header_shop' ) ) {
				return false;
			}

			if ( ! in_array( mrbara_theme_option( 'page_header_layout_shop' ), array( '2', '5' ) ) ) {
				return false;
			}


			if ( is_product_category() ) {
				global $wp_query;
				$term_id = $wp_query->get_queried_object_id();

				if ( ! $term_id ) {
					return false;
				}
				$thumbnail_id = absint( get_term_meta( $term_id, 'page_header_id', true ) );

				if ( $thumbnail_id ) {
					$thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );

					return $thumbnail[0];
				}

			} else {
				$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
				if ( get_post_meta( $post_id, 'hide_page_header', true ) ) {
					return false;
				}

				$banner_page = get_post_meta( $post_id, 'page_header_bg', true );
				if ( ! $banner_shop && ! $banner_page ) {
					return false;
				}

				if ( $banner_page ) {
					$banner       = wp_get_attachment_image_src( $banner_page, 'full' );
					$banner_image = $banner ? $banner[0] : '';

					return $banner_image;
				}

			}

			return $banner_shop;

		} elseif ( ( function_exists( 'is_product' ) && is_product() ) ) {
			if ( intval( get_post_meta( get_the_ID(), 'hide_product_header', true ) ) ) {
				return false;
			}

			if ( intval( get_post_meta( get_the_ID(), 'custom_page_header_layout', true ) ) ) {

				if ( get_post_meta( get_the_ID(), 'page_header_layout', true ) != '3' ) {
					return false;
				}

				$product_header_bg = get_post_meta( get_the_ID(), 'page_header_bg', true );
				if ( ! $product_header_bg ) {
					return false;
				}

				if ( $product_header_bg ) {
					$banner       = wp_get_attachment_image_src( $product_header_bg, 'full' );
					$banner_image = $banner ? $banner[0] : '';

					return $banner_image;
				}
			}


			if ( ! in_array( mrbara_theme_option( 'page_header_layout_product' ), array( '3' ) ) ) {
				return false;
			}

			return mrbara_theme_option( 'page_header_bg_product' );
		} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			if ( ! intval( mrbara_theme_option( 'page_header_portfolio' ) ) ) {
				return false;
			}
		} elseif ( is_page() ) {

			if ( ! mrbara_theme_option( 'page_header_pages' ) ) {
				return false;
			}

			if ( mrbara_get_meta( 'hide_page_header' ) ) {
				return false;
			}


			$banner_page = mrbara_get_meta( 'page_header_bg' );

			if ( ! $banner_page ) {
				return false;
			}

			if ( $banner_page ) {
				$banner       = wp_get_attachment_image_src( $banner_page, 'full' );
				$banner_image = $banner ? $banner[0] : '';

				return $banner_image;
			}

		} else {
			if ( is_404() ) {
				if ( mrbara_theme_option( 'bg_404' ) ) {
					return true;
				} else {
					return false;
				}
			}

			if ( is_singular( 'post' ) ) {
				return false;
			}

			if ( ! intval( mrbara_theme_option( 'page_header' ) ) ) {
				return false;
			}

			if ( is_home() && ! is_front_page() ) {

				$post_id = get_queried_object_id();
				if ( get_post_meta( $post_id, 'hide_page_header', true ) ) {
					return false;
				}

				$banner_page = get_post_meta( $post_id, 'page_header_bg', true );
				if ( ! $banner_page ) {
					return false;
				}

				if ( $banner_page ) {
					$banner       = wp_get_attachment_image_src( $banner_page, 'full' );
					$banner_image = $banner ? $banner[0] : '';

					return $banner_image;
				}

			}

		}
	}
endif;


/**
 * Check if account page is transparent
 *
 * @return bool
 */
if ( ! function_exists( 'mrbara_is_account_transparent' ) ) :
	function mrbara_is_account_transparent() {

		if ( function_exists( 'is_account_page' ) && is_account_page() && mrbara_theme_option( 'login_page_layout' ) ) {
			return true;
		}

		return false;
	}
endif;


/**
 * Check is homepage
 *
 * @return bool
 */
if ( ! function_exists( 'mrbara_is_homepage' ) ) :
	function mrbara_is_homepage() {

		if ( is_page_template( 'template-homepage.php' ) ||
			is_page_template( 'template-homepage-transparent.php' ) ||
			is_page_template( 'template-home-split.php' ) ||
			is_page_template( 'template-home-boxed-content.php' ) ||
			is_page_template( 'template-home-width-1620.php' ) ||
			is_page_template( 'template-home-cosmetic.php' )
		) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'mrbara_is_catalog' ) ) :
	function mrbara_is_catalog() {

		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() || is_tax('product') ) ) {
			return true;
		}

		return false;
	}

endif;

/**
 * Retrieves related product terms
 *
 * @param string $term
 *
 * @return array
 */
function mrbara_get_related_terms( $term, $post_id = null ) {
	$post_id     = $post_id ? $post_id : get_the_ID();
	$terms_array = array( 0 );

	$terms = wp_get_post_terms( $post_id, $term );
	foreach ( $terms as $term ) {
		$terms_array[] = $term->term_id;
	}

	return array_map( 'absint', $terms_array );
}

/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_get_breadcrumbs' ) ) :
	function mrbara_get_breadcrumbs() {
		ob_start();
		?>
		<nav class="breadcrumbs">
			<?php
			mrbara_breadcrumbs(
				array(
					'before'   => '',
					'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
				)
			);
			?>
		</nav>
		<?php
		echo ob_get_clean();
	}

endif;


/**
 * Get shop description
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_get_shop_desc' ) ) :
	function mrbara_get_shop_desc() {
		$desc = '';
		if ( mrbara_is_catalog() ) {
			$desc = wp_kses( mrbara_theme_option( 'shop_desc' ), wp_kses_allowed_html( 'post' ) );

			if ( is_product_category() ) {
				global $wp_query;
				$term_id = $wp_query->get_queried_object_id();

				if ( $term_id && function_exists( 'term_description' ) ) {
					$desc = term_description( $term_id, 'product_cat' );
				}
			}
		}

		echo sprintf( '<div class="desc">%s</div>', $desc );
	}
endif;

/**
 * Get portfolio description
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'mrbara_get_portfolio_desc' ) ) :
	function mrbara_get_portfolio_desc() {
		$desc = wp_kses( mrbara_theme_option( 'portfolio_desc' ), wp_kses_allowed_html( 'post' ) );

		$desc = str_replace( "\n", "<br>", $desc );

		if ( is_tax( 'portfolio_category' ) ) {
			global $wp_query;
			$term_id = $wp_query->get_queried_object_id();

			if ( $term_id && function_exists( 'term_description' ) ) {
				$desc = term_description( $term_id, 'portfolio_category' );
			}
		}

		if ( $desc ) {
			printf( '<div class="desc">%s</div>', $desc );
		}
	}
endif;