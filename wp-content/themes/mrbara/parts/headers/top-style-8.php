<div class="container">
	<div class="header-main">
		<div class="row">
			<?php mrbara_icon_menu() ?>
			<div class="menu-logo col-md-2 col-sm-2">
				<?php get_template_part( 'parts/logo' ); ?>
			</div>
			<div class="menu-sidebar col-md-10 col-sm-10">
				<?php mrbara_extra_search(); ?>
				<ul class="menu-sideextra">
					<?php
					mrbara_extra_cart();
					mrbara_extra_account();
					?>
				</ul>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="primary-nav nav">
							<?php mrbara_header_menu(); ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>