/**
 * JavaScript for the Google Maps v3 form input of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.googlemapsinput = function( mapDivId, options ) {

	var self = this;
	var geocoder = false;
	
	/**
	 * Creates and places a new marker on the map at the provided
	 * coordinate set and the pans to it.
	 * @param {Object} coordinate
	 */	
	this.showCoordinate = function( coordinate ) {
		this.mapDiv.removeMarkers();
		coordinate.icon = '';
		coordinate.title = '';
		coordinate.text = coord.dms( coordinate.lat, coordinate.lon );
		var marker = this.mapDiv.addMarker( coordinate );
		this.mapDiv.map.panTo( marker.getPosition() );
	};
	
	/**
	 * Calls this.showCoordinate with the provided latLng and updates the input field.
	 * @param {google.maps.LatLng} latLng
	 */
	this.showLatLng = function( latLng ) {
		var location = { lat: latLng.lat(), lon: latLng.lng() };
		this.showCoordinate( location );
		this.updateInput( [ location ] );		
	};
	
	this.setupGeocoder = function() {
		if ( geocoder === false ) {
			geocoder = new google.maps.Geocoder();
		}
	};
	
	this.geocodeAddress = function( address ) {
		this.setupGeocoder();
		geocoder.geocode( { 'address': address }, function( results, status ) {
			if ( status == google.maps.GeocoderStatus.OK ) {
				self.showLatLng( results[0].geometry.location );
			}
			else {
				// TODO: i18n
				alert( "Geocode was not successful for the following reason: " + status );
			}
		} );
	};
	
	this.mapforminput( mapDivId, options );
	
	this.mapDiv.googlemaps( options );	
	
	google.maps.event.addListener( this.mapDiv.map, 'click', function( event ) {
		self.showLatLng( event.latLng );
	} );	
	
	return this;
	
}; })( jQuery );
