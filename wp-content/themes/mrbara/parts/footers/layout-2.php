<?php
$footer_class   = 'footer-layout-' . mrbara_theme_option( 'footer_layout' );
$footer_skin    = mrbara_theme_option( 'footer_skin' );
$logo           = get_template_directory_uri() . '/img/logo/logo-5-light.png';
$col_logo       = 'col-md-5';
$col_newsletter = 'col-md-4';
$col_socials    = 'col-md-3';
if ( in_array( $footer_skin, array( 'gray', 'light' ) ) ) {
	$logo = get_template_directory_uri() . '/img/logo/logo-footer-dark.png';
	$col_logo   = $col_newsletter = $col_socials   = 'col-md-4';
}
$footer_class .= ' ' . mrbara_theme_option( 'footer_skin' ) . '-skin';
?>

<nav id="footer-extra" class="<?php echo esc_attr( $footer_class ); ?>">
	<div class="footer-nav">
		<div class="container">
			<div class="row">
				<div class="<?php echo esc_attr( $col_logo ); ?> col-sm-4">
					<?php mrbara_footer_logo( $logo ); ?>
				</div>
				<div class="<?php echo esc_attr( $col_newsletter ); ?> col-sm-5 text-right col-right">
					<div class="footer-newsletter">
						<?php mrbara_footer_newsletter(); ?>
					</div>
				</div>
				<div class="<?php echo esc_attr( $col_socials ); ?> col-sm-3">
					<?php mrbara_footer_socials(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 text-left">
					<?php mrbara_footer_copyright(); ?>
				</div>
				<div class="col-md-6 col-sm-6 text-right">
					<?php mrbara_footer_menu() ?>
				</div>
			</div>
		</div>
	</div>

</nav>