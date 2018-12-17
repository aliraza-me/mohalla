<?php
/**
 * Template for displaying search forms in MrBara
 *
 * @package WordPress
 * @subpackage MrBara
 * @since 1.0
 * @version 1.0
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'mrbara' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php  esc_html_e( 'Search &hellip;', 'mrbara' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit" value="<?php esc_html_e('Search', 'mrbara'); ?>">
</form>
