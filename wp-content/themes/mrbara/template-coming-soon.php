<?php
/**
 * Template Name: Coming Soon
 *
 * The template file for display coming soon page
 *
 * @package MrBara
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<header class="coming-header">
		<?php

		$logo_coming = get_post_meta( get_the_ID(), 'logo_comingsoon', true );

		if ( $logo_coming ) {
			$image = wp_get_attachment_image_src( $logo_coming, 'full' );
			if ( $image ) {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="logo-coming"><img alt="logo-coming-soon" src="' . esc_url( $image[0] ) . '"></a>';
			}
		}

		$socials = apply_filters(
			'mrbara_comingsoon_socials', array(
			'facebook'   => esc_html__( 'Facebook', 'mrbara' ),
			'twitter'    => esc_html__( 'Twitter', 'mrbara' ),
			'googleplus' => esc_html__( 'Google Plus', 'mrbara' ),
			'linkedin'   => esc_html__( 'LinkedIn', 'mrbara' ),
			'pinterest'  => esc_html__( 'Pinterest', 'mrbara' ),
			'dribbble'   => esc_html__( 'Dribbble', 'mrbara' ),
			'youtube'    => esc_html__( 'Youtube', 'mrbara' ),
			'vimeo'      => esc_html__( 'Vimeo', 'mrbara' ),
		)
		);

		$socials_html = array();
		foreach ( $socials as $key => $value ) {
			$meta = get_post_meta( get_the_ID(), 'socials_' . $key, true );
			if ( $meta ) {
				$socials_html[] = sprintf( '<a href="%s"><i class="ion-social-%s"></i></a> ', esc_url( $meta ), esc_attr( $key ) );
			}
		}

		if ( $socials_html ) {
			printf( '<div class="coming-socials"><div class="socials-list">%s</div><h3>%s</h3></div>', implode( '', $socials_html ), esc_html__( 'Follow us on', 'mrbara' ) );
		}

		?>
	</header>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
	endif;

	?>
	<footer class="coming-footer">
		<?php
		$location_coming = get_post_meta( get_the_ID(), 'location_comingsoon', true );

		if ( $location_coming ) {
			printf(
				'<div class="location-coming">
				<div class="title">%s</div>
				<div class="desc">%s</div>
			</div>',
				esc_html__( 'Location', 'mrbara' ),
				$location_coming
			);
		}

		$phone_comingsoon = get_post_meta( get_the_ID(), 'phone_comingsoon', true );

		if ( $phone_comingsoon ) {
			printf(
				'<div class="phone-coming">
				<div class="title">%s</div>
				<div class="desc">%s</div>
			</div>',
				esc_html__( 'Phone', 'mrbara' ),
				$phone_comingsoon
			);
		}
		?>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>