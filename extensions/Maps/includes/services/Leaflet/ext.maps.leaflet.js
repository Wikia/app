/**
 * JavaScript for Leaflet maps in the Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Maps
 *
 * @licence GNU GPL v2+
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */
(function( $, mw ) {

	$( document ).ready( function() {

		$( '.maps-leaflet' ).each( function() {
			var $this = $( this );
			var map = $this.leafletmaps( $.parseJSON( $this.find( 'div').text() ) );
			window.maps.leafletList.push(map);
		} );
	} );

})( window.jQuery, mediaWiki );
