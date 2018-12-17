<?php
/**
 * Display Tesimonial on frontend
 *
 * @package DF Tesimonial
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
function df_testimonial_get_template( $template ) {
	if ( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = DF_TESTIMONIAL_DIR . 'template/' . $template;
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
function df_testimonial_template_include( $template ) {
	if ( is_singular( 'testimonial' ) ) {
		return df_testimonial_get_template( 'single-testimonial.php' );
	}

	return $template;
}

add_filter( 'template_include', 'df_testimonial_template_include' );
