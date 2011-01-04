/**
 * JavasSript for OpenLayers maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 * 
 * TODO: document
 */

$( document ).ready( function() { 
	
	OpenLayers.ImgPath = '../extensions/Maps/includes/services/OpenLayers/OpenLayers/img/';
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
    OpenLayers.Util.onImageLoadErrorColor = 'transparent';
	OpenLayers.Feature.prototype.popupClass = OpenLayers.Class(
		OpenLayers.Popup.FramedCloud,
		{
			'autoSize': true,
			'minSize': new OpenLayers.Size( 200, 100 )
		}
	);	
	
	for ( i = 0, n = window.maps['openlayers'].length; i < n; i++ ) {
		initiateMap( window.maps['openlayers'][i] );
	}
	
	function initiateMap( params ) {
		OpenLayers.Lang.setCode( params.langCode );
		
		var hasImageLayer = false;
		for ( i = 0, n = params.layers.length; i < n; i++ ) {
			// Idieally this would check if the objecct is of type OpenLayers.layer.image
			if ( params.layers[i].options && params.layers[i].options.isImage === true ) {
				hasImageLayer = true;
				break;
			}
		}		
		
		// Create a new OpenLayers map with without any controls on it.
		var mapOptions = {
			controls: [],
			projection: new OpenLayers.Projection("EPSG:900913"),
			units: "m",
	        maxResolution: 156543.0339,
	        maxExtent: new OpenLayers.Bounds(
	            -20037508, -20037508, 20037508, 20037508.34
	        )
		};

		var mapElement = document.getElementById( params.mapId );
		
		// Remove the loading map message.
		mapElement.innerHTML = '';
		
		var map = new OpenLayers.Map( params.mapId, mapOptions );		
		
		addControls( map, params.controls, mapElement );

		// Add the base layers.
		for ( i = 0, n = params.layers.length; i < n; i++ ) {
			map.addLayer( eval( params.layers[i] ) );
		}

		var centerIsSet = params.centre.lon != null && params.centre.lat != null;		
		
		addMarkers( map, params, centerIsSet );
		
		if ( centerIsSet ) { // When the center is provided, set it.
			var centre = new OpenLayers.LonLat( params.centre.lon, params.centre.lat );
			
			map.setCenter( centre );
		}

		if (params.zoom != null) map.zoomTo(params.zoom); // When the zoom is provided, set it.		
	}
	
	function addControls( map, controls, mapElement ) {
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
	}
	
	function addMarkers( map, params, centerIsSet ) {
		if ( typeof params.markers == 'undefined' ) {
			return;
		}

		var bounds = null;
		
		// Layer to hold the markers.
		var markerLayer = new OpenLayers.Layer.Markers( mediaWiki.msg( 'maps-markers' ) );
		markerLayer.id= 'markerLayer';
		map.addLayer( markerLayer );		
		
		if ( params.markers.length > 1 && ( !centerIsSet || params.zoom == null ) ) {
			bounds = new OpenLayers.Bounds();
		}
		
		for ( i = params.markers.length - 1; i >= 0; i-- ) {
			params.markers[i].lonlat = new OpenLayers.LonLat( params.markers[i].lon, params.markers[i].lat );
			
			if ( bounds != null ) bounds.extend( params.markers[i].lonlat ); // Extend the bounds when no center is set.
			markerLayer.addMarker( getOLMarker( markerLayer, params.markers[i] ) ); // Create and add the marker.
		}
			
		if ( bounds != null ) map.zoomToExtent( bounds ); // If a bounds object has been created, use it to set the zoom and center.		
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
	
	function getOLMarker(markerLayer, markerData) {
		var marker;
		
		if (markerData.icon != "") {
			marker = new OpenLayers.Marker(markerData.lonlat, new OpenLayers.Icon(markerData.icon));
		} else {
			marker = new OpenLayers.Marker(markerData.lonlat);
		}

		if ( markerData.title.length + markerData.label.length > 0 ) {
			
			// This is the handler for the mousedown event on the marker, and displays the popup.
			marker.events.register('mousedown', marker,
				function(evt) { 
					var popup = new OpenLayers.Feature(markerLayer, markerData.lonlat).createPopup(true);
					
					if (markerData.title.length > 0 && markerData.label.length > 0) { // Add the title and label to the popup text.
						popup.setContentHTML('<b>' + markerData.title + '</b><hr />' + markerData.label);
					}
					else {
						popup.setContentHTML(markerData.title + markerData.label);
					}
					
					popup.setOpacity(0.85);
					markerLayer.map.addPopup(popup);
					OpenLayers.Event.stop(evt); // Stop the event.
				}
			);
			
		}	

		return marker;
	}	
	
} );