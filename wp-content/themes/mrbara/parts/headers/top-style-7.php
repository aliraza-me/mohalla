<div class="container">
	<div class="header-main">
		<div class="row">
			<?php mrbara_icon_menu() ?>
			<div class="menu-extra  menu-extra-left text-left col-md-3 col-sm-3">
				<ul>
					<li class="extra-menu-item menu-item-nav">
						<?php mrbara_extra_menu(); ?>
					</li>
					<?php mrbara_extra_search(); ?>
				</ul>
			</div>
			<div class="menu-logo col-md-6 col-sm-6 text-center">
				<?php get_template_part( 'parts/logo' ); ?>
			</div>
			<div class="menu-extra menu-extra-right  text-right col-md-3 col-sm-3">
				<ul>
					<?php
					mrbara_extra_shop();
					mrbara_extra_account();
					mrbara_extra_cart();
					?>
				</ul>

			</div>
		</div>
	</div>
</div>