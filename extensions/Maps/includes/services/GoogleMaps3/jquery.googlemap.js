/**
 * JavasSript for Google Maps v3 maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ){ $.fn.googlemaps = function( options ) {

	var _this = this;
	
	this.map = null;
	this.options = options;
	
	/**
	 * All markers that are currently on the map.
	 * @type {Array}
	 * @private
	 */
	this.markers = [];
	
	/**
	 * Creates a new marker with the provided data,
	 * adds it to the map, and returns it.
	 * @param {Object} markerData Contains the fields lat, lon, title, text and icon
	 * @return {google.maps.Marker}
	 */
	this.addMarker = function( markerData ) {
		var markerOptions = {
			position: new google.maps.LatLng( markerData.lat , markerData.lon ),
			title: markerData.title
		};
		
		if ( markerData.icon !== '' ) {
			markerOptions.icon = markerData.icon; 
		}
		
		var marker = new google.maps.Marker( markerOptions );
		
		marker.openWindow = false;
		
		if ( markerData.text !== '' ) {
			marker.text = markerData.text;
			google.maps.event.addListener( marker, 'click', function() {
				if ( this.openWindow !== false ) {
					this.openWindow.close();
				}
				this.openWindow = new google.maps.InfoWindow( { content: this.text } );
				this.openWindow.closeclick = function() {
					marker.openWindow = false;
				};
				this.openWindow.open( _this.map, this );					
			} );		
		}
		
		marker.setMap( this.map );
		this.markers.push( marker );
		
		return marker;
	};
	
	/**
	 * Removes a single marker from the map.
	 * @param {google.maps.Marker} marker The marker to remove.
	 */
	this.removeMarker = function( marker ) {
		marker.setMap( null );
		
		for ( var i = this.markers.length - 1; i >= 0; i-- ) {
			if ( this.markers[i] === marker ) {
				delete this.markers[i];
				break;
			}
		}
		
		delete marker;
	};
	
	/**
	 * Removes all markers from the map.
	 */		
	this.removeMarkers = function() {
		for ( var i = this.markers.length - 1; i >= 0; i-- ) {
			this.markers[i].setMap( null );
		}
		this.markers = [];
	};
	
	/**
	 * Remove the "earth" type from options.types if it's present.
	 * 
	 * @since 1.0.1
	 */
	this.removeEarthType = function() {
		if ( Array.prototype.filter ) {
			options.types = options.types.filter( function( element, index, array ) { return element !== 'earth'; } );
		}
		else {
			// Seems someone is using the o-so-awesome browser that is IE.
			var types = [];
			
			for ( i in options.types ) {
				if ( typeof( options.types[i] ) !== 'function' && options.types[i] !== 'earth' ) {
					types.push( options.types[i] );
				}
			}
			
			options.types = types;
		}
	};
	
	this.addOverlays = function() {
		// Add the Google KML/KMZ layers.
		for ( i = options.gkml.length - 1; i >= 0; i-- ) {
			var kmlLayer = new google.maps.KmlLayer(
				options.gkml[i],
				{
					map: map,
					preserveViewport: !options.kmlrezoom
				}
			);
		}
		
		// If there are any non-Google KML/KMZ layers, load the geoxml library and use it to add these layers.
		if ( options.kml.length != 0 ) {
			mw.loader.using( 'ext.maps.gm3.geoxml', function() {
				var geoXml = new geoXML3.parser( { map: map, zoom: options.kmlrezoom } );
				
				for ( i = options.kml.length - 1; i >= 0; i-- ) {
					geoXml.parse( options.kml[i] );
				}
			} );		
		}		
	};
	
	this.setup = function() {
		var showEarth = $.inArray( 'earth', options.types ) !== -1; 
		
		// If there are any non-Google KML/KMZ layers, load the geoxml library and use it to add these layers.
		if ( showEarth ) {
			this.removeEarthType();
			showEarth = mw.config.get( 'egGoogleJsApiKey' ) !== '';
		}
		
		var mapOptions = {
			disableDefaultUI: true,
			mapTypeId: options.type == 'earth' ? google.maps.MapTypeId.SATELLITE : eval( 'google.maps.MapTypeId.' + options.type )
		};
		
		// Map controls
		mapOptions.panControl = $.inArray( 'pan', options.controls ) != -1;
		mapOptions.zoomControl = $.inArray( 'zoom', options.controls ) != -1;
		mapOptions.mapTypeControl = $.inArray( 'type', options.controls ) != -1;
		mapOptions.scaleControl = $.inArray( 'scale', options.controls ) != -1;
		mapOptions.streetViewControl = $.inArray( 'streetview', options.controls ) != -1;

		for ( i in options.types ) {
			if ( typeof( options.types[i] ) !== 'function' ) {
				options.types[i] = eval( 'google.maps.MapTypeId.' + options.types[i] );
			}
		}
		
		// Map control styles
		mapOptions.zoomControlOptions = { style: eval( 'google.maps.ZoomControlStyle.' + options.zoomstyle ) };
		mapOptions.mapTypeControlOptions = {
			style: eval( 'google.maps.MapTypeControlStyle.' + options.typestyle ),
			mapTypeIds: options.types
		};

		var map = new google.maps.Map( this.get( 0 ), mapOptions );
		this.map = map;
		
		if ( !options.locations ) {
			options.locations = [];
		}
		
		// Add the markers.
		for ( var i = options.locations.length - 1; i >= 0; i-- ) {
			this.addMarker( options.locations[i] );
		}
		
		for ( i = options.fusiontables.length - 1; i >= 0; i-- ) {
			var ftLayer = new google.maps.FusionTablesLayer( options.fusiontables[i], { map: map } );
		}
		
		var layerMapping = {
			'traffic': 'new google.maps.TrafficLayer()',
			'bicycling': 'new google.maps.BicyclingLayer()'
		};
		
		for ( i = options.layers.length - 1; i >= 0; i-- ) {
			var layer = eval( layerMapping[options.layers[i]] );
			layer.setMap( map );
		}	
		
		var bounds;
		
		if ( ( options.centre === false || options.zoom === false ) && options.locations.length > 1 ) {
			bounds = new google.maps.LatLngBounds();

			for ( var i = this.markers.length - 1; i >= 0; i-- ) {
				bounds.extend( this.markers[i].getPosition() );
			}
		}
		
		if ( options.zoom === false ) {
			map.fitBounds( bounds );
		}
		else {
			map.setZoom( options.zoom );
		}
		
		var centre;
		
		if ( options.centre === false ) {
			if ( options.locations.length > 1 ) {
				centre = bounds.getCenter();
			}
			else if ( options.locations.length == 1 ) {
				centre = new google.maps.LatLng( options.locations[0].lat, options.locations[0].lon );
			}
			else {
				centre = new google.maps.LatLng( 0, 0 );
			}
		}
		else {
			centre = new google.maps.LatLng( options.centre.lat, options.centre.lon );
		}
		
		map.setCenter( centre );
		
		if ( showEarth ) {
			$.getScript(
				'https://www.google.com/jsapi?key=' + mw.config.get( 'egGoogleJsApiKey' ),
				function( data, textStatus ) {
					google.load( 'earth', '1', { callback: function() {
						mw.loader.using( 'ext.maps.gm3.earth', function() {
							if ( google.earth.isSupported() ) {
								var ge = new GoogleEarth( map );
								var setTilt = function() {
									
									if ( ge.getInstance() !== undefined ) {
									
										 var center = map.getCenter();
										  var lookAt = ge.instance_.createLookAt('');
										  var range = Math.pow(2, GoogleEarth.MAX_EARTH_ZOOM_ - map.getZoom());
										  lookAt.setRange(range);
										  lookAt.setLatitude(center.lat());
										  lookAt.setLongitude(center.lng());
										  lookAt.setHeading(0);
										  lookAt.setAltitude(0);
										  
										    // Teleport to the pre-tilt view immediately.
										  ge.instance_.getOptions().setFlyToSpeed(5);
										  ge.instance_.getView().setAbstractView(lookAt);
										    lookAt.setTilt(options.tilt);
										    // Fly to the tilt at regular speed in 200ms
										    ge.instance_.getOptions().setFlyToSpeed(0.75);
										    window.setTimeout(function() {
										    	ge.instance_.getView().setAbstractView(lookAt);
										    }, 200);
										    // Set the flyto speed back to default after the animation starts.
										    window.setTimeout(function() {
										    	ge.instance_.getOptions().setFlyToSpeed(1);
										    }, 250);
											
									}
									else {
										setTimeout( function() { setTilt(); }, 100 );
									}
								};
								
								if ( options.type == 'earth' ) {
									map.setMapTypeId( GoogleEarth.MAP_TYPE_ID );
									setTilt();
								}
								else {
									google.maps.event.addListenerOnce( map, 'maptypeid_changed', function() { setTilt(); } );
								}
							}
							
							_this.addOverlays();
						} );	
					} } );
				}
			);
		}
		else {
			google.maps.event.addListenerOnce( map, 'tilesloaded', function() { _this.addOverlays(); } );
		}
		
		if ( options.autoinfowindows ) {
			for ( var i = this.markers.length - 1; i >= 0; i-- ) {
				google.maps.event.trigger( this.markers[i], 'click' );
			}		
		}
		
		if ( options.resizable ) {
			mw.loader.using( 'ext.maps.resizable', function() {
				_this.resizable();
			} );
		}		
	};
	
	this.setup();
	
	return this;
	
}; })( jQuery, window.mediaWiki );