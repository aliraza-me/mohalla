<?php
/**
 * Custom functions for nav menu
 *
 * @package MrBara
 */


/**
 * Display numeric pagination
 *
 * @since 1.0
 * @return void
 */
function mrbara_numeric_pagination() {
	global $wp_query;

	if( $wp_query->max_num_pages < 2 ) {
        return;
	}

	?>
	<nav class="navigation paging-navigation mumeric-navigation">
		<?php
		$big = 999999999;

		$args = array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'total'     => $wp_query->max_num_pages,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'prev_text' => esc_html__( 'Prev', 'mrbara' ),
			'next_text' => esc_html__( 'Next', 'mrbara' ),
			'type'      => 'plain',
		);

		if ( is_home() && ! is_front_page() ) {

			if ( mrbara_theme_option( 'blog_nav_type' ) == 'ajax' ) {
				$args['next_text'] = '<span class="dots-loading"><span>.</span><span>.</span><span>.</span>' . esc_html__( 'Loading', 'mrbara' ) . '<span>.</span><span>.</span><span>.</span></span>';
			}
		} elseif( is_post_type_archive( 'portfolio_project' ) || is_tax( 'portfolio_category' ) ) {
			if ( mrbara_theme_option( 'portfolio_nav_type' ) == 'ajax' ) {
				if( mrbara_theme_option( 'portfolio_loading_type' ) == '1' ) {
					$args['next_text'] = '<span class="dots-loading"><span>.</span><span>.</span><span>.</span>' . esc_html__( 'Loading', 'mrbara' ) . '<span>.</span><span>.</span><span>.</span></span>';

				} else {
					$args['next_text'] = '<span class="dots-loading loading-2"><span></span><span></span><span></span>';
				}
			}
		}

		echo paginate_links( $args );

		?>
	</nav>
<?php
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0
 * @return void
 */
function mrbara_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation">
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( wp_kses_post( esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'mrbara' ) ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( wp_kses_post( esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'mrbara' ) ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}


/**
 * Display navigation to next/previous post when applicable.
 *
 * @since 1.0
 * @return void
 */
function mrbara_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation">
		<div class="container">
			<div class="nav-links">
				<?php
				previous_post_link( '<div class="nav-previous">%link</div>', esc_html__('Prev', 'mrbara' ) );
				next_post_link( '<div class="nav-next">%link</div>', esc_html__('Next', 'mrbara' ) );
				?>
			</div>
		</div>
		<!-- .nav-links -->
	</nav>
<?php
}