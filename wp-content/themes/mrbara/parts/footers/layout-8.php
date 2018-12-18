<?php
$skins = mrbara_theme_option( 'footer_skin' ) . '-skin';
if ( mrbara_theme_option( 'footer_copyright_view' ) == '2' ) {
	$skins .= ' footer-copyright-2';
}

$class_container = 'container';
if( mrbara_theme_option( 'footer_layout' ) == '9' && intval( mrbara_theme_option('footer_full_width') ) ) {
	$class_container = 'mr-container-fluid';
}

?>

<div id="footer-widgets" class="footer-widgets footer-layout-8 widgets-area  <?php echo esc_attr( $skins ); ?>">
	<div class="<?php echo esc_attr( $class_container ); ?>">
		<div class="footer-main">
			<div class="row">
				<?php mrbara_footer_widget(); ?>
			</div>
		</div>
		<?php if ( $footer_links = mrbara_theme_option( 'footer_links' ) ) { ?>
			<div class="footer-quicklinks">
				<?php echo do_shortcode( $footer_links ); ?>
			</div>
		<?php } ?>
		<?php if ( mrbara_theme_option( 'footer_copyright_view' ) == '2' ) { ?>
			<div class="footer-copyright-vertical">
				<div class="row">
					<div class="footer-copyright col-md-5 col-sm-12">
						<?php mrbara_footer_copyright(); ?>
					</div>
					<div class="footer-payment col-md-7 col-sm-12">
						<?php mrbara_footer_payment(); ?>
					</div>
				</div>
			</div>

		<?php } else { ?>
			<div class="footer-payment">
				<?php mrbara_footer_payment(); ?>
			</div>
			<div class="footer-copyright">
				<?php mrbara_footer_copyright(); ?>
			</div>
		<?php } ?>
	</div>
</div>