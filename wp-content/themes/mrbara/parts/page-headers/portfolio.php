<?php

if ( ! mrbara_theme_option( 'page_header_portfolio' ) ) {
	return;
}

?>

<div class="site-banner page-header text-center">
	<div class="container">
		<?php the_archive_title( '<h1>', '</h1>' ); ?>
		<?php mrbara_get_breadcrumbs(); ?>
		<?php mrbara_get_portfolio_desc(); ?>
	</div>
</div>
