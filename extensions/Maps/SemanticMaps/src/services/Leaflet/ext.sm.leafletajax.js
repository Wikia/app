/**
 * JavaScript for Leaflet in the Semantic Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Semantic_Maps
 *
 * @licence GNU GPL v2+
 * @author Peter Grassberger < petertheone@gmail.com >
 */


(function( $, sm ) {
	var ajaxRequest = null;

	var mapEvents = ['dragend', 'zoomend'];

	$( document ).ready( function() {
		// todo: find a way to remove setTimeout.
		setTimeout( function() {
			$( window.maps.leafletList ).each( function( index, map ) {
				if( !map.options.ajaxquery || !map.options.ajaxcoordproperty ) {
					return;
				}
				map.map.on( mapEvents.join( ' ' ), function() {
					var bounds = map.map.getBounds();
					var query = sm.buildQueryString(
						decodeURIComponent( map.options.ajaxquery.replace( /\+/g, ' ' ) ),
						map.options.ajaxcoordproperty,
						bounds.getNorthEast().lat,
						bounds.getNorthEast().lng,
						bounds.getSouthWest().lat,
						bounds.getSouthWest().lng
					);

					if( ajaxRequest !== null ) {
						ajaxRequest.abort();
					}
					ajaxRequest = sm.ajaxUpdateMarker( map, query, map.options.icon ).done( function() {
						map.createMarkerCluster();
						ajaxRequest = null;
					} );
				} );
			} );
		}, 1000 );
	} );
})( window.jQuery, window.sm );
