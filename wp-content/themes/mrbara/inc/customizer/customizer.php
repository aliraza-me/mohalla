<?php
/**
 * MrBara theme customizer
 *
 * @package MrBara
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MrBara_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		$default = isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;

		return get_theme_mod( $name, $default );
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function mrbara_theme_option( $name ) {
	global $mrbara_customize;

	if ( empty( $mrbara_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $mrbara_customize->get_theme(), $name );
	} else {
		$value = $mrbara_customize->get_option( $name );
	}

	return apply_filters( 'mrbara_theme_option', $value, $name );
}

/**
 * The custom control class
 */

function mrbara_kirki_enqueue_scripts() {
	wp_enqueue_style( 'mrbara-kirki-style', get_template_directory_uri() . '/css/backend/custom-kirki.css', array(), '20170106' );
}

add_action( 'customize_controls_print_styles', 'mrbara_kirki_enqueue_scripts', 30 );


/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function mrbara_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'mrbara_customize_modify' );


$attributes = array();
if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
	$attributes_tax = wc_get_attribute_taxonomies();
	if ( $attributes_tax ) {
		$attributes['none'] = esc_html__( 'None', 'mrbara' );

		foreach ( $attributes_tax as $attribute ) {
			$attributes[ $attribute->attribute_name ] = $attribute->attribute_label;
		}

	}
}

/**
 * Customizer configuration
 */
$mrbara_customize = new MrBara_Customize(
	array(
		'theme' => 'mrbara',

		'panels' => array(
			'general'     => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'mrbara' ),
			),
			'typography'  => array(
				'priority' => 10,
				'title'    => esc_html__( 'Typography', 'mrbara' ),
			),
			// Styling
			'styling'     => array(
				'title'    => esc_html__( 'Styling', 'mrbara' ),
				'priority' => 15,
			),
			//Layout
			'layout'      => array(
				'title'    => esc_html__( ' Layout', 'mrbara' ),
				'priority' => 15,
			),
			'header'      => array(
				'priority' => 20,
				'title'    => esc_html__( 'Header', 'mrbara' ),
			),
			'page_header' => array(
				'priority' => 30,
				'title'    => esc_html__( 'Page Header', 'mrbara' ),
			),
			'woocommerce' => array(
				'priority' => 40,
				'title'    => esc_html__( 'Woocommerce', 'mrbara' ),
			),
		),

		'sections' => array(
			'body_typo'             => array(
				'title'       => esc_html__( 'Body', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'heading_typo'          => array(
				'title'       => esc_html__( 'Heading', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'header_typo'           => array(
				'title'       => esc_html__( 'Header', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'page_header_typo'      => array(
				'title'       => esc_html__( 'Page Header', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'widget_typo'           => array(
				'title'       => esc_html__( 'Widget', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'footer_typo'           => array(
				'title'       => esc_html__( 'Footer', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'newsletter'            => array(
				'title'       => esc_html__( 'NewsLetter', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
			),
			'404_page'              => array(
				'title'       => esc_html__( '404 Page', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
			),
			'image_sizes'           => array(
				'title'       => esc_html__( 'Image Sizes', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
			),
			// Styling
			'styling_general'       => array(
				'title'       => esc_html__( 'General', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'color_scheme'          => array(
				'title'       => esc_html__( 'Color Scheme', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'custom_css'            => array(
				'title'       => esc_html__( 'Custom CSS', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'custom_js'             => array(
				'title'       => esc_html__( 'Custom JavaScript', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'responsiveness'        => array(
				'title'       => esc_html__( 'Responsiveness', 'mrbara' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			//Layout
			'site_layout'           => array(
				'title'       => esc_html__( 'Site Layout', 'mrbara' ),
				'description' => '',
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
				'panel'       => 'layout',
			),
			'boxed_layout'          => array(
				'title'       => esc_html__( 'Boxed Layout', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'layout',
			),
			// Header
			'promotion'             => array(
				'title'       => esc_html__( 'Promotion', 'mrbara' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'logo'                  => array(
				'title'       => esc_html__( 'Logo', 'mrbara' ),
				'description' => '',
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'header'                => array(
				'title'       => esc_html__( 'Header Layout', 'mrbara' ),
				'description' => '',
				'priority'    => 30,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'custom_header_text'    => array(
				'title'       => esc_html__( 'Custom Header Text', 'mrbara' ),
				'description' => '',
				'priority'    => 30,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			// Page Header
			'page_header_site'      => array(
				'title'       => esc_html__( 'On Whole Site', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page_header',
			),
			'page_header_pages'     => array(
				'title'       => esc_html__( 'On Pages', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page_header',
			),
			'page_header_shop'      => array(
				'title'       => esc_html__( 'On Shop', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page_header',
			),
			'page_header_product'   => array(
				'title'       => esc_html__( 'On Product Page', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page_header',
			),
			'page_header_portfolio' => array(
				'title'       => esc_html__( 'On Portfolio', 'mrbara' ),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page_header',
			),
			// Content
			'content'               => array(
				'title'       => esc_html__( 'Blog', 'mrbara' ),
				'description' => '',
				'priority'    => 30,
				'capability'  => 'edit_theme_options',
			),
			// Shop
			'catalog'               => array(
				'title'       => esc_html__( 'Catalog', 'mrbara' ),
				'description' => '',
				'priority'    => 40,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_toolbar'          => array(
				'title'       => esc_html__( 'Catalog ToolBar', 'mrbara' ),
				'description' => '',
				'priority'    => 45,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_widget'           => array(
				'title'       => esc_html__( 'Catalog Widgets', 'mrbara' ),
				'description' => '',
				'priority'    => 50,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_categories'       => array(
				'title'       => esc_html__( 'Shop Categories', 'mrbara' ),
				'description' => '',
				'priority'    => 60,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'product_grid'          => array(
				'title'       => esc_html__( 'Product Grid', 'mrbara' ),
				'description' => '',
				'priority'    => 70,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'shop_badge'            => array(
				'title'       => esc_html__( 'Badges', 'mrbara' ),
				'description' => '',
				'priority'    => 80,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'single_product'        => array(
				'title'       => esc_html__( 'Single Product', 'mrbara' ),
				'description' => '',
				'priority'    => 90,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'cart_page'             => array(
				'title'       => esc_html__( 'Cart', 'mrbara' ),
				'description' => '',
				'priority'    => 90,
				'panel'       => 'woocommerce',
				'capability'  => 'edit_theme_options',
			),
			'account_page'          => array(
				'title'       => esc_html__( 'Account Page', 'mrbara' ),
				'description' => '',
				'priority'    => 100,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'account_popup'         => array(
				'title'       => esc_html__( 'Account Popup', 'mrbara' ),
				'description' => '',
				'priority'    => 110,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'portfolio'             => array(
				'title'       => esc_html__( 'Portfolio', 'mrbara' ),
				'description' => '',
				'priority'    => 50,
				'capability'  => 'edit_theme_options',
			),
			'footer'                => array(
				'title'       => esc_html__( 'Footer', 'mrbara' ),
				'description' => '',
				'priority'    => 60,
				'capability'  => 'edit_theme_options',
			),
		),

		'fields' => array(

			// Back To Top
			'back_to_top'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Back To Top', 'mrbara' ),
				'default'     => 0,
				'section'     => 'styling_general',
				'priority'    => 10,
				'description' => esc_html__( 'Check this to show back to top.', 'mrbara' ),
			),
			// Preloader
			'preloader'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Preloader', 'mrbara' ),
				'default'     => 0,
				'section'     => 'styling_general',
				'priority'    => 10,
				'description' => esc_html__( 'Display a preloader when page is loading.', 'mrbara' ),
			),
			'preloader_color'                  => array(
				'type'            => 'multicolor',
				'label'           => esc_html__( 'Preloader Color', 'mrbara' ),
				'section'         => 'styling_general',
				'priority'        => 10,
				'choices'         => array(
					'color1' => esc_attr__( 'Color 1', 'mrbara' ),
					'color2' => esc_attr__( 'Color 2', 'mrbara' ),
					'color3' => esc_attr__( 'Color 3', 'mrbara' ),
					'color4' => esc_attr__( 'Color 4', 'mrbara' ),
				),
				'default'         => array(
					'color1' => '#990000',
					'color2' => '#305e7b',
					'color3' => '#cc0000',
					'color4' => '#ca7f09',
				),
				'active_callback' => array(
					array(
						'setting'  => 'preloader',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			// Product page
			'responsiveness'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Responsiveness', 'mrbara' ),
				'default'     => 1,
				'section'     => 'responsiveness',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to enable responsive.', 'mrbara' ),
			),
			'topbar_mobile'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Top Bar on Mobile', 'mrbara' ),
				'default'     => 1,
				'section'     => 'responsiveness',
				'priority'    => 30,
				'description' => esc_html__( 'Check this option to enable the top bar on mobile.', 'mrbara' ),
			),
			'promotion_mobile'                 => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Promotion on Mobile', 'mrbara' ),
				'default'     => 1,
				'section'     => 'responsiveness',
				'priority'    => 30,
				'description' => esc_html__( 'Check this option to enable the promotion on mobile.', 'mrbara' ),
			),
			'product_columns_mobile'           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Page Columns on Mobile', 'mrbara' ),
				'section'     => 'responsiveness',
				'default'     => 1,
				'priority'    => 30,
				'description' => esc_html__( 'Select columns for product page on mobile. This option is used for the product page layout has sidebar', 'mrbara' ),
				'choices'     => array(
					'1' => esc_html__( '1 Column', 'mrbara' ),
					'2' => esc_html__( '2 Columns', 'mrbara' ),
				),
			),
			'product_grid_columns_mobile'      => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Grid Columns on Mobile', 'mrbara' ),
				'section'     => 'responsiveness',
				'default'     => 1,
				'priority'    => 30,
				'description' => esc_html__( 'Select columns for product grid on mobile.', 'mrbara' ),
				'choices'     => array(
					'1' => esc_html__( '1 Column', 'mrbara' ),
					'2' => esc_html__( '2 Columns', 'mrbara' ),
				),
			),
			// Color Scheme
			'color_scheme'                     => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Base Color Scheme', 'mrbara' ),
				'default'  => '0',
				'section'  => 'color_scheme',
				'priority' => 10,
				'choices'  => array(
					'0'       => get_template_directory_uri() . '/img/colors/default.jpg',
					'#305e7b' => get_template_directory_uri() . '/img/colors/blue.jpg',
					'#8c3718' => get_template_directory_uri() . '/img/colors/sienna.jpg',
					'#e8ae5c' => get_template_directory_uri() . '/img/colors/lightorange.jpg',
					'#9b6501' => get_template_directory_uri() . '/img/colors/goldenrod.jpg',
					'#ff7a5e' => get_template_directory_uri() . '/img/colors/coral.jpg',
					'#cd3333' => get_template_directory_uri() . '/img/colors/lightred01.jpg',
					'#cc0000' => get_template_directory_uri() . '/img/colors/lightred02.jpg',
					'#ff6666' => get_template_directory_uri() . '/img/colors/pink.jpg',
					'#ca7f09' => get_template_directory_uri() . '/img/colors/gold.jpg',
				),
			),
			'custom_color_scheme'              => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Custom Color Scheme', 'mrbara' ),
				'default'  => 0,
				'section'  => 'color_scheme',
				'priority' => 10,
			),
			'custom_color'                     => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'mrbara' ),
				'default'         => '',
				'section'         => 'color_scheme',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'custom_color_scheme',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			// Boxed Layout
			'boxed_custom'                     => array(
				'type'            => 'custom',
				'label'           => esc_html__( 'Boxed Layout', 'mrbara' ),
				'default'         => esc_html__( 'This function just works fine with header layout is header top', 'mrbara' ),
				'section'         => 'boxed_layout',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
				),
			),
			'boxed_layout'                     => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Boxed Layout', 'mrbara' ),
				'default'         => 0,
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this to show boxed layout for site layout.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'boxed_layout_width'               => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Boxed Layout Width', 'mrbara' ),
				'default'         => '0',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'0'     => esc_html__( '1270(px)', 'mrbara' ),
					'w1470' => esc_html__( '1470(px)', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_color'                 => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'mrbara' ),
				'default'         => '',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_image'                 => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'mrbara' ),
				'default'         => '',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_horizontal'            => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Horizontal', 'mrbara' ),
				'default'         => 'left',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'left'   => esc_html__( 'Left', 'mrbara' ),
					'right'  => esc_html__( 'Right', 'mrbara' ),
					'center' => esc_html__( 'Center', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_vertical'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Vertical', 'mrbara' ),
				'default'         => 'top',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'top'    => esc_html__( 'Top', 'mrbara' ),
					'center' => esc_html__( 'Center', 'mrbara' ),
					'bottom' => esc_html__( 'Bottom', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_repeats'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Repeat', 'mrbara' ),
				'default'         => 'repeat',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'repeat'    => esc_html__( 'Repeat', 'mrbara' ),
					'repeat-x'  => esc_html__( 'Repeat Horizontally', 'mrbara' ),
					'repeat-y'  => esc_html__( 'Repeat Vertically', 'mrbara' ),
					'no-repeat' => esc_html__( 'No Repeat', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_attachments'           => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Attachment', 'mrbara' ),
				'default'         => 'scroll',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'scroll' => esc_html__( 'Scroll', 'mrbara' ),
					'fixed'  => esc_html__( 'Fixed', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'background_size'                  => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Size', 'mrbara' ),
				'default'         => 'normal',
				'section'         => 'boxed_layout',
				'priority'        => 30,
				'choices'         => array(
					'normal'  => esc_html__( 'Normal', 'mrbara' ),
					'contain' => esc_html__( 'Contain', 'mrbara' ),
					'cover'   => esc_html__( 'Cover', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			// Typography
			'body_typo'                        => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Body', 'mrbara' ),
				'section'  => 'body_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Poppins',
					'variant'        => 'regular',
					'font-size'      => '14px',
					'line-height'    => '1.7',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#999',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'body, .entry-content, .woocommerce div.product .woocommerce-tabs .panel',
					),
				),
			),
			'heading1_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 1', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '14px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h1',
					),
				),
			),
			'heading2_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 2', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '30px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h2',
					),
				),
			),
			'heading3_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 3', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '24px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h3',
					),
				),
			),
			'heading4_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 4', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '18px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h4',
					),
				),
			),
			'heading5_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 5', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '14px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h5',
					),
				),
			),
			'heading6_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 6', 'mrbara' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Montserrat',
					'variant'        => '700',
					'font-size'      => '12px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => '',
					'color'          => '#000',
					'text-transform' => 'none',
				),
				'output'   => array(
					array(
						'element' => 'h6',
					),
				),
			),
			'header_menu_typo'                 => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Primary Menu & Mega Menu Items Level 1', 'mrbara' ),
				'section'  => 'header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Montserrat',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.primary-nav > ul > li > a,
						.menu .is-mega-menu .dropdown-submenu .menu-item-mega > a,
						.header-top-style-7 .item-menu-nav,.header-top-style-6 .item-menu-nav,
						.header-top-style-7 .site-header .menu-extra .extra-menu-item > a,
						.header-top-style-6 .site-header .menu-extra .extra-menu-item > a,
						.display-nav .modal-content .menu li > a,
						.header-top-style-3 .primary-nav > ul > li > a,
						.header-top-style-4 .primary-nav > ul > li > a,
						.header-top-style-4 .site-header .widget-mr-language-switcher ul li a,
						.primary-mobile-nav ul.menu .is-mega-menu .dropdown-submenu .menu-item-mega > a,
						.header-top-style-8 .site-header .menu-sidebar .menu-sideextra .menu-item-cart .mini-cart-counter,
						.header-top-style-9 .site-header .menu-sideextra .menu-item-cart .mini-cart-counter,
						.header-top-style-11 .site-header .menu-sideextra .menu-item-cart .mini-cart-counter,
						.header-top-style-11 .site-header .menu-sideextra .menu-item-yith .mini-yith-counter,
						.menu .is-mega-menu .dropdown-submenu .menu-item-mega.uppercase-text > .mega-menu-submenu > ul > li > a',
					),
				),
			),
			'sub_menu_typo'                    => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Sub Menu Items', 'mrbara' ),
				'section'  => 'header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Poppins',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.site-header .primary-nav li li a,
						.display-nav .modal-content .menu li .sub-menu li a',
					),
				),
			),
			'extra_menu_typo'                  => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Extra Menu Items', 'mrbara' ),
				'section'  => 'header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Montserrat',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.site-header .menu-extra .extra-menu-item > a,
						.site-header .menu-extra .extra-menu-item.menu-item-account ul li a,
						.header-top-style-2 .site-header .header-main .menu-extra .menu-item-search .search-form,
						.header-top-style-7 .item-menu-nav,
						.header-top-style-6 .item-menu-nav,
						.header-left .site-header .menu-footer .widget-mr-currency-switcher > ul ul li a,
						.header-left .site-header .menu-footer .widget-mr-language-switcher > ul ul li a',
					),
				),
			),
			'page_header_typo'                 => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Page Header Title', 'mrbara' ),
				'section'  => 'page_header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Montserrat',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.site-banner h1, .page-header-shop-layout-3 .site-banner h1',
					),
				),
			),
			'swidget_title_typo'               => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Widget Title', 'mrbara' ),
				'section'  => 'widget_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Montserrat',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.widget .widget-title, .woocommerce .widget .widget-title',
					),
				),
			),
			'footer_widget_typo'               => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Widget Title', 'mrbara' ),
				'section'  => 'footer_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Montserrat',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.footer-widgets .widget .widget-title',
					),
				),
			),
			'footer_text_typo'                 => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Text', 'mrbara' ),
				'section'  => 'footer_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Poppins',
					'subsets'     => '',
				),
				'output'   => array(
					array(
						'element' => '.site-footer,
						.site-footer .footer-widgets,
						.site-footer .footer-widgets .widget a,
						.footer-layout-5 .widget-mr-language-switcher > ul ul li a,
						.footer-vertical .menu li a,
						.footer-vertical .socials h2',
					),
				),
			),
			// Site Layout
			'default_layout'                   => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Default Layout', 'mrbara' ),
				'default'     => 'full-content',
				'section'     => 'site_layout',
				'priority'    => 10,
				'description' => esc_html__( 'Select default layout for whole site.', 'mrbara' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'mrbara' ),
					'sidebar-content' => esc_html__( 'Sidebar Content', 'mrbara' ),
					'content-sidebar' => esc_html__( 'Content Sidebar', 'mrbara' ),
				),
			),
			// Site Layout
			'page_layout'                      => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Page Layout', 'mrbara' ),
				'default'     => 'full-content',
				'section'     => 'site_layout',
				'priority'    => 10,
				'description' => esc_html__( 'Default layout for pages.', 'mrbara' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'mrbara' ),
					'sidebar-content' => esc_html__( 'Sidebar Content', 'mrbara' ),
					'content-sidebar' => esc_html__( 'Content Sidebar', 'mrbara' ),
				),
			),
			// Site Layout
			'shop_layout'                      => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Shop Layout', 'mrbara' ),
				'default'     => 'sidebar-content',
				'section'     => 'site_layout',
				'priority'    => 10,
				'description' => esc_html__( 'Default layout for shop, product archive pages.', 'mrbara' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'mrbara' ),
					'sidebar-content' => esc_html__( 'Sidebar Content', 'mrbara' ),
					'content-sidebar' => esc_html__( 'Content Sidebar', 'mrbara' ),
				),
			),
			// Site Layout
			'portfolio_layout'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Portfolio Layout', 'mrbara' ),
				'default'     => 'full-content',
				'section'     => 'site_layout',
				'priority'    => 10,
				'description' => esc_html__( 'Default layout for portfolio archive, category pages.', 'mrbara' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'mrbara' ),
					'sidebar-content' => esc_html__( 'Sidebar Content', 'mrbara' ),
					'content-sidebar' => esc_html__( 'Content Sidebar', 'mrbara' ),
				),
			),
			// NewsLetter
			'newsletter_popup'                 => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable NewsLetter Popup', 'mrbara' ),
				'default'     => 0,
				'section'     => 'newsletter',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show enable newsletter popup.', 'mrbara' ),
			),
			'newsletter_layout'                => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'NewsLetter Layout', 'mrbara' ),
				'default'         => '0',
				'section'         => 'newsletter',
				'priority'        => 20,
				'choices'         => array(
					'0'            => esc_html__( 'Layout 1', 'mrbara' ),
					'newsletter-2' => esc_html__( 'Layout 2', 'mrbara' ),
				),
				'description'     => esc_html__( 'Select default layout for newsletter form.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_image'                 => array(
				'type'            => 'image',
				'label'           => esc_html__( 'NewsLetter Image', 'mrbara' ),
				'default'         => '',
				'section'         => 'newsletter',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_title'                 => array(
				'type'            => 'text',
				'label'           => esc_html__( 'NewsLetter Title', 'mrbara' ),
				'default'         => '',
				'section'         => 'newsletter',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_desc'                  => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'NewsLetter Description', 'mrbara' ),
				'default'         => '',
				'section'         => 'newsletter',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_form'                  => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'NewsLetter Form', 'mrbara' ),
				'default'         => '',
				'description'     => sprintf( wp_kses_post( 'Enter the shortcode of MailChimp form . You can edit your sign - up form in the <a href= "%s" > MailChimp for WordPress form settings </a>.', 'mrbara' ), admin_url( 'admin.php?page=mailchimp-for-wp-forms' ) ),
				'section'         => 'newsletter',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_show'                  => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Show "Don\'t show this popup again.', 'mrbara' ),
				'default'         => 0,
				'section'         => 'newsletter',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_days'                  => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Day(s)', 'mrbara' ),
				'default'         => '',
				'section'         => 'newsletter',
				'priority'        => 20,
				'description'     => esc_html__( 'Reappear after how many day(s) using Cookie', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'newsletter_seconds'               => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Seconds', 'mrbara' ),
				'default'         => '3',
				'section'         => 'newsletter',
				'priority'        => 20,
				'description'     => esc_html__( 'Display after how many second(s)', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			//Login & Register
			'login_page_layout'                => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Layout', 'mrbara' ),
				'default'     => '0',
				'section'     => 'account_page',
				'priority'    => 20,
				'choices'     => array(
					'0'       => esc_html__( 'Layout 1', 'mrbara' ),
					'login-2' => esc_html__( 'Layout 2', 'mrbara' ),
				),
				'description' => esc_html__( 'Select default layout for login form.', 'mrbara' ),
			),
			'login_page_image'                 => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'mrbara' ),
				'default'         => '',
				'section'         => 'account_page',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'login_page_layout',
						'operator' => '==',
						'value'    => 'login-2',
					),
				),
			),
			'login_layout'                     => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Layout', 'mrbara' ),
				'default'     => '0',
				'section'     => 'account_popup',
				'priority'    => 20,
				'choices'     => array(
					'0'       => esc_html__( 'Layout 1', 'mrbara' ),
					'login-2' => esc_html__( 'Layout 2', 'mrbara' ),
				),
				'description' => esc_html__( 'Select default layout for login form.', 'mrbara' ),
			),
			'login_image'                      => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'mrbara' ),
				'default'         => '',
				'section'         => 'account_popup',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'login_layout',
						'operator' => '==',
						'value'    => 'login-2',
					),
				),
			),
			// 404 Page
			'bg_404'                           => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Background 404 Page', 'mrbara' ),
				'default'  => '',
				'section'  => '404_page',
				'priority' => 20,
			),
			// image size
			'image_sizes'                      => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Image Size', 'mrbara' ),
				'default'  => array(
					'blog_grid',
					'blog_list',
					'blog_masonry',
					'portfolio_grid',
					'portfolio_masonry_2',
					'portfolio_masonry_4',
					'shop_cat_masonry',
				),
				'section'  => 'image_sizes',
				'priority' => 20,
				'choices'  => array(
					'blog_grid'           => esc_attr__( 'Blog Grid', 'mrbara' ),
					'blog_list'           => esc_attr__( 'Blog List', 'mrbara' ),
					'blog_masonry'        => esc_attr__( 'Blog Masonry', 'mrbara' ),
					'portfolio_grid'      => esc_attr__( 'Portfolio Grid', 'mrbara' ),
					'portfolio_masonry_2' => esc_attr__( 'Portfolio Masonry 2 Columns', 'mrbara' ),
					'portfolio_masonry_4' => esc_attr__( 'Portfolio Masonry 4 Columns', 'mrbara' ),
					'shop_cat_masonry'    => esc_attr__( 'Shop Categories Masonry', 'mrbara' ),
				),
			),
			// Styling
			'custom_css'                       => array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom CSS', 'mrbara' ),
				'default'     => '',
				'section'     => 'custom_css',
				'priority'    => 20,
				'description' => esc_html__( 'Enter your custom style rulers here', 'mrbara' ),
			),
			'custom_footer_js'                 => array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom Script', 'mrbara' ),
				'default'     => '',
				'section'     => 'custom_js',
				'priority'    => 20,
				'description' => esc_html__( 'Enter your custom scripts here.', 'mrbara' ),
			),
			// Promotion
			'promotion'                        => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Promotion', 'mrbara' ),
				'section'  => 'promotion',
				'default'  => 0,
				'priority' => 10,
			),
			'promotion_home_only'              => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Display On Homepage Only', 'mrbara' ),
				'section'         => 'promotion',
				'default'         => 0,
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_color'               => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'mrbara' ),
				'default'         => '',
				'section'         => 'promotion',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_image'               => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'mrbara' ),
				'default'         => '',
				'section'         => 'promotion',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_horizontal'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Horizontal', 'mrbara' ),
				'default'         => 'left',
				'section'         => 'promotion',
				'priority'        => 10,
				'choices'         => array(
					'left'   => esc_html__( 'Left', 'mrbara' ),
					'right'  => esc_html__( 'Right', 'mrbara' ),
					'center' => esc_html__( 'Center', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_vertical'            => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Vertical', 'mrbara' ),
				'default'         => 'top',
				'section'         => 'promotion',
				'priority'        => 10,
				'choices'         => array(
					'top'    => esc_html__( 'Top', 'mrbara' ),
					'center' => esc_html__( 'Center', 'mrbara' ),
					'bottom' => esc_html__( 'Bottom', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_repeats'             => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Repeat', 'mrbara' ),
				'default'         => 'repeat',
				'section'         => 'promotion',
				'priority'        => 10,
				'choices'         => array(
					'repeat'    => esc_html__( 'Repeat', 'mrbara' ),
					'repeat-x'  => esc_html__( 'Repeat Horizontally', 'mrbara' ),
					'repeat-y'  => esc_html__( 'Repeat Vertically', 'mrbara' ),
					'no-repeat' => esc_html__( 'No Repeat', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_attachments'         => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Attachment', 'mrbara' ),
				'default'         => 'scroll',
				'section'         => 'promotion',
				'priority'        => 10,
				'choices'         => array(
					'scroll' => esc_html__( 'Scroll', 'mrbara' ),
					'fixed'  => esc_html__( 'Fixed', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_bg_size'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Background Size', 'mrbara' ),
				'default'         => 'normal',
				'section'         => 'promotion',
				'priority'        => 10,
				'choices'         => array(
					'normal'  => esc_html__( 'Normal', 'mrbara' ),
					'contain' => esc_html__( 'Contain', 'mrbara' ),
					'cover'   => esc_html__( 'Cover', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'promotion_content'                => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Content', 'mrbara' ),
				'section'         => 'promotion',
				'default'         => '',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'promotion',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

			// Header layout
			'header_layout'                    => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Header Layout', 'mrbara' ),
				'section'  => 'header',
				'default'  => 'header-top',
				'priority' => 10,
				'choices'  => array(
					'header-top'  => esc_html__( 'Header Top', 'mrbara' ),
					'header-left' => esc_html__( 'Header Left', 'mrbara' ),
				),
			),
			'header_style'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Top Style', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1'  => esc_html__( 'Header 1', 'mrbara' ),
					'2'  => esc_html__( 'Header 2', 'mrbara' ),
					'3'  => esc_html__( 'Header 3', 'mrbara' ),
					'4'  => esc_html__( 'Header 4', 'mrbara' ),
					'5'  => esc_html__( 'Header 5', 'mrbara' ),
					'6'  => esc_html__( 'Header 6', 'mrbara' ),
					'7'  => esc_html__( 'Header 7', 'mrbara' ),
					'8'  => esc_html__( 'Header 8', 'mrbara' ),
					'9'  => esc_html__( 'Header 9', 'mrbara' ),
					'10' => esc_html__( 'Header 10', 'mrbara' ),
					'11' => esc_html__( 'Header 11', 'mrbara' ),
					'12' => esc_html__( 'Header 12', 'mrbara' ),
					'13' => esc_html__( 'Header 13', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_width'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Width', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 30,
				'choices'         => array(
					'0' => esc_html__( '1655(px)', 'mrbara' ),
					'2' => esc_html__( '1520(px)', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '5' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_skin'                      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Skin', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 30,
				'choices'         => array(
					'0'    => esc_html__( 'Light', 'mrbara' ),
					'dark' => esc_html__( 'Dark', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '10' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'topbar'                           => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Top Bar', 'mrbara' ),
				'default'         => '1',
				'section'         => 'header',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '8', '9', '10', '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'topbar_skin'                      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Top Bar Skin', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 30,
				'choices'         => array(
					'0'    => esc_html__( 'Light', 'mrbara' ),
					'dark' => esc_html__( 'Dark', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '8', '9', '10', '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'header_transparent'               => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Transparent', 'mrbara' ),
				'default'         => 1,
				'section'         => 'header',
				'priority'        => 40,
				'description'     => esc_html__( 'This option is used for homepage.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1', '3', '4', '5', '6', '7' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_text_color'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Text Color', 'mrbara' ),
				'section'         => 'header',
				'default'         => 'light',
				'priority'        => 40,
				'choices'         => array(
					'light' => esc_html__( 'Light', 'mrbara' ),
					'dark'  => esc_html__( 'Dark', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_transparent',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1', '3', '4', '5', '6' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_sticky'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Sticky Header', 'mrbara' ),
				'default'         => 0,
				'section'         => 'header',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_sticky_type'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sticky Header Type', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 50,
				'choices'         => array(
					'1' => esc_html__( 'Type 1', 'mrbara' ),
					'2' => esc_html__( 'Type 2', 'mrbara' ),
				),
				'description'     => esc_html__( 'Choose type 1 to show header when scroll up and down. Choose type 2 to show header when scroll up.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'menu_extra'                       => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'search', 'account', 'cart' ),
				'priority'        => 60,
				'choices'         => array(
					'account' => esc_html__( 'Account', 'mrbara' ),
					'cart'    => esc_html__( 'Cart', 'mrbara' ),
					'search'  => esc_html__( 'Search', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1', '2', '10', '8' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'menu_extra_1'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'search', 'account', 'cart', 'shop' ),
				'priority'        => 60,
				'choices'         => array(
					'account' => esc_html__( 'Account', 'mrbara' ),
					'cart'    => esc_html__( 'Cart', 'mrbara' ),
					'search'  => esc_html__( 'Search', 'mrbara' ),
					'shop'    => esc_html__( 'Shop', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '7' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'menu_extra_2'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'account', 'cart', ),
				'priority'        => 60,
				'choices'         => array(
					'account' => esc_html__( 'Account', 'mrbara' ),
					'cart'    => esc_html__( 'Cart', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '6', '9' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'menu_extra_4'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'account', 'cart', 'wishlist', 'compare', 'search' ),
				'priority'        => 60,
				'choices'         => array(
					'account'  => esc_html__( 'Account', 'mrbara' ),
					'cart'     => esc_html__( 'Cart', 'mrbara' ),
					'wishlist' => esc_html__( 'Wishlist', 'mrbara' ),
					'compare'  => esc_html__( 'Compare', 'mrbara' ),
					'search'   => esc_html__( 'Search', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'menu_extra_5'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'account', 'cart', 'wishlist', 'search' ),
				'priority'        => 60,
				'choices'         => array(
					'account'  => esc_html__( 'Account', 'mrbara' ),
					'cart'     => esc_html__( 'Cart', 'mrbara' ),
					'wishlist' => esc_html__( 'Wishlist', 'mrbara' ),
					'search'   => esc_html__( 'Search', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '12' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'mini_cart_content'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Mini Cart Type', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 70,
				'description'     => esc_html__( 'Choose type you want to show mini cart content', 'mrbara' ),
				'choices'         => array(
					'0'          => esc_html__( 'On Hover', 'mrbara' ),
					'cart-click' => esc_html__( 'On Click', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1', '2', '7', '6', '8', '9', '10', '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'mini_cart_button'                 => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Display Mini Cart Button', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 70,
				'description'     => esc_html__( 'Choose type you want to display mini cart button', 'mrbara' ),
				'choices'         => array(
					'1' => esc_html__( 'In line', 'mrbara' ),
					'2' => esc_html__( 'In multiple lines', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1', '2', '7', '6', '8', '9', '10', '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_search_type'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Products Search Type', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 80,
				'description'     => esc_html__( 'Choose type you want to show search form', 'mrbara' ),
				'choices'         => array(
					'0' => esc_html__( 'Vertical', 'mrbara' ),
					'2' => esc_html__( 'Horizontal', 'mrbara' ),
					'3' => esc_html__( 'Popup', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'header_search_type_2'             => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Products Search Type', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 80,
				'description'     => esc_html__( 'Choose type you want to show search form', 'mrbara' ),
				'choices'         => array(
					'0' => esc_html__( 'Vertical', 'mrbara' ),
					'3' => esc_html__( 'Popup', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '7', '10' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'popular_keywords'                 => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Popular keywords', 'mrbara' ),
				'section'         => 'header',
				'default'         => '',
				'priority'        => 90,
				'description'     => esc_html__( 'Enter popular keywords', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_type',
						'operator' => '==',
						'value'    => '3',
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '1' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'popular_keywords_2'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Popular keywords', 'mrbara' ),
				'section'         => 'header',
				'default'         => '',
				'priority'        => 90,
				'description'     => esc_html__( 'Enter popular keywords', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_type_2',
						'operator' => '==',
						'value'    => '3',
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '7', '10' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'product_cats_menu_style'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Categories Menu Style', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 90,
				'choices'         => array(
					'1' => esc_html__( 'Style 1', 'mrbara' ),
					'2' => esc_html__( 'Style 2', 'mrbara' ),
					'3' => esc_html__( 'Style 3', 'mrbara' ),
					'4' => esc_html__( 'Style 4', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'product_cats_menu_items_homepage' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Categories Menu items on Homepage', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 90,
				'choices'         => array(
					'1' => esc_html__( 'Open', 'mrbara' ),
					'0' => esc_html__( 'Close', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'product_cats_menu_items_type'     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Categories Menu Items Type', 'mrbara' ),
				'section'         => 'header',
				'default'         => '0',
				'priority'        => 90,
				'description'     => esc_html__( 'Choose type you want to show categories menu items', 'mrbara' ),
				'choices'         => array(
					'0' => esc_html__( 'On Click', 'mrbara' ),
					'1' => esc_html__( 'On Hover', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '12', '13' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),
			'custom_search_content'            => array(
				'type'     => 'custom',
				'section'  => 'custom_header_text',
				'default'  => '<h2>' . esc_html__( 'Custom Search Content Text', 'mrbara' ) . '</h2>',
				'priority' => 90,
			),
			'custom_categories_text'           => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Categories DropDown', 'mrbara' ),
				'section'         => 'custom_header_text',
				'default'         => esc_html__( 'All Categories', 'mrbara' ),
				'priority'        => 90,
				'description'     => esc_html__( 'Enter this option if your products search type have categories dropdown control', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '=',
						'value'    => 'header-top',
					),
				),
			),
			'custom_search_textbox'            => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Search TextBox', 'mrbara' ),
				'section'  => 'custom_header_text',
				'default'  => esc_html__( 'Search here', 'mrbara' ),
				'priority' => 90,

			),
			'custom_search_button'             => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Search Button', 'mrbara' ),
				'section'         => 'custom_header_text',
				'default'         => esc_html__( 'Search', 'mrbara' ),
				'priority'        => 90,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '=',
						'value'    => 'header-top',
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '8', '11', '12', '13' ),
					),
				),
			),
			'custom_product_categories'        => array(
				'type'            => 'custom',
				'section'         => 'custom_header_text',
				'default'         => '<div style="border-top: 1px solid #ccc"><h2>' . esc_html__( 'Custom Product Categories Text', 'mrbara' ) . '</h2></div>',
				'priority'        => 90,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '=',
						'value'    => 'header-top',
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '12', '13' ),
					),
				),
			),
			'custom_product_categories_text'   => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Product Categories', 'mrbara' ),
				'section'         => 'custom_header_text',
				'default'         => esc_html__( 'Shop By Department', 'mrbara' ),
				'priority'        => 90,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '=',
						'value'    => 'header-top',
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '11', '12', '13' ),
					),
				),
			),
			// Header Left
			'header_left_style'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Left Style', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Header 1', 'mrbara' ),
					'2' => esc_html__( 'Header 2', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
				),
			),
			'menu_extra_3'                     => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra', 'mrbara' ),
				'section'         => 'header',
				'default'         => array( 'search', 'account', 'cart' ),
				'priority'        => 30,
				'choices'         => array(
					'account' => esc_html__( 'Account', 'mrbara' ),
					'cart'    => esc_html__( 'Cart', 'mrbara' ),
					'search'  => esc_html__( 'Search', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
				),
			),
			'popular_keywords_3'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Popular keywords', 'mrbara' ),
				'section'         => 'header',
				'default'         => '',
				'priority'        => 40,
				'description'     => esc_html__( 'Enter popular keywords', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
					array(
						'setting'  => 'menu_extra_3',
						'operator' => 'contains',
						'value'    => 'search',
					),
				),
			),
			'bg_header_left'                   => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Header Background Image', 'mrbara' ),
				'section'         => 'header',
				'default'         => '1',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
				),
			),
			'header_social'                    => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Socials', 'mrbara' ),
				'section'         => 'header',
				'priority'        => 50,
				'default'         => array(
					array(
						'link_url' => 'https://facebook.com/mrbara',
					),
					array(
						'link_url' => 'https://twitter.com/mrbara',
					),
					array(
						'link_url' => 'https://plus.google.com/mrbara',
					),
				),
				'fields'          => array(
					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'mrbara' ),
						'description' => esc_html__( 'Enter the URL for this social', 'mrbara' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-left',
					),
					array(
						'setting'  => 'header_left_style',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			// Logo
			'logo'                             => array(
				'type'        => 'image',
				'label'       => esc_html__( 'Logo', 'mrbara' ),
				'description' => esc_html__( 'This logo is used for all site.', 'mrbara' ),
				'section'     => 'logo',
				'default'     => '',
				'priority'    => 20,
			),
			'logo_transparent'                 => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Header Transparent Logo', 'mrbara' ),
				'section'         => 'logo',
				'description'     => esc_html__( 'This logo is just used for header transparent in the homepage, account layout 2 page and 404 page.', 'mrbara' ),
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),

			'logo_sticky' => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Header Sticky Logo', 'mrbara' ),
				'section'         => 'logo',
				'description'     => esc_html__( 'This logo is just used for header sticky', 'mrbara' ),
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'header_skin',
						'operator' => '==',
						'value'    => 'dark',
					),
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'header_style',
						'operator' => 'in',
						'value'    => array( '10' ),
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'header-top',
					),
				),
			),

			'logo_width'                     => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Logo Width(px)', 'mrbara' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_height'                    => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Logo Height(px)', 'mrbara' ),
				'section'  => 'logo',
				'priority' => 20,
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'logo_margins'                   => array(
				'type'     => 'spacing',
				'label'    => esc_html__( 'Logo Margin', 'mrbara' ),
				'section'  => 'logo',
				'priority' => 20,
				'default'  => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
				),
				array(
					'setting'  => 'logo',
					'operator' => '!=',
					'value'    => '',
				),
			),
			'page_header'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Page Header', 'mrbara' ),
				'section'     => 'page_header_site',
				'description' => esc_html__( 'Enable to show a page header for whole site below the site header', 'mrbara' ),
				'priority'    => 20,
			),
			'page_header_pages'              => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Page Header', 'mrbara' ),
				'section'     => 'page_header_pages',
				'default'     => 1,
				'description' => esc_html__( 'Enable to show a page header for pages below the site header', 'mrbara' ),
				'priority'    => 20,
			),
			'page_header_layout_pages'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'mrbara' ),
				'section'         => 'page_header_pages',
				'default'         => '7',
				'priority'        => 20,
				'choices'         => array(
					'7'  => esc_html__( 'Layout 1', 'mrbara' ),
					'8'  => esc_html__( 'Layout 2', 'mrbara' ),
					'9'  => esc_html__( 'Layout 3', 'mrbara' ),
					'10' => esc_html__( 'Layout 4', 'mrbara' ),
					'11' => esc_html__( 'Layout 5', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_pages',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_shop'               => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Page Header', 'mrbara' ),
				'section'     => 'page_header_shop',
				'default'     => 1,
				'description' => esc_html__( 'Enable to show a page header for shop, product category, product tag below the site header', 'mrbara' ),
				'priority'    => 20,
			),
			'page_header_layout_shop'        => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'mrbara' ),
				'section'         => 'page_header_shop',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'mrbara' ),
					'2' => esc_html__( 'Layout 2', 'mrbara' ),
					'3' => esc_html__( 'Layout 3', 'mrbara' ),
					'4' => esc_html__( 'Layout 4', 'mrbara' ),
					'5' => esc_html__( 'Layout 5', 'mrbara' ),
					'6' => esc_html__( 'Layout 6', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'bg_shop_parallax'               => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'mrbara' ),
				'section'         => 'page_header_shop',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			'page_header_bg_shop'            => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'mrbara' ),
				'section'         => 'page_header_shop',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => 'in',
						'value'    => array( '2', '5' ),
					),
				),
			),
			'logo_shop'                      => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Custom Logo', 'mrbara' ),
				'section'         => 'page_header_shop',
				'default'         => '7',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			'shop_desc'                      => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Description', 'mrbara' ),
				'section'         => 'page_header_shop',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'page_header_layout_shop',
						'operator' => '==',
						'value'    => 6,
					),
				),
			),
			'page_header_product'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Page Header', 'mrbara' ),
				'section'     => 'page_header_product',
				'default'     => 1,
				'description' => esc_html__( 'Enable to show a page header for product page below the site header', 'mrbara' ),
				'priority'    => 20,
			),
			'page_header_layout_product'     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Page Header Layout', 'mrbara' ),
				'section'         => 'page_header_product',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Layout 1', 'mrbara' ),
					'2' => esc_html__( 'Layout 2', 'mrbara' ),
					'3' => esc_html__( 'Layout 3', 'mrbara' ),
					'4' => esc_html__( 'Layout 4', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_product',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_product_title'      => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Product Title', 'mrbara' ),
				'section'         => 'page_header_product',
				'default'         => 1,
				'description'     => esc_html__( 'Check this option to enable product title', 'mrbara' ),
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_product',
						'operator' => 'in',
						'value'    => array( '1', '2', '3' ),
					),
					array(
						'setting'  => 'page_header_product',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_product_breadcrumb' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Breadcrumb', 'mrbara' ),
				'section'     => 'page_header_product',
				'default'     => 1,
				'description' => esc_html__( 'Check this option to enable breadcrumb', 'mrbara' ),
				'priority'    => 20,
			),
			'bg_product_parallax'            => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Enable Parallax', 'mrbara' ),
				'section'         => 'page_header_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_product',
						'operator' => '==',
						'value'    => 3,
					),
					array(
						'setting'  => 'page_header_product',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_bg_product'         => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Page Header Background Image', 'mrbara' ),
				'section'         => 'page_header_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_product',
						'operator' => '==',
						'value'    => 3,
					),
					array(
						'setting'  => 'page_header_product',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'product_logo'                   => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Custom Logo', 'mrbara' ),
				'section'         => 'page_header_product',
				'default'         => 1,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_layout_product',
						'operator' => '==',
						'value'    => 3,
					),
					array(
						'setting'  => 'page_header_product',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_portfolio'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Page Header', 'mrbara' ),
				'section'     => 'page_header_portfolio',
				'default'     => 1,
				'description' => esc_html__( 'Enable to show a page header for portfolio, portfolio archive pages  below the site header', 'mrbara' ),
				'priority'    => 20,
			),
			'portfolio_desc'                 => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Description', 'mrbara' ),
				'section'         => 'page_header_portfolio',
				'default'         => '',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_portfolio',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'blog_view'                      => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Blog View', 'mrbara' ),
				'section'  => 'content',
				'default'  => 'grid',
				'priority' => 20,
				'choices'  => array(
					'grid'   => esc_html__( 'Grid', 'mrbara' ),
					'list'   => esc_html__( 'List', 'mrbara' ),
					'masony' => esc_html__( 'Masony', 'mrbara' ),
				),
			),
			'show_cat_filter'                => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Categories Filter', 'mrbara' ),
				'section'  => 'content',
				'default'  => 0,
				'priority' => 20,
			),
			'blog_nav_type'                  => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Type of Navigation', 'mrbara' ),
				'section'  => 'content',
				'default'  => 'links',
				'priority' => 20,
				'choices'  => array(
					'links' => esc_html__( 'Links', 'mrbara' ),
					'ajax'  => esc_html__( 'Load Ajax', 'mrbara' ),
				),
			),
			'blog_nav_view'                  => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Navigation View', 'mrbara' ),
				'section'         => 'content',
				'default'         => 'center',
				'priority'        => 20,
				'choices'         => array(
					'center' => esc_html__( 'View 1', 'mrbara' ),
					'full'   => esc_html__( 'View 2', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_nav_type',
						'operator' => '==',
						'value'    => 'links',
					),
				),
			),
			'excerpt_length'                 => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Excerpt Length', 'mrbara' ),
				'section'         => 'content',
				'default'         => 30,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'blog_view',
						'operator' => '==',
						'value'    => 'list',
					),
				),
			),
			'show_share_box'                 => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Sharing Icons', 'mrbara' ),
				'section'     => 'content',
				'default'     => 1,
				'description' => esc_html__( 'Display social sharing icons for each post on single page', 'mrbara' ),
				'priority'    => 20,
			),
			'post_social_icons'              => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Social Icons', 'mrbara' ),
				'section'         => 'content',
				'default'         => array( 'twitter', 'facebook', 'google', 'pinterest', 'linkedin' ),
				'priority'        => 60,
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'mrbara' ),
					'facebook'  => esc_html__( 'Facebook', 'mrbara' ),
					'google'    => esc_html__( 'Google Plus', 'mrbara' ),
					'pinterest' => esc_html__( 'Pinterest', 'mrbara' ),
					'linkedin'  => esc_html__( 'Linkedin', 'mrbara' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'show_share_box',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_post_format'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Post Format', 'mrbara' ),
				'section'     => 'content',
				'default'     => '1',
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to show post format(image, video...) in single post.', 'mrbara' ),
			),
			// Woocommerce
			'product_shop_topbar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Shop Top bar', 'mrbara' ),
				'section'     => 'catalog',
				'default'     => 0,
				'priority'    => 20,
				'description' => sprintf( wp_kses_post( 'Please go to <a href="%s">Widgets</a> to drag widgets to shop top bar', 'mrbara' ), admin_url( 'widgets.php' ) ),
			),
			'shop_topbar_width'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Shop Top bar Width', 'mrbara' ),
				'section'         => 'catalog',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'0' => esc_html__( 'Default(1170px)', 'mrbara' ),
					'1' => esc_html__( 'Full Width', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_shop_topbar',
						'operator' => '==',
						'value'    => '1',
					),
				),

			),
			'product_cat_filter'             => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Categories filter', 'mrbara' ),
				'section'  => 'catalog',
				'default'  => 0,
				'priority' => 30,
			),
			'shop_width'                     => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Shop Width', 'mrbara' ),
				'section'  => 'catalog',
				'default'  => '0',
				'priority' => 50,
				'choices'  => array(
					'0' => esc_html__( 'Default(1170px)', 'mrbara' ),
					'1' => esc_html__( 'Large(1365px)', 'mrbara' ),
					'2' => esc_html__( 'Full Width', 'mrbara' ),
				),

			),
			'shop_skin'                      => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Shop Skin', 'mrbara' ),
				'section'  => 'catalog',
				'default'  => '0',
				'priority' => 60,
				'choices'  => array(
					'0'    => esc_html__( 'Light', 'mrbara' ),
					'gray' => esc_html__( 'Gray', 'mrbara' ),
				),
			),
			'shop_view'                      => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Shop View', 'mrbara' ),
				'section'  => 'catalog',
				'default'  => 'grid',
				'priority' => 70,
				'choices'  => array(
					'grid' => esc_html__( 'Grid', 'mrbara' ),
					'list' => esc_html__( 'List', 'mrbara' ),
				),
			),
			'product_columns'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Product Columns Per Page', 'mrbara' ),
				'section'         => 'catalog',
				'default'         => 4,
				'priority'        => 80,
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
					'2' => esc_html__( '2 Columns', 'mrbara' ),
				),
				'description'     => esc_html__( 'Specify how many product columns you want to show on shop page', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'shop_view',
						'operator' => '==',
						'value'    => 'grid',
					),
				),
			),
			'products_per_page'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Products  Number Per Page', 'mrbara' ),
				'section'     => 'catalog',
				'default'     => 12,
				'priority'    => 90,
				'description' => esc_html__( 'Specify how many products you want to show on shop page', 'mrbara' ),
			),
			'navigation_type'                => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Type of Navigation', 'mrbara' ),
				'section'  => 'catalog',
				'default'  => 'links',
				'priority' => 100,
				'choices'  => array(
					'links' => esc_html__( 'Links', 'mrbara' ),
					'ajax'  => esc_html__( 'Load Ajax', 'mrbara' ),
				),
			),
			'show_category_desc'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Category Description', 'mrbara' ),
				'section'     => 'catalog',
				'default'     => 0,
				'priority'    => 100,
				'description' => esc_html__( 'Check this option to show category description on the top product category page', 'mrbara' ),
			),
			//Badge
			'show_badges'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Badges', 'mrbara' ),
				'section'     => 'shop_badge',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this to show badges on every products.', 'mrbara' ),
			),
			'badges'                         => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Badges', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => array( 'hot', 'new', 'featured', 'sold_out' ),
				'priority'        => 20,
				'choices'         => array(
					'hot'        => esc_html__( 'Hot', 'mrbara' ),
					'new'        => esc_html__( 'New', 'mrbara' ),
					'sale'       => esc_html__( 'Sale', 'mrbara' ),
					'outofstock' => esc_html__( 'Out Of Stock', 'mrbara' ),
				),
				'description'     => esc_html__( 'Select which badges you want to show', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'hot_text'                       => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom Hot Text', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => 'Hot',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'hot',
					),
				),
			),
			'new_text'                       => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom New Text', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => 'New',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'new',
					),
				),
			),
			'sale_text'                      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom Sale Text', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => 'Sale',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'sale',
					),
				),
			),
			'outofstock_text'                => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Custom Out Of Stock Text', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => 'Out Of Stock',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
					array(
						'setting'  => 'badges',
						'operator' => 'contains',
						'value'    => 'outofstock',
					),
				),
			),
			'product_newness'                => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Newness', 'mrbara' ),
				'section'         => 'shop_badge',
				'default'         => 3,
				'priority'        => 20,
				'description'     => esc_html__( 'Display the "New" badge for how many days?', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'show_badges',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			//Shop ToolBar
			'show_shop_bar'                  => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Show Shop ToolBar For', 'mrbara' ),
				'section'     => 'shop_toolbar',
				'default'     => array( 'found', 'sort_by', 'per_page', 'view' ),
				'priority'    => 40,
				'choices'     => array(
					'found'    => esc_html__( 'Products Found', 'mrbara' ),
					'sort_by'  => esc_html__( 'Sort By', 'mrbara' ),
					'per_page' => esc_html__( 'Per Page', 'mrbara' ),
					'view'     => esc_html__( 'View', 'mrbara' ),
				),
				'description' => esc_html__( 'Select which elements you want to show in shop bar', 'mrbara' ),
			),
			// Per Page
			'shop_per_page'                  => array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom Shop Per Page', 'mrbara' ),
				'section'     => 'shop_toolbar',
				'default'     => '',
				'priority'    => 45,
				'description' => esc_html__( 'Enter numbers for this option (Note: divide numbers with linebreaks (Enter))', 'mrbara' ),
			),
			//Shop Widget
			'swidget_title_style'            => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Widget Title Style', 'mrbara' ),
				'section'     => 'shop_widget',
				'default'     => 0,
				'priority'    => 20,
				'choices'     => array(
					'0' => esc_html__( 'Style 1', 'mrbara' ),
					'2' => esc_html__( 'Style 2', 'mrbara' ),
				),
				'description' => esc_html__( 'Select default style for shop widget title', 'mrbara' ),
			),
			'filter_layout'                  => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Widget Filter Layout', 'mrbara' ),
				'section'     => 'shop_widget',
				'default'     => '1',
				'priority'    => 20,
				'choices'     => array(
					'1' => esc_html__( 'Layout 1', 'mrbara' ),
					'2' => esc_html__( 'Layout 2', 'mrbara' ),
				),
				'description' => esc_html__( 'Select default layout for shop widget filter', 'mrbara' ),
			),
			'shop_categories_layout'         => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Shop Categories Layout', 'mrbara' ),
				'section'     => 'shop_categories',
				'default'     => 'grid',
				'priority'    => 20,
				'choices'     => array(
					'grid'    => esc_html__( 'Grid', 'mrbara' ),
					'masonry' => esc_html__( 'Masonry', 'mrbara' ),
				),
				'description' => sprintf( wp_kses_post( 'Please go to <a href="%s">Shop Setting</a> and choose Shop Page Display as show categories.', 'mrbara' ), admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) ),
			),
			'shop_categories'                => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Custom Layout', 'mrbara' ),
				'section'         => 'shop_categories',
				'default'         => '1F-2L-3N-4L-5N-6N-7N-8N-9N-10W',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'shop_categories_layout',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			'shop_cats_custom'               => array(
				'type'            => 'custom',
				'section'         => 'shop_categories',
				'description'     => esc_html__( 'Enter the shop layout by the format: F-N-W-L. Note: Divide sizes with dash(-)', 'mrbara' ),
				'default'         => '<p>' . esc_html__( 'F: Full Size(866x866)', 'mrbara' ) . '</p><p>' . esc_html__( 'N: Normal Size(418x418)', 'mrbara' ) . '</p><p>' . esc_html__( 'W: Wide Size(866x418)', 'mrbara' ) . '</p><p>' . esc_html__( 'L: Long Size(418x866)', 'mrbara' ) . '</p>',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'shop_categories_layout',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			// Product grid
			'product_item_layout'            => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Grid Layout', 'mrbara' ),
				'section'     => 'product_grid',
				'default'     => 1,
				'priority'    => 20,
				'choices'     => array(
					'1'  => esc_html__( 'Layout 1', 'mrbara' ),
					'2'  => esc_html__( 'Layout 2', 'mrbara' ),
					'3'  => esc_html__( 'Layout 3', 'mrbara' ),
					'4'  => esc_html__( 'Layout 4', 'mrbara' ),
					'5'  => esc_html__( 'Layout 5', 'mrbara' ),
					'6'  => esc_html__( 'Layout 6', 'mrbara' ),
					'7'  => esc_html__( 'Layout 7', 'mrbara' ),
					'8'  => esc_html__( 'Layout 8', 'mrbara' ),
					'9'  => esc_html__( 'Layout 9', 'mrbara' ),
					'10' => esc_html__( 'Layout 10', 'mrbara' ),
				),
				'description' => esc_html__( 'Select default layout for product grid layout', 'mrbara' ),
			),
			'disable_secondary_thumb'        => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Disable Secondary Product Thumbnail', 'mrbara' ),
				'section'         => 'product_grid',
				'default'         => 0,
				'priority'        => 20,
				'description'     => esc_html__( 'Check this option to disable secondary product thumbnail when hover over the main product image.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_item_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '4', '7', '8', '10' ),
					),
				),
			),
			'product_add_to_cart'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Add To Cart button', 'mrbara' ),
				'section'     => 'product_grid',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to enable add to cart button in product grid layout.', 'mrbara' ),
			),
			'product_item_cat'               => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Show Category', 'mrbara' ),
				'section'         => 'product_grid',
				'default'         => 1,
				'priority'        => 20,
				'description'     => esc_html__( 'Check this option to show category for this layout.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_item_layout',
						'operator' => 'in',
						'value'    => array( '8' ),
					),
				),
			),
			'product_item_shadow'            => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Box Shadow', 'mrbara' ),
				'section'         => 'product_grid',
				'default'         => 1,
				'priority'        => 20,
				'description'     => esc_html__( 'Check this option to enable box shadow when hover over the product.', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_item_layout',
						'operator' => 'in',
						'value'    => array( '8' ),
					),
				),
			),
			'product_item_center'            => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Text Center', 'mrbara' ),
				'section'         => 'product_grid',
				'default'         => 0,
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_item_layout',
						'operator' => '==',
						'value'    => 3,
					),
				),
			),
			'product_attribute'              => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Product Attribute', 'mrbara' ),
				'section'         => 'product_grid',
				'default'         => 1,
				'priority'        => 20,
				'choices'         => $attributes,
				'description'     => esc_html__( 'Show the attribute in shop grid layout', 'mrbara' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_item_layout',
						'operator' => '==',
						'value'    => 10,
					),
				),
			),
			// Product page
			'product_page_layout'            => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Page Layout', 'mrbara' ),
				'section'     => 'single_product',
				'default'     => 1,
				'priority'    => 20,
				'description' => esc_html__( 'Select default layout for product page', 'mrbara' ),
				'choices'     => array(
					'1'  => esc_html__( 'Layout 1', 'mrbara' ),
					'2'  => esc_html__( 'Layout 2', 'mrbara' ),
					'3'  => esc_html__( 'Layout 3', 'mrbara' ),
					'4'  => esc_html__( 'Layout 4', 'mrbara' ),
					'5'  => esc_html__( 'Layout 5', 'mrbara' ),
					'6'  => esc_html__( 'Layout 6', 'mrbara' ),
					'7'  => esc_html__( 'Layout 7', 'mrbara' ),
					'8'  => esc_html__( 'Layout 8', 'mrbara' ),
					'9'  => esc_html__( 'Layout 9', 'mrbara' ),
					'10' => esc_html__( 'Layout 10', 'mrbara' ),
					'11' => esc_html__( 'Layout 11', 'mrbara' ),
					'12' => esc_html__( 'Layout 12', 'mrbara' ),
				),
			),
			'product_zoom'                   => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Product Zoom', 'mrbara' ),
				'section'         => 'single_product',
				'default'         => 1,
				'description'     => esc_html__( 'Check this option to show a bigger size product image on mouseover', 'mrbara' ),
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '8', '9', '12' ),
					),
				),
			),
			'product_add_to_cart_ajax'       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'AJAX add to cart button', 'mrbara' ),
				'section'     => 'single_product',
				'default'     => 0,
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to enable AJAX add to cart button in the product page.', 'mrbara' ),
			),
			'show_product_extra'             => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Show Product Extra', 'mrbara' ),
				'section'     => 'single_product',
				'default'     => array( 'sku', 'categories', 'tags', 'share' ),
				'priority'    => 40,
				'choices'     => array(
					'sku'        => esc_html__( 'SKU', 'mrbara' ),
					'categories' => esc_html__( 'Categories', 'mrbara' ),
					'tags'       => esc_html__( 'Tags', 'mrbara' ),
					'share'      => esc_html__( 'Share Socials', 'mrbara' ),
				),
				'description' => esc_html__( 'Select which section you want to show in product page', 'mrbara' ),
			),
			'product_social_icons'           => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Social Icons', 'mrbara' ),
				'section'  => 'single_product',
				'default'  => array( 'twitter', 'facebook', 'google', 'pinterest', 'linkedin' ),
				'priority' => 40,
				'choices'  => array(
					'twitter'   => esc_html__( 'Twitter', 'mrbara' ),
					'facebook'  => esc_html__( 'Facebook', 'mrbara' ),
					'google'    => esc_html__( 'Google Plus', 'mrbara' ),
					'pinterest' => esc_html__( 'Pinterest', 'mrbara' ),
					'linkedin'  => esc_html__( 'Linkedin', 'mrbara' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'mrbara' ),
				),
			),
			'related_products'               => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Related Products', 'mrbara' ),
				'section'  => 'single_product',
				'default'  => 1,
				'priority' => 40,
			),
			'related_products_columns'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Related Products Columns', 'mrbara' ),
				'section'         => 'single_product',
				'default'         => 3,
				'priority'        => 40,
				'description'     => esc_html__( 'Specify how many columns of related products you want to show on single product page', 'mrbara' ),
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
					'5' => esc_html__( '5 Columns', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '5', '7', '8', '11', '12' ),
					),
				),
			),
			'related_products_numbers'       => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Related Products Numbers', 'mrbara' ),
				'section'     => 'single_product',
				'default'     => 3,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of related products you want to show on single product page', 'mrbara' ),
			),
			'upsells_products'               => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Upsells Products', 'mrbara' ),
				'section'  => 'single_product',
				'default'  => 0,
				'priority' => 40,
			),
			'upsells_products_columns'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Up-sells Products Columns', 'mrbara' ),
				'section'         => 'single_product',
				'default'         => 3,
				'priority'        => 40,
				'description'     => esc_html__( 'Specify how many columns of up-sells products you want to show on single product page', 'mrbara' ),
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
					'5' => esc_html__( '5 Columns', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_page_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '5', '7', '8', '11', '12' ),
					),
				),
			),
			'upsells_products_numbers'       => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Up-sells Products Numbers', 'mrbara' ),
				'section'     => 'single_product',
				'default'     => 3,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of up-sells products you want to show on single product page', 'mrbara' ),
			),
			'crosssells_products_columns'    => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Cross-sells Products Columns', 'mrbara' ),
				'section'     => 'cart_page',
				'default'     => 3,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many columns of cross-sells products you want to show on single product page', 'mrbara' ),
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
					'5' => esc_html__( '5 Columns', 'mrbara' ),
				),
			),
			'crosssells_products_numbers'    => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Cross-sells Products Numbers', 'mrbara' ),
				'section'     => 'cart_page',
				'default'     => 3,
				'priority'    => 40,
				'description' => esc_html__( 'Specify how many numbers of cross-sells products you want to show on single product page', 'mrbara' ),
			),
			// Portfolio
			'portfolio_cat_filter'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Categories Filter', 'mrbara' ),
				'section'     => 'portfolio',
				'description' => esc_html__( 'Display portfolio categories filter on portfolios page', 'mrbara' ),
				'default'     => 1,
				'priority'    => 20,
			),
			'portfolios_view'                => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Portfolios View', 'mrbara' ),
				'description' => esc_html__( 'Select default view for portfolios page', 'mrbara' ),
				'section'     => 'portfolio',
				'default'     => 'masonry',
				'priority'    => 20,
				'choices'     => array(
					'masonry' => esc_html__( 'Masonry', 'mrbara' ),
					'grid'    => esc_html__( 'Grid', 'mrbara' ),
				),
			),
			'portfolio_columns'              => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Portfolio Columns Per Page', 'mrbara' ),
				'description'     => esc_html__( 'Specify how many portfolio columns you want to show on portfolios page', 'mrbara' ),
				'section'         => 'portfolio',
				'default'         => '2',
				'priority'        => 20,
				'choices'         => array(
					'2' => esc_html__( '2 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolios_view',
						'operator' => '==',
						'value'    => 'masonry',
					),
				),
			),
			'portfolio_per_page'             => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Portfolio  Number Per Page', 'mrbara' ),
				'section'     => 'portfolio',
				'default'     => 9,
				'priority'    => 20,
				'description' => esc_html__( 'Specify how many portfolio you want to show on portfolio page', 'mrbara' ),
			),
			'portfolio_nav_type'             => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Type of Navigation', 'mrbara' ),
				'description' => esc_html__( 'Select type of navigation you want to show on portfolios page', 'mrbara' ),
				'section'     => 'portfolio',
				'default'     => 'links',
				'priority'    => 20,
				'choices'     => array(
					'links' => esc_html__( 'Links', 'mrbara' ),
					'ajax'  => esc_html__( 'Load Ajax', 'mrbara' ),
				),
			),
			'portfolio_loading_type'         => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Loading type', 'mrbara' ),
				'section'         => 'portfolio',
				'default'         => '1',
				'priority'        => 20,
				'choices'         => array(
					'1' => esc_html__( 'Type 1', 'mrbara' ),
					'2' => esc_html__( 'Type 2', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_nav_type',
						'operator' => '==',
						'value'    => 'ajax',
					),
				),
			),
			'portfolio_share_box'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Sharing Icons', 'mrbara' ),
				'section'     => 'portfolio',
				'default'     => 1,
				'description' => esc_html__( 'Display social sharing icons for each single portfolio page', 'mrbara' ),
				'priority'    => 20,
			),
			'portfolio_social_icons'         => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Social Icons', 'mrbara' ),
				'section'         => 'portfolio',
				'default'         => array( 'twitter', 'facebook', 'google', 'pinterest', 'linkedin' ),
				'priority'        => 40,
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'mrbara' ),
					'facebook'  => esc_html__( 'Facebook', 'mrbara' ),
					'google'    => esc_html__( 'Google Plus', 'mrbara' ),
					'pinterest' => esc_html__( 'Pinterest', 'mrbara' ),
					'linkedin'  => esc_html__( 'Linkedin', 'mrbara' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_share_box',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			// Footer
			'footer_layout'                  => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Footer Layout', 'mrbara' ),
				'description' => esc_html__( 'Select default layout for site footer', 'mrbara' ),
				'section'     => 'footer',
				'default'     => '1',
				'priority'    => 20,
				'choices'     => array(
					'1' => esc_html__( 'Layout 1', 'mrbara' ),
					'2' => esc_html__( 'Layout 2', 'mrbara' ),
					'3' => esc_html__( 'Layout 3', 'mrbara' ),
					'4' => esc_html__( 'Layout 4', 'mrbara' ),
					'5' => esc_html__( 'Layout 5', 'mrbara' ),
					'6' => esc_html__( 'Layout 6', 'mrbara' ),
					'7' => esc_html__( 'Layout 7', 'mrbara' ),
					'8' => esc_html__( 'Layout 8', 'mrbara' ),
					'9' => esc_html__( 'Layout 9', 'mrbara' ),
				),
			),
			'footer_skin'                    => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Footer Skin', 'mrbara' ),
				'section'         => 'footer',
				'default'         => 'light',
				'priority'        => 30,
				'choices'         => array(
					'light' => esc_html__( 'Light', 'mrbara' ),
					'dark'  => esc_html__( 'Dark', 'mrbara' ),
					'gray'  => esc_html__( 'Gray', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '4', '8', '7', '9' ),
					),
				),
			),
			'footer_width'                   => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Footer Width', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '1',
				'priority'        => 30,
				'choices'         => array(
					'1' => esc_html__( 'Default(1170px)', 'mrbara' ),
					'2' => esc_html__( 'Normal(1600px)', 'mrbara' ),
					'3' => esc_html__( 'Large(1780px)', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '4' ),
					),
				),
			),
			'footer_full_width'              => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Full Width', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '1',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '9' ),
					),
				),
			),
			'footer_widget_columns'          => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Footer Widget Columns', 'mrbara' ),
				'description'     => esc_html__( 'How many sidebar you want to show on footer', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '3',
				'priority'        => 30,
				'choices'         => array(
					'1' => esc_html__( '1 Column', 'mrbara' ),
					'2' => esc_html__( '2 Columns', 'mrbara' ),
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '8' ),
					),
				),
			),
			'footer_widget_columns_2'        => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Footer Widget Columns', 'mrbara' ),
				'description'     => esc_html__( 'How many sidebar you want to show on footer', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '4',
				'priority'        => 30,
				'choices'         => array(
					'1' => esc_html__( '1 Column', 'mrbara' ),
					'2' => esc_html__( '2 Columns', 'mrbara' ),
					'3' => esc_html__( '3 Columns', 'mrbara' ),
					'4' => esc_html__( '4 Columns', 'mrbara' ),
					'5' => esc_html__( '5 Columns', 'mrbara' ),
					'6' => esc_html__( '6 Columns', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '9' ),
					),
				),
			),
			'footer_widget_custom'           => array(
				'type'            => 'custom',
				'description'     => sprintf( wp_kses_post( 'Please go to <a href="%s">Widgets</a> to drag widgets to footer', 'mrbara' ), admin_url( 'widgets.php' ) ),
				'section'         => 'footer',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '8', '9' ),
					),
				),
			),
			'footer_logo'                    => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Footer Logo', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '',
				'priority'        => 40,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4' ),
					),
				),
			),
			'footer_news_letter'             => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer NewsLetter', 'mrbara' ),
				'description'     => sprintf( wp_kses_post( 'Please go to <a href="%s">MailChimp Forms</a> to get shortcode.', 'mrbara' ), admin_url( 'admin.php?page=mailchimp-for-wp-forms' ) ),
				'section'         => 'footer',
				'default'         => '',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '2' ),
					),
				),
			),
			'footer_links'                   => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer Links', 'mrbara' ),
				'description'     => esc_html__( 'Shortcodes are allowed', 'mrbara' ),
				'section'         => 'footer',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '8', '9' ),
					),
				),
			),
			'footer_payment'                 => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer Payment', 'mrbara' ),
				'description'     => esc_html__( 'Shortcodes are allowed', 'mrbara' ),
				'section'         => 'footer',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '8', '9' ),
					),
				),
			),
			'footer_copyright'               => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer Copyright', 'mrbara' ),
				'description'     => esc_html__( 'Shortcodes are allowed', 'mrbara' ),
				'section'         => 'footer',
				'default'         => esc_html__( 'Copyright &copy; 2016', 'mrbara' ),
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '2', '3', '4', '6', '8', '9' ),
					),
				),
			),
			'footer_copyright_view'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Footer Copyright View', 'mrbara' ),
				'section'         => 'footer',
				'default'         => '0',
				'priority'        => 50,
				'choices'         => array(
					'0' => esc_html__( 'Horizontal', 'mrbara' ),
					'2' => esc_html__( 'Vertical', 'mrbara' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '8', '9' ),
					),
				),
			),
			'footer_info'                    => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Footer Information', 'mrbara' ),
				'description'     => esc_html__( 'Shortcodes are allowed', 'mrbara' ),
				'section'         => 'footer',
				'priority'        => 50,
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '7' ),
					),
				),
			),
			'footer_socials'                 => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Socials', 'mrbara' ),
				'section'         => 'footer',
				'priority'        => 60,
				'default'         => array(
					array(
						'link_url' => 'https://facebook.com/mrbara',
					),
					array(
						'link_url' => 'https://twitter.com/mrbara',
					),
					array(
						'link_url' => 'https://plus.google.com/mrbara',
					),
				),
				'fields'          => array(

					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'mrbara' ),
						'description' => esc_html__( 'Enter the URL for this social', 'mrbara' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_layout',
						'operator' => 'in',
						'value'    => array( '1', '2', '3', '4', '5', '6' ),
					),
				),
			),

		),
	)
);