 /**
  * Javascript functions for Yahoo! Maps functionallity in Maps and it's extensions
  *
  * @file YahooMapFunctions.js
  * @ingroup MapsYahooMaps
  *
  * @author Jeroen De Dauw
  */


/**
 * Returns YMarker object on the provided location.
 * It will show a popup baloon with title and label when clicked, if either of these is set.
 */
function createYMarker(geoPoint, title, label, icon){
	var newMarker;
	
	if (icon != '') {
		newMarker = new YMarker(geoPoint,  new YImage(icon));
	} else {
		newMarker = new YMarker(geoPoint);
	}	
	
	if ((title + label).length > 0) {
		var bothTxtAreSet = title.length > 0 && label.length > 0;
		var markerMarkup = bothTxtAreSet ? '<b>' + title + '</b><hr />' + label : title + label;
		YEvent.Capture(newMarker, EventsList.MouseClick, 
			function(){
				newMarker.openSmartWindow(markerMarkup);
			}
		);
	}

	return newMarker;
}

/**
 * Returns YMap object with the provided properties and markers.
 */
function initializeYahooMap(mapName, lat, lon, zoom, type, types, controls, scrollWheelZoom, markers, height) {
	 var centre = (lon != null && lat != null) ? new YGeoPoint(lat, lon) : null;
	 return createYahooMap(document.getElementById(mapName), centre, zoom, type, types, controls, scrollWheelZoom, markers, height);
}

/**
 * Returns YMap object with the provided properties.
 */
function createYahooMap(mapElement, centre, zoom, type, types, controls, scrollWheelZoom, markers, height) {
	var typesContainType = false;

	for (var i = 0; i < types.length; i++) {
		if (types[i] == type) typesContainType = true;
	}
	
	if (! typesContainType) types.push(type);	 
	 
	var map = new YMap(mapElement, type); 
	
	map.removeZoomScale();
	
	for (i in controls){
		if (controls[i].toLowerCase() == 'auto-zoom') {
			if (height > 42) controls[i] = height > 100 ? 'zoom' : 'zoom-short';
		}			
		
		switch (controls[i]) {
			case 'scale' : 
				map.addZoomScale();
			case 'type' :
				map.addTypeControl(types);
				break;		
			case 'pan' :
				map.addPanControl();
				break;
			case 'zoom' : 
				map.addZoomLong();
				break;		
			case 'zoom-short' : 
				map.addZoomShort();				
				break;
		}
	}
	
	map.setMapType(type);
	
	if (!scrollWheelZoom) map.disableKeyControls();
	
	var map_locations = ((zoom == null || centre == null) && markers.length > 1) ? Array() : null;
	
	for (i in markers) {
		var marker = markers[i];
		map.addOverlay(createYMarker(marker.point, marker.title, marker.label, marker.icon));
		if (map_locations != null) map_locations.push(marker.point);
	}

	if (map_locations != null) {
		var centerAndZoom = map.getBestZoomAndCenter(map_locations);
		map.drawZoomAndCenter(centerAndZoom.YGeoPoint, centerAndZoom.zoomLevel);
	}
	
	if (zoom != null) map.setZoomLevel(zoom);
	
	// FIXME: the code after this line REFUSES to be executed
	// This is probably caused by the YGeoPoint
	// Notice that the map object will therefore NOT BE RETURNED!
	if (centre != null) map.drawZoomAndCenter(centre);
	
	return map;
}
 
function getYMarkerData(lat, lon, title, label, icon) {
		return {point: new YGeoPoint(lat, lon), title: title, label: label, icon: icon};
	}