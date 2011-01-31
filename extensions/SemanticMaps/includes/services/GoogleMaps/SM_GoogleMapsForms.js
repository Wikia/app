 /**
  * Javascript functions for Google Maps functionality in Semantic Maps
  *
  * @file SM_GoogleMapFunctions.js
  * @ingroup SMGoogleMaps
  * 
  * @author Jeroen De Dauw
  */

/**
 * This function holds specific functionality for the Google Maps form input of Semantic Maps
 */
function makeGoogleMapFormInput( mapName, locationFieldName, mapOptions, marker_lat, marker_lon ) {
	 if ( GBrowserIsCompatible() ) {
		 mapOptions.centre =  new GLatLng(mapOptions.lat, mapOptions.lon);		 
		 var map = createGoogleMap( mapName, mapOptions, [ { "lat": marker_lat, "lon": marker_lon, "title": "", "label": "", "icon": "" } ] );
		 
		// Show a starting marker only if marker coordinates are provided
		if ( marker_lat != null && marker_lon != null ) {
			map.addOverlay( new GMarker( new GLatLng( marker_lat, marker_lon ) ) );
		}
		
		// Click event handler for updating the location of the marker
		GEvent.addListener(map, "click",
			function(overlay, point) {
				if (overlay) {
					map.removeOverlay(overlay);
				} else {
					map.clearOverlays();
					document.getElementById(locationFieldName).value = convertLatToDMS(point.y)+', '+convertLngToDMS(point.x);
					map.addOverlay(new GMarker(point));
					map.panTo(point);
				}
			}
		);
		
		// Make the map variable available for other functions
		if (!window.GMaps) window.GMaps = new Object;
		eval("window.GMaps." + mapName + " = map;"); 
	}
}

/**
 * This function holds specific functionality for the Google Maps form input of Semantic Maps.
 */
function showGAddress(address, mapName, outputElementName, notFoundFormat) {
	var map = GMaps[mapName];
	var geocoder = new GClientGeocoder();

	geocoder.getLatLng(address,
		function(point) {
			if (!point) {
				window.alert(address + ' ' + notFoundFormat);
			} else {
				map.clearOverlays();
				map.setCenter(point, 14);
				var marker = new GMarker(point);
				map.addOverlay(marker);
				document.getElementById(outputElementName).value = convertLatToDMS(point.y) + ', ' + convertLngToDMS(point.x);
			}
		}
	);

}