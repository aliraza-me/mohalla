<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package MrBara
 */
?>

<?php do_action( 'mrbara_before_site_content_close' ); ?>

</div><!-- #content -->

<?php do_action( 'mrbara_before_footer' ); ?>

<footer id="colophon" class="site-footer">

	<?php do_action( 'mrbara_footer' ); ?>

</footer><!-- #colophon -->

<?php do_action( 'mrbara_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
