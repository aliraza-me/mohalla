<?php
/**
 * Template for displaying single portfolio
 *
 * @package MrBara
 */

get_header(); ?>

<div id="primary" class="content-area">
	<?php while ( have_posts() ) :
		the_post(); ?>

		<?php get_template_part( 'parts/content-single', 'portfolio' ); ?>

		<?php
		$container = 'container';
		if ( get_post_meta( get_the_ID(), '_project_type', true ) == 'image' ) {
			$container = 'container-full';
		}
		?>
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
		</div>
	<?php endwhile; ?>

</div>
<?php get_footer(); ?>
