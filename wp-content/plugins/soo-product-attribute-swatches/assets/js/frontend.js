;(function ( $ ) {
	'use strict';

	/**
	 * @TODO Code a function the calculate available combination instead of use WC hooks
	 */
	$.fn.soopas_variation_swatches_form = function () {
		return this.each( function() {
			var $form = $( this ),
				clicked = null,
				selected = [];

			$form
				// .on( 'mouseenter', '.soopas-swatches', function() {
				// 	$( this ).closest( '.value' ).find( 'select' ).trigger( 'focusin' );
				// } )
				.on( 'click', '.swatch', function ( e ) {
					e.preventDefault();
					var $el = $( this ),
						$select = $el.closest( '.value' ).find( 'select' ),
						attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
						value = $el.data( 'value' );

					$select.trigger( 'focusin' );

					// Check if this combination is available
					if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
						$el.siblings( '.swatch' ).removeClass( 'selected' );
						$select.val( '' ).change();
						$form.trigger( 'soopas_no_matching_variations', [$el] );
						return;
					}

					clicked = attribute_name;

					if ( selected.indexOf( attribute_name ) === -1 ) {
						selected.push(attribute_name);
					}

					if ( $el.hasClass( 'selected' ) ) {
						$select.val( '' );
						$el.removeClass( 'selected' );

						delete selected[selected.indexOf(attribute_name)];
					} else {
						$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
						$select.val( value );
					}

					$select.change();
				} )
				.on( 'click', '.reset_variations', function () {
					$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
					// $form.find( '.variations .swatch' ).removeClass( 'disabled' );
					selected = [];
				} )
				.on( 'soopas_no_matching_variations', function() {
					window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
				} )
				// .on( 'update_variation_values', function ( event, variations ) {
				// 	var available = {};
				//
				// 	$.each( variations, function( index, variation ) {
				//
				// 		$.each( variation.attributes, function( name, value ) {
				// 			if ( typeof available[name] === 'undefined' ) {
				// 				available[name] = [];
				// 			}
				//
				// 			if ( available[name].indexOf( value ) === -1 ) {
				// 				available[name].push( value );
				// 			}
				// 		} );
				//
				// 	} );
				//
				// 	console.log(available);
				//
				// 	$.each( available, function( attribute, values ) {
				// 		if ( attribute == clicked || clicked === null ) {
				// 			return;
				// 		}
				//
				// 		var $attribute = $form.find( '.soopas-swatches[data-attribute_name="' + attribute + '"]' ),
				// 			$selected = $attribute.find( '.selected' );
				//
				// 		// If it allows any value
				// 		if ( values.length === 1 && values[0] === '' ) {
				// 			$attribute.find( '.swatch' ).removeClass( 'disabled' );
				// 			return;
				// 		}
				//
				// 		$attribute.find( '.swatch' ).addClass( 'disabled' );
				//
				// 		$.each( values, function( index, value ) {
				// 			$attribute.find( '.swatch[data-value="' + value + '"]' ).removeClass( 'disabled' );
				// 		} );
				// 	} );
				// } )
			;
		} );
	};

	$( function () {
		$( '.variations_form' ).soopas_variation_swatches_form();
		$( document.body ).trigger( 'soopas_initialized' );
	} );
})( jQuery );