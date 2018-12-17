<?php
/**
 * Plugin Name: Mr.Bara WPBakery Page Builder Addons
 * Plugin URI: http://drfuri.com/mrbara
 * Description: Extra elements for WPBakery Page Builder. It was built for MrBara theme.
 * Version: 1.2.8
 * Author: DrFuri
 * Author URI: http://drfuri.com/
 * License: GPL2+
 * Text Domain: mrbara
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'MRBARA_ADDONS_DIR' ) ) {
	define( 'MRBARA_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MRBARA_ADDONS_URL' ) ) {
	define( 'MRBARA_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once MRBARA_ADDONS_DIR . '/inc/visual-composer.php';
require_once MRBARA_ADDONS_DIR . '/inc/shortcodes.php';

if( is_admin()) {
	require_once MRBARA_ADDONS_DIR . '/inc/importer.php';
}

/**
 * Init
 */
function mrbara_vc_addons_init() {
	load_plugin_textdomain( 'mrbara', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	add_image_size( 'team-member', 130, 130, true );
	add_image_size( 'mrbara-posts-grid', 678, 504, true );

	new MrBara_VC;
	new MrBara_Shortcodes;

}

add_action( 'after_setup_theme', 'mrbara_vc_addons_init', 20 );

