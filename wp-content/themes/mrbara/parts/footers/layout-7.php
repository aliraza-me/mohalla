<?php
$skins = mrbara_theme_option( 'footer_skin' ) . '-skin';
?>
<div class="footer-layout-7 <?php echo esc_attr( $skins ); ?>">
	<div class="container">
		<?php
		echo wp_kses( mrbara_theme_option( 'footer_info' ), wp_kses_allowed_html( 'post' ) );
		?>
	</div >
</div>