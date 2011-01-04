 /**
  * Javascript functions for Yahoo! Maps functionality in Maps and its extensions
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
	
	if ( icon != '' ) {
		/* Determine size of icon and pass it in */
		var newimg = new Image();
		newimg.src = icon;
		newMarker = new YMarker( geoPoint,  new YImage( icon, new YSize( newimg.width, newimg.height ) ) );
	} else {
		newMarker = new YMarker( geoPoint );
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
function initializeYahooMap( mapName, lat, lon, zoom, type, types, controls, scrollWheelZoom, markers ) {
	 var centre = ( lon != null && lat != null ) ? new YGeoPoint( lat, lon ) : null;
	 return createYahooMap( document.getElementById( mapName ), centre, zoom, type, types, controls, scrollWheelZoom, markers );
}

/**
 * Returns YMap object with the provided properties.
 */
function createYahooMap( mapElement, centre, zoom, type, types, controls, scrollWheelZoom, markers ) {
	var typesContainType = false;

	for (var i = 0; i < types.length; i++) {
		if (types[i] == type) typesContainType = true;
	}
	
	if (! typesContainType) types.push(type);	 
	 
	var map = new YMap(mapElement, type); 
	
	map.removeZoomScale();
	
	for ( var i = controls.length - 1; i >= 0; i-- ){
		if ( controls[i].toLowerCase() == 'auto-zoom' ) {
			if ( mapElement.offsetHeight > 42 ) controls[i] = mapElement.offsetHeight > 100 ? 'zoom' : 'zoom-short';
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
	
	map.setMapType( type );
	
	if ( !scrollWheelZoom ) map.disableKeyControls();
	
	var map_locations = ( ( zoom == null || centre == null ) && markers.length > 1 ) ? Array() : null;
	
	for ( var i= markers.length - 1; i >= 0; i-- ) {
		var marker = markers[i];
		marker.point = new YGeoPoint( marker.lat, marker.lon );		
		map.addOverlay( createYMarker( marker.point, marker.title, marker.label, marker.icon ) );
		if ( map_locations != null ) map_locations.push( marker.point );
	}

	if (map_locations != null) {
		var centerAndZoom = map.getBestZoomAndCenter(map_locations);
		map.drawZoomAndCenter(centerAndZoom.YGeoPoint, centerAndZoom.zoomLevel);
	}
	
	if ( zoom != null ) map.setZoomLevel( zoom );
	
	// FIXME: the code after this line REFUSES to be executed
	// This is probably caused by the YGeoPoint
	// Notice that the map object will therefore NOT BE RETURNED!
	if ( centre != null ) map.drawZoomAndCenter( centre );
	
	return map;
}