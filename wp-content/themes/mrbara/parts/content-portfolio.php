<?php
/**
 * @package MrBara
 */

$columns     = intval(mrbara_theme_option( 'portfolio_columns' ));
$css_class = 'portfolio-wapper';

$index = 0;
global $wp_query;

if($wp_query && isset($wp_query->current_post)  ) {
	$index = $wp_query->current_post;
}
$image_size = 'mrbara-portfolio-grid';
if( mrbara_theme_option( 'portfolios_view' ) == 'masonry' ) {
	$image_size = 'mrbara-portfolio-normal';
	if( $columns == 2 ) {
		if ( $index % 8 == 1 || $index % 8 == 3 ) {
			$image_size = 'mrbara-portfolio-full';
			$css_class  .= ' portfolio-item-full';
		} elseif ( $index % 8 == 7 ) {
			$image_size = 'mrbara-portfolio-wide';
			$css_class  .= ' portfolio-item-wide';
		}
	} else {
		if ( $index % 9 == 1 || $index % 9 == 6 || $index % 9 == 4 ) {
			$image_size = 'mrbara-portfolio-long';
			$css_class  .= ' portfolio-item-long';
		} elseif ( $index % 9 == 8 ) {
			$image_size = 'mrbara-portfolio-small';
			$css_class  .= ' portfolio-item-small';
		}
	}
}

$cats = wp_get_post_terms( get_the_ID(), 'portfolio_category' );

$cat_name = '<div class="cats-list">';
if ( $cats ) {
	foreach ( $cats as $cat ) {
		$cat_name .= sprintf(
			'<a href="%s" class="portfolio-cat">%s<i class="split">, </i></a>',
			esc_url( get_term_link( $cat->term_id ) ),
			esc_attr( $cat->name )
		);

	}

}
$cat_name .= '</div>';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($css_class) ); ?>>
	<div class="entry-content">
		<?php
		mrbara_portfolio_thumbnail( $image_size );
		printf( '<a href="%s" class="icon-link"><i class="ion-ios-plus-empty"></i></a>', esc_url( get_the_permalink() ) );
		?>
		<?php if( mrbara_theme_option( 'portfolios_view' ) == 'masonry' ) { ?>
			<div class="entry-footer">
				<?php
				echo $cat_name;
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="portfolio-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				?>
			</div>
		<?php } ?>

	</div>
	<?php if( mrbara_theme_option( 'portfolios_view' ) == 'grid' ) { ?>
		<div class="entry-footer">
			<?php
			echo $cat_name;
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="portfolio-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			?>
		</div>
	<?php } ?>
	<!-- .entry-content -->
</article><!-- #post-## -->
