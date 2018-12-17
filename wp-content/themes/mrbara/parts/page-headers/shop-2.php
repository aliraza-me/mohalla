<?php
if ( ! mrbara_is_catalog() ) {
	return;

}

if ( mrbara_theme_option( 'page_header_layout_shop' ) != '5' ) {
	return;
}

if ( ! intval( mrbara_theme_option( 'page_header_shop' ) ) ) {
	return;
}

if ( ( function_exists( 'is_shop' ) && is_shop() ) ) {
	if ( get_post_meta( intval( get_option( 'woocommerce_shop_page_id' ) ), 'hide_page_header', true ) ) {
		return;
	}
}

?>
<div class="site-banner page-header">
	<?php mrbara_get_breadcrumbs(); ?>
	<div class="page-header-content">
		<?php the_archive_title( '<h1>', '</h1>' ); ?>
	</div>
</div>