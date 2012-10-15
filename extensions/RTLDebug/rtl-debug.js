( function( $ ) {

	// Select all elements in the body (we don't need stuff in <head>)
	$( document.body )
		.find( '*' )
		.andSelf() // include body as well
		.each( function() {
			var $el = $( this );
			$el.addClass( $el.css( 'direction' ) === 'rtl' ? 'mw-rtldebug-rtl' : 'mw-rtldebug-ltr' );
		} );

} )( jQuery );
