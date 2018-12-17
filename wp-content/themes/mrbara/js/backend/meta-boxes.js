jQuery(document).ready(function ($) {
	"use strict";

	// Show/hide settings for post format when choose post format
	var $format = $('#post-formats-select').find('input.post-format'),
		$formatBox = $('#post-format-settings');

	$format.on('change', function () {
		var type = $format.filter(':checked').val();

		$formatBox.hide();
		if ($formatBox.find('.rwmb-field').hasClass(type)) {
			$formatBox.show();
		}

		$formatBox.find('.rwmb-field').slideUp();
		$formatBox.find('.' + type).slideDown();
	});
	$format.filter(':checked').trigger('change');

	// Show/hide settings for custom layout settings
	$('#custom_layout').on('change', function () {
		if ($(this).is(':checked')) {
			$('.rwmb-field.custom-layout').slideDown();
		}
		else {
			$('.rwmb-field.custom-layout').slideUp();
		}
	}).trigger('change');

	// Show/hide settings for custom layout settings
	$('#custom_page_header_layout, #custom_product_header_layout').on('change', function () {
		if ($(this).is(':checked')) {
			$('.rwmb-field.page-header-layout').slideDown();
		}
		else {
			$('.rwmb-field.page-header-layout').slideUp();
		}
	}).trigger('change');

	$('#display-settings,#product-display-settings').find('.page-header-layout .rwmb-image-select').css({
		width : '450',
		height: 'auto'
	});



	// Show/hide settings for template settings
	$('#page_template').on('change', function () {

		if ($(this).val() == 'template-homepage.php' ||
			$(this).val() == 'template-homepage-transparent.php' ||
			$(this).val() == 'template-home-boxed-content.php' ||
			$(this).val() == 'template-home-cosmetic.php' ||
			$(this).val() == 'template-home-split.php' ||
			$(this).val() == 'template-home-width-1620.php') {
			$('#display-settings').hide();
			$('#display-comingsoon').hide();
			$('#display-settings .hide-fullwidth').hide();
		} else if ($(this).val() == 'template-full-width.php') {
			$('#display-comingsoon').hide();
			$('#display-settings').show();

			$('#display-settings .hide-fullwidth').hide();

		} else {
			$('#display-settings').show();
			$('#display-settings .hide-fullwidth').show();
			$('#display-comingsoon').hide();

			if ($(this).val() == 'template-coming-soon.php') {
				$('#display-comingsoon').show();
				$('#display-settings').hide();
				$('#display-settings .hide-fullwidth').hide();
			}
		}

	}).trigger('change');

	$('#display-settings').find('.hide-custom-page-header').hide();

	$('#variable_product_options').on('reload', function (event, data) {
		var postID = $('#post_ID').val();
		$.ajax({
			url     : ajaxurl,
			dataType: 'json',
			method  : 'post',
			data    : {
				action : 'product_meta_fields',
				post_id: postID
			},
			success : function (response) {
				$('#product_attributes_extra').empty().append(response.data);
			}
		});
	});

	// Show/hide settings for custom layout settings
	var custom = false;
	$('#product-display-settings').on('change', '.rwmb-image_select', function () {
		if ($(this).is(':checked') ) {
			if ($(this).val() == '3') {
				custom = true;
			} else {
				custom = false;
			}
		}

		if (custom) {
			$('#product-display-settings').find('.bg-page-header').slideDown();
		}
		else {
			$('#product-display-settings').find('.bg-page-header').slideUp();
		}
	}).trigger('change');

});
