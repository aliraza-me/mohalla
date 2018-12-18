<?php
/**
 * @package MrBara
 */

$class_css = 'blog-wapper';
$views     = mrbara_theme_option( 'blog_view' );
if ( $views == 'list' ) {
	$class_css .= ' col-md-12 col-sm-12 col-xs-12';
} else {
	$layout = mrbara_get_layout();
	if ( 'full-content' == $layout ) {
		$class_css .= ' col-md-4 col-sm-4 col-xs-12';
	} else {
		$class_css .= ' col-md-6 col-sm-6 col-xs-12';
	}
}


$index = 0;
global $wp_query;

if($wp_query && isset($wp_query->current_post)  ) {
	$index = $wp_query->current_post;
}

$image_size = 'thumbnail';
if( $views == 'masony' ) {
	$image_size = 'mrbara-blog-masonry-' . ($index + 1);

	if( $index == 3 ) {
		$image_size = 'mrbara-blog-masonry-2';
	}

	if( $index == 4 ) {
		$image_size = 'mrbara-blog-masonry-5';
	}

	if( $index == 5 ) {
		$image_size = 'mrbara-blog-masonry-3';
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class_css ); ?>>
	<header class="entry-header">
		<?php mrbara_entry_thumbnail( $image_size ); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php if ( $views != 'list' ) {?>
			<?php mrbara_posted_on(); ?>
		<?php } ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( $views == 'list' ) { ?>
			<?php mrbara_posted_on(); ?>
		<?php } ?>

		<div class="entry-desc">
			<?php the_excerpt(); ?>
		</div>

	</div>
	<footer class="entry-footer">
		<a class="readmore button" href="<?php the_permalink() ?>"><?php esc_html_e( 'Continue', 'mrbara' ) ?></a>
	</footer>
	<!-- .entry-content -->
</article><!-- #post-## -->
