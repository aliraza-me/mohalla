<?php
$page_header_layout_shop = mrbara_theme_option( 'page_header_layout_shop' );

if ( $page_header_layout_shop == '5' ) {
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

$css_class = '';
if ( in_array(mrbara_theme_option( 'page_header_layout_shop' ), array( '2') ) ) {
	if(  intval(mrbara_theme_option('bg_shop_parallax') ) ) {
		$css_class = 'parallax no-parallax-mobile';
	}
}
?>

<div class="site-banner page-header text-center <?php echo esc_attr( $css_class )?>">
	<?php
	if ( $page_header_layout_shop == '4' ) :

		$css_class     = 'col-md-12 col-sm-12';
		if ( mrbara_get_layout() == 'sidebar-content' ) {
			$css_class = 'col-md-10 col-sm-10 col-md-offset-2 col-sm-offset-2';

			if ( mrbara_class_full_width() != 'mr-container-fluid' ) {
				$css_class = 'col-md-9 col-sm-9 col-md-offset-3 col-sm-offset-3';
			}
		}
		$class_content = mrbara_class_full_width();
		?>
		<div class="page-header-content <?php echo esc_attr( $class_content ); ?>">
			<div class="row">
				<div class="col-bread <?php echo esc_attr( $css_class ); ?>">
					<?php the_archive_title( '<h1>', '</h1>' ); ?>
					<?php mrbara_get_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="container page-header-content">
			<?php if ( $page_header_layout_shop != '3' ) { ?>
				<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php } ?>

			<?php if ( $page_header_layout_shop != '6' ) { ?>
				<?php mrbara_get_breadcrumbs(); ?>
			<?php } else { ?>
				<?php  mrbara_get_shop_desc(); ?>
			<?php } ?>
			<?php if ( $page_header_layout_shop == '3' ) : ?>
				<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>