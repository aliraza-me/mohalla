<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package MrBara
 */

get_header(); ?>

<?php
$columns = intval( mrbara_theme_option( 'portfolio_columns' ) );

$css_class = 'portfolio-' . $columns . '-columns';
?>
<div id="primary" class="content-area <?php mrbara_content_columns() ?>">
	<main id="main" class="site-main  portfolio-showcase <?php echo esc_attr( $css_class ); ?>">

		<?php if ( have_posts() ) : ?>
			<div class="row">
				<div class="portfolio-list">
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						get_template_part( 'parts/content', 'portfolio' );
						?>

					<?php endwhile; ?>
				</div>
				<div class="post-pagination">
					<?php mrbara_numeric_pagination(); ?>
				</div>
			</div>
		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

	</main>
	<!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
