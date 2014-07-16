/*global require*/
require([
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slot.interactiveMaps'
], function (window, document, eventDispatcher, interactiveMaps) {
	'use strict';

	if (!window.wgShowAds) {
		return false;
	}
	if (window.wgIsArticle) {

			eventDispatcher.bind('InteractiveMaps.ready', function() {
				var i, j, iframe, maps = document.querySelectorAll('.wikia-ad-interactive-map');

				for (i = 0, j = maps.length; i < j; i = i + 1) {
					interactiveMaps.initSlot(maps[i]);
				}
			}, true);

	}

});
