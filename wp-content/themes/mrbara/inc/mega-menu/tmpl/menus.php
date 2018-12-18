<% if ( depth == 0 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'mrbara' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'mrbara' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'mrbara' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'mrbara' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'mrbara' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'mrbara' ) ?></a>
<% } else if ( depth == 1 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'mrbara' ) ?>" data-panel="content"><?php esc_html_e( 'Menu Content', 'mrbara' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'mrbara' ) ?>" data-panel="general"><?php esc_html_e( 'General', 'mrbara' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'mrbara' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'mrbara' ) ?></a>
<% } else { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Icon', 'mrbara' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'mrbara' ) ?></a>
<% } %>
