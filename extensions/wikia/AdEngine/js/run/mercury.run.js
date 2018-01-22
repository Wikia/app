/*global require*/
require([
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.babDetection',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.lookup.a9',
	'ext.wikia.adEngine.lookup.prebid',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.mobile.mercuryListener',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.tracking.adInfoListener',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (
	adEngineBridge,
	adContext,
	pageLevelParams,
	adTracker,
	babDetection,
	slotStateMonitor,
	a9,
	prebid,
	customAdsLoader,
	messageListener,
	mercuryListener,
	btfBlocker,
	actionHandler,
	slotRegistry,
	adInfoListener,
	geo,
	instantGlobals,
	win
) {
	'use strict';

	var context = adContext.getContext();

	messageListener.init();

	// Custom ads (skins, footer, etc)
	if (geo.isProperGeo(instantGlobals.wgAdDriverAdProductsBridgeMobileCountries)) {
		adContext.addCallback(function () {
			adEngineBridge.init(
				adTracker,
				geo,
				slotRegistry,
				mercuryListener,
				pageLevelParams.getPageLevelParams(),
				adContext,
				btfBlocker,
				'mercury'
			);
		});
		win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);

		if (context.opts.babDetectionMobile) {
			adEngineBridge.checkAdBlocking(babDetection);
		}
	} else {
		win.loadCustomAd = customAdsLoader.loadCustomAd;
	}

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
