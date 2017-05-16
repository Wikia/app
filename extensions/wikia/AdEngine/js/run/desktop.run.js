/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngineRunner',
	'ext.wikia.adEngine.adInfoTracker',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.slot.service.stateMonitor',
	'ext.wikia.adEngine.config.desktop',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.pageFairDetection',
	'ext.wikia.adEngine.taboolaHelper',
	'ext.wikia.adEngine.slot.service.actionHandler',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.sourcePointDetection',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.window',
	require.optional('ext.wikia.adEngine.recovery.gcs'),
	require.optional('ext.wikia.adEngine.template.floatingRail')
], function (
	adContext,
	adEngineRunner,
	adInfoTracker,
	pageLevelParams,
	slotStateMonitor,
	adConfigDesktop,
	customAdsLoader,
	dartHelper,
	messageListener,
	pageFairDetection,
	taboolaHelper,
	actionHandler,
	slotTracker,
	slotTweaker,
	sourcePointDetection,
	adBlockDetection,
	win,
	gcs,
	floatingRail
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
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		if (floatingRail) {
			pageLevelParams.add('ah', floatingRail.getArticleHeightParameter().toString());
		}

		adInfoTracker.run();
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

		// Taboola
		if (context.opts.loadTaboolaLibrary) {
			adBlockDetection.addOnBlockingCallback(function() {
				taboolaHelper.loadTaboola();
			});
		}

		if (context.opts.googleConsumerSurveys && gcs) {
			gcs.addRecoveryCallback();
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
	'ext.wikia.adEngine.slot.skyScraper3',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.document',
	'wikia.window'
], function (
	adContext,
	slotsContext,
	bottomLeaderboard,
	highImpact,
	inContent,
	skyScraper3,
	slotTweaker,
	doc,
	win
) {
	'use strict';

	var context = adContext.getContext();

	function initDesktopSlots() {
		var incontentLeaderboardSlotName = 'INCONTENT_LEADERBOARD',
			incontentPlayerSlotName = 'INCONTENT_PLAYER';

		highImpact.init();
		skyScraper3.init();

		if (slotsContext.isApplicable(incontentPlayerSlotName)) {
			inContent.init(incontentPlayerSlotName);
		}

		if (slotsContext.isApplicable(incontentLeaderboardSlotName)) {
			inContent.init(incontentLeaderboardSlotName, function () {
				if (context.opts.incontentLeaderboardAsOutOfPage) {
					slotTweaker.adjustIframeByContentSize(incontentLeaderboardSlotName);
				}
			});
		}
	}

	win.addEventListener('wikia.uap', bottomLeaderboard.init);

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
