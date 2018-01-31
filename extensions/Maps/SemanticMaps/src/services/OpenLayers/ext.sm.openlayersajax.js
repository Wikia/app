/**
 * JavaScript for OpenLayers maps in the Semantic Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Semantic_Maps
 *
 * @licence GNU GPL v2+
 * @author Peter Grassberger < petertheone@gmail.com >
 */


(function( $, sm ) {
	var ajaxRequest = null;

	$( document ).ready( function() {
		// todo: find a way to remove setTimeout.
		setTimeout( function() {
			$( window.maps.openlayersList ).each( function( index, map ) {
				if( !map.options.ajaxquery || !map.options.ajaxcoordproperty ) {
					return;
				}
				map.map.events.register( 'moveend', map.map, function() {
					var bounds = map.map.getExtent().transform( map.map.projection, map.map.displayProjection );
					var query = sm.buildQueryString(
						decodeURIComponent( map.options.ajaxquery.replace( /\+/g, ' ' ) ),
						map.options.ajaxcoordproperty,
						bounds.top,
						bounds.right,
						bounds.bottom,
						bounds.left
					);

					if( ajaxRequest !== null ) {
						ajaxRequest.abort();
					}
					ajaxRequest = sm.ajaxUpdateMarker( map, query, map.options.icon ).done( function() {
						ajaxRequest = null;
					} );
				} );
			} );
		}, 500 );
	} );
})( window.jQuery, window.sm );
