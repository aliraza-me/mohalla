<?php mrbara_icon_menu() ?>
<div class="menu-logo">
	<?php get_template_part( 'parts/logo' ); ?>
</div>
<div class="menu-extra">
	<ul id="left-menu-nav">
		<li class="extra-menu-item  menu-item-nav">
			<a href="#" class="item-menu-nav"><i class="t-icon ion-navicon"></i></a>
		</li>
		<?php
		mrbara_extra_search();
		mrbara_extra_cart();
		mrbara_extra_account();
		?>
	</ul>
</div>
<div class="menu-footer">
	<?php
	mrbara_footer_currency();
	mrbara_footer_language();
	?>
</div>