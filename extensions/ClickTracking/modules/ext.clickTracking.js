/*
 * JavaScript for ClickTracking extension
 */

jQuery( function( $ ) {
	// Add click tracking hooks to the sidebar
	$( '#p-logo a, #p-navigation a, #p-interaction a, #p-tb a' ).each( function() {
		var $el = $(this), href = $el.attr( 'href' );
		// Only modify local URLs
		if ( href.length > 0 && href[0] == '/' && ( href.length == 1 || href[1] != '/' ) ) {
			var id = 'leftnav-' + skin + '-' + ( $el.attr( 'id' ) || $el.parent().attr( 'id' ) );
			$el.attr( 'href', $.trackActionURL( href, id ) );
		}
	} );
} );
