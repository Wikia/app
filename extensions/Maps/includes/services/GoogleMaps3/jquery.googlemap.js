/**
 * JavaScript for Google Maps v3 maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 *
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function ($, mw) {
	$.fn.googlemaps = function (options) {

		var _this = this;
		this.map = null;
		this.markercluster = null;
		this.options = options;

		/**
		 * All markers that are currently on the map.
		 * @type {Array}
		 * @private
		 */
		this.markers = [];

		/**
		 * All Polylines currently on the map,
		 * @type {Array}
		 * @private
		 */
		this.lines = [];

		/**
		 * All polygons currently on the map,
		 */
		this.polygons = [];


		/**
		 * All circles on the map
		 */
		this.circles = [];


		/**
		 * All rectangles on the map
		 */
		this.rectangles = [];


		/**
		 * All image overlays on the map
		 */
		this.imageoverlays = [];


		var getBounds = function() {
			if (( options.centre === false || options.zoom === false ) && options.locations.length > 1) {
				bounds = new google.maps.LatLngBounds();

				for (var i = _this.markers.length - 1; i >= 0; i--) {
					bounds.extend(_this.markers[i].getPosition());
				}
				return bounds;
			}
			return null;
		};

		var setZoom = function(bounds) {
				if (options.zoom === false) {
				_this.map.fitBounds(bounds);
			}
			else {
				_this.map.setZoom(options.zoom);
			}
		};


		/**
		 * Creates a new marker with the provided data,
		 * adds it to the map, and returns it.
		 * @param {Object} markerData Contains the fields lat, lon, title, text and icon
		 * @return {google.maps.Marker}
		 */
		this.addMarker = function (markerData) {
			var markerOptions = {
				position:new google.maps.LatLng(markerData.lat, markerData.lon),
				title:markerData.title,
				text:$(markerData.text).text(),
				labelContent:markerData.inlineLabel,
				labelAnchor:new google.maps.Point(-15, 34),
				labelClass:'markerwithlabel'
			};

			if (markerData.icon !== '') {
				markerOptions.icon = markerData.icon;
			}

			if (markerData.visitedicon !== '') {
				if(markerData.visitedicon === 'on'){
					//when keyword 'on' is set, set visitedicon to a default official marker
					markerOptions.visitedicon = mw.config.get('wgScriptPath')+'/extensions/Maps/includes/services/GoogleMaps3/img/blue-dot.png';
				}else{
					markerOptions.visitedicon = markerData.visitedicon;
				}
			}

			var addToMapAndHandlers = function( marker ) {
				//Add onclick listener
				google.maps.event.addListener(marker, 'click', function (e) {
					if (e.target !== undefined && (e.target instanceof HTMLAnchorElement || e.target.tagName == 'A')) {
						//click link defined in inlinelabel
						window.location.href = e.target.href;
					} else {
						openBubbleOrLink.call(this, markerData, e, marker);
					}

					if (markerOptions.visitedicon) {
						marker.setIcon(markerOptions.visitedicon);
						markerOptions.visitedicon = undefined;
					}
				});

				marker.setMap( _this.map );
				_this.markers.push( marker );

				return marker;
			};

			var marker;
			if (markerData.inlineLabel === undefined || markerData.inlineLabel === null || markerData.inlineLabel.length == 0) {
				marker = new google.maps.Marker( markerOptions );
				return addToMapAndHandlers( marker );
			} else {
				mw.loader.using(
					'ext.maps.gm3.markerwithlabel',
					function() {
						marker = new MarkerWithLabel( markerOptions );
						addToMapAndHandlers( marker );
						setZoom(getBounds());
					}
				);
			}
		};

		/**
		 * Removes a single marker from the map.
		 * @param {google.maps.Marker} marker The marker to remove.
		 */
		this.removeMarker = function (marker) {
			marker.setMap(null);

			for (var i = this.markers.length - 1; i >= 0; i--) {
				if (this.markers[i] === marker) {
					delete this.markers[i];
					break;
				}
			}

			delete marker;
		};

		/**
		 * Removes all markers from the map.
		 */
		this.removeMarkers = function () {
			for (var i = this.markers.length - 1; i >= 0; i--) {
				this.markers[i].setMap(null);
			}
			this.markers = [];
		};

		/**
		 * Remove the "earth" type from options.types if it's present.
		 *
		 * @since 1.0.1
		 */
		this.removeEarthType = function () {
			if (Array.prototype.filter) {
				options.types = options.types.filter(function (element, index, array) {
					return element !== 'earth';
				});
			}
			else {
				// Seems someone is using the o-so-awesome browser that is IE.
				var types = [];

				for (i in options.types) {
					if (typeof( options.types[i] ) !== 'function' && options.types[i] !== 'earth') {
						types.push(options.types[i]);
					}
				}

				options.types = types;
			}
		};

		this.addOverlays = function () {
			// Add the Google KML/KMZ layers.
			for (i = options.gkml.length - 1; i >= 0; i--) {
				var kmlLayer = new google.maps.KmlLayer(
					options.gkml[i],
					{
						map:this.map,
						preserveViewport:!options.kmlrezoom
					}
				);
			}

			// If there are any non-Google KML/KMZ layers, load the geoxml library and use it to add these layers.
			if (options.kml.length != 0) {
				mw.loader.using('ext.maps.gm3.geoxml', function () {

					function addToCopyCoords(doc){
						if(options.copycoords){
							for(var i = 0; i < doc.length; i++){
								addCopyCoordsOnRightClick([
									doc[i].gpolygons,
									doc[i].gpolylines,
									doc[i].ggroundoverlays
									]);
							}
						}
					}


					var geoXml = new geoXML3.parser({
						map:_this.map,
						zoom:options.kmlrezoom,
						failedParse:function(){
							alert(mediaWiki.msg('maps-kml-parsing-failed'));
						}
					});
					geoXml.options.afterParse = function(docs){
						//add toggle functionality
						var toggleDiv = document.createElement('div');
						toggleDiv.style.backgroundColor = 'white';
						toggleDiv.style.marginTop = '5px';
						toggleDiv.style.padding = '5px';
						toggleDiv.style.border = '1px solid grey';
						for(var i = docs.length-1; i >= 0; i--){
							(function(doc){
								var label = document.createElement('label');
								label.style.display = 'block';
								var text = document.createTextNode(doc.baseUrl.substring(doc.baseDir.length));
								var checkbox = document.createElement('input');
								checkbox.setAttribute('type','checkbox');
								checkbox.style.verticalAlign = '-0.2em';
								checkbox.checked = true;
								checkbox.onclick = function(){
									if(this.checked){
										geoXml.showDocument(doc);
									}else{
										geoXml.hideDocument(doc);
									}
								};
								label.appendChild(checkbox);
								label.appendChild(text);

								toggleDiv.appendChild(label);

								console.log(toggleDiv);
							})(docs[i]);
						}
						_this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(toggleDiv);
					};

					geoXml.parse(options.kml);
				});
			}
		};

		this.addLine = function (properties) {
			var paths = new google.maps.MVCArray();
			for (var x = 0; x < properties.pos.length; x++) {
				paths.push(new google.maps.LatLng(properties.pos[x].lat, properties.pos[x].lon));
			}

			var line = new google.maps.Polyline({
				map:this.map,
				path:paths,
				strokeColor:properties.strokeColor,
				strokeOpacity:properties.strokeOpacity,
				strokeWeight:properties.strokeWeight
			});
			this.lines.push(line);

			google.maps.event.addListener(line, "click", function (event) {
				openBubbleOrLink.call(this, properties, event, line);
			});
		};

		this.removeLine = function (line) {
			line.setMap(null);

			for (var i = this.line.length - 1; i >= 0; i--) {
				if (this.line[i] === line) {
					delete this.line[i];
					break;
				}
			}

			delete line;
		};

		this.removeLines = function () {
			for (var i = this.lines.length - 1; i >= 0; i--) {
				this.lines[i].setMap(null);
			}
			this.lines = [];
		};

		this.addPolygon = function (properties) {
			var paths = new google.maps.MVCArray();
			for (var x = 0; x < properties.pos.length; x++) {
				paths.push(new google.maps.LatLng(properties.pos[x].lat, properties.pos[x].lon));
			}

			var polygon = new google.maps.Polygon({
				map:this.map,
				path:paths,
				strokeColor:properties.strokeColor,
				strokeOpacity:properties.strokeOpacity,
				strokeWeight:properties.strokeWeight,
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity
			});
			this.polygons.push(polygon);

			//add hover event/effect
			if (properties.onlyVisibleOnHover === true) {

				function hidePolygon(polygon) {
					polygon.setOptions({
						fillOpacity:0,
						strokeOpacity:0
					});
				}

				hidePolygon(polygon);

				google.maps.event.addListener(polygon, "mouseover", function () {
					this.setOptions({
						fillOpacity:properties.fillOpacity,
						strokeOpacity:properties.strokeOpacity
					});
				});

				google.maps.event.addListener(polygon, "mouseout", function () {
					hidePolygon(this);
				});

			}

			//add click event
			google.maps.event.addListener(polygon, "click", function (event) {
				openBubbleOrLink.call(this, properties, event, polygon);
			});
		};

		this.addCircle = function (properties) {
			var circle = new google.maps.Circle({
				map:this.map,
				center:new google.maps.LatLng(properties.centre.lat, properties.centre.lon),
				radius:properties.radius,
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity,
				strokeColor:properties.strokeColor,
				strokeOpacity:properties.strokeOpacity,
				strokeWeight:properties.strokeWeight
			});
			this.circles.push(circle);

			//add click event
			google.maps.event.addListener(circle, "click", function (event) {
				openBubbleOrLink.call(this, properties, event, circle);
			});
		};


		this.addRectangle = function (properties) {
			var rectangle = new google.maps.Rectangle({
				map:this.map,
				bounds:new google.maps.LatLngBounds(
					new google.maps.LatLng(properties.sw.lat, properties.sw.lon), //sw
					new google.maps.LatLng(properties.ne.lat, properties.ne.lon)  //ne
				),
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity,
				strokeColor:properties.strokeColor,
				strokeOpacity:properties.strokeOpacity,
				strokeWeight:properties.strokeWeight
			})
			this.rectangles.push(rectangle);

			//add click event
			google.maps.event.addListener(rectangle, "click", function (event) {
				openBubbleOrLink.call(this, properties, event, rectangle);
			});
		};

		this.addImageOverlay = function(properties){
			var imageBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng(properties.sw.lat,properties.sw.lon),
				new google.maps.LatLng(properties.ne.lat,properties.ne.lon)
			);

			var image = new google.maps.GroundOverlay(properties.image,imageBounds);
			image.setMap(this.map);

			this.imageoverlays.push(image);

			//add click event
			google.maps.event.addListener(image, "click", function (event) {
				openBubbleOrLink.call(this, properties, event, image);
			});
		};


		this.removePolygon = function (polygon) {
			polygon.setMap(null);

			for (var i = this.polygon.length - 1; i >= 0; i--) {
				if (this.polygon[i] === polygon) {
					delete this.polygon[i];
					break;
				}
			}

			delete polygon;
		};

		this.removePolygons = function () {
			for (var i = this.polygon.length - 1; i >= 0; i--) {
				this.polygon[i].setMap(null);
			}
			this.polygon = [];
		};

		//Rezoom's the map to show all visible markers.
		this.reZoom = function(){
			var bounds = new google.maps.LatLngBounds();
			for(var x = 0; x < this.markers.length; x++){
				var marker = this.markers[x];
				if (marker.getVisible() === true) {
					bounds.extend(marker.getPosition());
				}
			}
			this.map.fitBounds(bounds);
		}

		this.initializeMap = function () {
			var mapOptions = {
				disableDefaultUI:true,
				mapTypeId:options.type == 'earth' ? google.maps.MapTypeId.SATELLITE : eval('google.maps.MapTypeId.' + options.type)
			};

			// Map controls
			mapOptions.panControl = $.inArray('pan', options.controls) != -1;
			mapOptions.zoomControl = $.inArray('zoom', options.controls) != -1;
			mapOptions.mapTypeControl = $.inArray('type', options.controls) != -1;
			mapOptions.scaleControl = $.inArray('scale', options.controls) != -1;
			mapOptions.streetViewControl = $.inArray('streetview', options.controls) != -1;

			for (i in options.types) {
				if (typeof( options.types[i] ) !== 'function') {
					options.types[i] = eval('google.maps.MapTypeId.' + options.types[i].toUpperCase() );
				}
			}

			// Map control styles
			mapOptions.zoomControlOptions = { style:eval('google.maps.ZoomControlStyle.' + options.zoomstyle) };
			mapOptions.mapTypeControlOptions = {
				style:eval('google.maps.MapTypeControlStyle.' + options.typestyle),
				mapTypeIds:options.types
			};


			//max/min -zoom
			mapOptions.maxZoom = options.maxzoom === false ? null : options.maxzoom;
			mapOptions.minZoom = options.minzoom === false ? null : options.minzoom;

			//static mode
			if (options['static']) {
				mapOptions.draggable = false;
				mapOptions.disableDoubleClickZoom = true;
				mapOptions.panControl = false;
				mapOptions.rotateControl = false;
				mapOptions.zoomControl = false;
				mapOptions.scrollwheel = false;
				mapOptions.streetViewControl = false;
				mapOptions.overviewMapControl = false;
				mapOptions.mapTypeControl = false;
			}

			var map = new google.maps.Map(this.get(0), mapOptions);

			google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
				_this.addOverlays();
			});


			this.map = map;

			if (options.poi === false) {
				map.setOptions({ styles:[
					{
						featureType:"poi",
						stylers:[
							{ visibility:"off" }
						]
					}
				] });
			}

			if (!options.locations) {
				options.locations = [];
			}

			// Add the markers.
			for (var i = options.locations.length - 1; i >= 0; i--) {
				this.addMarker(options.locations[i]);
			}

			for (i = options.fusiontables.length - 1; i >= 0; i--) {
				var ftLayer = new google.maps.FusionTablesLayer(options.fusiontables[i], { map:map });
			}

			var layerMapping = {
				'traffic':'new google.maps.TrafficLayer()',
				'bicycling':'new google.maps.BicyclingLayer()'
			};

			for (i = options.layers.length - 1; i >= 0; i--) {
				var layer = eval(layerMapping[options.layers[i]]);
				layer.setMap(map);
			}

			var bounds = getBounds();

			setZoom(bounds);

			var centre;

			if (options.centre === false) {
				if (options.locations.length > 1) {
					centre = bounds.getCenter();
				}
				else if (options.locations.length == 1) {
					centre = new google.maps.LatLng(options.locations[0].lat, options.locations[0].lon);
				}
				else {
					centre = new google.maps.LatLng(0, 0);
				}
			}
			else {
				centre = new google.maps.LatLng(options.centre.lat, options.centre.lon);
			}

			map.setCenter(centre);

			setTimeout(
				function() {
					if ( options.autoinfowindows ) {
						for ( var i = _this.markers.length - 1; i >= 0; i-- ) {
							google.maps.event.trigger( _this.markers[i], 'click', {} );
						}
					}
				},
				500 // If we wait a bit, the map will re-position to accommodate for the info windows.
			);

			if (options.resizable) {
				mw.loader.using('ext.maps.resizable', function () {
					_this.resizable();
				});
			}

			/**
			 * used in display_line functionality
			 * draws paths between markers
			 */
			if (options.lines) {
				for (var i = 0; i < options.lines.length; i++) {
					this.addLine(options.lines[i]);
				}
			}

			/**
			 * used in display_line to draw polygons
			 */
			if (options.polygons) {
				for (var i = 0; i < options.polygons.length; i++) {
					this.addPolygon(options.polygons[i]);
				}
			}

			/**
			 * used in display_line to draw circles
			 */
			if (options.circles) {
				for (var i = 0; i < options.circles.length; i++) {
					this.addCircle(options.circles[i]);
				}
			}

			/**
			 * used in display_line to draw rectangles
			 */
			if (options.rectangles) {
				for (var i = 0; i < options.rectangles.length; i++) {
					this.addRectangle(options.rectangles[i]);
				}
			}

			/**
			 * Allows grouping of markers.
			 */
			if ( options.markercluster ) {
				mw.loader.using(
					'ext.maps.gm3.markercluster',
					function() {
						_this.markercluster = new MarkerClusterer( _this.map, _this.markers, {
							averageCenter: true
						} );
					}
				);
			}



			if (options.searchmarkers) {
				var searchBoxValue = mediaWiki.msg('maps-searchmarkers-text');
				var searchBox = $('<input type="text" value="' + searchBoxValue + '" />');
				var searchContainer = document.createElement('div');
				searchContainer.style.padding = '5px';
				searchContainer.index = 1;
				searchBox.appendTo(searchContainer);
				map.controls[google.maps.ControlPosition.TOP_RIGHT].push(searchContainer);

				//prevents markers and other map objects to be placed beneath searchfield
				google.maps.event.addListenerOnce(map, 'bounds_changed', function () {
					map.panBy(0,-30);
				});


				searchBox.on('keyup',function (e) {
					for (var i = 0; i < _this.markers.length; i++) {
						var haystack = '';
						var marker = _this.markers[i];
						if (options.searchmarkers == 'title') {
							haystack = marker.title;
						} else if (options.searchmarkers == 'all') {
							haystack = marker.title + marker.text;
						}

						var visible = haystack.toLowerCase().indexOf(e.target.value.toLowerCase()) != -1;
						marker.setVisible(visible);
					}
					_this.reZoom();
				}).on('focusin',function () {
					if ($(this).val() === searchBoxValue) {
						$(this).val('');
					}
				}).on('focusout', function () {
					if ($(this).val() === '') {
						$(this).val(searchBoxValue);
					}
				});
			}

			if(options.imageoverlays){
				for (var i = 0; i < options.imageoverlays.length; i++) {
					this.addImageOverlay(options.imageoverlays[i]);
				}
			}

			if (options.copycoords) {

				addCopyCoordsOnRightClick([
					this.lines,
					this.circles,
					this.polygons,
					this.markers,
					this.rectangles,
					this.imageoverlays,
					this.map
				]);
			}

			if (options.wmsoverlay) {
				var wmsOptions = {
					alt: "OpenLayers",
					getTileUrl:function (tile, zoom) {
						var projection = _this.map.getProjection();
						var zpow = Math.pow(2, zoom);
						var ul = new google.maps.Point(tile.x * 256.0 / zpow, (tile.y + 1) * 256.0 / zpow);
						var lr = new google.maps.Point((tile.x + 1) * 256.0 / zpow, (tile.y) * 256.0 / zpow);
						var ulw = projection.fromPointToLatLng(ul);
						var lrw = projection.fromPointToLatLng(lr);
						//The user will enter the address to the public WMS layer here.  The data must be in WGS84
						var baseURL = options.wmsoverlay.wmsServerUrl;
						//The layer ID.  Can be found when using the layers properties tool in ArcMap or from the WMS settings
						var layers = options.wmsoverlay.wmsLayerName;

						var style = options.wmsoverlay.wmsStyleName;
						//With the 1.3.0 version the coordinates are read in LatLon, as opposed to LonLat in previous versions
						var bbox = ulw.lat() + "," + ulw.lng() + "," + lrw.lat() + "," + lrw.lng();
						//Establish the baseURL.  Several elements, including &EXCEPTIONS=INIMAGE and &Service are unique to openLayers addresses.
						var url = baseURL + "version=1.3.0&EXCEPTIONS=INIMAGE&Service=WMS" +
							"&request=GetMap&Styles=" + encodeURI(style) + "&format=image%2Fjpeg&CRS=EPSG:4326" +
							"&width=256&height=256" + "&Layers=" + layers + "&BBOX=" + bbox;
						return url;
					},
					isPng: false,
					maxZoom: 17,
					minZoom: 1,
					name: "OpenLayers",
					tileSize: new google.maps.Size(256, 256)

				};



				//Creating the object to create the ImageMapType that will call the WMS Layer Options.

				openlayersWMS = new google.maps.ImageMapType(wmsOptions);


				//Layers to appear on Map A.  The first string will give the map the map a name in the dropdown and the second object calls the map type

				map.mapTypes.set('OpenLayers', openlayersWMS);
				map.setMapTypeId('OpenLayers');
			}

			//Add custom controls
			// - Fullscreen
			if(options.enablefullscreen){
				this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(new FullscreenControl(this.map));
			}
		};

		this.setup = function () {

			var showEarth = $.inArray('earth', options.types) !== -1 || options.type == 'earth';

			// If there are any non-Google KML/KMZ layers, load the geoxml library and use it to add these layers.
			if (showEarth) {
				this.removeEarthType();
				$.getScript(
					'https://www.google.com/jsapi',
					function (data, textStatus) {
						google.load('earth', '1', { callback:function () {
							mw.loader.using('ext.maps.gm3.earth', function () {
								_this.initializeMap();
								if (google.earth.isSupported()) {
									_this.ge = new GoogleEarth(_this.map);
								}
							});
						} });
					}
				);
			}else{
				this.initializeMap();
			}


		};

		function FullscreenControl(map) {

			var controlDiv = document.createElement('div');
			controlDiv.style.padding = '5px';
			controlDiv.index = 1;

			var controlUI = document.createElement('div');
			controlUI.style.backgroundColor = 'white';
			controlUI.style.borderStyle = 'solid';
			controlUI.style.borderColor = 'rgba(0, 0, 0, 0.14902)';
			controlUI.style.borderWidth = '1px';
			controlUI.style.borderRadius = '2px';
			controlUI.style.cursor = 'pointer';
			controlUI.style.textAlign = 'center';
			controlUI.style.boxShadow = 'rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px';
			controlUI.style.backgroundClip = 'padding-box';
			controlUI.title = mediaWiki.msg('maps-fullscreen-button-tooltip');
			controlDiv.appendChild(controlUI);

			var controlText = document.createElement('div');
			controlText.style.fontFamily = 'Roboto, Arial, sans-serif';
			controlText.style.fontSize = '11px';
			controlText.style.fontWeight = '400';
			controlText.style.color = 'rgb(86, 86, 86)';
			controlText.style.padding = '1px 6px';
			controlText.innerHTML = mediaWiki.msg('maps-fullscreen-button');
			controlUI.appendChild(controlText);

			google.maps.event.addDomListener(controlUI, 'click', function() {
				var mapDiv = $(map.getDiv());
				if(mapDiv.data('preFullscreenCss') != null){
					mapDiv.css(mapDiv.data('preFullscreenCss'));
					mapDiv.removeData('preFullscreenCss');
				}else{
					var fullscreenCss = {
						position:'fixed',
						top: 0,
						left:0,
						width:'100%',
						height:'100%',
						zIndex:10000
					};
					var oldState = {};
					for(var cssProp in fullscreenCss){
						oldState[cssProp] = mapDiv.css(cssProp);
					}
					mapDiv.data('preFullscreenCss',oldState);
					mapDiv.css(fullscreenCss);
				}

				google.maps.event.trigger(map, "resize");
			});

			return controlDiv;
		}


		function openBubbleOrLink(properties, event, obj) {
			if (properties.link) {
				window.location.href = properties.link;
			} else if (properties.text !== '') {
				openBubble.call(this, properties, event, obj);
			}
		}

		function openBubble( properties, event, obj ) {
			if ( this.openWindow !== undefined ) {
				this.openWindow.close();
			}

			this.openWindow = new google.maps.InfoWindow();
			this.openWindow.setContent( properties.text );

			if ( event.latLng !== undefined ) {
				this.openWindow.setPosition( event.latLng );
			}

			this.openWindow.closeclick = function () {
				obj.openWindow = undefined;
			};

			if ( event.latLng === undefined ) {
				this.openWindow.open( this.map, this );
			}
			else {
				this.openWindow.open( this.map );
			}
		}

		function addCopyCoordsOnRightClick(object) {
			if(object instanceof Array){
				for (var x = 0; x < object.length; x++) {
					addCopyCoordsOnRightClick(object[x]);
				}
			}else{
				google.maps.event.addListener(object, 'rightclick', function (event) {
					prompt(mediaWiki.msg('maps-copycoords-prompt'), event.latLng.lat() + ',' + event.latLng.lng());
				});
			}
		}

		//Complete path to OpenLayers WMS layer

		this.setup();

		return this;

	};
})(jQuery, window.mediaWiki);
