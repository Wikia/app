/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adInfoTracker',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.openXBidder',
	'ext.wikia.adEngine.lookup.prebid',
	'ext.wikia.adEngine.lookup.rubicon.rubiconFastlane',
	'ext.wikia.adEngine.lookup.rubicon.rubiconVulcan',
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
	oxBidder,
	prebid,
	rubiconFastlane,
	rubiconVulcan,
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

	if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile)) {
		amazon.call();
	}

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries)) {
			rubiconFastlane.call();
		}

		// TODO ADEN-5170 remove one condition or old OXBidder when we decide which way we go
		if (
			geo.isProperGeo(instantGlobals.wgAdDriverOpenXBidderCountries) &&
			!geo.isProperGeo(instantGlobals.wgAdDriverOpenXPrebidBidderCountries)
		) {
			oxBidder.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverRubiconVulcanCountries)) {
			rubiconVulcan.call();
		}

		adInfoTracker.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();
	});

	if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
		mercuryListener.onEveryPageChange(function () {
			prebid.call();
		});
	}

	if (
		geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneCountries) &&
		geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlaneMercuryFixCountries)
	) {
		mercuryListener.onEveryPageChange(function () {
			rubiconFastlane.call();
		});
	}
});
