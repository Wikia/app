/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adInfoTracker',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.prebid',
	'ext.wikia.adEngine.lookup.rubicon.rubiconFastlane',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	adContext,
	adInfoTracker,
	slotStateMonitor,
	amazon,
	prebid,
	rubiconFastlane,
	customAdsLoader,
	messageListener,
	mercuryListener,
	actionHandler,
	geo,
	instantGlobals,
	win
) {
	'use strict';
	messageListener.init();

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile)) {
			amazon.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries)) {
			rubiconFastlane.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		adInfoTracker.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();
	});

	mercuryListener.onEveryPageChange(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		if (
			geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries) &&
			geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneMercuryFixCountries)
		) {
			rubiconFastlane.call();
		}
	});
});
