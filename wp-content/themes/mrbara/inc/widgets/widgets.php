<?php
/**
 * Load and register widgets
 *
 * @package MrBara
 */

require_once get_template_directory() . '/inc/widgets/recent-posts.php';
require_once get_template_directory() . '/inc/widgets/tabs.php';
require_once get_template_directory() . '/inc/widgets/social-media-links.php';
require_once get_template_directory() . '/inc/widgets/tweets.php';
require_once get_template_directory() . '/inc/widgets/product-sort-by.php';

/**
 * Register widgets
 *
 * @since  1.0
 *
 * @return void
 */
function mrbara_register_widgets() {
	register_widget( 'MrBara_Recent_Posts_Widget' );
	register_widget( 'MrBara_Tabs_Widget' );
	register_widget( 'MrBara_Social_Links_Widget' );
	register_widget( 'MrBara_Tweets_Widget' );
	register_widget( 'MrBara_Product_ShortBy_Widget' );
}
add_action( 'widgets_init', 'mrbara_register_widgets' );