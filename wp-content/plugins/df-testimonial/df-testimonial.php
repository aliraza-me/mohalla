<?php
/*
 * Plugin Name: DF Testimonial
 * Version: 1.0.1
 * Plugin URI: http://drfuri.com/
 * Description: Create and manage testimonial in the easiest way.
 * Author: DrFuri
 * Author URI: http://drfuri.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Define constants **/
define( 'DF_TESTIMONIAL_VER', '1.0.1' );
define( 'DF_TESTIMONIAL_DIR', plugin_dir_path( __FILE__ ) );
define( 'DF_TESTIMONIAL_URL', plugin_dir_url( __FILE__ ) );

/** Load files **/
require_once DF_TESTIMONIAL_DIR . '/inc/class-testimonial.php';
require_once DF_TESTIMONIAL_DIR . '/inc/frontend.php';

new DF_Testimonial;

/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function df_testimonial_load_text_domain() {
	load_plugin_textdomain( 'df-testimonial', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'df_testimonial_load_text_domain' );
