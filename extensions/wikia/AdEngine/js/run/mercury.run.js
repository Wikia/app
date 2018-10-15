/*global require*/
require([
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.geo',
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
	'ext.wikia.adEngine.tracking.pageInfoTracker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.adEngine.wad.babDetection',
	'wikia.trackingOptIn',
	'wikia.window',
	require.optional('wikia.articleVideo.featuredVideo.lagger')
], function (
	adEngineBridge,
	adContext,
	pageLevelParams,
	adTracker,
	slotsContext,
	geo,
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
	pageInfoTracker,
	adLogicZoneParams,
	babDetection,
	trackingOptIn,
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
			adLogicZoneParams,
			adContext,
			btfBlocker,
			'mercury',
			trackingOptIn,
			babDetection,
			slotsContext
		);
	});

	win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);

	function passFVLineItemIdToUAP() {
		if (fvLagger && context.opts.isFVUapKeyValueEnabled) {
			fvLagger.addResponseListener(function (lineItemId) {
				win.loadCustomAd({
					adProduct: 'jwp',
					type: 'bfp',
					uap: lineItemId
				});
			});
		}
	}

	function callOnConsecutivePageView() {
		if (adContext.get('bidders.prebid')) {
			prebid.call();
		}

		if (adContext.get('bidders.a9')) {
			a9.call();
		}

		passFVLineItemIdToUAP();

		adEngineBridge.readSessionId();

		// Track Labrador values to DW
		var labradorPropValue = geo.getSamplingResults().join(';');

		if (context.opts.enableAdInfoLog && labradorPropValue) {
			pageInfoTracker.trackProp('labrador', labradorPropValue);
		}
	}

	mercuryListener.onLoad(function () {
		callOnConsecutivePageView();

		adInfoListener.run();
		slotStateMonitor.run();
		actionHandler.registerMessageListener();

		window.addEventListener('adengine.emitter', function (event) {
			adEngineBridge.passSlotEvent(event.detail.slotName, event.detail.eventName);
		});
	});

	mercuryListener.afterPageWithAdsRender(function () {
		callOnConsecutivePageView();
	});
});
