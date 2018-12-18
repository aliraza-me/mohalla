<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package MrBara
 */

if ( 'full-content' == mrbara_get_layout() ) {
	return;
}

$sidebar = 'blog-sidebar';
$css_class = '';
if( mrbara_class_full_width() == 'mr-container-fluid' ) {
	$css_class = ' col-xs-12 col-sm-12 col-md-2';
} else {
	$css_class = ' col-xs-12 col-sm-12 col-md-3';
}

if ( mrbara_is_catalog() ) {
	$sidebar = 'shop-sidebar';
	if( mrbara_class_full_width() == 'mr-container-fluid' ) {
		$css_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-2';
	} else {
		$css_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-3';
	}
}  elseif ( function_exists( 'is_product' ) && is_product() ) {
	$sidebar = 'product-sidebar';
	if(  mrbara_theme_option( 'product_columns_mobile' ) == '2' ) {
		$css_class = ' col-xs-5 col-sm-6 col-md-3 mr-columns-2';
	}
}  elseif ( is_post_type_archive('portfolio_project') || is_tax( 'portfolio_category' ) ) {
	$sidebar = 'portfolio-sidebar';
} elseif ( is_page() ) {
	$sidebar = 'page-sidebar';
}

$css_class .= ' ' . $sidebar;

?>
<aside id="primary-sidebar" class="widgets-area primary-sidebar <?php echo esc_attr( $css_class ) ?>" >
	<?php dynamic_sidebar( $sidebar ) ?>
</aside><!-- #secondary -->
