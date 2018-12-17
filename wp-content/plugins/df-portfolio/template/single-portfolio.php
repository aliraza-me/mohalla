<?php
/**
 * Template for displaying single portfolio
 *
 * @package DF Portfolio Management
 */

get_header(); ?>

<div id="primary" class="content-area">
	<?php while ( have_posts() ) :
		the_post(); ?>

		<article <?php post_class() ?>>
			<div class="container">
				<div class="work-single-desc">
					<div class="row">
						<div class="detail col-md-3 col-sm-3">
							<span class="desc"><?php esc_html_e( 'Date', 'df-portfolio' ) ?></span>
							<span class="value"><?php echo get_the_date( 'd M, Y' ) ?></span>
						</div>
						<?php
						$client = get_post_meta( get_the_ID(), '_project_client', true );
						if ( $client ) :
							?>
							<div class="detail col-md-3 col-sm-3">
								<span class="desc"><?php esc_html_e( 'Client', 'df-portfolio' ) ?></span>
								<span class="value"><?php echo $client ?></span>
							</div>
						<?php endif; ?>
						<?php
						$cats  = wp_get_post_terms( get_the_ID(), 'portfolio_category' );
						$album = $cats ? $cats[0]->name : '';
						if ( $album ) :
							?>
							<div class="detail col-md-3 col-sm-3">
								<span class="desc"><?php esc_html_e( 'Project Type', 'df-portfolio' ) ?></span>
								<span class="value"><?php echo $album ?></span>
							</div>
						<?php endif; ?>
						<?php
						$author = get_post_meta( get_the_ID(), '_project_author', true );
						if ( $author ) :
							?>
							<div class="detail col-md-3 col-sm-3">
								<span class="desc"><?php esc_html_e( 'Constractor', 'df-portfolio' ) ?></span>
								<span class="value"><?php echo $author ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
		</article>
	<?php endwhile; ?>
	<!-- #content -->
	<!-- .navigation -->
	<!-- .navigation -->
	<!-- #primary -->
</div>
<?php get_footer(); ?>
