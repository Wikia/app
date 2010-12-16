/* 
 * @file
 *
 * @description
 *
 * OpenStreetMap SlippyMap - MediaWiki extension
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
 * @license 
 *
 * Copyright 2008 Harry Wood, Jens Frank, Grant Slater, Raymond Spekking and others
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

OpenLayers.Lang.setCode(wgSlippyMapLanguageCode);

var slippymaps = new Array();
var mapId = 0;
var layer = null;

if (wgSlippyMapSlippyByDefault) {
	addOnloadHook(slippymap_init);
}
	
function slippymap_init() {
	for (i=0; i < slippymaps.length; i++) {
		slippymaps[i].init();
	}
}
	
function slippymap_map(mapId, mapParams) {
	var self = this;
	this.mapId = mapId;
	
	for (key in mapParams)
		this[key] = mapParams[key];
		
	var buttonsPanel = new OpenLayers.Control.Panel( { displayClass: "buttonsPanel" } );
	buttonsPanel.addControls([	new OpenLayers.Control.Button({
									title: wgSlippyMapButtonCode,
									displayClass: "getWikiCodeButton",
									trigger: function() { self.getWikicode(); }
								}), 
								new OpenLayers.Control.Button({
									title: wgSlippyMapResetview,
									displayClass: "resetButton",
									trigger: function() { self.resetPosition(); }
								})
							]);

	this.mapOptions = { controls: [ new OpenLayers.Control.Navigation(),
                                  	new OpenLayers.Control.ArgParser(),
                                  	new OpenLayers.Control.Attribution(),
                                  	new OpenLayers.Control.LayerSwitcher(),
                                  	buttonsPanel ]                                  
                      };

	/* Add the zoom bar control, except if the map is only little */
	if (this.height > 320)
		this.mapOptions.controls.push(new OpenLayers.Control.PanZoomBar());
	else if (this.height > 140)
		this.mapOptions.controls.push(new OpenLayers.Control.PanZoom());	
}

slippymap_map.prototype.init = function() {
	/* Swap out against the preview image */
	var previewImage = document.getElementById('mapPreview' + this.mapId);	
	if (previewImage)
		previewImage.style.display = 'none';

	switch(this.mode) {
		case "satellite":
			/* Nasa WorldWind */
			this.map = this.ww_create(this.mapId, this.lon, this.lat, this.zoom, this.layer);
			break;
		case "wms":
			/* wms map */
			this.map = this.wms_create(this.mapId, this.lon, this.lat, this.zoom, this.layer);
			break;
		default:
			/* OpenStreetMap */
			this.map = this.osm_create(this.mapId, this.lon, this.lat, this.zoom);
	}
	
	if (this.marker) {
		var markers = new OpenLayers.Layer.Markers( "Markers" );
		this.map.addLayer(markers);
		var icon = OpenLayers.Marker.defaultIcon();
		markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(this.lon, this.lat).transform(new OpenLayers.Projection('EPSG:4326'), this.map.getProjectionObject()), icon));
	}
}

slippymap_map.prototype.osm_create = function(mapId, lon, lat, zoom) {
	var map;
	var osmLayer;
	map = new OpenLayers.Map('map' + mapId, this.mapOptions /* all provided for by OSM.js */);
	
	if (this.layer == 'mapnik' ) {
		osmLayer = new OpenLayers.Layer.OSM();
	} else if (this.layer == 'osmarender' ) {
		osmLayer = new OpenLayers.Layer.OSM("t@h", 
 	       [ "http://a.tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png",
 			  "http://b.tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png",
			  "http://c.tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png"]);
	} else if (this.layer == 'maplint' ) {
		osmLayer = new OpenLayers.Layer.OSM("maplint", 
        	[ "http://a.tah.openstreetmap.org/Tiles/maplint/${z}/${x}/${y}.png",
 			  "http://b.tah.openstreetmap.org/Tiles/maplint/${z}/${x}/${y}.png",
			  "http://c.tah.openstreetmap.org/Tiles/maplint/${z}/${x}/${y}.png"]);
	} else if (this.layer == 'cycle' ) {
		osmLayer = new OpenLayers.Layer.OSM("cycle", 
        	[ "http://a.thunderflames.org/tiles/cycle/${z}/${x}/${y}.png",
 			  "http://b.thunderflames.org/tiles/cycle/${z}/${x}/${y}.png",
			  "http://c.thunderflames.org/tiles/cycle/${z}/${x}/${y}.png"]);
	}	
	
	map.addLayers([osmLayer]);
	map.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:4326'), map.getProjectionObject()), zoom);
	return map;
}

/* Nasa WorldWind 
 * TODO make configurable
 */
slippymap_map.prototype.ww_create = function(mapId, lon, lat, zoom, layer) {
	var map;
	var wwLayer;
	this.mapOptions.maxResolution = 1.6;
	this.mapOptions.numZoomLevels = 21;

	map = new OpenLayers.Map('map' + mapId, this.mapOptions);
	
	if (this.layer == 'urban' ) {
		wwLayer = new OpenLayers.Layer.WorldWind( 'urban',
       		  "http://worldwind25.arc.nasa.gov/tile/tile.aspx?", .8, 9,
        		{T:"104"}, { tileSize: new OpenLayers.Size(512,512) });
	// TODO
	} else if (this.layer  == 'landsat') {
	// TODO
	} else if (this.layer == 'bluemarble') {

	}

	map.addLayers([wwLayer]);
	map.setCenter(new OpenLayers.LonLat(lon, lat), zoom);
	return map;
}

/* WMS custom map
 * TODO make configurable
 */
slippymap_map.prototype.wms_create = function(mapId, lon, lat, zoom) {
	/* ? */
	var map;
	this.mapOptions.maxResolution = 360/512/16;
	this.mapOptions.numZoomLevels = 15;
       	map = new OpenLayers.Map('map' + mapId, this.mapOptions);
	wmsLayer = new OpenLayers.Layer.WMS(
		"Fire detects", "http://map.ngdc.noaa.gov/wmsconnector/com.esri.wms.Esrimap/firedetects",
               	{
	        	layers: 'firedetects',
	                format: 'image/png'
	        });
	map.addLayers([wmsLayer]);				
	map.setCenter(new OpenLayers.LonLat( lon, lat ), zoom);
	return map;
}

slippymap_map.prototype.resetPosition = function() {
	this.map.setCenter(new OpenLayers.LonLat(this.lon, this.lat).transform(new OpenLayers.Projection('EPSG:4326'), this.map.getProjectionObject()), this.zoom);
}

slippymap_map.prototype.getWikicode = function() {
	LL = this.map.getCenter().transform(this.map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	Z = this.map.getZoom();
	size = this.map.getSize();
	
	prompt(
	    wgSlippyMapCode,
	    "<slippymap lat=" + LL.lat + " lon=" + LL.lon + " zoom=" + Z + " width=" + size.w + " height=" + size.h + " mode=" + this.mode + " layer=" + this.layer + (this.marker == 0 ? "" : " marker=" + this.marker) + " />"
	);
}

