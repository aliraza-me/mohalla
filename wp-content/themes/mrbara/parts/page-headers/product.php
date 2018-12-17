<?php

if ( intval( get_post_meta( get_the_ID(), 'hide_page_header', true ) ) ) {
	return false;
}

if ( ! intval( mrbara_theme_option( 'page_header_product' ) ) ) {
	return;
}

$header_product_layout = mrbara_theme_option( 'page_header_layout_product' );
if ( intval( get_post_meta( get_the_ID(), 'custom_page_header_layout', true ) ) ) {
	$header_product_layout = get_post_meta( get_the_ID(), 'page_header_layout', true );

}

$css_class = '';
if ( in_array( $header_product_layout, array( '3' ) ) ) {
	if ( intval( mrbara_theme_option( 'bg_product_parallax' ) ) ) {
		$css_class = 'parallax no-parallax-mobile';
	}
}

?>

<div class="site-banner page-header text-center <?php echo esc_attr( $css_class ) ?>">
	<div class="container">
		<?php if ( $header_product_layout != '2' ) { ?>
			<?php
			if ( intval( mrbara_theme_option( 'page_header_product_title' ) ) ) {
				the_archive_title( '<h1>', '</h1>' );
			}
			?>
			<?php if ( intval( mrbara_theme_option( 'page_header_product_breadcrumb' ) ) ) {
				mrbara_get_breadcrumbs();
			} ?>
		<?php } else { ?>
			<div class="row">
				<div class="col-md-8 col-sm-12 col-md-offset-4">
					<div class="page-header-content">
						<?php
						if ( intval( mrbara_theme_option( 'page_header_product_title' ) ) ) {
							the_archive_title( '<h1>', '</h1>' );
						}
						?>
						<?php if ( intval( mrbara_theme_option( 'page_header_product_breadcrumb' ) ) ) {
							mrbara_get_breadcrumbs();
						} ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>