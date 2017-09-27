/*global require*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adInfoTracker',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.a9',
	'ext.wikia.adEngine.lookup.prebid',
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
	a9,
	prebid,
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

	function callBiddersOnConsecutivePageView() {
		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverA9BidderCountries)) {
			a9.call();
		}
	}

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverA9BidderCountries)) {
			a9.call();
		}

		// TODO ADEN-5756 remove 'if' after A9 full roll out
		if (geo.isProperGeo(instantGlobals.wgAmazonMatchCountriesMobile) &&
			!geo.isProperGeo(instantGlobals.wgAdDriverA9BidderCountries)) {
			amazon.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		adInfoTracker.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();
	});

	// TODO: Remove else statement, this step is required in order to keep bidders working during cache invalidation
	// Why checking getSlots method - because this method has been removed in PR with required changes
	if (!win.Mercury.Modules.Ads.getInstance().getSlots) {
		mercuryListener.afterPageWithAdsRender(function () {
			callBiddersOnConsecutivePageView();
		});
	} else {
		mercuryListener.onEveryPageChange(function () {
			callBiddersOnConsecutivePageView();
		});
	}
});
