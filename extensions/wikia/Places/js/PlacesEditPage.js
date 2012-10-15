/*global PlacesEditor: true*/
if (window.mwCustomEditButtons && window.skin === 'oasis') {
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
					PlacesEditor.createNew(function(location) {
						$().log(location, 'Inserting <place> tag');

						if (location !== false) {
							var wikitext = '<place lat="' + location.lat + '" lon="' + location.lon + '" />';

							// focus on current editor textarea
							if (typeof RTE !== 'undefined') {
								RTE.getInstanceEditor().getEditbox().focus();
							}
							else {
								$('#wpTextbox1').focus();
							}

							insertTags(wikitext, '' /* tagClose */, '' /* sampleText */);
						}
					});
				}
			);
		}
	});
}