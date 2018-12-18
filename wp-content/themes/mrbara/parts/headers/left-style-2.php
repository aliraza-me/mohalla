<?php mrbara_icon_menu() ?>
<div class="menu-logo">
	<?php get_template_part( 'parts/logo' ); ?>
</div>
<div class="menu-extra">
	<ul id="left-menu-nav">
		<li class="extra-menu-item  menu-item-nav">
			<a href="#" class="item-menu-nav"><i class="t-icon ion-navicon"></i></a>
		</li>
		<?php
		mrbara_extra_search();
		mrbara_extra_cart();
		mrbara_extra_account();
		?>
	</ul>
</div>
<div class="menu-footer">

	<?php
	mrbara_footer_currency();
	mrbara_footer_language();

	$header_social = mrbara_theme_option( 'header_social' );

	if ( $header_social ) {


		$socials = mrbara_get_socials();

		printf( '<div class="socials">' );
		foreach( $header_social as $social ) {
			foreach( $socials as $name =>$label ) {
				$link_url = $social['link_url'];

				if( preg_match('/' . $name . '/',$link_url) ) {

					if( $name == 'google' ) {
						$name = 'googleplus';
					}

					printf( '<a href="%s" target="_blank"><i class="social social_%s"></i></a>', esc_url( $link_url ), esc_attr( $name ) );
					break;
				}
			}
		}
		printf( '</div>' );
	}


	?>
</div>