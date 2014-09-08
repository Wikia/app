/*global define*/
/*jshint maxlen:125*/
define('ext.wikia.adEngine.slot.interactiveMaps', [
	'wikia.log', 'wikia.window', 'wikia.document', 'ext.wikia.adEngine.adContext', 'ext.wikia.adEngine.adLogicPageParams'
], function (log, window, document, adContext, adLogicPageParams) {
	'use strict';

	var iframeCounter = 0,
		logGroup = 'ext.wikia.adEngine.slot.interactiveMaps';

	function initSlot(container) {
		log(['initSlot', container], 'info', logGroup);

		if (!adContext.getContext().opts.showAds || !container) {
			return;
		}

		var params = adLogicPageParams.getPageLevelParams(),
			adParams = {},
			iframe,
			url = '/extensions/wikia/AdEngine/InteractiveMaps/ad.html';

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
		iframe.src = url + '?' + window.wgStyleVersion + '#' + JSON.stringify({adParams: adParams});
		container.appendChild(iframe);

		log(['initSlot', 'iframeCreated', iframe, 'adParams', adParams], 'info', logGroup);

		iframeCounter += 1;
	}

	return {
		initSlot: initSlot
	};
});
