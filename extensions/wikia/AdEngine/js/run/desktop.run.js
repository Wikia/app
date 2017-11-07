/*global require*/
/*jshint camelcase:false*/
require([
	'ad-engine.bridge',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngineRunner',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.config.desktop',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.pageFairDetection',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.sourcePointDetection',
	'ext.wikia.adEngine.tracking.adInfoListener',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.window'
], function (
	adEngineBridge,
	adContext,
	adEngineRunner,
	pageLevelParams,
	slotStateMonitor,
	adConfigDesktop,
	customAdsLoader,
	dartHelper,
	messageListener,
	pageFairDetection,
	actionHandler,
	slotTracker,
	slotTweaker,
	sourcePointDetection,
	adInfoListener,
	adBlockDetection,
	win
) {
	'use strict';

	var context = adContext.getContext();

	win.AdEngine_getTrackerStats = slotTracker.getStats;

	messageListener.init();

	// Register window.wikiaDartHelper so jwplayer can use it
	win.wikiaDartHelper = dartHelper;

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	win.adSlotTweaker = slotTweaker;

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		adInfoListener.run();
		slotStateMonitor.run();

		// Ads
		win.adslots2 = win.adslots2 || [];
		adEngineRunner.run(adConfigDesktop, win.adslots2, 'queue.desktop', !!context.opts.delayEngine);

		actionHandler.registerMessageListener();

		sourcePointDetection.initDetection();

		if (context.opts.pageFairDetection) {
			pageFairDetection.initDetection(context);
		}

		// Recovery & detection
		adBlockDetection.initEventQueues();
	});
});

// Inject extra slots
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.slot.bottomLeaderboard',
	'ext.wikia.adEngine.slot.highImpact',
	'ext.wikia.adEngine.slot.inContent',
	'ext.wikia.adEngine.slot.skyScraper3',
	'wikia.document',
	'wikia.window'
], function (
	adContext,
	slotsContext,
	bottomLeaderboard,
	highImpact,
	inContent,
	skyScraper3,
	doc,
	win
) {
	'use strict';
	var context = adContext.getContext(),
		premiumSlots = context.slots.premiumAdLayoutSlotsToUnblock;

	function initDesktopSlots() {
		highImpact.init();
		skyScraper3.init();
		inContent.init('INCONTENT_PLAYER');
	}

	win.addEventListener('wikia.uap', bottomLeaderboard.init);

	if (context.opts.premiumAdLayoutEnabled && premiumSlots.indexOf('BOTTOM_LEADERBOARD') >= 0) {
		win.addEventListener('wikia.not_uap', bottomLeaderboard.init);
		win.addEventListener('wikia.blocking', bottomLeaderboard.init);
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
