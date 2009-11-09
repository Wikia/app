 /**
  * Javascript functions for Open Layers functionallity in Maps and it's extensions
  *
  * @file OpenLayerFunctions.js
  * @ingroup Maps
  *
  * @author Jeroen De Dauw
  */
  
/**
 * Creates and initializes an OpenLayers map. 
 * The resulting map is returned by the function but no further handling is required in most cases.
 */
function initOpenLayer(mapName, lon, lat, zoom, mapTypes, controls, marker_data, height){

	// Create a new OpenLayers map with without any controls on it
	var mapOptions = 	{ 
			            projection: new OpenLayers.Projection("EPSG:900913"),
			            displayProjection: new OpenLayers.Projection("EPSG:4326"),
			            units: "m",
			            numZoomLevels: 18,
			            maxResolution: 156543.0339,
			            maxExtent: new OpenLayers.Bounds(-20037508, -20037508, 20037508, 20037508.34), 
						controls: []
						};

	var map = new OpenLayers.Map(mapName, mapOptions);
	
	// Add the controls
	for (i in controls) {
		
		// If a string is provided, find the correct name for the control, and use eval to create the object itself
		if (typeof controls[i] == 'string') {
			if (controls[i].toLowerCase() == 'autopanzoom') {
				if (height > 140) controls[i] = height > 320 ? 'panzoombar' : 'panzoom';
			}	
				
			control = getValidControlName(controls[i]);
			
			if (control) {
				eval(' map.addControl( new OpenLayers.Control.' + control + '() ); ');
			}
		}
		else {
			map.addControl(controls[i]); // If a control is provided, instead a string, just add it
			controls[i].activate(); // And activate it
		}
		
	}
	
	addMapBaseLayers(map, mapTypes);
	
	// Layer to hold the markers
	var markerLayer = new OpenLayers.Layer.Markers('Markers');
	markerLayer.id= 'markerLayer';
	map.addLayer(markerLayer);
	
	var centerIsSet = lon != null && lat != null;
	
	var bounds = null;
	
	if (marker_data.length > 1 && (!centerIsSet || zoom == null)) {
		bounds = new OpenLayers.Bounds();
	}
	
	for (i in marker_data) {
		marker_data[i].lonlat.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
		if (bounds != null) bounds.extend(marker_data[i].lonlat); // Extend the bounds when no center is set
		markerLayer.addMarker(getOLMarker(markerLayer, marker_data[i], map.getProjectionObject())); // Create and add the marker
	}
		
	if (bounds != null) map.zoomToExtent(bounds); // If a bounds object has been created, use it to set the zoom and center
	
	if (centerIsSet) { // When the center is provided, set it
		var centre = new OpenLayers.LonLat(lon, lat);
		centre.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
		map.setCenter(centre); 
	}
	
	if (zoom != null) map.zoomTo(zoom); // When the zoom is provided, set it
	
	return map;
}

/**
 * Gets a valid control name (with excat lower and upper case letters),
 * or returns false when the control is not allowed.
 */
function getValidControlName(control) {
	var OLControls = ['ArgParser', 'Attribution', 'Button', 'DragFeature', 'DragPan', 
	                  'DrawFeature', 'EditingToolbar', 'GetFeature', 'KeyboardDefaults', 'LayerSwitcher',
	                  'Measure', 'ModifyFeature', 'MouseDefaults', 'MousePosition', 'MouseToolbar',
	                  'Navigation', 'NavigationHistory', 'NavToolbar', 'OverviewMap', 'Pan',
	                  'Panel', 'PanPanel', 'PanZoom', 'PanZoomBar', 'Permalink',
	                  'Scale', 'ScaleLine', 'SelectFeature', 'Snapping', 'Split', 
	                  'WMSGetFeatureInfo', 'ZoomBox', 'ZoomIn', 'ZoomOut', 'ZoomPanel',
	                  'ZoomToMaxExtent'];
	
	for (i in OLControls) {
		if (control == OLControls[i].toLowerCase()) {
			return OLControls[i];
		}
	}
	
	return false;
}

/**
 * Adds all map type base layers to a map, and returns it.
 */
function addMapBaseLayers(map, mapTypes) {
	// Variables for whowing an error when the Google Maps API is not loaded
	var googleAPILoaded = typeof(G_NORMAL_MAP) != 'undefined';
	var shownApiError = false;
	
	// Variables to prevent double adding of a base layer
	var usedNor = false; var usedSat = false; var usedHyb = false; var usedPhy = false;  // Google types
	var usedBingNor = false; var usedBingHyb = false; var usedBingSat = false; // Bing types
	var usedYahooNor = false; var usedYahooHyb = false; var usedYahooSat = false; // Yahoo types
	var usedOLWMS = false; // OL types
	var usedOSMnik = false; var usedOSMcycle = false; var usedOSMarender = false; // OSM types
	var usedNasa = false; // Others
	
	var isDefaultBaseLayer = false;

	// Add the base layers
	for (i in mapTypes) {
		//if (mapTypes[i].substring(0, 1) == '+') {
		//	mapTypes[i] = mapTypes[i].substring(1);
		//	isDefaultBaseLayer = true;
		//}
		
		var newLayer = null;
		
		// TODO: allow adding of custom layers somehow
		// TODO: layer name alliasing system? php or js based?
		switch(mapTypes[i]) {
			case 'google' : case 'google-normal' : case 'google-satellite' : case 'google-hybrid' : case 'google-physical' :
				if (googleAPILoaded) {
					switch(mapTypes[i]) {
						case 'google-normal' :
							if (!usedNor){ newLayer = new OpenLayers.Layer.Google( 'Google Streets', {'sphericalMercator':true} ); usedNor = true; }
							break;
						case 'google-satellite' :
							if (!usedSat){ newLayer = new OpenLayers.Layer.Google( 'Google Satellite' , {type: G_SATELLITE_MAP , 'sphericalMercator':true}); usedSat = true; }
							break;		
						case 'google-hybrid' :
							if (!usedHyb){ newLayer = new OpenLayers.Layer.Google( 'Google Hybrid' , {type: G_HYBRID_MAP , 'sphericalMercator':true}); usedHyb = true; } 
							break;
						case 'google-physical' :
							if (!usedPhy){ newLayer = new OpenLayers.Layer.Google( 'Google Physical' , {type: G_PHYSICAL_MAP , 'sphericalMercator':true}); usedPhy = true; }
							break;						
						case 'google' :
							if (!usedNor){ map.addLayer(new OpenLayers.Layer.Google( 'Google Streets' , {'sphericalMercator':true})); usedNor = true; }
							if (!usedSat){ map.addLayer(new OpenLayers.Layer.Google( 'Google Satellite' , {type: G_SATELLITE_MAP , 'sphericalMercator':true})); usedSat = true; }
							if (!usedHyb){ map.addLayer(new OpenLayers.Layer.Google( 'Google Hybrid' , {type: G_HYBRID_MAP , 'sphericalMercator':true})); usedHyb = true; } 
							if (!usedPhy){ map.addLayer(new OpenLayers.Layer.Google( 'Google Physical' , {type: G_PHYSICAL_MAP , 'sphericalMercator':true})); usedPhy = true; }
							break;	
					}
				}
				else {
					if (!shownApiError) { window.alert('Please enter your Google Maps API key to use the Google Maps layers'); shownApiError = true; }
				}
				break;
			case 'bing' : case 'virtual-earth' :
				if (!usedBingNor){ map.addLayer(new OpenLayers.Layer.VirtualEarth( 'Bing Streets'  , {type: VEMapStyle.Shaded, 'sphericalMercator':true} )); usedBingNor = true; }
				if (!usedBingSat){ map.addLayer(new OpenLayers.Layer.VirtualEarth( 'Bing Satellite'  , {type: VEMapStyle.Aerial, 'sphericalMercator':true} )); usedBingSat = true; }					
				if (!usedBingHyb){ map.addLayer(new OpenLayers.Layer.VirtualEarth( 'Bing Hybrid'  , {type: VEMapStyle.Hybrid, 'sphericalMercator':true} )); usedBingHyb = true; }
				break;
			case 'bing-normal' :
				if (!usedBingNor){ newLayer = new OpenLayers.Layer.VirtualEarth( 'Bing Streets'  , {type: VEMapStyle.Shaded, 'sphericalMercator':true} ); usedBingNor = true; }
			case 'bing-satellite' :
				if (!usedBingSat){ newLayer = new OpenLayers.Layer.VirtualEarth( 'Bing Satellite'  , {type: VEMapStyle.Aerial, 'sphericalMercator':true} ); usedBingSat = true; }					
			case 'bing-hybrid' :			
				if (!usedBingHyb){ newLayer = new OpenLayers.Layer.VirtualEarth( 'Bing Hybrid'  , {type: VEMapStyle.Hybrid, 'sphericalMercator':true} ); usedBingHyb = true; }			
			case 'yahoo' :
				if (!usedYahooNor){ map.addLayer(new OpenLayers.Layer.Yahoo( 'Yahoo! Streets' ), {'sphericalMercator':true}); usedYahooNor = true; }
				if (!usedYahooSat){ map.addLayer(new OpenLayers.Layer.Yahoo( 'Yahoo! Satellite', {'type': YAHOO_MAP_SAT, 'sphericalMercator':true} )); usedYahooSat = true; }
				if (!usedYahooHyb){ map.addLayer(new OpenLayers.Layer.Yahoo( 'Yahoo! Hybrid', {'type': YAHOO_MAP_HYB, 'sphericalMercator':true} )); usedYahooHyb = true; }
				break;
			case 'yahoo-normal' :
				if (!usedYahooNor){ newLayer = new OpenLayers.Layer.Yahoo( 'Yahoo! Streets', {'sphericalMercator':true} ); usedYahooNor = true; }
				break;	
			case 'yahoo-satellite' :
				if (!usedYahooSat){ newLayer = new OpenLayers.Layer.Yahoo( 'Yahoo! Satellite', {'type': YAHOO_MAP_SAT, 'sphericalMercator':true} ); usedYahooSat = true; }
				break;	
			case 'yahoo-hybrid' :
				if (!usedYahooHyb){ newLayer = new OpenLayers.Layer.Yahoo( 'Yahoo! Hybrid', {'type': YAHOO_MAP_HYB, 'sphericalMercator':true} ); usedYahooHyb = true; }
				break;					
			case 'openlayers' : case 'open-layers' :
				if (!usedOLWMS){ newLayer = new OpenLayers.Layer.WMS( 'OpenLayers WMS', 'http://labs.metacarta.com/wms/vmap0', {layers: 'basic', 'sphericalMercator':true} ); usedOLWMS = true; }
				break;		
			case 'nasa' :
				if (!usedNasa){ newLayer = new OpenLayers.Layer.WMS("NASA Global Mosaic", "http://t1.hypercube.telascience.org/cgi-bin/landsat7",  {layers: "landsat7", 'sphericalMercator':true} ); usedNasa = true; }
				break;	
			case 'osm' : case 'openstreetmap' :
				if (!usedOSMarender){ map.addLayer(new OpenLayers.Layer.OSM.Osmarender("OSM arender")); usedOSMarender = true; }
				if (!usedOSMnik){ map.addLayer(new OpenLayers.Layer.OSM.Mapnik("OSM Mapnik"), {'sphericalMercator':true}); usedOSMnik = true; }
				if (!usedOSMcycle){ map.addLayer(new OpenLayers.Layer.OSM.CycleMap("OSM Cycle Map"), {'sphericalMercator':true}); usedOSMcycle = true; }
				break;	
			case 'osmarender' : 
				if (!usedOSMarender){ newLayer = new OpenLayers.Layer.OSM.Osmarender("OSM arender"); usedOSMarender = true; }
				break;					
			case 'osm-nik' : case 'osm-mapnik' :
				if (!usedOSMnik){ newLayer = new OpenLayers.Layer.OSM.Mapnik("OSM Mapnik"); usedOSMnik = true; }
				break;	
			case 'osm-cycle' : case 'osm-cyclemap' :
				if (!usedOSMcycle){ newLayer = new OpenLayers.Layer.OSM.CycleMap("OSM Cycle Map"); usedOSMcycle = true; }
				break;		
		}
		
		if (newLayer != null) {
			map.addLayer(newLayer);
			
			/*
			if (isDefaultBaseLayer) {
				// FIXME: This messes up the layer for some reason
				// Probably fixed by adding this code to an onload event (problem that other layer gets loaded first?) 
				map.setBaseLayer(newLayer);
				isDefaultBaseLayer = false;
			}
			*/
		}
	}	
	return map;
}
	
function getOLMarker(markerLayer, markerData, projectionObject) {
	var marker;
	
	if (markerData.icon != '') {
		//var iconSize = new OpenLayers.Size(10,17);
		//var iconOffset = new OpenLayers.Pixel(-(iconSize.w/2), -iconSize.h);
		marker = new OpenLayers.Marker(markerData.lonlat, new OpenLayers.Icon(markerData.icon)); // , iconSize, iconOffset
	} else {
		marker = new OpenLayers.Marker(markerData.lonlat);
	}
	
	if (markerData.title.length + markerData.label.length > 0 ) {
		
		// This is the handler for the mousedown event on the marker, and displays the popup
		marker.events.register('mousedown', marker,
			function(evt) { 
				var popup = new OpenLayers.Feature(markerLayer, markerData.lonlat).createPopup(true);
				
				if (markerData.title.length > 0 && markerData.label.length > 0) { // Add the title and label to the popup text
					popup.setContentHTML('<b>' + markerData.title + "</b><hr />" + markerData.label);
				}
				else {
					popup.setContentHTML(markerData.title + markerData.label);
				}
				
				popup.setOpacity(0.85);
				markerLayer.map.addPopup(popup);
				OpenLayers.Event.stop(evt); // Stop the event
			}
		);
		
	}	
	
	return marker;
}
	
function getOLMarkerData(lon, lat, title, label, icon) {
	lonLat = new OpenLayers.LonLat(lon, lat);
	return {
		lonlat: lonLat,
		title: title,
		label: label,
		icon: icon
		};
}

function initOLSettings(minWidth, minHeight) {
    OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
    OpenLayers.Util.onImageLoadErrorColor = "transparent";
	OpenLayers.Feature.prototype.popupClass = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {'autoSize': true, 'minSize': new OpenLayers.Size(minWidth, minHeight)});
}

