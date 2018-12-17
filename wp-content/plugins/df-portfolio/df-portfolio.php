<?php
/*
 * Plugin Name: DF Portfolio Management
 * Version: 1.0.0
 * Plugin URI: http://drfuri.com
 * Description: Create and manage your works you have done and present them in the easiest way.
 * Author: DrFuri
 * Author URI: http://drfuri.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DF_PORTFOLIO_DIR', plugin_dir_path( __FILE__ ) );
define( 'DF_PORTFOLIO_URL', plugin_dir_url( __FILE__ ) );

/** Load files */
require_once DF_PORTFOLIO_DIR . '/inc/class-portfolio.php';
require_once DF_PORTFOLIO_DIR . '/inc/frontend.php';

new DF_Portfolio;


/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function df_portfolio_load_text_domain() {
	load_plugin_textdomain( 'df-portfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'df_portfolio_load_text_domain' );
