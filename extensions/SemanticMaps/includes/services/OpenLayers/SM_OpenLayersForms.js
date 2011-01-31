 /**
  * Javascript functions for OpenLayers functionality in Semantic Maps
  *
  * @file SM_OpenLayersFunctions.js
  * @ingroup SMOpenLayers
  * 
  * @author Jeroen De Dauw
  */

/**
 * This function holds specific functionality for the Open Layers form input of Semantic Maps.
 */
function makeFormInputOpenLayer( mapName, locationFieldName, lat, lon, zoom, marker_lat, marker_lon, layers, controls, height, langCode ) {
	var markers = Array();

	// Show a starting marker only if marker coordinates are provided.
	if ( marker_lat != null && marker_lon != null ) {
		markers.push( { "lat": marker_lat, "lon": marker_lon, "title": "", "label": "", "icon": "" } );
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
        	 var lonlat = map.getLonLatFromViewPortPx(e.xy);
        	 
        	 replaceMarker(mapName, lonlat);
        	 
        	 var proj = new OpenLayers.Projection("EPSG:4326");
        	 lonlat.transform(map.getProjectionObject(), proj);
             
             document.getElementById(locationFieldName).value = convertLatToDMS(lonlat.lat)+', '+convertLngToDMS(lonlat.lon);
         }

     });
     
	var clickHanler = new OpenLayers.Control.Click();
	controls.push(clickHanler);
     
	var map = initOpenLayer( mapName, lon, lat, zoom, layers, controls, markers, height, langCode );
	
	// Make the map variable available for other functions
	if (!window.OLMaps) window.OLMaps = new Object;
	eval("window.OLMaps." + mapName + " = map;"); 
}

/**
 * Remove all markers from an OL map (that's in window.OLMaps), and place a new one.
 * 
 * @param mapName Name of the map as in OLMaps[mapName].
 * @param newLocation The location for the new marker.
 */
function replaceMarker(mapName, newLocation) {
	var map = OLMaps[mapName];
	var markerLayer = map.getLayer('markerLayer');
	
	removeMarkers(markerLayer);
	markerLayer.addMarker(getOLMarker(
		markerLayer,
		{ lonlat:newLocation, title: "", label:"", icon:"" },
		map.getProjectionObject())
	);
	
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
	
	for (var i = 0; i < markerCollection.length; i++) {
		markerLayer.removeMarker(markerCollection[i]);
	}
}