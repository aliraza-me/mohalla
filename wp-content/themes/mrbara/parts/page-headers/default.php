<?php

$show_breadcrumbs = true;
if ( ! is_singular( 'post' ) ) {

	if ( ! mrbara_theme_option( 'page_header' ) ) {
		return;
	}

	if ( is_home() && ! is_front_page() ) {
		$post_id = get_queried_object_id();
		if ( get_post_meta( $post_id, 'hide_page_header', true ) ) {
			return;
		}

		if( get_post_meta( $post_id, 'hide_breadcrumb', true  ) ) {
			$show_breadcrumbs = false;
		}
	}

}

if( get_post_meta( get_the_ID(), 'hide_breadcrumb', true  ) ) {
	$show_breadcrumbs = false;
}

?>

<div class="site-banner page-header text-center">
	<div class="container">
		<?php the_archive_title( '<h1>', '</h1>' ); ?>
		<?php
		if( $show_breadcrumbs ) {
			mrbara_get_breadcrumbs();
		}
		?>
	</div>
</div>