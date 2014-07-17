/*global define*/
define('ext.wikia.adEngine.slot.interactiveMaps', ['wikia.window', 'wikia.document', 'ext.wikia.adEngine.adLogicPageParams'], function (window, document, adLogicPageParams) {
	'use strict';

	var iframeCounter = 0;

	function initSlot(container) {

		if (!window.wgShowAds) {
			return;
		}

		var params = adLogicPageParams.getPageLevelParams(),
			data = {},
			iframe;

		data.mapid = container.getAttribute('data-map-id');
		data.s0 = params.s0;
		data.s1 = params.s1;
		data.s2 = 'map';

		if (!data.mapid) {
			return false;
		}

		iframe = document.createElement('IFRAME');
		iframe.id = 'wikia-map-ad-' + data.mapid + '-' + iframeCounter;
		iframe.name = 'wikia-map-ad-' + data.mapid + '-' + iframeCounter;
		iframe.src = '/__cb' + window.wgStyleVersion + '/extensions/wikia/AdEngine/InteractiveMaps/ad.html#' + JSON.stringify(data);
		container.appendChild(iframe);

		iframeCounter = iframeCounter + 1;
	}

	return {
		initSlot: initSlot
	};
});
