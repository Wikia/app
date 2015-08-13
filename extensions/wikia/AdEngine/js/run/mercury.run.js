/*global require*/
require([
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	amazon,
	customAdsLoader,
	messageListener,
	geo,
	instantGlobals,
	win
) {
	'use strict';
	messageListener.init();

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	var ac = instantGlobals.wgAmazonMatchCountriesMobile;
	if (ac && ac.indexOf && ac.indexOf(geo.getCountryCode()) > -1) {
		amazon.call();
	}
});
