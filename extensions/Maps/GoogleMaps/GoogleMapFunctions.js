 /**
  * Javascript functions for Google Maps functionallity in Maps and it's extensions
  *
  * @file GoogleMapFunctions.js
  * @ingroup Maps
  *
  * @author Robert Buzink
  * @author Yaron Koren   
  * @author Jeroen De Dauw
  */


/**
 * Returns GMarker object on the provided location. It will show a popup baloon
 * with title and label when clicked, if either of these is set.
 */
function createGMarker(point, title, label, icon) {
	var marker;
	
	if (icon != '') {
		var iconObj = new GIcon(G_DEFAULT_ICON);
		iconObj.image = icon;
		marker = new GMarker(point, {icon:iconObj});
	} else {
		marker = new GMarker(point);
	}
	
	if ((title + label).length > 0) {
		var bothTxtAreSet = title.length > 0 && label.length > 0;
		var popupText = bothTxtAreSet ? '<b>' + title + '</b><hr />' + label : title + label;	
		popupText = '<div style="overflow:auto;max-height:150px;">' + popupText + '</div>';

		GEvent.addListener(marker, 'click',
			function() {
				marker.openInfoWindowHtml(popupText, {maxWidth:350});
			}
		);		
	}

	return marker;
}

/**
 * Returns GMap2 object with the provided properties and markers.
 */
function initializeGoogleMap(mapName, width, height, lat, lon, zoom, type, types, controls, scrollWheelZoom, markers) {
	var map;
	
	var centre = (lat != null && lon != null) ? new GLatLng(lat, lon) : null;
	
	if (GBrowserIsCompatible()) {
		map = createGoogleMap(document.getElementById(mapName), new GSize(width, height), centre, zoom, type, types, controls, scrollWheelZoom, markers);
	}
		
	return map;
}

/**
 * Returns GMap2 object with the provided properties.
 */
function createGoogleMap(mapElement, size, centre, zoom, type, types, controls, scrollWheelZoom, markers) {
	var typesContainType = false;

	// TODO: Change labels of the moon/mars map types?
	for (var i = 0; i < types.length; i++) {
		if (types[i] == type) typesContainType = true;
	}
	
	if (! typesContainType) {
		types.push(type);
	}

	var map = new GMap2(mapElement, {size: size, mapTypes: types});
	
	map.setMapType(type);	
	
	// List of GControls: http://code.google.com/apis/maps/documentation/reference.html#GControl
	for (i in controls){
		switch (controls[i]) {
			case 'large' : 
				map.addControl(new GLargeMapControl3D());
				break;
			case 'small' : 
				map.addControl(new GSmallZoomControl3D());
				break;
			case 'large-original' : 
				map.addControl(new GLargeMapControl());
				break;
			case 'small-original' : 
				map.addControl(new GSmallMapControl());
				break;
			case 'zoom' : 
				map.addControl(new GSmallZoomControl());
				break;
			case 'type' : 
				map.addControl(new GMapTypeControl());
				break;		
			case 'type-menu' : 
				map.addControl(new GMenuMapTypeControl());
				break;
			case 'overview' : case 'overview-map' : 
				map.addControl(new GOverviewMapControl());
				break;					
			case 'scale' : 
				map.addControl(new GScaleControl());
				break;
			case 'nav-label' : case 'nav' : 
				map.addControl(new GNavLabelControl());
				break;	
		}
	}	
	
	var bounds = ((zoom == null || centre == null) && markers.length > 1) ? new GLatLngBounds() : null;
	
	for (i in markers) {
		var marker = markers[i];
		map.addOverlay(createGMarker(marker.point, marker.title, marker.label, marker.icon));
		if (bounds != null) bounds.extend(marker.point);
	}
	
	if (bounds != null) {
		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
	}
	
	if (centre != null) map.setCenter(centre);
	if (zoom != null) map.setZoom(zoom);
	
	if (scrollWheelZoom) map.enableScrollWheelZoom();
	
	map.enableContinuousZoom();
	
	return map;
}
 
function getGMarkerData(lat, lon, title, label, icon) {
		return {point: new GLatLng(lat, lon), title: title, label: label, icon: icon};
}
