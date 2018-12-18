<?php
/**
 * @package MrBara
 */

$portfolio_type = get_post_meta( get_the_ID(), '_project_type', true );
$col_right      = $col_left = 'col-md-12 col-sm-12';
$gallery        = 'gallery-main-carousel';
$container      = 'container';
$col_detail     = 'col-md-3 col-sm-3 col-xs-6';
$size           = 'mrbara-portfolio-gallery';

if ( $portfolio_type == 'image' ) {
	$col_left   = 'col-md-5 col-sm-5';
	$col_right  = 'col-md-6 col-sm-6 col-sm-offset-1 col-md-offset-1';
	$gallery    = 'portfolio-images';
	$container  = 'container-full';
	$col_detail = 'col-md-4 col-sm-4 col-xs-6';
	$size       = 'mrbara-portfolio-image';
}

?>
<article <?php post_class( 'col-md-12 col-sm-12 col-xs-12' ) ?>>
	<div class="row">
		<div class="col-left <?php echo esc_attr( $col_left ); ?>">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php do_action( 'mrbara_before_portfolio_content' ); ?>
				<div class="work-single-desc">
					<div class="row">
						<div class="detail <?php echo esc_attr( $col_detail ); ?>">
							<span class="desc"><?php esc_html_e( 'Date', 'mrbara' ) ?></span>
							<span class="value"><?php echo get_the_date( 'd M, Y' ) ?></span>
						</div>
						<?php
						$client = get_post_meta( get_the_ID(), '_project_client', true );
						if ( $client ) :
							?>
							<div class="detail <?php echo esc_attr( $col_detail ); ?>">
								<span class="desc"><?php esc_html_e( 'Client', 'mrbara' ) ?></span>
								<span class="value"><?php echo esc_html( $client ) ?></span>
							</div>
						<?php endif; ?>
						<?php
						$cats  = wp_get_post_terms( get_the_ID(), 'portfolio_category' );
						$album = $cats ? $cats[0]->name : '';
						if ( $album ) :
							?>
							<div class="detail <?php echo esc_attr( $col_detail ); ?>">
								<span class="desc"><?php esc_html_e( 'Project Type', 'mrbara' ) ?></span>
								<span class="value"><?php echo esc_html( $album ) ?></span>
							</div>
						<?php endif; ?>
						<?php
						$author = get_post_meta( get_the_ID(), '_project_author', true );
						if ( $author && $portfolio_type == 'gallery' ) :
							?>
							<div class="detail <?php echo esc_attr( $col_detail ); ?>">
								<span class="desc"><?php esc_html_e( 'Constractor', 'mrbara' ) ?></span>
								<span class="value"><?php echo esc_html( $author ) ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				<div class="entry-footer">
					<?php if( mrbara_theme_option( 'portfolio_share_box' ) ): ?>
						<div class="footer-socials">
							<?php printf( '<strong>%s :</strong>', esc_html__( 'Share', 'mrbara' ) ) ?>
							<?php
							$image = mrbara_get_image(
								array(
									'size'     => 'full',
									'format'   => 'src',
									'meta_key' => 'image',
									'echo'     => false,
								)
							);
							mrbara_share_link_socials( get_the_title(), get_permalink(), $image );
							?>
						</div>
					<?php endif; ?>
				</div>
				<?php
				if ( $portfolio_type == 'image' ) {
					mrbara_post_nav();
				}
				?>
			</div>
		</div>
		<div class="<?php echo esc_attr( $col_right ); ?>">
			<div class="<?php echo esc_attr( $gallery ); ?>">
				<?php
				$gallery = get_post_meta( get_the_ID(), 'images', false );

				if ( $gallery ) {
					foreach ( $gallery as $image ) {
						$img_name  = basename( get_attached_file( $image ) );
						$image = wp_get_attachment_image_src( $image, $size );
						if ( $image ) {
							printf(
								'<div class="item"><img src="%s"  alt="%s"/></div>',
								esc_url( $image[0] ),
								esc_attr( $img_name )
							);
						}
					}
				} else {
					$gallery = get_post_thumbnail_id( get_the_ID() );
					$img_name  = basename( get_attached_file( $gallery ) );
					$image   = wp_get_attachment_image_src( $gallery, $size );
					if ( $image ) {
						printf(
							'<div class="item"><img src="%s"  alt="%s"/></div>',
							esc_url( $image[0] ),
							esc_attr( $img_name )
						);
					}
				}
				?>
			</div>
		</div>
	</div>
	<?php
	if ( $portfolio_type == 'gallery' ) {
		mrbara_post_nav();
	}
	?>
</article>
