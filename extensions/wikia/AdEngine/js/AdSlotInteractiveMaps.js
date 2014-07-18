/*global define*/
define('ext.wikia.adEngine.slot.interactiveMaps', ['wikia.window', 'wikia.document', 'ext.wikia.adEngine.adLogicPageParams'], function (window, document, adLogicPageParams) {
	'use strict';

	var iframeCounter = 0;

	function initSlot(container) {

		if (!window.wgShowAds || !container) {
			return;
		}

		var params = adLogicPageParams.getPageLevelParams(),
			adParams = {},
			iframe,
			url = '/__cb' + window.wgStyleVersion + '/extensions/wikia/AdEngine/InteractiveMaps/ad.html';

		adParams.mapid = container.getAttribute('data-map-id');
		adParams.s0 = params.s0;
		adParams.s1 = params.s1;
		adParams.s2 = 'map';
		adParams.hostpre = params.hostpre;
		adParams.dmn = params.dmn;

		if (!adParams.mapid) {
			return false;
		}

		iframe = document.createElement('iframe');
		iframe.id = 'wikia-map-ad-' + adParams.mapid + '-' + iframeCounter;
		iframe.name = 'wikia-map-ad-' + adParams.mapid + '-' + iframeCounter;
		iframe.src = url + '#' + JSON.stringify({adParams: adParams});
		container.appendChild(iframe);

		iframeCounter += 1;
	}

	return {
		initSlot: initSlot
	};
});
