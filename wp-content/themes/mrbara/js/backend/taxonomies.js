jQuery( document ).ready( function( $ ) {
	"use strict";

	// Only show the "remove image" button when needed
	if ( '' == $( '#product_cat_bg_id' ).val() ) {
		$( '.remove_bg_image_button' ).hide();
	}

	// Uploading files
	var file_frame;

	$( '#product-cat-bg' ).on( 'click', '.upload_bg_image_button', function( event ) {

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.downloadable_file = wp.media({
			multiple: false
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			var attachment = file_frame.state().get( 'selection' ).first().toJSON();

			$( '#product_cat_bg_id' ).val( attachment.id );
			$( '#product_cat_bg' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
			$( '.remove_bg_image_button' ).show();
		});

		// Finally, open the modal.
		file_frame.open();
	});

	$( document ).on( 'click', '.remove_bg_image_button', function() {
		var image_src = $(this).closest('#product-brand-thumb-box').find('#product_brand_thumb').data('rel');
		$( '#product_cat_bg' ).find( 'img' ).attr( 'src', image_src );
		$( '#product_cat_bg_id' ).val( '' );
		$( '.remove_bg_image_button' ).hide();
		return false;
	});

	$('.mr-product-cat-color').find('.colorpicker').wpColorPicker();
} );
