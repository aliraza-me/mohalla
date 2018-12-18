<?php
$footer_class = 'footer-layout-' . mrbara_theme_option( 'footer_layout' );
$logo         = get_template_directory_uri() . '/img/logo/logo-footer-dark.png';
$container    = 'container';
if ( mrbara_theme_option( 'footer_width' ) != '1' ) {
	$footer_class .= ' footer-width-' . mrbara_theme_option( 'footer_width' );
	$container   = 'mr-container-fluid';
}

$footer_class .= ' ' . mrbara_theme_option( 'footer_skin' ) . '-skin';

if ( mrbara_theme_option( 'footer_skin' ) == 'dark' ) {
	$logo = get_template_directory_uri() . '/img/logo/logo-footer-light.png';
}
?>

<div class="footer-vertical <?php echo esc_attr( $footer_class ); ?>">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row">
			<div class="col-lg-5 col-md-12 col-sm-12">
				<?php mrbara_footer_menu(); ?>
			</div>
			<div class="col-lg-2 col-md-12 col-sm-12 col-logo text-center">
				<?php mrbara_footer_logo( $logo, 'text-center' ); ?>

			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 text-right">
				<?php mrbara_footer_socials( true ); ?>
			</div>
			<div class="col-md-12 col-sm-12 text-center footer-copyright">
				<?php mrbara_footer_copyright(); ?>
			</div>
		</div>
	</div>
</div>