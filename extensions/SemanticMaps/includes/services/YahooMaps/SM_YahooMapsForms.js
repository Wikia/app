 /**
  * Javascript functions for Yahoo! Maps functionality in Semantic Maps
  *
  * @file SM_YahooMapsFunctions.js
  * @ingroup SMYahooMaps
  * 
  * @author Jeroen De Dauw
  */

/**
 * This function holds specific functionality for the Yahoo! Maps form input of Semantic Maps.
 */
function makeFormInputYahooMap( mapName, locationFieldName, lat, lon, zoom, type, types, controls, scrollWheelZoom, marker_lat, marker_lon ) {
	var map = createYahooMap(
		document.getElementById( mapName ),
		new YGeoPoint( lat, lon ),
		zoom,
		type,
		types,
		controls,
		scrollWheelZoom,
		[ { "lat": marker_lat, "lon": marker_lon, "title": "", "label": "", "icon": "" } ]
	);

	// Show a starting marker only if marker coordinates are provided.
	if ( marker_lat != null && marker_lon != null ) {
		map.addOverlay( createYMarker( new YGeoPoint( marker_lat, marker_lon ) ) );
	}
	
	// Click event handler for updating the location of the marker.
		YEvent.Capture(map, EventsList.MouseClick,
		function(_e, point) {
			var loc = new YGeoPoint(point.Lat, point.Lon)
			map.removeMarkersAll();
			document.getElementById(locationFieldName).value = convertLatToDMS(point.Lat)+', '+convertLngToDMS(point.Lon);
			map.addMarker(loc);
			map.panToLatLon(loc);
		}
	);
	
	// Make the map variable available for other functions
	if (!window.YMaps) window.YMaps = new Object;
	eval("window.YMaps." + mapName + " = map;"); 
}

/**
 * This function holds specific functionality for the Yahoo! Maps form input of Semantic Maps
 * TODO: Refactor as much code as possible to non specific functions
 */
function showYAddress(address, mapName, outputElementName, notFoundFormat) {
	var map = YMaps[mapName];
	
	map.removeMarkersAll();
	map.drawZoomAndCenter(address);
	
	YEvent.Capture(map, EventsList.onEndGeoCode,
		function(resultObj) {
			map.addOverlay(new YMarker(resultObj.GeoPoint));
			document.getElementById(outputElementName).value = convertLatToDMS(resultObj.GeoPoint.Lat) + ', ' + convertLngToDMS(resultObj.GeoPoint.Lon);				
		}
	);
}