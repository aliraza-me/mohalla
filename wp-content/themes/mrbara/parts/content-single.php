<?php
/**
 * @package MrBara
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<div class="post-author-box">
				<div class="post-author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>
				</div>
				<div class="post-author-desc">
					<strong><?php the_author_meta( 'display_name' ); ?></strong>
					<div class="post-author-role">
					  <?php	echo mrbara_get_user_role( get_the_author_meta( 'ID' ) ); ?>
					</div>
				</div>
			</div>
			<?php
				$time_string = '<time class="entry-date" datetime="%1$s">%2$s</time>';
				$time_string = sprintf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				);
				$archive_year  = get_the_time('Y');
				$archive_month = get_the_time('m');
				$archive_day   = get_the_time('d');
			?>

			<div class="mb-post-on mb-post-meta">
				<span class="date-links"><strong><?php esc_html_e('Date', 'mrbara') ?></strong></span>
				<?php echo '<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day) ) . '" class="entry-date" rel="bookmark">' . $time_string . '</a>' ?>
			</div>
			<div class="mb-category mb-post-meta">
				<?php if ( has_category() ) : ?>
					<span class="category-links"><strong><?php esc_html_e( 'Category', 'mrbara' ) ?></strong> <?php the_category( ', ' ) ?></span>
				<?php endif; ?>
			</div>
			<div class="mb-tag mb-post-meta">
				<?php the_tags( '<span class="tags-links"><strong>' . esc_html__( 'Tags', 'mrbara' ) . '</strong> ', ', ', '</span>' ) ?>
			</div>



		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mrbara' ) . '</span>',
				'after'  => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if( mrbara_theme_option( 'show_share_box' ) ): ?>
			<div class="footer-socials">
				<?php printf('<strong>%s :</strong>', esc_html__( 'Share', 'mrbara' ) ) ?>
				<?php
				$image = mrbara_get_image(array(
					'size'     => 'full',
					'format'   => 'src',
					'meta_key' => 'image',
					'echo'     => false,
				));
				mrbara_share_link_socials(get_the_title(), get_permalink(), $image);
				?>
			</div>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php  get_template_part('parts/related-content', 'single'); ?>
