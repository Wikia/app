 /**
  * Javascript functions for OpenStreetMap functionallity in Semantic Maps
  *
  * @file SM_OSMFunctions.js
  * @ingroup SMOSM
  * 
  * @author Jeroen De Dauw
  */

/**
 * This function holds spesific functionallity for the OpenStreetMap form input of Semantic Maps
 */
function makeOSMFormInput(mapName, locationFieldName, mapParams) {
	var markers = Array();

	// Show a starting marker only if marker coordinates are provided
	if (mapParams.lat != null && mapParams.lon != null) {
		mapParams.markers = [(getOSMMarkerData(mapParams.lon, mapParams.lat, '', '', ''))];
	}

	// Click event handler for updating the location of the marker
	// TODO / FIXME: This will probably cause problems when used for multiple maps on one page.
     OpenLayers.Control.ClickHandler = OpenLayers.Class(OpenLayers.Control, {                
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
        	 var lonlat = this.getLonLatFromViewPortPx(e.xy);
        	 
        	 replaceMarker(mapName, lonlat);
        	 
        	 var proj = new OpenLayers.Projection("EPSG:4326");
        	 lonlat.transform(map.getProjectionObject(), proj);
             
             document.getElementById(locationFieldName).value = convertLatToDMS(lonlat.lat)+', '+convertLngToDMS(lonlat.lon);
         }

     });

	var clickHanler = new OpenLayers.Control.ClickHandler();
	mapParams.controls.push(clickHanler);
	mapParams.initializedContols = [];

    var map = new slippymap_map(mapName, mapParams);     
     
 	// Make the map variable available for other functions
 	eval("window.slippymaps." + mapName + " = map;");      
}
 
/**
 * Remove all markers from an OSM map (that's in window.OSMMaps), and place a new one.
 * 
 * @param mapName Name of the map as in OSMMaps[mapName].
 * @param newLocation The location for the new marker.
 * @return
 */
function replaceMarker(mapName, newLocation) {
	var map = slippymaps[mapName];

	var markerLayer = map.getLayer('markerLayer');
	
	removeOSMMarkers(markerLayer);
	markerLayer.addMarker(getOSMMarker(markerLayer, getOSMMarkerData(newLocation.lon, newLocation.lat, '', '', ''), map.getProjectionObject()));
	
	map.panTo(newLocation);
}
 
/**
 * Removes all markers from a marker layer.
 * 
 * @param markerLayer The layer to remove all markers from.
 * @return
 */
function removeOSMMarkers(markerLayer) {
	var markerCollection = markerLayer.markers;
	
	for (i in markerCollection) {
		markerLayer.removeMarker(markerCollection[i]);
	}
}