/**
 * JavaSript for OpenLayers maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 *
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 * @author Daniel Werner
 * @author Peter Grassberger < petertheone@gmail.com >
 *
 * @todo This whole JS is very blown up and could use some quality refactoring.
 */

(function ($, mw, OpenLayers) {
	$.fn.openlayers = function (mapElementId, options) {

		this.map = null;
		this.options = options;
		this.bounds = null;

		OpenLayers._getScriptLocation = function() {
			return mw.config.get('wgScriptPath') + '/extensions/Maps/includes/services/OpenLayers/OpenLayers/';
		};

		this.getOLMarker = function (markerLayer, markerData) {
			var marker;

			if (markerData.hasOwnProperty('icon') && markerData.icon !== "") {
				marker = new OpenLayers.Marker(markerData.lonlat, new OpenLayers.Icon(markerData.icon));
			} else {
				marker = new OpenLayers.Marker(markerData.lonlat, new OpenLayers.Icon(markerLayer.defaultIcon));
			}

			// This is the handler for the mousedown/touchstart event on the marker, and displays the popup.
			function handleClickEvent(evt) {
				if (markerData.link) {
					window.location.href = markerData.link;
				} else if (markerData.text !== '') {
					var popup = new OpenLayers.Feature(markerLayer, markerData.lonlat).createPopup(true);
					popup.setContentHTML(markerData.text);
					markerLayer.map.addPopup(popup);
					OpenLayers.Event.stop(evt); // Stop the event.
				}

				if (markerData.visitedicon && markerData.visitedicon !== '') {
					if(markerData.visitedicon === 'on'){
						//when keyword 'on' is set, set visitedicon to a default official marker
						markerData.visitedicon = mw.config.get('wgScriptPath')+'/extensions/Maps/includes/services/OpenLayers/OpenLayers/img/marker3.png';
					}
					marker.setUrl(markerData.visitedicon);
					markerData.visitedicon = undefined;
				}
			}
			marker.events.register('mousedown', marker, handleClickEvent);
			marker.events.register('touchstart', marker, handleClickEvent);

			return marker;
		};

		this.addMarkers = function (map, options) {
			if (!options.locations) {
				options.locations = [];
			}

			var locations = options.locations;

			if (locations.length > 1 && ( options.centre === false || options.zoom === false )) {
				this.bounds = new OpenLayers.Bounds();
			}

			this.groupLayers = new Object();
			this.groups = 0;

			for (var i = locations.length - 1; i >= 0; i--) {
				this.addMarker( locations[i] );
			}

			if (this.bounds != null) map.zoomToExtent(this.bounds); // If a bounds object has been created, use it to set the zoom and center.
		};

		this.addMarker = function (markerData) {
			markerData.group = !markerData.hasOwnProperty('group') ? '' : markerData.group;
			// Create a own marker-layer for the marker group:
			if (!this.groupLayers[ markerData.group ]) {
				// in case no group is specified, use default marker layer:
				var layerName = markerData.group != '' ? markerData.group : mw.msg('maps-markers');
				var curLayer = new OpenLayers.Layer.Markers(layerName);
				this.groups++;
				curLayer.id = 'markerLayer' + this.groups;
				// define default icon, one of ten in different colors, if more than ten layers, colors will repeat:
				curLayer.defaultIcon = mw.config.get( 'egMapsScriptPath' ) + '/includes/services/OpenLayers/OpenLayers/img/marker' + ( ( this.groups + 10 ) % 10 ) + '.png';
				map.addLayer(curLayer);
				this.groupLayers[ markerData.group ] = curLayer;
			} else {
				// if markers of this group exist already, they have an own layer already
				var curLayer = this.groupLayers[ markerData.group ];
			}

			markerData.lonlat = new OpenLayers.LonLat(markerData.lon, markerData.lat);

			if (!hasImageLayer) {
				markerData.lonlat.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
			}

			if (this.bounds != null) this.bounds.extend(markerData.lonlat); // Extend the bounds when no center is set.
			var marker = this.getOLMarker(curLayer, markerData);
			this.markers.push({
				target:marker,
				data:markerData
			});
			curLayer.addMarker(marker); // Create and add the marker.
		};

		this.removeMarkers = function () {
			var map = this.map;
			$.each(this.groupLayers, function(index, layer) {
				map.removeLayer(layer);
			});
			this.groupLayers = new Object();
			this.groups = 0;
			this.markers = [];
		};

		this.addControls = function (map, controls, mapElement) {
			// Add the controls.
			for (var i = controls.length - 1; i >= 0; i--) {
				// If a string is provided, find the correct name for the control, and use eval to create the object itself.
				if (typeof controls[i] == 'string') {
					if (controls[i].toLowerCase() == 'autopanzoom') {
						if (mapElement.offsetHeight > 140) controls[i] = mapElement.offsetHeight > 320 ? 'panzoombar' : 'panzoom';
					}

					control = getValidControlName(controls[i]);

					if (control) {
						map.addControl(eval('new OpenLayers.Control.' + control + '() '));
					}
				}
				else {
					map.addControl(controls[i]); // If a control is provided, instead a string, just add it.
					controls[i].activate(); // And activate it.
				}
			}

			map.addControl(new OpenLayers.Control.Attribution());
			map.addControl(new OpenLayers.Control.MousePosition({
				formatOutput: function(lonLat) {
					var digits = parseInt(this.numDigits);
					var newHtml =
						this.prefix +
						lonLat.lat.toFixed(digits) +
						this.separator +
						lonLat.lon.toFixed(digits) +
						this.suffix;
					return newHtml;
				}
			}));
		};

		this.addLine = function (properties) {
			var pos = [];
			for (var x = 0; x < properties.pos.length; x++) {
				var point = new OpenLayers.Geometry.Point(properties.pos[x].lon, properties.pos[x].lat);
				point.transform(
					new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
					map.getProjectionObject() // to Spherical Mercator Projection
				);
				pos.push(point);
			}

			var style = {
				'strokeColor':properties.strokeColor,
				'strokeWidth':properties.strokeWeight,
				'strokeOpacity':properties.strokeOpacity
			};

			var line = new OpenLayers.Geometry.LineString(pos);
			var lineFeature = new OpenLayers.Feature.Vector(line, properties, style);
			this.lineLayer.addFeatures([lineFeature]);
		};

		this.addPolygon = function (properties) {
			var pos = [];
			for (var x = 0; x < properties.pos.length; x++) {
				var point = new OpenLayers.Geometry.Point(properties.pos[x].lon, properties.pos[x].lat);
				point.transform(
					new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
					map.getProjectionObject() // to Spherical Mercator Projection
				);
				pos.push(point);
			}

			var style = {
				'strokeColor':properties.strokeColor,
				'strokeWidth':properties.strokeWeight,
				'strokeOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.strokeOpacity,
				'fillColor':properties.fillColor,
				'fillOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.fillOpacity
			};

			var polygon = new OpenLayers.Geometry.LinearRing(pos);
			var polygonFeature = new OpenLayers.Feature.Vector(polygon, properties, style);
			this.polygonLayer.addFeatures([polygonFeature]);
		};

		this.addCircle = function (properties) {
			var style = {
				'strokeColor':properties.strokeColor,
				'strokeWidth':properties.strokeWeight,
				'strokeOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.strokeOpacity,
				'fillColor':properties.fillColor,
				'fillOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.fillOpacity
			};

			var point = new OpenLayers.Geometry.Point(properties.centre.lon, properties.centre.lat);
			point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				map.getProjectionObject() // to Spherical Mercator Projection
			);
			var circle = OpenLayers.Geometry.Polygon.createRegularPolygon(
				point,
				properties.radius,
				30
			);
			var circleFeature = new OpenLayers.Feature.Vector(circle, properties, style);
			this.circleLayer.addFeatures([circleFeature])
		};

		this.addRectangle = function (properties) {
			var style = {
				'strokeColor':properties.strokeColor,
				'strokeWidth':properties.strokeWeight,
				'strokeOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.strokeOpacity,
				'fillColor':properties.fillColor,
				'fillOpacity':properties.onlyVisibleOnHover === true ? 0 : properties.fillOpacity
			};

			var point1 = new OpenLayers.Geometry.Point(properties.ne.lon, properties.ne.lat);
			var point2 = new OpenLayers.Geometry.Point(properties.sw.lon, properties.sw.lat);
			point1.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				map.getProjectionObject() // to Spherical Mercator Projection
			);
			point2.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				map.getProjectionObject() // to Spherical Mercator Projection
			);

			var bounds = new OpenLayers.Bounds();
			bounds.extend(point1);
			bounds.extend(point2);

			var rectangle = bounds.toGeometry();
			var rectangleFeature = new OpenLayers.Feature.Vector(rectangle, properties, style);
			this.rectangleLayer.addFeatures([rectangleFeature])
		};

		/**
		 * Gets a valid control name (with excat lower and upper case letters),
		 * or returns false when the control is not allowed.
		 */
		function getValidControlName(control) {
			var OLControls = [
				'ArgParser', 'Attribution', 'Button', 'DragFeature', 'DragPan',
				'DrawFeature', 'EditingToolbar', 'GetFeature', 'KeyboardDefaults', 'LayerSwitcher',
				'Measure', 'ModifyFeature', 'MouseDefaults', 'MouseToolbar',
				'Navigation', 'NavigationHistory', 'NavToolbar', 'OverviewMap', 'Pan',
				'Panel', 'PanPanel', 'PanZoom', 'PanZoomBar', 'Permalink',
				'Scale', 'ScaleLine', 'SelectFeature', 'Snapping', 'Split',
				'WMSGetFeatureInfo', 'ZoomBox', 'ZoomIn', 'ZoomOut', 'ZoomPanel',
				'ZoomToMaxExtent'
			];

			for (var i = OLControls.length - 1; i >= 0; i--) {
				if (control == OLControls[i].toLowerCase()) {
					return OLControls[i];
				}
			}

			return false;
		}

		var _this = this;
		this.markers = [];

		// Remove the loading map message.
		this.text('');

		// Create a new OpenLayers map with without any controls on it.
		var mapOptions = {
			controls:[]
		};

		// Remove the loading map message.
		this.text( '' );

		/**
		 * ToDo: That layers being created by 'eval' will deny us the possibility to
		 * set certain options. It's possible to set properties of course but they will
		 * show no effect since they are not passed as options to the constructor.
		 * With this working we could adjust max/minScale to display overlays independent
		 * from the specified values in the layer which only make sense if the layer is
		 * displayed as base layer. On the other hand, it might be intended overlay
		 * layers are only seen at a certain zoom level.
		 */

		// collect all layers and check for custom image layer:
		var hasImageLayer = false;
		var layers = [];

		// evaluate base layers:
		for( i = 0, n = options.layers.length; i < n; i++ ) {
			layer = eval( options.layers[i] );
			layer.isBaseLayer = true;
			// Ideally this would check if the object is of type OpenLayers.layer.image
			if( layer.isImage === true ) {
				hasImageLayer = true;
				layer.transitionEffect = 'resize'; // makes transition smoother
			}
			layers.push( layer );
		}

		// Create KML layer and push it to layers
		if (options.kml.length>0) { 
			var kmllayer = new OpenLayers.Layer.Vector("KML Layer", {
				strategies: [new OpenLayers.Strategy.Fixed()],
				protocol: new OpenLayers.Protocol.HTTP({
					url: options.kml,
				format: new OpenLayers.Format.KML({
					extractStyles: true, 
				extractAttributes: true,
				maxDepth: 2,
				'internalProjection': new OpenLayers.Projection( "EPSG:900913" ), //EPSG:3785/900913
				'externalProjection': new OpenLayers.Projection( "EPSG:4326" ) //EPSG:4326
				})
				})
			});
			layers.push( kmllayer );
		}
		// Create a new OpenLayers map with without any controls on it.
		var mapOptions = {
			controls: []
		};
		//mapOptions.units = "m";
		if ( !hasImageLayer ) {
			mapOptions.projection = new OpenLayers.Projection( "EPSG:900913" );
			mapOptions.displayProjection = new OpenLayers.Projection( "EPSG:4326" );
			mapOptions.units = "m";
			mapOptions.numZoomLevels = 18;
			mapOptions.maxResolution = 156543.0339;
			mapOptions.maxExtent = new OpenLayers.Bounds( -20037508, -20037508, 20037508, 20037508 );
		}

		this.map = new OpenLayers.Map(mapElementId, mapOptions);
		var map = this.map;

		if (!options['static']) {
			this.addControls(map, options.controls, this.get(0));
		}

		map.addLayers( layers ); // Add the base layers

		//Add markers
		this.addMarkers( map, options );
		var centre = false;

		if ( options.centre === false ) {
			if ( options.locations.length == 1 ) {
				centre = new OpenLayers.LonLat( options.locations[0].lon, options.locations[0].lat );
			}
			else if ( options.locations.length == 0 ) {
				centre = new OpenLayers.LonLat( 0, 0 );
			}
		} else { // When the center is provided, set it.
			centre = new OpenLayers.LonLat( options.centre.lon, options.centre.lat );
		}

		if( centre !== false ) {
			if ( !hasImageLayer ) {
				centre.transform(
					new OpenLayers.Projection( "EPSG:4326" ),
					new OpenLayers.Projection( "EPSG:900913" )
				);
				map.setCenter( centre );
			} else {
				map.zoomToMaxExtent();
			}
		}

		if ( options.zoom !== false ) {
			map.zoomTo( options.zoom );
		}

		if ( options.resizable ) {
			mw.loader.using( 'ext.maps.resizable', function() {
				_this.resizable();
			} );
		}

        //ugly hack to allow for min/max zoom
        if (options.maxzoom !== false && options.maxzoom !== undefined ||
            options.minzoom !== false && options.minzoom !== undefined) {

            if(options.maxzoom === false){
                options.maxzoom = mapOptions.numZoomLevels;
            }

            map.getNumZoomLevels = function () {
	            var zoomLevels = 1;
	            zoomLevels += options.maxzoom !== false ? options.maxzoom : 0;
	            zoomLevels -= options.minzoom !== false ? options.minzoom : 0;
                return zoomLevels;
            };

            map.isValidZoomLevel = function (zoomLevel) {
                var valid = ( (zoomLevel != null) &&
                    (zoomLevel >= options.minzoom) &&
                    (zoomLevel <= options.maxzoom) );
                if (!valid && map.getZoom() == 0) {
	                var maxzoom = options.maxzoom !== false ? options.maxzoom : 0;
	                var minzoom = options.minzoom !== false ? options.minzoom : 0;
	                var zoom =  Math.round(maxzoom - (maxzoom - minzoom) / 2);
                    map.zoomTo(zoom);
                }
                return valid;
            }
        }

		//Add line layer if applicable
		if (options.lines && options.lines.length > 0) {
			this.lineLayer = new OpenLayers.Layer.Vector("Line Layer");

			var controls = {
				select:new OpenLayers.Control.SelectFeature(this.lineLayer, {
					clickout:true, toggle:false,
					multiple:true, hover:true,
					callbacks:{
						'click':function (feature) {
							openBubbleOrLink(feature.attributes);
						}
					}
				})
			};

			for (var key in controls) {
				var control = controls[key];
				map.addControl(control);
				control.activate();
			}

			map.addLayer(this.lineLayer);
			map.raiseLayer(this.lineLayer, -1);
			map.resetLayersZIndex();

			for (var i = 0; i < options.lines.length; i++) {
				this.addLine(options.lines[i]);
			}
		}

		if (options.polygons && options.polygons.length > 0) {
			this.polygonLayer = new OpenLayers.Layer.Vector("Polygon Layer");

			var controls = {
				select:new OpenLayers.Control.SelectFeature(this.polygonLayer, {
					clickout:true, toggle:false,
					multiple:true, hover:true,
					callbacks:{
						'over':function (feature) {
							if (feature.attributes.onlyVisibleOnHover === true) {
								var style = {
									'strokeColor':feature.attributes.strokeColor,
									'strokeWidth':feature.attributes.strokeWeight,
									'strokeOpacity':feature.attributes.strokeOpacity,
									'fillColor':feature.attributes.fillColor,
									'fillOpacity':feature.attributes.fillOpacity
								};
								_this.polygonLayer.drawFeature(feature, style);
							}
						},
						'out':function (feature) {
							if (feature.attributes.onlyVisibleOnHover === true && _this.map.popups.length === 0) {
								var style = {
									'strokeColor':feature.attributes.strokeColor,
									'strokeWidth':feature.attributes.strokeWeight,
									'strokeOpacity':0,
									'fillColor':feature.attributes.fillColor,
									'fillOpacity':0
								};
								_this.polygonLayer.drawFeature(feature, style);
							}
						},
						'click':function (feature) {
							openBubbleOrLink(feature.attributes);
						}
					}
				})
			};

			for (var key in controls) {
				var control = controls[key];
				map.addControl(control);
				control.activate();
			}

			map.addLayer(this.polygonLayer);
			map.raiseLayer(this.polygonLayer, -1);
			map.resetLayersZIndex();

			for (var i = 0; i < options.polygons.length; i++) {
				this.addPolygon(options.polygons[i]);
			}
		}

		if (options.circles && options.circles.length > 0) {
			this.circleLayer = new OpenLayers.Layer.Vector("Circle Layer");

			var controls = {
				select:new OpenLayers.Control.SelectFeature(this.circleLayer, {
					clickout:true, toggle:false,
					multiple:true, hover:true,
					callbacks:{
						'click':function (feature) {
							openBubbleOrLink(feature.attributes);
						}
					}
				})
			};

			for (key in controls) {
				var control = controls[key];
				map.addControl(control);
				control.activate();
			}

			map.addLayer(this.circleLayer);
			map.raiseLayer(this.circleLayer, -1);
			map.resetLayersZIndex();

			for (var i = 0; i < options.circles.length; i++) {
				this.addCircle(options.circles[i]);
			}
		}


		if (options.rectangles && options.rectangles.length > 0) {
			this.rectangleLayer = new OpenLayers.Layer.Vector("Rectangle Layer");

			var controls = {
				select:new OpenLayers.Control.SelectFeature(this.rectangleLayer, {
					clickout:true, toggle:false,
					multiple:true, hover:true,
					callbacks:{
						'click':function (feature) {
							openBubbleOrLink(feature.attributes);
						}
					}
				})
			};

			for (var key in controls) {
				var control = controls[key];
				map.addControl(control);
				control.activate();
			}

			map.addLayer(this.rectangleLayer);
			map.raiseLayer(this.rectangleLayer, -1);
			map.resetLayersZIndex();

			for (var i = 0; i < options.rectangles.length; i++) {
				this.addRectangle(options.rectangles[i]);
			}
		}

		if (options.zoom !== false) {
			map.zoomTo(options.zoom);
		}

		if (options.copycoords) {
			map.div.oncontextmenu = function () {
				return false;
			};
			OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
				defaultHandlerOptions:{
					'single':true,
					'double':false,
					'pixelTolerance':0,
					'stopSingle':false,
					'stopDouble':false
				},
				handleRightClicks:true,

				initialize:function (options) {
					this.handlerOptions = OpenLayers.Util.extend(
						{}, this.defaultHandlerOptions
					);
					OpenLayers.Control.prototype.initialize.apply(
						this, arguments
					);
					this.handler = new OpenLayers.Handler.Click(
						this, this.eventMethods, this.handlerOptions
					);
				}

			});
			var click = new OpenLayers.Control.Click({
				eventMethods:{
					'rightclick':function (e) {
						var lonlat = map.getLonLatFromViewPortPx(e.xy);
						if (!hasImageLayer) {
							lonlat = lonlat.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
						}
						prompt(mw.msg('maps-copycoords-prompt'), lonlat.lat + ',' + lonlat.lon);
					}
				}
			});
			map.addControl(click);
			click.activate();
		}

		if (options.searchmarkers) {
			OpenLayers.Control.SearchField = OpenLayers.Class(OpenLayers.Control, {
				draw:function (px) {
					OpenLayers.Control.prototype.draw.apply(this, arguments);
					var searchBoxValue = mw.msg('maps-searchmarkers-text');
					var searchBoxContainer = document.createElement('div');
					this.div.style.top = "5px";
					this.div.style.right = "5px";
					var searchBox = $('<input type="text" value="' + searchBoxValue + '" />');
					searchBox.appendTo(searchBoxContainer);

					searchBox.on('keyup',function (e) {
						for (var i = 0; i < _this.markers.length; i++) {
							var haystack = '';
							var marker = _this.markers[i];
							if (options.searchmarkers == 'title') {
								haystack = marker.data.title;
							} else if (options.searchmarkers == 'all') {
								haystack = marker.data.title + $(marker.data.text).text();
							}

							marker.target.display(haystack.toLowerCase().indexOf(e.target.value.toLowerCase()) != -1);
						}
					}).on('focusin',function () {
						if ($(this).val() === searchBoxValue) {
							$(this).val('');
						}
					}).on('focusout', function () {
						if ($(this).val() === '') {
							$(this).val(searchBoxValue);
						}
					});
					this.div.appendChild(searchBoxContainer);
					return this.div;
				}
			});
			var searchBox = new OpenLayers.Control.SearchField();
			map.addControl(searchBox);
		}

		if (options.wmsoverlay) {
			var layer = new OpenLayers.Layer.WMS( "WMSLayer", options.wmsoverlay.wmsServerUrl, { layers: options.wmsoverlay.wmsLayerName });
			map.addLayer(layer);
			map.setBaseLayer(layer);
		}


		function openBubbleOrLink(properties) {
			if (properties.link) {
				window.location.href = properties.link;
			} else if (properties.text !== '') {
				openBubble(properties);
			}
		}

		function openBubble(properties) {
			var mousePos = map.getControlsByClass("OpenLayers.Control.MousePosition")[0].lastXy;
			var lonlat = map.getLonLatFromPixel(mousePos);
			var popup = new OpenLayers.Popup(null, lonlat, null, properties.text, true, function () {
				map.getControlsByClass('OpenLayers.Control.SelectFeature')[0].unselectAll();
				map.removePopup(this);
			});
			_this.map.addPopup(popup);
		}

		return this;

	};
})(jQuery, window.mediaWiki, OpenLayers);
