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
	'wikia.window',
	require.optional('wikia.articleVideo.featuredVideo.lagger')
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
	win,
	fvLagger
) {
	'use strict';

	var context = adContext.getContext();

	messageListener.init();

	// Custom ads (skins, footer, etc)
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

	function passFVLineItemIdToUAP() {
		if (fvLagger && context.opts.isFVUapKeyValueEnabled) {
			fvLagger.addResponseListener(function (lineItemId) {
				adEngineBridge.universalAdPackage.setUapId(lineItemId);
				adEngineBridge.universalAdPackage.setType('jwp');
			});
		}
	}

	function callBiddersOnConsecutivePageView() {
		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverA9BidderCountries)) {
			a9.call();
		}

		passFVLineItemIdToUAP();
	}

	mercuryListener.onLoad(function () {
		if (geo.isProperGeo(instantGlobals.wgAdDriverA9BidderCountries)) {
			a9.call();
		}

		if (geo.isProperGeo(instantGlobals.wgAdDriverPrebidBidderCountries)) {
			prebid.call();
		}

		passFVLineItemIdToUAP();

		adInfoListener.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();

		window.addEventListener('adengine.emitter', function (event) {
			adEngineBridge.passSlotEvent(event.detail.slotName, event.detail.eventName);
		});
	});

	mercuryListener.afterPageWithAdsRender(function () {
		callBiddersOnConsecutivePageView();
	});
});
