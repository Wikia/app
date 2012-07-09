/*global google: true*/
var PlacesEditor = {
	map : false,
	markers: [],
	currentMarker: false,
	searchResults: false,

	// use this function to create a new place
	createNew: function(callback) {
		this._show(false, callback);
	},

	// use this function to edit an existing place
	edit: function(model, callback) {

	},

	// used internally to render the editor modal
	_show: function(model, callback) {
		$.nirvana.sendRequest({
			controller:'PlacesEditor',
			method: 'getEditorModal',
			format: 'html',
			data: {
				uselang: wgUserLanguage
			},
			type: 'get',
			callback: $.proxy(function(html) {
				this.onModalShow(model, html, callback);
			}, this)
		});
	},

	// initialize the modal using HTML provided
	onModalShow: function(model, html, okCallback) {
		var createNew = (model === false),
			modalTitle = $.msg(createNew ? 'places-editor-title-create-new' : 'places-editor-title-edit');

		$.showCustomModal(modalTitle, html,
			{
				id: 'PlacesEditor',
				width: 980,
				height: 615,
				buttons: [{
					id: 'ok',
					defaultButton: true,
					message: $.msg('ok'),
					handler: $.proxy(function() {
						var marker = this.getCurrentMarkerLocation();

						$().log(marker, 'Places result');

						if (typeof okCallback == 'function') {
							okCallback(marker);
						}

						$('#PlacesEditor').closeModal();
					}, this)
				}],
				callback: $.proxy(function() {
					this.setupMap();
					this.setupForm();
					this.onGetMyLocation();
				}, this)
			}
		);
	},

	// initialize and render Google Map
	setupMap: function() {
		var mapConfig = {
			'center': new google.maps.LatLng(0, 0),
			'mapTypeId': google.maps.MapTypeId.ROADMAP,
			'zoom': 5
		};

		this.map = new google.maps.Map(
			$('#PlacesEditorMap').get(0),
			mapConfig
		);
	},

	// setup geolocation search form
	setupForm: function() {
		var form = $('#PlacesEditorWrapper form'),
			queryField = form.find('input[type="text"]');

		// get google maps key
		this.googleMapsKey = $('#GoogleMapsKey').val();

		// setup search results
		this.searchResults = form.children('ul');
		this.searchResults.delegate('li > a', 'click', $.proxy(function(ev) {
			ev.preventDefault();
			var markerId = parseInt($(ev.target).attr('data-marker-id'));
			this.selectMarker(markerId);
		}, this));

		// setup geolocation form
		form.bind('submit', $.proxy(function(ev) {
			ev.preventDefault();

			this.searchResults.html('');
			this.findPlaces(queryField.val(), $.proxy(this.onSearchResults, this));
		}, this));

		// setup browser geolocation button
		$('#PlacesEditorMyLocation').bind('click', $.proxy(this.onGetMyLocation, this));
	},

	// perform geolocation search
	findPlaces: function(query, callback) {
		$().log(query, 'Places query');

		var geocoder = new google.maps.Geocoder();

		// @see https://developers.google.com/maps/documentation/javascript/geocoding
		geocoder.geocode({address: query}, function(data, status) {
			$().log(data, 'Places results (status: ' + status + ')');
			callback(data || []);
		});
	},

	// populate list of search results
	onSearchResults: function(results) {
		// no results
		if (!results.length) {
			return;
		}

		var html = '',
			result,
			coords;

		this.resetMarkers();

		// iterate through results and create pointers
		for(var n=0, len=results.length; n<len; n++) {
			result = results[n];
			coords = result.geometry.location;

			// add to results
			html += '<li><a href="#" data-marker-id="' + n + '">' + result['formatted_address'] + '</li>';

			// add to markers
			this.addMarker(result.address, coords.lat(), coords.lng());
		}

		this.searchResults.html(html);
		this.selectMarker(0);
	},

	// use geolocation HTML5 API
	onGetMyLocation: function(ev) {
		ev && ev.preventDefault();

		if (typeof navigator.geolocation == 'undefined') {
			alert('Your browser doesn\'t support this feature');
			return;
		}

		this.resetMarkers();

		navigator.geolocation.getCurrentPosition($.proxy(function(position) {
			var coords = position.coords,
				markerId = this.addMarker('', coords.latitude, coords.longitude);

			this.selectMarker(markerId);
		}, this));
	},

	// clear list of markers with search results
	resetMarkers: function() {
		var marker;

		for(var n=0, len=this.markers.length; n<len; n++) {
			marker = this.markers[n];
			marker.setMap(null);
			delete marker;
		};

		this.markers = [];
	},

	// add a marker to search results
	addMarker: function(label, lat, lon) {
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(lat, lon),
			map: this.map,
			title: label,
			draggable: true
		});

		// update the coordinates when marker is dropped
		google.maps.event.addListener(marker, 'dragend', $.proxy(function() {
			this.selectMarker(marker.markerId, true /* doNotCenter */);
		}, this));

		// add to the list
		this.markers.push(marker);

		// return ID of stored marker
		return marker.markerId = this.markers.length - 1;
	},

	// select given marker
	selectMarker: function(markerId, doNotCenter) {
		var marker = this.markers[markerId],
			coords = marker.getPosition();

		if (doNotCenter !== true) {
			this.map.setCenter(coords);
			this.map.setZoom(15);
		}

		this.currentMarker = marker;

		$('#PlacesEditorGeoPosition').val(coords.lat().toFixed(8) + ','  + coords.lng().toFixed(8));
	},

	// get geolocation of currently selected marker
	getCurrentMarkerLocation: function() {
		if (this.currentMarker !== false) {
			var coords = this.currentMarker.getPosition();

			return {
				lat: coords.lat().toFixed(8),
				lon: coords.lng().toFixed(8),
				label: this.currentMarker.getTitle()
			};
		}
		else {
			return false;
		}
	}
}
