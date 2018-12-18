<?php
/**
 * DrFuri Core functions and definitions
 *
 * @package MrBara
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function mrbara_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'mrbara_content_width', 840 );

	// Make theme available for translation.
	load_theme_textdomain( 'mrbara', get_template_directory() . '/lang' );

	// Theme supports
	add_theme_support( 'woocommerce' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'gallery', 'video', 'quote', 'link' ) );
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);

	// Register theme nav menu
	register_nav_menus(
		array(
			'primary'      => esc_html__( 'Primary Menu', 'mrbara' ),
			'secondary'    => esc_html__( 'Secondary Menu', 'mrbara' ),
			'footer'       => esc_html__( 'Footer Menu', 'mrbara' ),
			'product_cats' => esc_html__( 'Product Categories', 'mrbara' ),
			'mobile'       => esc_html__( 'Mobile Menu', 'mrbara' ),
		)
	);

	$image_sizes = mrbara_theme_option( 'image_sizes' );

	// Register new image sizes
	if ( in_array( 'df-portfolio/df-portfolio.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		if( in_array( 'portfolio_masonry_2', $image_sizes ) ) {
			add_image_size( 'mrbara-portfolio-normal', 428, 428, true );
			add_image_size( 'mrbara-portfolio-full', 770, 770, true );
			add_image_size( 'mrbara-portfolio-wide', 770, 370, true );
		}

		if( in_array( 'portfolio_masonry_4', $image_sizes ) ) {
			add_image_size( 'mrbara-portfolio-long', 428, 732, true );
			add_image_size( 'mrbara-portfolio-small', 428, 274, true );
			add_image_size( 'mrbara-portfolio-normal', 428, 428, true );
		}

		if( in_array( 'portfolio_grid', $image_sizes ) ) {
			add_image_size( 'mrbara-portfolio-grid', 370, 275, true );
		}

		add_image_size( 'mrbara-portfolio-gallery', 1170, 692, true );
		add_image_size( 'mrbara-portfolio-image', 945, 851, true );
	}

	// Register new image sizes
	add_image_size( 'mrbara-blog-full', 1920, 800, true );

	if( in_array( 'blog_list', $image_sizes ) ) {
		add_image_size( 'mrbara-blog-thumb', 870, 450, true );
		add_image_size( 'mrbara-blog-large-thumb', 1170, 605, true );

	}

	if( in_array( 'blog_grid', $image_sizes ) ) {
		add_image_size( 'mrbara-blog-normal', 767, 555, true );
	}

	if( in_array( 'blog_masonry', $image_sizes ) ) {
		add_image_size( 'mrbara-blog-masonry-1', 767, 823, true );
		add_image_size( 'mrbara-blog-masonry-2', 767, 1202, true );
		add_image_size( 'mrbara-blog-masonry-3', 767, 570, true );
		add_image_size( 'mrbara-blog-masonry-5', 767, 949, true );
	}

	if( in_array( 'shop_cat_masonry', $image_sizes ) ) {
		add_image_size( 'mrbara-category-full', 866, 866, true );
		add_image_size( 'mrbara-category-thumbnail', 418, 418, true );
		add_image_size( 'mrbara-category-long', 418, 866, true );
		add_image_size( 'mrbara-category-wide', 866, 418, true );
	}

	// Initialize
	global $mrbara_woocommerce;
	$mrbara_woocommerce = new MrBara_WooCommerce;

	if ( is_admin() ) {
		new MrBara_Taxonomies;
		new Mrbara_Meta_Box_Product_Data;
	}
}

add_action( 'after_setup_theme', 'mrbara_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function mrbara_register_sidebar() {

	$sidebars = array(
		'blog-sidebar'      => esc_html__( 'Blog Sidebar', 'mrbara' ),
		'page-sidebar'      => esc_html__( 'Page Sidebar', 'mrbara' ),
		'shop-sidebar'      => esc_html__( 'Shop Sidebar', 'mrbara' ),
		'portfolio-sidebar' => esc_html__( 'Portfolio Sidebar', 'mrbara' ),
		'topbar-left'       => esc_html__( 'Topbar Left', 'mrbara' ),
		'topbar-right'      => esc_html__( 'Topbar Right', 'mrbara' ),
		'leftbar'           => esc_html__( 'Home Sidebar', 'mrbara' ),
		'shop-topbar'       => esc_html__( 'Shop Top Bar', 'mrbara' ),
		'product-sidebar'   => esc_html__( 'Single Product Sidebar', 'mrbara' ),
	);

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Register footer sidebars
	for ( $i = 1; $i < 7; $i ++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'mrbara' ) . " $i",
				'id'            => "footer-sidebar-$i",
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}

add_action( 'widgets_init', 'mrbara_register_sidebar' );

/**
 * Integrate Visual Composer as a part of theme
 */
function mrbara_integrate_vc() {
	vc_set_as_theme();
	remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}

add_action( 'vc_before_init', 'mrbara_integrate_vc' );

/**
 * Load theme
 */

// Widgets
require get_template_directory() . '/inc/widgets/widgets.php';

// Woocommerce hooks
require get_template_directory() . '/inc/frontend/woocommerce.php';


// Search Products
require get_template_directory() . '/inc/frontend/search.php';


// customizer hooks
require get_template_directory() . '/inc/customizer/customizer.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
	require get_template_directory() . '/inc/backend/plugins.php';
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/backend/product-meta-box-data.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
	require get_template_directory() . '/inc/backend/taxonomies.php';
	require get_template_directory() . '/inc/backend/importer.php';
} else {
	// Frontend functions and shortcodes
	require get_template_directory() . '/inc/functions/header.php';
	require get_template_directory() . '/inc/functions/breadcrumbs.php';
	require get_template_directory() . '/inc/functions/media.php';
	require get_template_directory() . '/inc/functions/nav.php';
	require get_template_directory() . '/inc/functions/entry.php';
	require get_template_directory() . '/inc/functions/comments.php';
	require get_template_directory() . '/inc/functions/options.php';
	require get_template_directory() . '/inc/functions/layout.php';
	require get_template_directory() . '/inc/functions/class-menu-walker.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';
	require get_template_directory() . '/inc/functions/footer.php';

	// Frontend hooks
	require get_template_directory() . '/inc/frontend/layout.php';
	require get_template_directory() . '/inc/frontend/header.php';
	require get_template_directory() . '/inc/frontend/nav.php';
	require get_template_directory() . '/inc/frontend/entry.php';
	require get_template_directory() . '/inc/frontend/footer.php';
}
