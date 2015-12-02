/**
 * JavaScript for the OpenLayers form input of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.openlayersinput = function( mapDivId, options ) {

	var self = this;
	
	/**
	 * @param {OpenLayers.LonLat} location
	 * @param {string} title
	 */
	this.showLocation = function( location, title ) {
		var markerLayer = self.mapDiv.map.getLayer('markerLayer');
		var markerCollection = markerLayer.markers;

		for ( var i = markerCollection.length - 1; i >= 0; i-- ) {
			markerLayer.removeMarker( markerCollection[i] );
		}
		
		var normalProjectionLocation = new OpenLayers.LonLat( location.lon, location.lat );
		normalProjectionLocation.transform( new OpenLayers.Projection( "EPSG:900913" ), new OpenLayers.Projection( "EPSG:4326" ) );		
		
		var text = coord.dms( normalProjectionLocation.lat, normalProjectionLocation.lon );
		
		if ( title !== '' ) {
			text = '<b>' + title + '</b><hr />' + text;
		}
		
		markerLayer.addMarker(
			this.mapDiv.getOLMarker(
				markerLayer,
				{
					lonlat: location,
					text: text,
					title: title,
					icon: options.icon
				}
			)
		);
		
		self.mapDiv.map.panTo( location );

		self.input.attr( 'value', semanticMaps.buildInputValue( [ normalProjectionLocation ] ) ); 
	};
	
	this.projectAndShowLocation = function( location, title ) {
		location.transform( new OpenLayers.Projection( "EPSG:4326" ), new OpenLayers.Projection( "EPSG:900913" ) );
		this.showLocation( location, title );
	};	
	
	this.showCoordinate = function( coordinate ) {
		this.projectAndShowLocation( new OpenLayers.LonLat( coordinate.lon, coordinate.lat ), '' );
	};
	
	if ( options.geonamesusername !== '' ) {
		this.geocodeAddress = function( address ) {
			$.getJSON(
				'http://api.geonames.org/searchJSON?callback=?',
				{
					'q': address,
					'username': options.geonamesusername,
					//'formatted': 'true',
					'maxRows': 1
				},
				function( data ) {
					if ( data.totalResultsCount ) {
						if ( data.totalResultsCount > 0 ) {
							self.projectAndShowLocation( new OpenLayers.LonLat( data.geonames[0].lng, data.geonames[0].lat ), address );
						}
						else {
							// TODO: notify no result
						}
					}
					else {
						// TODO: error
					}
				}
			);		
		};		
	}

	this.mapforminput( mapDivId, options );
	
	this.mapDiv.openlayers( mapDivId, options );		
	
	var clickControl = new (OpenLayers.Class(OpenLayers.Control, {				
		defaultHandlerOptions: {
			'single': true,
			'double': false,
			'pixelTolerance': 0,
			'stopSingle': false,
			'stopDouble': false
		},

		initialize: function(options) {
			this.handlerOptions = OpenLayers.Util.extend(
				{}, this.defaultHandlerOptions
			);
			OpenLayers.Control.prototype.initialize.apply(
				this, arguments
			); 
			this.handler = new OpenLayers.Handler.Click(
				this, {
					'click': this.trigger
				}, this.handlerOptions
			);
		}, 

		trigger: function(e) {
			self.showLocation( self.mapDiv.map.getLonLatFromViewPortPx(e.xy), 'Click' ); // TODO
		}

	}))();

	this.mapDiv.map.addControl( clickControl );
	clickControl.activate();
	;
	return this;
	
}; })( jQuery );
