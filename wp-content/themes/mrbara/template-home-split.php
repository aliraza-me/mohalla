<?php
/**
 * Template Name: Home Split
 *
 * The template file for displaying homepage in split layout.
 * This page use all its child pages as slides
 *
 * @package MrBara
 */

get_header();

if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		$sections = get_pages(
			array(
				'sort_column'  => 'menu_order',
				'hierarchical' => 0,
				'parent'       => get_the_ID(),
			)
		);

		if ( $sections ) {
			$left_sections = array();
			$right_sections = array();
			$mobile_sections = array();

			foreach ( $sections as $index => $section ) {
				$content = sprintf(
					'<div class="section-content ms-section %s %s">' .
						'<div class="title">%s</div>' .
						'<div class="content"><div class="section-no">%s</div>%s</div>' .
					'</div>',
					$index % 2 ? 'section-odd' : 'section-even',
					$index === 0 ? 'loaded' : '',
					apply_filters( 'the_title', $section->post_title, $section->ID ),
					sprintf( '%02d', $index + 1 ),
					apply_filters( 'the_content', $section->post_content )
				);

				$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($section->ID), 'full' );


				if( $image_src ) {
					$image_src = 'style="background-image:url(' . esc_url( $image_src[0] ) . ')"';
				}

				$image = sprintf( '<div class="section-image ms-section" %s></div>', $image_src );

				if ( $index % 2 ) {
					$left_sections[] = $image;
					$right_sections[] = $content;
				} else {
					$left_sections[] = $content;
					$right_sections[] = $image;
				}

				$mobile_sections[] = sprintf( '<div class="section-image ms-section">%s</div>', get_the_post_thumbnail( $section->ID, 'full' ) );;

				$mobile_sections[] = $content;
			}

			// Print output
			?>

			<div id="split-scroll" class="split-scroll">
				<div class="ms-left">
					<?php echo implode( "\n\t", $left_sections ) ?>
				</div>
				<div class="ms-right">
					<?php echo implode( "\n\t", $right_sections ) ?>
				</div>
			</div>

			<div class="split-scroll-mobile split-scroll" id="split-scroll-mobile">
				<?php echo implode( "\n\t", $mobile_sections ) ?>
			</div>

			<?php if ( count( $left_sections ) > 1 ) : ?>
				<div id="split-scroll-nav" class="split-scroll-nav">
					<a href="#" class="scrollup"><i class="ion-android-arrow-up"></i></a>
					<a href="#" class="scrolldown"><i class="ion-android-arrow-down"></i></a>
				</div>
			<?php endif; ?>

			<?php
		}

	endwhile;

endif;

get_footer();