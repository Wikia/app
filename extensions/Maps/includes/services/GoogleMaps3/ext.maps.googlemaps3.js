/**
 * JavasSript for Google Maps v3 maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
jQuery(document).ready(function() {
	if ( typeof google != 'undefined' ) {
		for ( i in window.mwmaps.googlemaps3 ) {
			jQuery( '#' + i ).googlemaps( window.mwmaps.googlemaps3[i] );
		}
	}
	else {
		for ( i in window.mwmaps.googlemaps3 ) {
			jQuery( '#' + i ).text( mediaWiki.msg( 'maps-load-failed' ) + ' ' + mediaWiki.msg( 'maps-googlemaps3-incompatbrowser' ) );
		}
	}	
});
