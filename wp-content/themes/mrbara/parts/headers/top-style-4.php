<div class="container-fluid mr-container-fluid">
	<div class="header-main">
		<div class="menu-logo">
			<?php get_template_part( 'parts/logo' ); ?>
		</div>
		<div class="container menu-main">
			<div class="row">
				<?php
				$primary_class   = 'col-md-12 col-sm-12';
				$secondary_class = 'col-lg-4 col-md-5 col-sm-5';

				if ( has_nav_menu( 'secondary' ) ) {
					$primary_class = 'col-lg-8 col-md-7 col-sm-7';
				}
				?>
				<div class="<?php echo esc_attr( $primary_class ); ?>">
					<div class="primary-nav nav">
						<?php mrbara_header_menu(); ?>
					</div>
				</div>
				<?php
				if ( has_nav_menu( 'secondary' ) ) :
					?>
					<div class="<?php echo esc_attr( $secondary_class ); ?>">
						<div class="primary-nav nav">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'secondary',
									'container'      => false,
									'walker'         => new MrBara_Mega_Menu_Walker()
								)
							);
							?>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
		<div class="menu-extra">
			<?php
			mrbara_header_language();
			?>

		</div>
		<?php mrbara_icon_menu() ?>
	</div>

</div>