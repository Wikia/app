require(['jquery', 'sloth'], function ($, sloth) {
	'use strict';

	/**
	 * @desc Obtains a thumbnail for the map, with right dimensions
	 * @param {HTMLElement} element - map figure that was lazy-loaded
	 */
	function getThumbnail(element) {
		var img = element.getElementsByTagName('img')[0],
			title = document.getElementById('mapTitle'),
			width = img.offsetWidth - 20;
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsParserTag',
			method: 'getMobileThumbnail',
			data: {
				image: img.getAttribute('data-src'),
				width: width,
				height: img.offsetHeight
			}
		}).done(function(data) {
			img.src = data.src;
			title.style.width = width + 'px';
		});
	}

	sloth({
		on: document.getElementsByClassName('wikia-interactive-map-thumbnail'),
		callback: getThumbnail
	});
});
