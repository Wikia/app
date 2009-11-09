 /**
  * Javascript functions for OpenLayers functionallity in Semantic Maps
  *
  * @file SM_OpenLayersFunctions.js
  * @ingroup SemanticMaps
  * 
  * @author Jeroen De Dauw
  */

/**
 * This function holds spesific functionallity for the Open Layers form input of Semantic Maps
 * TODO: Refactor as much code as possible to non specific functions
 */
function makeFormInputOpenLayer(mapName, locationFieldName, lat, lon, zoom, marker_lat, marker_lon, layers, controls, height) {
	var markers = Array();

	// Show a starting marker only if marker coordinates are provided
	if (marker_lat != null && marker_lon != null) {
		markers.push(getOLMarkerData(marker_lon, marker_lat, '', ''));
	}		
	
	// Click event handler for updating the location of the marker
	// TODO / FIXME: This will probably cause problems when used for multiple maps on one page.
     OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {                
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
             replaceMarker(mapName, map.getLonLatFromViewPortPx(e.xy));
             document.getElementById(locationFieldName).value = convertLatToDMS(map.getLonLatFromViewPortPx(e.xy).lat)+', '+convertLngToDMS(map.getLonLatFromViewPortPx(e.xy).lon);
         }

     });
     
	var clickHanler = new OpenLayers.Control.Click();
     controls.push(clickHanler);
     
     var map = initOpenLayer(mapName, lon, lat, zoom, layers, controls, markers, height);
	
	// Make the map variable available for other functions
	if (!window.OLMaps) window.OLMaps = new Object;
	eval("window.OLMaps." + mapName + " = map;"); 
}


/**
 * This function holds spesific functionallity for the Open Layers form input of Semantic Maps
 * TODO: Refactor as much code as possible to non specific functions
 */
function showOLAddress(address, mapName, outputElementName, notFoundFormat) {

	var map = OLMaps[mapName];
	var geocoder = new GClientGeocoder();

	geocoder.getLatLng(address,
		function(point) {
			if (!point) {
				window.alert(address + ' ' + notFoundFormat);
			} else {
				var loc = new OpenLayers.LonLat(point.x, point.y);
				
				replaceMarker(mapName, loc);
				document.getElementById(outputElementName).value = convertLatToDMS(point.y) + ', ' + convertLngToDMS(point.x);
			}
		}
	);

}
 
/**
 * Remove all markers from an OL map (that's in window.OLMaps), and pplace a new one.
 * 
 * @param mapName Name of the map as in OLMaps[mapName].
 * @param newLocation The location for the new marker.
 * @return
 */
function replaceMarker(mapName, newLocation) {
	var map = OLMaps[mapName];
	var markerLayer = map.getLayer('markerLayer');
	
	removeMarkers(markerLayer);
	markerLayer.addMarker(getOLMarker(markerLayer, getOLMarkerData(newLocation.lon, newLocation.lat, '', ''), map.getProjectionObject()));
	
	map.panTo(newLocation);
}
 
/**
 * Removes all markers from a marker layer.
 * 
 * @param markerLayer The layer to remove all markers from.
 * @return
 */
function removeMarkers(markerLayer) {
	var markerCollection = markerLayer.markers;
	
	for (i in markerCollection) {
		markerLayer.removeMarker(markerCollection[i]);
	}
}