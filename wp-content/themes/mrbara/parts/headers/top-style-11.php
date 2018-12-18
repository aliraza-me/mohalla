<?php
$custom_product_categories_text = mrbara_theme_option( 'custom_product_categories_text' );
$menu_extra_class = 'extra-style-2';
$menu_class = '';
$header_style = mrbara_theme_option( 'header_style' );
if( $header_style == '11' ) {
	$menu_extra_class = '';
} elseif( $header_style == '13' ) {
	$menu_extra_class = 'extra-style-3';
	$menu_class = 'menu-style-3';
}

$cats_class = 'style-' . mrbara_theme_option( 'product_cats_menu_style' );
$open_class = '';
if ( intval( mrbara_theme_option( 'product_cats_menu_items_homepage' ) ) && ( is_front_page() || mrbara_is_homepage()) ) {
	$cats_class .= ' open-menu-items';
	$open_class = 'open';
}

if ( intval( mrbara_theme_option( 'product_cats_menu_items_type' ) ) ) {
	$cats_class .= ' on-hover';
} else {
	$cats_class .= ' on-click';
}
?>
<div class="container">
	<div class="header-main">
		<div class="row">
			<?php mrbara_icon_menu() ?>
			<div class="menu-logo col-md-3 col-sm-3">
				<?php get_template_part( 'parts/logo' ); ?>
			</div>
			<div class="menu-sidebar col-md-6 col-sm-6 <?php echo esc_attr( $menu_class ); ?>">
				<?php mrbara_extra_search(); ?>
			</div>
			<div class="menu-sideextra col-md-3 col-sm-3 <?php echo esc_attr( $menu_extra_class ); ?>">
				<ul>
					<?php
					if ( in_array( $header_style, array( '12', '13') ) ) {
						mrbara_extra_account();
					}

					if ( ! in_array( $header_style, array( '13') ) ) {
						mrbara_extra_cart();
						if ( $header_style == '11' ) {
							mrbara_extra_compare();
						}
						mrbara_extra_wislist();
					}
					?>
				</ul>
			</div>
			<div class="main-menu col-md-12 col-sm-12 <?php echo esc_attr( $menu_class ); ?>">
				<div class="row">
					<div class="col-md-3 col-sm-3 i-product-cats">
						<div class="products-cats-menu <?php echo esc_attr( $cats_class ); ?>">
							<?php
							if ( has_nav_menu( 'product_cats' ) ) {
								?>
								<h2 class="cats-menu-title"><?php echo esc_html( $custom_product_categories_text ); ?></h2>

								<div id="toggle-product-cats" class="toggle-product-cats <?php echo esc_attr( $open_class ); ?>">
									<?php
									wp_nav_menu(
										array(
											'theme_location' => 'product_cats',
											'container'      => false,
											'walker'         => new MrBara_Mega_Menu_Walker()
										)
									);
									?>
								</div>
								<?php
							}
							?>

						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-nav-menu">
						<div class="primary-nav nav">
							<?php mrbara_header_menu(); ?>
							<?php if ( $header_style == '11' ) : ?>
								<ul class="menu-sideextra">
									<?php
									mrbara_extra_account();
									?>
								</ul>
							<?php endif; ?>

							<?php if ( in_array( $header_style, array( '13') ) ) : ?>
								<ul class="menu-sideextra">
									<?php
									mrbara_extra_cart();
									mrbara_extra_compare();
									mrbara_extra_wislist();
									?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>