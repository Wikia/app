/**
 * JavasSript for OpenLayers maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.openlayers = function( mapElementId, options ) {
	
	this.getOLMarker = function( markerLayer, markerData ) {
		var marker;
		
		if ( markerData.icon != "" ) {
			marker = new OpenLayers.Marker( markerData.lonlat, new OpenLayers.Icon( markerData.icon ) );
		} else {
			marker = new OpenLayers.Marker( markerData.lonlat );
		}

		if ( markerData.text !== '' ) {
			// This is the handler for the mousedown event on the marker, and displays the popup.
			marker.events.register('mousedown', marker,
				function( evt ) { 
					var popup = new OpenLayers.Feature( markerLayer, markerData.lonlat ).createPopup( true ); 
					popup.setContentHTML( markerData.text );
					markerLayer.map.addPopup( popup );
					OpenLayers.Event.stop( evt ); // Stop the event.
				}
			);
		}	

		return marker;
	}
	
	this.addMarkers = function( map, options ) {
		if ( !options.locations ) {
			options.locations = [];
		}
		
		var bounds = null;
		
		// Layer to hold the markers.
		var markerLayer = new OpenLayers.Layer.Markers( mediaWiki.msg( 'maps-markers' ) );
		markerLayer.id= 'markerLayer';
		map.addLayer( markerLayer );
		
		if ( options.locations.length > 1 && ( options.centre === false || options.zoom === false ) ) {
			bounds = new OpenLayers.Bounds();
		}
		
		for ( i = options.locations.length - 1; i >= 0; i-- ) {
			options.locations[i].lonlat = new OpenLayers.LonLat( options.locations[i].lon, options.locations[i].lat );
			
			if ( !hasImageLayer ) {
				options.locations[i].lonlat.transform( new OpenLayers.Projection( "EPSG:4326" ), new OpenLayers.Projection( "EPSG:900913" ) );
			}
			
			if ( bounds != null ) bounds.extend( options.locations[i].lonlat ); // Extend the bounds when no center is set.
			markerLayer.addMarker( this.getOLMarker( markerLayer, options.locations[i] ) ); // Create and add the marker.
		}
		
		if ( bounds != null ) map.zoomToExtent( bounds ); // If a bounds object has been created, use it to set the zoom and center.
	}
	
	this.addControls = function( map, controls, mapElement ) {
		// Add the controls.
		for ( var i = controls.length - 1; i >= 0; i-- ) {
			// If a string is provided, find the correct name for the control, and use eval to create the object itself.
			if ( typeof controls[i] == 'string' ) {
				if ( controls[i].toLowerCase() == 'autopanzoom' ) {
					if ( mapElement.offsetHeight > 140 ) controls[i] = mapElement.offsetHeight > 320 ? 'panzoombar' : 'panzoom';
				}

				control = getValidControlName( controls[i] );
				
				if ( control ) {
					eval(' map.addControl( new OpenLayers.Control.' + control + '() ); ');
				}
			}
			else {
				map.addControl(controls[i]); // If a control is provided, instead a string, just add it.
				controls[i].activate(); // And activate it.
			}
		}
		
		map.addControl( new OpenLayers.Control.Attribution() ); 
	}
	
	/**
	 * Gets a valid control name (with excat lower and upper case letters),
	 * or returns false when the control is not allowed.
	 */
	function getValidControlName( control ) {
		var OLControls = [
	        'ArgParser', 'Attribution', 'Button', 'DragFeature', 'DragPan', 
			'DrawFeature', 'EditingToolbar', 'GetFeature', 'KeyboardDefaults', 'LayerSwitcher',
			'Measure', 'ModifyFeature', 'MouseDefaults', 'MousePosition', 'MouseToolbar',
			'Navigation', 'NavigationHistory', 'NavToolbar', 'OverviewMap', 'Pan',
			'Panel', 'PanPanel', 'PanZoom', 'PanZoomBar', 'Permalink',
			'Scale', 'ScaleLine', 'SelectFeature', 'Snapping', 'Split', 
			'WMSGetFeatureInfo', 'ZoomBox', 'ZoomIn', 'ZoomOut', 'ZoomPanel',
			'ZoomToMaxExtent'
		];
		
		for ( var i = OLControls.length - 1; i >= 0; i-- ) {
			if ( control == OLControls[i].toLowerCase() ) {
				return OLControls[i];
			}
		}
		
		return false;
	}	
	
	// Remove the loading map message.
	this.text( '' );
	
	var hasImageLayer = false;
	for ( i = 0, n = options.layers.length; i < n; i++ ) {
		// Idieally this would check if the objecct is of type OpenLayers.layer.image
		if ( options.layers[i].options && options.layers[i].options.isImage === true ) {
			hasImageLayer = true;
			break;
		}
	}	
	
	// Create a new OpenLayers map with without any controls on it.
	var mapOptions = {
		controls: []
	};
	
	if ( !hasImageLayer ) {
		mapOptions.projection = new OpenLayers.Projection("EPSG:900913");
		mapOptions.displayProjection = new OpenLayers.Projection("EPSG:4326");
		mapOptions.units = "m";
		mapOptions.numZoomLevels = 18;
		mapOptions.maxResolution = 156543.0339;
		mapOptions.maxExtent = new OpenLayers.Bounds(-20037508, -20037508, 20037508, 20037508.34);
	}
	
	this.map = new OpenLayers.Map( mapElementId, mapOptions );
	var map = this.map;
	this.addControls( map, options.controls, this.get( 0 ) );
	
	// Add the base layers.
	for ( i = 0, n = options.layers.length; i < n; i++ ) {
		map.addLayer( eval( options.layers[i] ) );
	}

	this.addMarkers( map, options );
	var centre = false;
	
	if ( options.centre === false ) {
		if ( options.locations.length == 1 ) {
			centre = new OpenLayers.LonLat( options.locations[0].lon, options.locations[0].lat );
		}
		else if ( options.locations.length == 0 ) {
			centre = new OpenLayers.LonLat( 0, 0 );
		}
	}
	else { // When the center is provided, set it.
		centre = new OpenLayers.LonLat( options.centre.lon, options.centre.lat );
	}
	
	if ( centre !== false ) {
		if ( !hasImageLayer ) {
			centre.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
		}		
		
		map.setCenter( centre );		
	}
	
	if ( options.zoom !== false ) {
		map.zoomTo( options.zoom );
	}
	
	if ( options.resizable ) {
		mw.loader.using( 'ext.maps.resizable', function() {
			_this.resizable();
		} );
	}	
	
	return this;
	
}; })( jQuery );
