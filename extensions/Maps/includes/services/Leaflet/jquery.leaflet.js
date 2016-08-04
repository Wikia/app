/**
 * JavaScript for Leaflet in the Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Maps
 *
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */

(function ($, mw) {
	$.fn.leafletmaps = function ( options ) {
		var _this = this;
		this.map = null;
		this.options = options;

		/**
		 * array point of all map elements (markers, lines, polygons, etc.)
		 * for map fit
		 */
		this.points = [];

		/**
		* Creates a new marker with the provided data,
		* adds it to the map, and returns it.
		* @param {Object} markerData Contains the fields lat, lon, title, text and icon
		* @return {L.Marker}
		*/
		this.addMarker = function (properties) {
			this.points.push( new L.LatLng(properties.lat, properties.lon) );

			if (properties.icon === '') {
				var icon = new L.Icon.Default();
			} else {
				var icon = new L.Icon({
					iconUrl: properties.icon
				});
			}

			var markerOptions = {
				title:properties.title,
				icon:icon
			};

			var marker = L.marker( [properties.lat, properties.lon], markerOptions ).addTo( this.map );
			if( properties.text.length > 0 ) marker.bindPopup( properties.text );
		};

		this.addLine = function (properties) {
			var options = {
				color: properties.strokeColor,
				weight:properties.strokeWeight,
				opacity:properties.strokeOpacity
			};

			var latlngs = [];
			for (var x = 0; x < properties.pos.length; x++) {
				latlngs.push([properties.pos[x].lat, properties.pos[x].lon]);
				this.points.push( new L.LatLng(properties.pos[x].lat, properties.pos[x].lon) );
			}

			L.polyline(latlngs, options).addTo(this.map);
		};

		/**
		 * TODO: check this
		 */
		this.addPolygon = function (properties) {
			var options = {
				color: properties.strokeColor,
				weight:properties.strokeWeight,
				opacity:properties.strokeOpacity,
				fill:properties.fill !== false, // TODO: check this
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity
			};

			var latlngs = [];
			for (var x = 0; x < properties.pos.length; x++) {
				latlngs.push([properties.pos[x].lat, properties.pos[x].lon]);
				this.points.push( new L.LatLng(properties.pos[x].lat, properties.pos[x].lon) );
			}

			L.Polygon(latlngs, options).addTo(this.map);
		};

		/**
		 * TODO: check this
		 */
		this.addCircle = function (properties) {
			this.points.push( new L.LatLng(properties.centre.lat-properties.radius, properties.centre.lon-properties.radius) ); // TODO: check this
			this.points.push( new L.LatLng(properties.centre.lat+properties.radius, properties.centre.lon+properties.radius) ); // TODO: check this

			var options = {
				color: properties.strokeColor,
				weight:properties.strokeWeight,
				opacity:properties.strokeOpacity,
				fill:properties.fill !== false, // TODO: check this
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity
			};

			L.Circle([properties.centre.lat, properties.centre.lon], properties.radius, options).addTo(this.map);
		};

		/**
		 * TODO: check this
		 */
		this.addRectangle = function (properties) {
			this.points.push( new L.LatLng(properties.sw.lat, properties.sw.lon) );
			this.points.push( new L.LatLng(properties.ne.lat, properties.ne.lon) );

			var options = {
				color: properties.strokeColor,
				weight:properties.strokeWeight,
				opacity:properties.strokeOpacity,
				fill:properties.fill !== false, // TODO: check this
				fillColor:properties.fillColor,
				fillOpacity:properties.fillOpacity
			};

			var bounds = [[properties.sw.lat, properties.sw.lon], [properties.ne.lat, properties.ne.lon]];

			L.rectangle( bounds, options ).addTo(this.map);
		};

		this.setup = function () {

			var mapOptions = {};
			if (options.minzoom !== false ) mapOptions.minZoom = options.minzoom;
			if (options.maxzoom !== false ) mapOptions.maxZoom = options.maxzoom;

			var map = L.map( this.get(0), mapOptions ).fitWorld();
			this.map = map;

			// add an OpenStreetMap tile layer
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			if (options.resizable) {
				mw.loader.using('ext.maps.resizable', function () { //TODO: Fix moving map when resized
					_this.resizable();
				});
			}

			if (!options.locations) {
				options.locations = [];
			}
			// Add the markers.
			for (var i = options.locations.length - 1; i >= 0; i--) {
				this.addMarker(options.locations[i]);
			}

			// Add lines
			if (options.lines) {
				for (var i = 0; i < options.lines.length; i++) {
					this.addLine(options.lines[i]);
				}
			}

			// Add polygons
			if (options.polygons) {
				for (var i = 0; i < options.polygons.length; i++) {
					this.addPolygon(options.polygons[i]);
				}
			}

			// Add circles
			if (options.circles) {
				for (var i = 0; i < options.circles.length; i++) {
					this.addCircle(options.circles[i]);
				}
			}

			// Add rectangles
			if (options.rectangles) {
				for (var i = 0; i < options.rectangles.length; i++) {
					this.addRectangle(options.rectangles[i]);
				}
			}

			// Set map position (centre and zoom)
			var centre;
			if (options.centre === false) {
				switch ( this.points.length ) {
					case 0:
						centre = new L.LatLng(0, 0);
						break;
					case 1:
						centre = this.points[0];
						break;
					default:
						var bounds = new L.LatLngBounds( this.points );
						if (options.zoom === false) {
							map.fitBounds( bounds );
							centre = false;
						} else {
							centre = bounds.getCenter();
						}
						break;
				}
			} else {
				centre = new L.LatLng(options.centre.lat, options.centre.lon);
			}
			if(centre) {
				map.setView( centre, options.zoom !== false ? options.zoom : options.defzoom );
			}
		};

		this.setup();

		return this;

	};
})(jQuery, window.mediaWiki);
