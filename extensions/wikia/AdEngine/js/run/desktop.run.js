/*global require*/
/*jshint camelcase:false*/
(function () {
	'use strict';

	var adContext = require('ext.wikia.adEngine.adContext'),
		adEngine = require('ext.wikia.adEngine.adEngine'),
		adLogicHighValueCountry = require('ext.wikia.adEngine.adLogicHighValueCountry'),
		adTracker = require('ext.wikia.adEngine.adTracker'),
		adConfigDesktop = require('ext.wikia.adEngine.config.desktop'),
		customAdsLoader = require('ext.wikia.adEngine.customAdsLoader'),
		dartHelper = require('ext.wikia.adEngine.dartHelper'),
		messageListener = require('ext.wikia.adEngine.messageListener'),
		providerEvolve = require('ext.wikia.adEngine.provider.evolve'),
		recoveryHelper = require('ext.wikia.adEngine.recovery.helper'),
		scrollHandler = require('ext.wikia.adEngine.slot.scrollHandler'),
		slotTracker = require('ext.wikia.adEngine.slotTracker'),
		slotTweaker = require('ext.wikia.adEngine.slotTweaker'),
		sourcePoint = require('ext.wikia.adEngine.sourcePointDetection'),
		krux = require('wikia.krux'),
		win = require('wikia.window'),
		loader = require('wikia.loader'),
		kruxSiteId = 'JU3_GW1b',
		context = adContext.getContext(),
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

	// Register Evolve hop
	win.evolve_hop = providerEvolve.hop;

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
		adTracker.measureTime('adengine.init', 'queue.desktop').track();
		scrollHandler.init(skin);
		win.adslots2 = win.adslots2 || [];
		adEngine.run(adConfigDesktop, win.adslots2, 'queue.desktop');

		// Recovery
		recoveryHelper.initEventQueue();
		sourcePoint.initDetection();

		if (context.opts.sourcePointRecovery && win.ads) {
			win.ads.runtime.sp.slots = win.ads.runtime.sp.slots || [];
			recoveryHelper.addOnBlockingCallback(function () {
				adTracker.measureTime('adengine.init', 'queue.sp').track();
				adEngine.run(adConfigDesktop, win.ads.runtime.sp.slots, 'queue.sp');
			});
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

		// Krux
		krux.load(kruxSiteId);
	});
})();

// Inject extra slots
(function () {
	'use strict';

	var inContentPlayer = require('ext.wikia.adEngine.slot.inContentPlayer'),
		skyScraper3 = require('ext.wikia.adEngine.slot.skyScraper3'),
		doc = require('wikia.document'),
		win = require('wikia.window');

	function initDesktopSlots() {
		inContentPlayer.init();
		skyScraper3.init();

		/**
		 * those two below are optional and won't be available always
		 */
		try {
			require('ext.wikia.adEngine.slot.exitstitial').init();
		} catch (exception) {}

		try {
			require('ext.wikia.adEngine.slot.inContentDesktop').init();
		} catch (exception) {}
	}

	if (doc.readyState === 'complete') {
		initDesktopSlots();
	} else {
		win.addEventListener('load', initDesktopSlots);
	}
})();

// FPS meter
(function () {
	'use strict';

	var qs = require('wikia.querystring'),
		doc = require('wikia.document');

	if (qs().getVal('fps')) {
		var s = doc.createElement('script');
		s.src = 'https://raw.githubusercontent.com/Wikia/fps-meter/master/fps-meter.js';
		doc.body.appendChild(s);
	}
})();
