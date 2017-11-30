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
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.slot.service.slotRegistry',
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
	btfBlocker,
	actionHandler,
	slotRegistry,
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
	if (adContext.get('opts.isAdProductsBridgeEnabled')) {
		adEngineBridge.init(slotRegistry, pageLevelParams.getPageLevelParams(), adContext, btfBlocker, 'oasis');
		win.loadCustomAd = adEngineBridge.loadCustomAd(customAdsLoader.loadCustomAd);
	} else {
		win.loadCustomAd = customAdsLoader.loadCustomAd;
	}

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
