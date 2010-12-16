/* 
 * @file OSMFunctions.js
 * @ingroup MapsOpenStreetMap
 *
 * @author Harry Wood, Jens Frank, Grant Slater, Raymond Spekking, Jeroen De Dauw and others 
 *
 * @description
 *
 * Javascript functions for OSM optimized Open Layers functionallity in Maps and it's extensions
 *
 * This defines what happens when <slippymap> tag is placed in the wikitext
 * 
 * We show a map based on the lat/lon/zoom data passed in. This extension brings in
 * the OpenLayers javascript, to show a slippy map.
 * 
 * Usage example:
 * <slippymap lat=51.485 lon=-0.15 z=11 w=300 h=200 layer=osmarender></slippymap>
 * 
 * Tile images are not cached local to the wiki.
 * To acheive this (remove the OSM dependency) you might set up a squid proxy,
 * and modify the requests URLs here accordingly.
 * 
 * This file should be placed in the mediawiki 'extensions' directory
 * ...and then it needs to be 'included' within LocalSettings.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */

var slippymaps = new Array();
var mapId = 0;
var layer = null;

if (false) { // wgSlippyMapSlippyByDefault
	addOnloadHook(slippymap_init);
}
	
function slippymap_init() {
	for(keyName in slippymaps) {
		slippymaps[keyName].init();
	}
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

function slippymap_map(mapId, mapParams) {
	var self = this;
	this.mapId = mapId;
	
	for (key in mapParams)
		this[key] = mapParams[key];

	// Add the controls
	this.mapOptions = {controls: []};

	for (i in this.controls) {
		if (typeof controls[i] == 'string') {
			if (this.controls[i].toLowerCase() == 'autopanzoom') {
				if (this.height > 140) this.controls[i] = this.height > 320 ? 'panzoombar' : 'panzoom';
			}
			
			control = getValidControlName(this.controls[i]);
			
			if (control) {
				eval(' this.mapOptions.controls.push( new OpenLayers.Control.' + control + '() ); ');
			}			
		}
		else {
			this.mapOptions.controls.push(controls[i]); // If a control is provided, instead a string, just add it
			controls[i].activate(); // And activate it			
		}
	}		
}

slippymap_map.prototype.init = function() {
	/* Swap out against the preview image */
	var previewImage = document.getElementById(this.mapId + '-preview');	
	if (previewImage)
		previewImage.style.display = 'none';

	this.map = this.osm_create(this.mapId, this.lon, this.lat, this.zoom, this.initializedContols);
	
	var centerIsSet = this.lon != null && this.lat != null;
	
	var bounds = null;	
	
	if (this.markers.length > 0) {
		var markerLayer = new OpenLayers.Layer.Markers('Markers');
		markerLayer.id= 'markerLayer';
		this.map.addLayer(markerLayer);		
		
		if (this.markers.length > 1 && (!centerIsSet || this.zoom == null)) {
			bounds = new OpenLayers.Bounds();
		}	
		
		for (i in this.markers) {
			this.markers[i].lonlat.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
			if (bounds != null) bounds.extend(this.markers[i].lonlat); // Extend the bounds when no center is set
			markerLayer.addMarker(getOSMMarker(markerLayer, this.markers[i], this.map.getProjectionObject())); // Create and add the marker
		}		
		
	}
	
	if (bounds != null) map.zoomToExtent(bounds); // If a bounds object has been created, use it to set the zoom and center
	
	if (centerIsSet) { // When the center is provided, set it
		var centre = new OpenLayers.LonLat(this.lon, this.lat);
		centre.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
		this.map.setCenter(centre); 
	}	
	
	if (this.zoom != null) this.map.zoomTo(this.zoom); // When the zoom is provided, set it	
}

slippymap_map.prototype.osm_create = function(mapId, lon, lat, zoom, initializedContols) {
	var osmLayer;
	var map = new OpenLayers.Map(mapId, this.mapOptions /* all provided for by OSM.js */);
	
	if (initializedContols) {
		for (i in initializedContols) {
			map.addControl(initializedContols[i]);
			initializedContols[i].activate();
		}
	}	
	
	if (this.layer == 'osm-like') {
		osmLayer = new OpenLayers.Layer.OSM("OpenStreetMap", 'http://cassini.toolserver.org/tiles/osm-like/' + this.locale + '/${z}/${x}/${y}.png');
    }
	
	map.addLayers([osmLayer]);
	map.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:4326'), map.getProjectionObject()), zoom);
	return map;
}

function getOSMMarkerData(lon, lat, title, label, icon) {
	lonLat = new OpenLayers.LonLat(lon, lat);
	return {
		lonlat: lonLat,
		title: title,
		label: label,
		icon: icon
		};
}


function getOSMMarker(markerLayer, markerData, projectionObject) {
	var marker;
	
	if (markerData.icon != '') {
		marker = new OpenLayers.Marker(markerData.lonlat, new OpenLayers.Icon(markerData.icon));
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

