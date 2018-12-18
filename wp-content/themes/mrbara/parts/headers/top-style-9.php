<?php
$custom_search_textbox = mrbara_theme_option( 'custom_search_textbox' );
?>
<div class="container">
	<div class="header-main">
		<div class="row">
			<div class="col-md-3 col-sm-3 navbar-menu">
				<?php mrbara_icon_menu() ?>
			</div>
			<div class="col-md-4 hidden-sm hidden-xs menu-search">
				<form class="products-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="text" name="s" id="search-field-auto" class="search-field" placeholder="<?php echo esc_attr( $custom_search_textbox ); ?> ">
					<input type="hidden" name="post_type" value="product">
					<input type="submit" value="<?php esc_attr_e( 'Search', 'mrbara' ); ?>" class="search-submit">
				</form>
			</div>
			<div class="menu-logo col-md-4 col-sm-4">
				<?php get_template_part( 'parts/logo' ); ?>
			</div>
			<div class="menu-sidebar col-md-4 col-sm-4">
				<ul class="menu-sideextra">
					<?php
					mrbara_extra_cart();
					mrbara_extra_account();
					?>
				</ul>
			</div>
			<div class="col-md-12 hidden-sm hidden-xs menu-nav">
				<div class="primary-nav nav">
					<div class="menu-logo">
						<?php
						$logo2 = mrbara_theme_option( 'logo' );
						if ( ! $logo2 ) {
							$logo2 = get_template_directory_uri() . '/img/logo/logo.png';
						}
						?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
							<img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $logo2 ); ?>" />
						</a>
					</div>
					<?php mrbara_header_menu(); ?>
				</div>
			</div>
		</div>
	</div>
</div>