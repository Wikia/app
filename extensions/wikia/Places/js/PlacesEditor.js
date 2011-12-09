var PlacesEditor = {
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
			callback: $.proxy(function(html) {
				this.onModalShow(model, html);
			}, this)
		});
	},

	// initialize the modal using HTML provided
	onModalShow: function(model, html) {
		var createNew = (model === false),
			modalTitle = $.msg(createNew ? 'places-editor-title-create-new' : 'places-editor-title-edit');

		$.showCustomModal(modalTitle, html,
			{
				id: 'PlacesEditor',
				buttons: [{
					id: 'ok',
					defaultButton: true,
					message: $.msg('ok'),
					handler: function() {

					}
				}],
				callback: $.proxy(function() {
					this.setupMap();
					this.setupForm();
				}, this)
			}
		);
	},

	setupMap: function() {
		var mapConfig = {
				'center': new google.maps.LatLng(0, 0),
				'mapTypeId': google.maps.MapTypeId.ROADMAP,
				'zoom': 5
			},
			map = new google.maps.Map(
				$('#PlacesEditorMap').get(0),
				mapConfig
			);
	},

	setupForm: function() {
		var form = $('#PlacesEditorWrapper > form'),
			places = form.children('ul'),
			queryField = form.find('input[type="text"]');

		form.bind('submit', $.proxy(function(ev) {
			ev.preventDefault();
			var query = queryField.val();

			this.findPlaces(query, $.proxy(function() {

			}, this));
		}, this));
	},

	findPlaces: function(query, callback) {
		$().log(query, 'Places query');

		// this still uses V2 of GoogleMaps API - v3 lacks JSONP support
		$.getJSON("http://maps.google.com/maps/geo?" +
			"output=json&q=" +encodeURIComponent(query) + "&key=" + wgGoogleMapsKey + "&callback=?",
			 function(data) {
				$().log(data, 'Places results');
 			});
	}
}
