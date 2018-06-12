/**
 * JavaScript for Google Maps v3 maps in the Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
(function( $, mw ) {

	$( document ).ready( function() {

		if ( typeof google === 'undefined' ) {
			$( '.maps-googlemaps3' ).text( mw.msg( 'maps-googlemaps3-incompatbrowser' ) );
		}
		else {
			$( '.maps-googlemaps3' ).each( function() {
				var $this = $( this );
				var map = $this.googlemaps( $.parseJSON( $this.find( 'div').text() ) );
				window.maps.googlemapsList.push(map);

				// SUS-5128 | track page views where Google Maps API is loaded
				window.Wikia.Tracker.track({
					action: Wikia.Tracker.ACTIONS.OPEN,
					category: 'googlemaps',
					label: 'maprendered',
					trackingMethod: 'analytics'
				});
			} );
		}

	} );

})( window.jQuery, mediaWiki );
