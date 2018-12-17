<?php
/**
 * @package MrBara
 */

$class_css = 'blog-wapper';
$class_css .= ' col-md-4 col-sm-4 col-xs-12';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class_css ); ?>>
	<header class="entry-header">
		<?php mrbara_entry_thumbnail( 'mrbara-blog-normal' ); ?>
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php mrbara_posted_on(); ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="entry-desc">
			<?php mrbara_content_limit( get_the_excerpt(), 30, '', true); ?>
		</div>

	</div>
	<footer class="entry-footer">
		<a class="readmore button" href="<?php the_permalink() ?>"><?php esc_html_e( 'Continue', 'mrbara' ) ?></a>
	</footer>
	<!-- .entry-content -->
</article><!-- #post-## -->
