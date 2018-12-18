<?php
/**
 * Custom functions for displaying comments
 *
 * @package MrBara
 */


/**
 * Comment callback function
 *
 * @param object $comment
 * @param array  $args
 * @param int    $depth
 */
if ( ! function_exists( 'mrbara_comment' ) ) {
	function mrbara_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ) ?> id="comment-<?php comment_ID() ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>
		<?php if ( 'div' != $args['style'] ) : ?>
			<article id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<footer class="comment-meta">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 70 ); ?>
			</div>
		</footer>

		<div class="comment-content">
			<div class="comment-metadata">
				<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'mrbara' ), '  ', '' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'mrbara' ); ?></em>
				<br />
			<?php else: ?>
				<div class="comment-desc">
					<?php comment_text(); ?>
				</div>
			<?php endif; ?>
			<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" class="date">
				<?php
				/* translators: 1: date, 2: time */
				printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?>
			</a>
		</div>


		<?php if ( 'div' != $args['style'] ) : ?>
			</article>
		<?php endif; ?>
		<?php
	}
}