/**
 * JavasSript for Yahoo! Maps maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

jQuery(document).ready(function() {
	if ( true ) {
		for ( i in window.mwmaps.yahoomaps ) {
			jQuery( '#' + i ).yahoomaps( i, window.mwmaps.yahoomaps[i] );
		}
	}
	else {
		alert( mediaWiki.msg( 'maps-openlayers-incompatbrowser' ) );
		
		for ( i in window.mwmaps.googlemaps3 ) {
			jQuery( '#' + i ).text( mediaWiki.msg( 'maps-load-failed' ) );
		}
	}	
});
