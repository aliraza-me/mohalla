<div class="container-fluid mr-container-fluid">
	<div class="header-main">
		<?php mrbara_icon_menu() ?>
		<div class="menu-logo">
			<?php get_template_part( 'parts/logo' ); ?>
		</div>
		<div class="menu-extra text-right">
			<ul>
				<?php
				echo mrbara_extra_search();
				mrbara_extra_account();
				mrbara_extra_cart();
				?>
				<li class="extra-menu-item menu-item-nav">
					<?php mrbara_extra_menu(); ?>
				</li>
			</ul>

		</div>
	</div>
</div>