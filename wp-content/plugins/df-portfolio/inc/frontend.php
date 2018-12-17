<?php
/**
 * Display portfolio on frontend
 *
 * @package DF Portfolio Management
 */

/**
 * Load template file for portfolio
 * Check if a custom template exists in the theme folder,
 * if not, load template file in plugin
 *
 * @since  1.0.0
 *
 * @param  string $template Template name with extension
 *
 * @return string
 */
function df_portfolio_get_template( $template ) {
	if( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	} else {
		$file = DF_PORTFOLIO_DIR . 'template/' . $template;
	}

	return apply_filters( __FUNCTION__, $file, $template );
}

/**
 * Load template file for portfolio single
 *
 * @since  1.0.0
 *
 * @param  string $template
 *
 * @return string
 */
function df_portfolio_template_include( $template ) {
	if( is_singular( 'portfolio_project' ) ) {
		return df_portfolio_get_template( 'single-portfolio.php' );
	}

	return $template;
}

add_filter( 'template_include', 'df_portfolio_template_include' );

