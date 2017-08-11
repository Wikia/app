/**
 * JavaScript for  the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @since 1.0
 *
 * @licence GNU GPL v2++
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
window.maps = new ( function( $, mw ) {
	
	this.log = function( message ) {
		if ( mw.config.get( 'egMapsDebugJS' ) ) {
			mw.log( message );
		}
	};

	this.googlemapsList = [];
	this.leafletList = [];
	this.openlayersList = [];
} )( jQuery, mediaWiki );
