<?php
/**
 * Template Name: Home Boxed Content
 *
 * The template file for displaying boxed content
 *
 * @package MrBara
 */

get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;
?>

<?php get_footer(); ?>
