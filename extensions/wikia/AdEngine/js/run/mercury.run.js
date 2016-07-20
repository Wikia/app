/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.openXBidder',
	'ext.wikia.adEngine.lookup.rubiconFastlane',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.slot.scrollHandler',
	'ext.wikia.adEngine.provider.yavliTag',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	adContext,
	amazon,
	oxBidder,
	rubiconFastlane,
	customAdsLoader,
	messageListener,
	mercuryListener,
	scrollHandler,
	yavliTag,
	geo,
	instantGlobals,
	win
) {
	'use strict';

	messageListener.init();
	scrollHandler.init('mercury');

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile)) {
		amazon.call();
	}

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries)) {
			rubiconFastlane.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountriesMobile)) {
			oxBidder.call();
		}

		if (adContext.getContext().opts.yavli) {
			yavliTag.add();
		}
	});
});
