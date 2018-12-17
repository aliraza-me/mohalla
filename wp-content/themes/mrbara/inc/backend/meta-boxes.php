<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


/**
 * Enqueue script for handling actions with meta boxes
 *
 * @since 1.0
 *
 * @param string $hook
 */
function mrbara_meta_box_scripts( $hook ) {
	// Detect to load un-minify scripts when WP_DEBUG is enable
	wp_enqueue_style( 'mrbara-admin', get_template_directory_uri() . '/css/backend/admin.css', array(), '20160802' );

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'mrbara-meta-boxes', get_template_directory_uri() . "/js/backend/meta-boxes.js", array( 'jquery' ), '20160802', true );
	}

	if ( in_array( $hook, array( 'edit-tags.php', 'term.php' ) ) ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'mrbara-taxomnomies', get_template_directory_uri() . "/js/backend/taxonomies.js", array( 'jquery' ), '20160802', true );
	}
}

add_action( 'admin_enqueue_scripts', 'mrbara_meta_box_scripts' );

/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function mrbara_register_meta_boxes( $meta_boxes ) {
	// Post format's meta box
	$meta_boxes[] = array(
		'id'       => 'post-format-settings',
		'title'    => esc_html__( 'Format Details', 'mrbara' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'             => esc_html__( 'Image', 'mrbara' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'class'            => 'image',
				'max_file_uploads' => 1,
			),
			array(
				'name'  => esc_html__( 'Gallery', 'mrbara' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Audio', 'mrbara' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => esc_html__( 'Video', 'mrbara' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
				'desc'  => esc_html__( 'Allow file types: MP4, WebM, Ogg, Youtube and Vimeo', 'mrbara' ),
			),
			array(
				'name'  => esc_html__( 'Link', 'mrbara' ),
				'id'    => 'url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Text', 'mrbara' ),
				'id'    => 'url_text',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Quote', 'mrbara' ),
				'id'    => 'quote',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author', 'mrbara' ),
				'id'    => 'quote_author',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author URL', 'mrbara' ),
				'id'    => 'author_url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Status', 'mrbara' ),
				'id'    => 'status',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'status',
			),
		),
	);

	$css_class = '';
	if ( ! empty( $_GET ) && isset( $_GET['post'] ) ) {
		if ( intval( get_option( 'woocommerce_shop_page_id' ) ) == intval( $_GET['post'] ) ) {
			$css_class = 'hide-custom-page-header';
		} elseif ( intval( get_option( 'page_for_posts' ) ) == intval( $_GET['post'] ) ) {
			$css_class = 'hide-custom-page-header';
		}
	}

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'mrbara' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Page Header', 'mrbara' ),
				'id'    => 'heading_page_header',
				'type'  => 'heading',
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Page Header', 'mrbara' ),
				'id'    => 'hide_page_header',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'mrbara' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'             => esc_html__( 'Custom Page Header Background', 'mrbara' ),
				'id'               => 'page_header_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class'            => "bg-title-area hide-homepage $css_class"
			),
			array(
				'name'  => esc_html__( 'Header Transparent', 'mrbara' ),
				'id'    => 'header_transparent_page',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => "bg-title-area hide-homepage $css_class",
			),
			array(
				'name'             => esc_html__( 'Custom Logo', 'mrbara' ),
				'id'               => 'custom_page_logo',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class'            => "bg-title-area hide-homepage $css_class",
			),
			array(
				'name'  => esc_html__( 'Custom Page Header Layout', 'mrbara' ),
				'id'    => 'custom_page_header_layout',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => "hide-homepage $css_class",
			),
			array(
				'name'    => esc_html__( 'Layout', 'mrbara' ),
				'id'      => 'page_header_layout',
				'type'    => 'image_select',
				'class'   => "page-header-layout hide-homepage $css_class",
				'options' => array(
					'7'  => get_template_directory_uri() . '/img/page-header/pheader-7.jpg',
					'8'  => get_template_directory_uri() . '/img/page-header/pheader-8.jpg',
					'9'  => get_template_directory_uri() . '/img/page-header/pheader-9.jpg',
					'10' => get_template_directory_uri() . '/img/page-header/pheader-10.jpg',
					'11' => get_template_directory_uri() . '/img/page-header/pheader-11.jpg',
				),
			),
			array(
				'name'  => esc_html__( 'Page Layout', 'mrbara' ),
				'id'    => 'heading_layout',
				'type'  => 'heading',
				'class' => "hide-fullwidth $css_class",
			),
			array(
				'name'  => esc_html__( 'Custom Layout', 'mrbara' ),
				'id'    => 'custom_layout',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => "hide-fullwidth $css_class",
			),
			array(
				'name'    => esc_html__( 'Layout', 'mrbara' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => "custom-layout hide-fullwidth $css_class",
				'options' => array(
					'full-content'    => get_template_directory_uri() . '/img/sidebars/empty.png',
					'sidebar-content' => get_template_directory_uri() . '/img/sidebars/single-left.png',
					'content-sidebar' => get_template_directory_uri() . '/img/sidebars/single-right.png',
				),
			),
		),
	);

	$meta_boxes[] = array(
		'id'       => 'product-display-settings',
		'title'    => esc_html__( 'Display Settings', 'mrbara' ),
		'pages'    => array( 'product' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Page Header', 'mrbara' ),
				'id'    => 'heading_page_header',
				'type'  => 'heading',
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Page Header', 'mrbara' ),
				'id'    => 'hide_page_header',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Custom Product Header Layout', 'mrbara' ),
				'id'    => 'custom_page_header_layout',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => "hide-homepage",
			),
			array(
				'name'    => esc_html__( 'Layout', 'mrbara' ),
				'id'      => 'page_header_layout',
				'type'    => 'image_select',
				'class'   => "page-header-layout",
				'options' => array(
					'1' => get_template_directory_uri() . '/img/page-header/product-pheader01.jpg',
					'2' => get_template_directory_uri() . '/img/page-header/product-pheader02.jpg',
					'3' => get_template_directory_uri() . '/img/page-header/product-pheader03.jpg',
					'4' => get_template_directory_uri() . '/img/page-header/product-pheader04.jpg',
				),
			),
			array(
				'name'             => esc_html__( 'Custom Product Header Background', 'mrbara' ),
				'id'               => 'page_header_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class'            => 'bg-page-header',
			),
			array(
				'name'             => esc_html__( 'Custom Logo', 'mrbara' ),
				'id'               => 'page_header_logo',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class'            => 'bg-page-header',
			),
		),
	);

	// Testimonial
	$meta_boxes[] = array(
		'id'       => 'testimonial-details',
		'title'    => esc_html__( 'Testimonial Details', 'mrbara' ),
		'pages'    => array( 'testimonial' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Email', 'mrbara' ),
				'desc' => esc_html__( 'Enter email of this customer to get avatar while no thumbnail is set.', 'mrbara' ),
				'id'   => 'email',
				'type' => 'text',
			),
			array(
				'name' => esc_html__( 'Byline', 'mrbara' ),
				'desc' => esc_html__( 'Enter a byline for the customer giving this testimonial', 'mrbara' ),
				'id'   => 'byline',
				'type' => 'text',
			),
			array(
				'name'       => esc_html__( 'Rating', 'mrbara' ),
				'desc'       => esc_html__( 'Set the rating score of this customer.', 'mrbara' ),
				'id'         => 'rating',
				'type'       => 'slider',
				'js_options' => array(
					'min' => 0,
					'max' => 10,
				),
			),
		),
	);

	$socials = apply_filters(
		'mrbara_coming_soon_socials', array(
			'facebook'   => esc_html__( 'Facebook', 'mrbara' ),
			'twitter'    => esc_html__( 'Twitter', 'mrbara' ),
			'googleplus' => esc_html__( 'Google Plus', 'mrbara' ),
			'linkedin'   => esc_html__( 'LinkedIn', 'mrbara' ),
			'pinterest'  => esc_html__( 'Pinterest', 'mrbara' ),
			'dribbble'   => esc_html__( 'Dribbble', 'mrbara' ),
			'youtube'    => esc_html__( 'Youtube', 'mrbara' ),
			'vimeo'      => esc_html__( 'Vimeo', 'mrbara' ),
		)
	);

	$socials_list   = array();
	$socials_list[] = array(
		'name'             => esc_html__( 'Upload Logo Image', 'mrbara' ),
		'id'               => 'logo_comingsoon',
		'type'             => 'image_advanced',
		'max_file_uploads' => 1,
		'class'            => 'show-comingson',
	);
	$socials_list[] = array(
		'id'    => 'heading_address_comingsoon',
		'type'  => 'heading',
		'class' => 'show-comingson',
	);
	$socials_list[] = array(
		'name' => esc_html__( 'Location Comming Soon', 'mrbara' ),
		'id'   => 'location_comingsoon',
		'type' => 'textarea',
		'std'  => false,
	);
	$socials_list[] = array(
		'name' => esc_html__( 'Phone Comming Soon', 'mrbara' ),
		'id'   => 'phone_comingsoon',
		'type' => 'textarea',
		'std'  => false,
	);

	$socials_list[] = array(
		'name'  => esc_html__( 'Socials URL', 'mrbara' ),
		'id'    => 'heading_address_socials',
		'type'  => 'heading',
		'class' => 'show-comingson',
	);

	foreach ( $socials as $key => $value ) {
		$socials_list[] = array(
			'name' => $value,
			'id'   => 'socials_' . $key,
			'type' => 'text',
			'std'  => false,
		);
	}

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-comingsoon',
		'title'    => esc_html__( 'ComingSoon Settings', 'mrbara' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => $socials_list,
	);

	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'mrbara' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'mrbara' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name' => esc_html__( 'Layout', 'mrbara' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'mrbara' ),
				'id'   => 'custom_layout',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Layout', 'mrbara' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => 'custom-layout',
				'options' => array(
					'full-content'    => get_template_directory_uri() . '/img/sidebars/empty.png',
					'sidebar-content' => get_template_directory_uri() . '/img/sidebars/single-left.png',
					'content-sidebar' => get_template_directory_uri() . '/img/sidebars/single-right.png',
				),
			),
		),
	);

	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'mrbara' ),
		'pages'    => array( 'portfolio_project' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'mrbara' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
		),
	);

	$meta_boxes[] = array(
		'id'       => 'product-videos',
		'title'    => esc_html__( 'Product Video', 'mrbara' ),
		'pages'    => array( 'product' ),
		'context'  => 'side',
		'priority' => 'low',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Video URL', 'mrbara' ),
				'id'   => 'video_url',
				'type' => 'oembed',
				'std'  => false,
				'desc' => esc_html__( 'Enter URL of Youtube or Video.', 'mrbara' ),
			),
			array(
				'id'   => 'video_urls_custom_html',
				'type' => 'custom_html',
				'std'  => '<div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px"></div>',
			),
			array(
				'name'             => esc_html__( 'Video Thumbnail', 'mrbara' ),
				'id'               => 'video_thumbnail',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
				'desc'             => esc_html__( 'Add video thumbnail', 'mrbara' )
			),
			array(
				'id'   => 'video_urls_custom_html2',
				'type' => 'custom_html',
				'std'  => '<div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px"></div>',
			),
			array(
				'name' => esc_html__( 'Video Position', 'mrbara' ),
				'id'   => 'video_position',
				'type' => 'number',
				'desc' => esc_html__( 'Enter number of video position in product gallery.', 'mrbara' ),
				'std'  => 2,
				'min'  => 2,
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'mrbara_register_meta_boxes' );