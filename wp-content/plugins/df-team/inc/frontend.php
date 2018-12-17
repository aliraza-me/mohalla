<?php
/**
 * Display Team on frontend
 *
 * @package DF Team Management
 */

/**
 * Load template file for team_member single
 * Check if a custom template exists in the theme folder,
 * if not, load template file in plugin
 *
 * @since  1.0.0
 *
 * @param  string $template Template name with extension
 *
 * @return string
 */
function df_team_get_template( $template ) {
	if ( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = DF_TEAM_DIR . 'template/' . $template;
	}

	return apply_filters( __FUNCTION__, $file, $template );
}

/**
 * Load template file for team member single
 *
 * @since  1.0.0
 *
 * @param  string $template
 *
 * @return string
 */
function df_team_template_include( $template ) {
	if ( is_singular( 'team_member' ) ) {
		return df_team_get_template( 'single-team_member.php' );
	}

	return $template;
}

add_filter( 'template_include', 'df_team_template_include' );


