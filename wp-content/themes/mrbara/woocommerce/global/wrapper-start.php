<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div id="primary" class="content-area <?php mrbara_content_columns();?>" role="main">
	<?php do_action( 'mrbara_before_content' ); ?>
