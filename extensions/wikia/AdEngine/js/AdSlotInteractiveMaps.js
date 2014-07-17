/*global define*/
define('ext.wikia.adEngine.slot.interactiveMaps', ['wikia.window', 'wikia.document'], function(window, document) {
	'use strict';

	function initSlot(container) {
		var data = {}, iframe;

		data.mapId = container.getAttribute('data-map-id');

		if (!data.mapId) {
			return false;
		}

		iframe = document.createElement('IFRAME');
		iframe.id = 'wikia-map-ad-' + data.mapId;
		iframe.name = 'wikia-map-ad-' + data.mapId;
		iframe.src = '/__cb' + window.wgStyleVersion + '/extensions/wikia/AdEngine/InteractiveMaps/ad.html#' + JSON.stringify(data) ;
		container.appendChild(iframe);
	}

	return {
		initSlot: initSlot
	};
});
