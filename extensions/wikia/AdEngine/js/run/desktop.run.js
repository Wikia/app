/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngineRunner',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.babDetection',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.config.desktop',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.pageFairDetection',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.tracking.adInfoListener',
	'ext.wikia.adEngine.tracking.scrollDepthTracker',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.geo',
	'wikia.trackingOptIn',
	'wikia.window',
	require.optional('wikia.articleVideo.featuredVideo.lagger')
], function (
	adEngineBridge,
	adContext,
	adEngineRunner,
	pageLevelParams,
	adTracker,
	babDetection,
	slotStateMonitor,
	adConfigDesktop,
	customAdsLoader,
	messageListener,
	pageFairDetection,
	btfBlocker,
	actionHandler,
	slotRegistry,
	slotTracker,
	slotTweaker,
	adInfoListener,
	scrollDepthTracker,
	adBlockDetection,
	geo,
	trackingOptIn,
	win,
	fvLagger
) {
	'use strict';

	win.AdEngine_getTrackerStats = slotTracker.getStats;

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	win.adSlotTweaker = slotTweaker;

	trackingOptIn.pushToUserConsentQueue(function () {
		var context = adContext.getContext();

		messageListener.init();

		// Custom ads (skins, footer, etc)
		adEngineBridge.init(
			adTracker,
			geo,
			slotRegistry,
			null,
			pageLevelParams.getPageLevelParams(),
			adContext,
			btfBlocker,
			'oasis',
			trackingOptIn
		);
		win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);

		if (context.opts.babDetectionDesktop) {
			adEngineBridge.checkAdBlocking(babDetection);
		}

		if (fvLagger && context.opts.isFVUapKeyValueEnabled) {
			fvLagger.addResponseListener(function (lineItemId) {
				win.loadCustomAd({
					adProduct: 'jwp',
					type: 'bfp',
					uap: lineItemId
				});
			});
		}

		// Everything starts after content and JS
		win.wgAfterContentAndJS.push(function () {
			adInfoListener.run();
			slotStateMonitor.run();

			// Ads
			win.adslots2 = win.adslots2 || [];
			adEngineRunner.run(adConfigDesktop, win.adslots2, 'queue.desktop', !!context.opts.delayEngine);

			actionHandler.registerMessageListener();

			scrollDepthTracker.run();

			if (context.opts.pageFairDetection) {
				pageFairDetection.initDetection(context);
			}
		});
	});
});

// Inject extra slots
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.slot.bottomLeaderboard',
	'ext.wikia.adEngine.slot.highImpact',
	'ext.wikia.adEngine.slot.inContent',
	'wikia.document',
	'wikia.trackingOptIn',
	'wikia.window'
], function (
	adContext,
	slotsContext,
	bottomLeaderboard,
	highImpact,
	inContent,
	doc,
	trackingOptIn,
	win
) {
	'use strict';

	function initDesktopSlots() {
		highImpact.init();
		inContent.init('INCONTENT_PLAYER');
		bottomLeaderboard.init();
	}

	trackingOptIn.pushToUserConsentQueue(function () {
		if (doc.readyState === 'complete') {
			initDesktopSlots();
		} else {
			win.addEventListener('load', initDesktopSlots);
		}
	});
});
