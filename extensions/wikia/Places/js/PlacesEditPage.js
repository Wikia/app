if (window.mwCustomEditButtons) {
	window.mwCustomEditButtons.push({
		imageId: 'mw-editbutton-places',
		imageFile: wgExtensionsPath + '/wikia/Places/images/button_place.png',
		speedTip: $.msg('places-toolbar-button-tooltip'),
		onclick: function(ev) {
			ev.preventDefault();

			// lazy load the editor
			$.getResources([
					$.loadGoogleMaps,
					wgExtensionsPath + '/wikia/Places/js/PlacesEditor.js',
					$.getSassCommonURL('extensions/wikia/Places/css/PlacesEditor.scss')
				],
				function() {
					PlacesEditor.createNew(function(model) {
						$().log(model, 'Places');
					});
				}
			);
		}
	});
}

/**
window.mwEditButtons && window.mwEditButtons.push({
	imageId: 'mw-editbutton-places',
	imageFile: wgExtensionsPath + '/wikia/Places/images/button_place.png',
	speedTip: '',
	onclick: function(ev) {
		ev.preventDefault();

		var query = prompt('');
		$().log(query, 'Places');

		if (!query || query.length === 0) {
			return;
		}

		$.getJSON("http://maps.google.com/maps/geo?output=json&q=" + encodeURIComponent(query) + "&key={$apiKey}&callback=?", function(data) {
			$().log(data, 'Places');

			if (data && data.Placemark && data.Placemark.length) {
				var place = data.Placemark.shift(),
					cords = place.Point.coordinates,
					address = place.address,
					wikitext = '<place lat="' + cords[1].toFixed(6) + '" lon="' + cords[0].toFixed(6) + '" />';

				$().log(address, 'Places');
				$().log(wikitext, 'Places');


			}
		});
	}
});
**/

//insertTags(wikitext, '' /* tagClose */, '' /* sampleText */);