<?php
if ( ! mrbara_theme_option( 'page_header_pages' ) ) {
	return;
} elseif ( get_post_meta( get_the_ID(), 'hide_page_header', true ) ) {
	return;
}
$show_breadcrumbs = true;
if( get_post_meta( get_the_ID(), 'hide_breadcrumb', true  ) ) {
	$show_breadcrumbs = false;
}
?>

<div class="site-banner page-header text-center">
	<div class="container">
		<?php if ( mrbara_page_header_layout() != '11' ) { ?>
			<?php the_archive_title( '<h1>', '</h1>' ); ?>
			<?php if( $show_breadcrumbs ) {
				mrbara_get_breadcrumbs();
			} ?>
		<?php } else { ?>
			<div class="row">
				<div class="col-md-8 col-sm-8 col-md-offset-4 col-sm-offset-4">
					<div class="page-header-content">
						<?php the_archive_title( '<h1>', '</h1>' ); ?>
						<?php if( $show_breadcrumbs ) {
							mrbara_get_breadcrumbs();
						} ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>