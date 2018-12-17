<?php
/**
 * Template for displaying single team member
 *
 * @package DF Team Management
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( 'df_team_member_single_before' ) ?>

				<div <?php post_class() ?>>
					<?php the_content();?>
				</div>

				<?php do_action( 'df_team_member_single_after' ) ?>

			<?php endwhile; ?>

		</div>
		<!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
