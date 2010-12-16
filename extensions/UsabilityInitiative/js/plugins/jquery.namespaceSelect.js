/**
 * Plugin that fills a <select> with namespaces
 */

(function ($) {
$.fn.namespaceSelector = function( defaultNS ) {
	if ( typeof defaultNS == 'undefined' )
		defaultNS = 0;
	return this.each( function() {
		for ( var id in wgFormattedNamespaces ) {
			var opt = $( '<option />' )
				.attr( 'value', id )
				.text( wgFormattedNamespaces[id] );
			if ( id == defaultNS )
				opt.attr( 'selected', 'selected' );
			opt.appendTo( $(this) );
		}
	});
};})(jQuery);

