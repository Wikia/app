require(['jquery', 'mw'], function($, mw) {
	// @see https://developer.mozilla.org/en-US/docs/Web/API/Geolocation/getCurrentPosition
	function getLocation( callback ) {
		navigator.geolocation.getCurrentPosition(
			function(position) {
				var coords = position.coords;

				callback( null, [ coords.latitude, coords.longitude ] );
			},
			function(err) {
				callback( err.message );
			}
		);
	}

	// @see https://doc.wikimedia.org/mediawiki-core/master/js/#!/api/mw.Api
	function getNearbyPlaces( coords, callback ) {
		var api = new mw.Api();

		api.get( {
			action: 'places',
			nearbygeo: coords[0] + ',' + coords[1]
		} ).done( function ( data ) {
			callback( null, data.query.places );
		} );
	}

	function renderNearbyPlaces(err, places) {
		var list = $('<ul class="places-nearby">'),
			i = 0;

		for (i = 0; i < places.length; i++) {
			list.append('<li><a href="' + window.wgArticlePath.replace('$1', places[i].title) + '">' + places[i].title + '</a>' +
				'<span>' + places[i].distance + ' m</soan></li>');
		}

		$('#places').append(list);
	};

	$(function() {
		if (window.currentLocation) {
			getNearbyPlaces(window.currentLocation, renderNearbyPlaces);
		}
		else {
			getLocation(function (err, coords) {
				getNearbyPlaces(coords, renderNearbyPlaces);
			});
		}
	});
});
