/*global require*/
require([
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window',
	require.optional('ext.wikia.adEngine.adInContentPlayer')
], function (
	amazon,
	customAdsLoader,
	messageListener,
	geo,
	instantGlobals,
	win,
	adInContentPlayer
) {
	'use strict';
	messageListener.init();

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	var ac = instantGlobals.wgAmazonMatchCountries;
	if (ac && ac.indexOf && ac.indexOf(geo.getCountryCode()) > -1) {
		amazon.call();
	}

	if (adInContentPlayer) {
		adInContentPlayer.init();
	}
});
