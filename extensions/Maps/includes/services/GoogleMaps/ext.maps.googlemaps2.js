/**
 * JavasSript for Google Maps v2 maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

jQuery(document).ready(function() {
	if ( GBrowserIsCompatible() ) {
		window.unload = GUnload;
		
		window.GOverlays = [
	      	new GLayer("com.panoramio.all"),
	      	new GLayer("com.youtube.all"),
	      	new GLayer("org.wikipedia.en"),
	      	new GLayer("com.google.webcams")
	    ];			
		
		for ( i in window.mwmaps.googlemaps2 ) {
			jQuery( '#' + i ).googlemaps2( window.mwmaps.googlemaps2[i] );
		}
	}
	else {
		alert( mediaWiki.msg( 'maps-googlemaps2-incompatbrowser' ) );
		
		for ( i in window.mwmaps.googlemaps2 ) {
			jQuery( '#' + i ).text( mediaWiki.msg( 'maps-load-failed' ) );
		}
	}	
});
	