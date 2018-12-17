<?php
/**
 * The template used for displaying course content in single.php
 *
 * @package MrBara
 */

global $post;
$class_css = 'blog-wapper col-md-6 col-sm-6 col-xs-12';
$post_per_page = '2';
if ( 'full-content' == mrbara_get_layout() ) {
	$class_css = ' blog-wapper col-md-4 col-sm-4 col-xs-12';
	$post_per_page = '3';
}

$related = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => apply_filters( 'mrbara_related_posts_per_page', $post_per_page ),
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'order'               => 'rand',
		'post__not_in'        => array( $post->ID ),
		'tax_query'           => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => mrbara_get_related_terms( 'category', $post->ID ),
				'operator' => 'IN',
			),
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => mrbara_get_related_terms( 'post_tag', $post->ID ),
				'operator' => 'IN',
			),
		),
	)
);
?>


<?php if ( $related->have_posts() ) : ?>
	<div class="related-post">
		<h2 class="related-title"><?php esc_html_e( ' Related Posts', 'mrbara' ); ?> </h2>
	</div>
	<div class="row">
		<?php while ( $related->have_posts() ) : $related->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( $class_css ); ?>>
				<div class="entry-header">
					<?php mrbara_entry_thumbnail( 'mrbara-blog-normal' ); ?>
				</div>
				<!-- .entry-header -->
				<div class="entry-content">
					<?php mrbara_posted_on(); ?>
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" class="post-title" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</div>
				<div class="entry-footer">
					<a class="readmore" href="<?php the_permalink() ?>"><?php esc_html_e( 'Continue', 'mrbara' ) ?></a>
				</div>
				<!-- .entry-content -->
			</article><!-- #post-## -->
		<?php endwhile; ?>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>