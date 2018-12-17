<div class="container">
	<div class="header-main row">
		<?php mrbara_icon_menu() ?>
		<div class="menu-logo col-md-2 col-sm-2 col-xs-12">
			<?php get_template_part( 'parts/logo' ); ?>
		</div>
		<div class="col-sm-8 col-md-8 col-xs-12 menu-main">
			<div class="primary-nav nav">
				<?php mrbara_header_menu(); ?>
			</div>
		</div>
		<div class="menu-extra col-md-2 col-sm-2 col-xs-12">
			<ul>
				<?php
				mrbara_extra_account();
				mrbara_extra_search();
				mrbara_extra_cart();
				?>
			</ul>

		</div>
	</div>

</div>