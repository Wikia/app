/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngineRunner',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.config.desktop',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'ext.wikia.adEngine.slot.scrollHandler',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.sourcePointDetection',
	'wikia.window',
	'wikia.loader',
	require.optional('ext.wikia.adEngine.recovery.gcs')
], function (
	adContext,
	adEngineRunner,
	adLogicHighValueCountry,
	adConfigDesktop,
	customAdsLoader,
	dartHelper,
	messageListener,
	recoveryHelper,
	scrollHandler,
	slotTracker,
	slotTweaker,
	sourcePoint,
	win,
	loader,
	gcs
) {
	'use strict';

	var context = adContext.getContext(),
		skin = 'oasis';

	win.AdEngine_getTrackerStats = slotTracker.getStats;

	// DART API for Liftium
	win.LiftiumDART = {
		getUrl: function (slotname, slotsize) {
			if (slotsize) {
				slotsize += ',1x1';
			}
			return dartHelper.getUrl({
				slotname: slotname,
				slotsize: slotsize,
				adType: 'adi',
				src: 'liftium'
			});
		}
	};

	messageListener.init();

	// Register window.wikiaDartHelper so jwplayer can use it
	win.wikiaDartHelper = dartHelper;

	// Register adLogicHighValueCountry as so Liftium can use it
	win.adLogicHighValueCountry = adLogicHighValueCountry;

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	win.adSlotTweaker = slotTweaker;

	// Custom ads (skins, footer, etc)
	win.loadCustomAd = customAdsLoader.loadCustomAd;

	// Everything starts after content and JS
	win.wgAfterContentAndJS.push(function () {
		// Ads
		scrollHandler.init(skin);
		win.adslots2 = win.adslots2 || [];
		adEngineRunner.run(adConfigDesktop, win.adslots2, 'queue.desktop', !!context.opts.delayEngine);

		// Recovery
		recoveryHelper.initEventQueue();

		if (!context.opts.sourcePointRecovery) {
			sourcePoint.initDetection();
		}

		if (context.opts.googleConsumerSurveys && gcs) {
			gcs.addRecoveryCallback();
		}

		if (context.opts.recoveredAdsMessage) {
			loader({
				type: loader.AM_GROUPS,
				resources: ['adengine2_ads_recovery_message_js']
			}).done(function () {
				require(['ext.wikia.adEngine.recovery.message'], function (recoveredAdMessage) {
					recoveredAdMessage.addRecoveryCallback();
				});
			});
		}
	});
});

// Inject extra slots
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.highImpact',
	'ext.wikia.adEngine.slot.inContent',
	'ext.wikia.adEngine.slot.skyScraper3',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.adEngine.slot.exitstitial')
], function (adContext, highImpact, inContent, skyScraper3, doc, win, exitstitial) {
	'use strict';

	var context = adContext.getContext();

	function initDesktopSlots() {
		highImpact.init();
		skyScraper3.init();

		if (context.slots.incontentPlayer) {
			inContent.init('INCONTENT_PLAYER');
		}

		if (context.slots.incontentLeaderboard) {
			inContent.init('INCONTENT_LEADERBOARD');
		}

		if (exitstitial) {
			exitstitial.init();
		}
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
