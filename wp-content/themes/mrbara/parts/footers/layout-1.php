<?php
$footer_class = 'footer-layout-' . mrbara_theme_option( 'footer_layout' );
$footer_skin = mrbara_theme_option( 'footer_skin' ) ;
$logo         = get_template_directory_uri() . '/img/logo/logo-footer-light.png';
if ( in_array( $footer_skin , array( 'gray', 'light')) ) {
	$logo         = get_template_directory_uri() . '/img/logo/logo-5.png';
}
$footer_class .= ' ' . mrbara_theme_option( 'footer_skin' ) . '-skin';
?>

<div id="footer-widgets" class="footer-widgets <?php echo esc_attr( $footer_class ); ?> widgets-area">
	<div class="mr-container-fluid">
		<div class="footer-main">
			<?php mrbara_footer_logo( $logo ); ?>
			<div class="container footer-widget-main">
				<div class="row">
					<?php mrbara_footer_widget(); ?>
				</div>
			</div>
			<div class="footer-extras">
				<?php
				mrbara_footer_language();
				mrbara_footer_currency();
				mrbara_footer_socials();
				?>
			</div>
		</div>
	</div>
</div>