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
	'wikia.window'
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
	win
) {
	'use strict';

	var context = adContext.getContext();

	win.AdEngine_getTrackerStats = slotTracker.getStats;

	messageListener.init();

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	win.adSlotTweaker = slotTweaker;

	// Custom ads (skins, footer, etc)
	adEngineBridge.init(
		adTracker,
		geo,
		slotRegistry,
		null,
		pageLevelParams.getPageLevelParams(),
		adContext,
		btfBlocker,
		'oasis'
	);
	win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);

	if (context.opts.babDetectionDesktop) {
		adEngineBridge.checkAdBlocking(babDetection);
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

// Inject extra slots
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.slot.bottomLeaderboard',
	'ext.wikia.adEngine.slot.highImpact',
	'ext.wikia.adEngine.slot.inContent',
	'wikia.document',
	'wikia.window'
], function (
	adContext,
	slotsContext,
	bottomLeaderboard,
	highImpact,
	inContent,
	doc,
	win
) {
	'use strict';

	function initDesktopSlots() {
		highImpact.init();
		inContent.init('INCONTENT_PLAYER');
		bottomLeaderboard.init();
	}

	if (doc.readyState === 'complete') {
		initDesktopSlots();
	} else {
		win.addEventListener('load', initDesktopSlots);
	}
});

// FPS meter
require(['wikia.querystring', 'wikia.document'], function (qs, doc) {
	'use strict';
	if (qs().getVal('fps')) {
		var s = doc.createElement('script');
		s.src = 'https://raw.githubusercontent.com/Wikia/fps-meter/master/fps-meter.js';
		doc.body.appendChild(s);
	}
});
