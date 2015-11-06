(function () {
	'use strict';

	var w = require('wikia.window'),
		pontoBridge = require('wikia.maps.pontoBridge'),
		mapAds,
		iframe = w.document.getElementsByName('wikia-interactive-map')[0],
		adContainer = w.document.querySelector('.wikia-ad-interactive-map');

	if (iframe) {
		pontoBridge.init(iframe);
	}

	try {
		//FIXME: turning off ads on map because of JS errors - should be fixed in ADEN-1784
		//mapAds = require('ext.wikia.adEngine.slot.interactiveMaps');
	} catch (exception) {
		mapAds = null;
	}

	if (mapAds) {
		mapAds.initSlot(adContainer);
	}
})();
