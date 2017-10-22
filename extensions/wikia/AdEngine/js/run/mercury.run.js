/*global require*/
require([
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.lookup.amazonMatch',
	'ext.wikia.adEngine.lookup.a9',
	'ext.wikia.adEngine.lookup.prebid',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.tracking.adInfoListener',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	slotStateMonitor,
	amazon,
	a9,
	prebid,
	customAdsLoader,
	messageListener,
	mercuryListener,
	actionHandler,
	adInfoListener,
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

		adInfoListener.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();
	});

	mercuryListener.afterPageWithAdsRender(function () {
		callBiddersOnConsecutivePageView();
	});
});
