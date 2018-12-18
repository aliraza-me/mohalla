<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MrBara
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'No Comments', '%1$s Comments', get_comments_number(), 'comments title', 'mrbara' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'mrbara' ); ?></h2>

				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'mrbara' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'mrbara' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 65,
					'callback'    => 'mrbara_comment'
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'mrbara' ); ?></h2>

				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'mrbara' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'mrbara' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'mrbara' ); ?></p>
	<?php endif; ?>

	<?php
	$comment_field = '<p class="comment-form-comment"><textarea id="comment" placeholder="' . esc_html__( 'Here goes your comment', 'mrbara' ) . '" name="comment" cols="45" rows="7" aria-required="true"></textarea></p>';
	?>
	<div class="clearfix"></div>
	<?php comment_form(
		array(
			'title_reply'   => esc_html__( 'Leave A Comment', 'mrbara' ),
			'comment_field' => $comment_field,
			'label_submit'  => esc_html__( 'Post Comment', 'mrbara' ),
		)
	) ?>

</div><!-- #comments -->