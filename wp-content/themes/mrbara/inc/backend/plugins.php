<?php
/**
 * Register required, recommended plugins for theme
 *
 * @package MrBara
 */

/**
 * Register required plugins
 *
 * @since  1.0
 */
function mrbara_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'Meta Box', 'mrbara' ),
			'slug'               => 'meta-box',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Kirki', 'mrbara' ),
			'slug'               => 'kirki',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WPBakery Page Builder', 'mrbara' ),
			'slug'               => 'js_composer',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/js_composer.zip' ),
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '5.1.1',
		),
		array(
			'name'               => esc_html__( 'MrBara WPBakery Page Builder Addons', 'mrbara' ),
			'slug'               => 'mrbara-vc-addons',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/mrbara-vc-addons.zip' ),
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.2.8',
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'mrbara' ),
			'slug'               => 'woocommerce',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'YITH WooCommerce Wishlist', 'mrbara' ),
			'slug'               => 'yith-woocommerce-wishlist',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'YITH WooCommerce Compare', 'mrbara' ),
			'slug'               => 'yith-woocommerce-compare',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Revolution Slider', 'mrbara' ),
			'slug'               => 'revslider',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/revslider.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '5.4.5.1',
		),
		array(
			'name'               => esc_html__( 'DF Team', 'mrbara' ),
			'slug'               => 'df-team',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/df-team.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.0',
		),
		array(
			'name'               => esc_html__( 'DF Testimonial', 'mrbara' ),
			'slug'               => 'df-testimonial',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/df-testimonial.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.1',
		),
		array(
			'name'               => esc_html__( 'DF Portfolio', 'mrbara' ),
			'slug'               => 'df-portfolio',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/df-portfolio.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.0',
		),
		array(
			'name'               => esc_html__( 'Soo Product Attribute Swatches', 'mrbara' ),
			'slug'               => 'soo-product-attribute-swatches',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/soo-product-attribute-swatches.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.3',
		),
		array(
			'name'               => esc_html__( 'Soo Product Filter', 'mrbara' ),
			'slug'               => 'soo-product-filter',
			'source'             => esc_url( 'http://demo2.drfuri.com/plugins/soo-product-filter.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.0.2',
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'mrbara' ),
			'slug'               => 'contact-form-7',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'mrbara' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
	);
	$config  = array(
		'domain'       => 'mrbara',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'mrbara' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'mrbara' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'mrbara' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'mrbara' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'mrbara' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'mrbara' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'mrbara' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'mrbara' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'mrbara' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'mrbara' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'mrbara' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'mrbara' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'mrbara' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'mrbara' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'mrbara' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'mrbara' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'mrbara' ),
			'nag_type'                        => 'updated',
		),
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'mrbara_register_required_plugins' );