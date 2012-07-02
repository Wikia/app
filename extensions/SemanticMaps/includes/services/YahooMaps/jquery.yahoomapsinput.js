/**
 * JavasSript for the Yahoo! Maps form input of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.yahoomapsinput = function( options ) {

	var self = this;

	/**
	 * Creates and places a new marker on the map at the provided
	 * coordinate set and the pans to it.
	 * @param {Object} coordinate
	 */
	this.showCoordinate = function( coordinate ) {
        this.mapDiv.map.removeMarkersAll();
		coordinate.icon = '';
		coordinate.title = '';
		coordinate.text = coord.dms( coordinate.lat, coordinate.lon );
		var marker = this.mapDiv.addMarker( coordinate );
        this.mapDiv.map.drawZoomAndCenter( new YGeoPoint( coordinate.lat, coordinate.lon ) );
    };

	this.geocodeAddress = function( address ) {
		this.mapDiv.map.drawZoomAndCenter( address );

        YEvent.Capture(this.mapDiv.map, EventsList.onEndGeoCode,
            function( resultObj ) {
                map.addOverlay( new YMarker( resultObj.GeoPoint ) );
                this.updateInput( [ { 'lat': resultObj.GeoPoint.Lat, 'lon': resultObj.GeoPoint.Lon } ] );
            }
        );
	};

	// Click event handler for updating the location of the marker.
	YEvent.Capture(this.mapDiv.map, EventsList.MouseClick,
		function(_e, point) {
            var coordinate = { 'lat': point.Lat, 'lon': point.Lon };
			this.showCoordinate( coordinate );
            this.updateInput( [ coordinate ] );
		}
	);

	this.mapforminput( mapDivId, options );

	this.mapDiv.yahoomaps( options );
	
	return this;
	
}; })( jQuery );