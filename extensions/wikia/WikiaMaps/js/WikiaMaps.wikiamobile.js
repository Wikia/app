require([
	'wikia.window',
	'wikia.maps.pontoBridge',
	require.optional('ext.wikia.adEngine.slot.interactiveMaps')
], function (w, pontoBridge, mapAds) {
	'use strict';

	var iframe =  w.document.getElementsByName('wikia-interactive-map')[0],
		adContainer = w.document.querySelector('.wikia-ad-interactive-map');

	if (iframe) {
		pontoBridge.init(iframe);
	}

	if (mapAds) {
		mapAds.initSlot(adContainer);
	}
});
