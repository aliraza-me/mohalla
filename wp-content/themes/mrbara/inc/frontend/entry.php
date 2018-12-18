<?php
/**
 * Hooks for template archive
 *
 * @package MrBara
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 1.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function mrbara_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'mrbara_setup_author' );

/**
 * Change more string at the end of the excerpt
 *
 * @since  1.0
 *
 * @param string $more
 *
 * @return string
 */
function mrbara_excerpt_more( $more ) {
	$more = '&hellip;';

	return $more;
}

add_filter( 'excerpt_more', 'mrbara_excerpt_more' );

/**
 * Change length of the excerpt
 *
 * @since  1.0
 *
 * @param string $length
 *
 * @return string
 */
function mrbara_excerpt_length( $length ) {
	$excerpt_length = intval( mrbara_theme_option( 'excerpt_length' ) );
	if ( $excerpt_length > 0 ) {
		return $excerpt_length;
	}

	return $length;
}

add_filter( 'excerpt_length', 'mrbara_excerpt_length' );

/**
 * The archive title
 *
 * @since  1.0
 *
 * @param  array $title
 *
 * @return mixed
 */
function mrbara_the_archive_title( $title ) {
	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results', 'mrbara' ) );
	} elseif ( is_404() ) {
		$title = sprintf( esc_html__( 'Page Not Found', 'mrbara' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'mrbara' );
	} elseif ( is_home() && ! is_front_page() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$title = get_the_title();
	} elseif ( is_single() ) {
		$title = get_the_title();
	} elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		$title = esc_html__( 'Portfolio', 'mrbara' );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	if ( is_front_page() && ( get_option( 'woocommerce_shop_page_id' ) == get_option( 'page_on_front' ) ) ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
	}


	return $title;
}

add_filter( 'get_the_archive_title', 'mrbara_the_archive_title' );

/**
 * Set order by get posts
 *
 * @since  1.0
 *
 * @param object $query
 *
 * @return string
 */
function mrbara_pre_get_posts( $query ) {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( $query->get( 'page_id' ) ) {
		if ( ( $query->get( 'page_id' ) == get_option( 'page_on_front' ) || is_front_page() )
			&& ( get_option( 'woocommerce_shop_page_id' ) != get_option( 'page_on_front' ) )
		) {
			return;
		}
	}

	$default = intval( mrbara_theme_option( 'products_per_page' ) );
	$default = $default ? $default : 12;
	$number  = isset( $_GET['showposts'] ) ? absint( $_GET['showposts'] ) : $default;

	if ( $query->is_search() ) {
		$query->set( 'orderby', 'post_type' );
		$query->set( 'order', 'desc' );

		if ( $_GET && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
			$query->set( 'posts_per_page', $number );
		}
	} elseif ( $query->is_archive() ) {
		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) {
			$query->set( 'posts_per_page', $number );
		} elseif ( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {

			$number = intval( mrbara_theme_option( 'portfolio_per_page' ) );

			$query->set( 'posts_per_page', $number );
		}
	}
}

add_action( 'pre_get_posts', 'mrbara_pre_get_posts' );


/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
function mrbara_single_entry_thumbnail() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( ! intval( mrbara_theme_option('single_post_format') )) {
		return;
	}

	echo '<div class="single-post-format">' . mrbara_entry_thumbnail( false, false, false ) . '</div>';
}

add_action( 'mrbara_after_header', 'mrbara_single_entry_thumbnail', 10 );

/**
 * Custom fields comment form
 *
 * @since  1.0
 *
 * @return  array  $fields
 */
function mrbara_comment_form_fields() {
	global $commenter, $aria_req;

	$fields = array(
		'author' => '<p class="comment-form-author col-md-4 col-sm-12">' .
			'<input id ="author" placeholder="' . esc_html__( 'Enter your name', 'mrbara' ) . ' " name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size    ="30"' . $aria_req . ' /></p>',

		'email'  => '<p class="comment-form-email col-md-4 col-sm-12">' .
			'<input id ="email" placeholder="' . esc_html__( 'Enter your email', 'mrbara' ) . '" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size    ="30"' . $aria_req . ' /></p>',

		'url'    => '<p class="comment-form-url col-md-4 col-sm-12">' .
			'<input id ="url" placeholder="' . esc_html__( 'Enter your website', 'mrbara' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size    ="30" /></p>'
	);

	return $fields;
}

add_filter( 'comment_form_default_fields', 'mrbara_comment_form_fields' );