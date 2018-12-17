<?php
/*
 * Plugin Name: DF Team
 * Version: 1.0.0
 * Plugin URI: http://drfuri.com/
 * Description: Create and manage your team member present them in the easiest way.
 * Author: DrFuri
 * Author URI: http://drfuri.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Define constants **/
define( 'DF_TEAM_VER', '1.0.0' );
define( 'DF_TEAM_DIR', plugin_dir_path( __FILE__ ) );
define( 'DF_TEAM_URL', plugin_dir_url( __FILE__ ) );

/** Load files **/
require_once DF_TEAM_DIR . '/inc/class-team-member.php';
require_once DF_TEAM_DIR . '/inc/frontend.php';

new DF_Team_Member;

/**
 * Add image sizes
 *
 * @since  1.0.0
 *
 * @return void
 */
function df_team_image_sizes_init() {
	add_image_size( 'team-member', 300, 300, true );
}

add_action( 'init', 'df_team_image_sizes_init' );

/**
 * Load language file
 *
 * @since  1.0.0
 *
 * @return void
 */
function df_team_load_text_domain() {
	load_plugin_textdomain( 'df-team', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

add_action( 'init', 'df_team_load_text_domain' );
