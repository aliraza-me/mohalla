<div class="container-fluid mr-container-fluid">
	<div class="row">
		<?php mrbara_icon_menu() ?>
		<div class="menu-extra menu-extra-left text-left col-md-2">
			<?php mrbara_extra_menu(); ?>
		</div>
		<div class="menu-logo text-center col-md-8 col-sm-4 col-xs-4">
			<?php get_template_part( 'parts/logo' ); ?>
		</div>
		<div class="menu-extra menu-extra-right text-right col-md-2">
			<ul>
				<?php
				mrbara_extra_account();
				mrbara_extra_cart();
				?>
			</ul>
		</div>
	</div>
</div>
