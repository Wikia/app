/*global require*/
require([
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.openXBidder',
	'ext.wikia.adEngine.lookup.rubiconFastlane',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.slot.scrollHandler',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	amazon,
	oxBidder,
	rubiconFastlane,
	customAdsLoader,
	messageListener,
	mercuryListener,
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

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountriesMobile)) {
			oxBidder.call('mercury');
		}
		if (geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountriesMobile)) {
			rubiconFastlane.call('mercury');
		}
	});
});
