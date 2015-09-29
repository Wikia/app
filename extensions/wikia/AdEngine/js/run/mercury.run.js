/*global require*/
require([
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.slot.scrollHandler',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	amazon,
	customAdsLoader,
	messageListener,
	scrollHandler,
	geo,
	instantGlobals,
	win
) {
	'use strict';
	var skin = 'mercury';

	messageListener.init();
	scrollHandler.init(skin);

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile)) {
		amazon.call();
	}
});
