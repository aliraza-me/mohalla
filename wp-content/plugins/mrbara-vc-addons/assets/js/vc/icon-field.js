!function($) {
	$( '.icon-selector' ).on( 'click', 'i', function(e) {
		e.preventDefault();
		var $el = $( this ),
			icon = $el.data( 'mr-icon' );

		$el.closest( 'div' ).prev( 'input.icon_field' ).val( icon ).siblings( '.icon-preview' ).children( 'i' ).attr( 'class', icon );
		$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
	} );

	$( '.icon-search' ).on( 'keyup', function() {
		var search = $( this ).val(),
			$icons = $( this ).siblings( '.icon-selector' ).children();

			if ( !search ) {
				$icons.show();
				return;
			}

			$icons.hide().filter( function() {
				return $( this ).data( 'mr-icon' ).indexOf( search ) >= 0;
			} ).show();
	} );
}(window.jQuery);
