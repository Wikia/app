/*global window, document, require, setTimeout*/
/*jslint newcap:true */
/*jshint camelcase:false */
/*jshint maxlen:200*/
require([
	'wikia.log',
	'wikia.document',
	'wikia.window',
	'wikia.tracker',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adConfig',
	'ext.wikia.adEngine.evolveSlotConfig',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.lateAdsQueue',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.messageListener',
	require.optional('wikia.abTest')
], function (log, document, window, tracker, instantGlobals, adContext, adEngine, adConfig, evolveSlotConfig, adLogicPageParams, wikiaDart, slotTracker, lateAdsQueue, adLogicHighValueCountry, slotTweaker, messageListener, abTest) {
	'use strict';

	var module = 'AdEngine2.run',
		params,
		param,
		value,
		adsInHead = abTest && abTest.inGroup('ADS_IN_HEAD', 'YES');

	window.AdEngine_getTrackerStats = slotTracker.getStats;

	// DART API for Liftium
	window.LiftiumDART = {
		getUrl: function (slotname, slotsize) {
			if (slotsize) {
				slotsize += ',1x1';
			}
			return wikiaDart.getUrl({
				slotname: slotname,
				slotsize: slotsize,
				adType: 'adi',
				src: 'liftium'
			});
		}
	};

	messageListener.init();

	// Register Evolve hop
	window.evolve_hop = function (slotname) {
		require(['ext.wikia.adEngine.provider.evolve'], function(adProviderEvolve) {
			adProviderEvolve.hop(slotname);
		});
	};

	// Register window.wikiaDartHelper so jwplayer can use it
	window.wikiaDartHelper = wikiaDart;

	// Register adLogicHighValueCountry as so Liftium can use it
	window.adLogicHighValueCountry = adLogicHighValueCountry;

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	window.adSlotTweaker = slotTweaker;

	// Export page level params, so Krux can read them
	params = adLogicPageParams.getPageLevelParams();
	for (param in params) {
		if (params.hasOwnProperty(param)) {
			value = params[param];
			if (value) {
				window['kruxDartParam_' + param] = value.toString();
			}
		}
	}

	// Custom ads (skins, footer, etc)
	// TODO: loadable modules
	window.loadCustomAd = function (params) {
		log('loadCustomAd', 'debug', module);

		var adModule = 'ext.wikia.adEngine.template.' + params.type;
		log('loadCustomAd: loading ' + adModule, 'debug', module);

		require([adModule], function (adTemplate) {
			log('loadCustomAd: module ' + adModule + ' required', 'debug', module);
			adTemplate.show(params);
		});
	};

	function startEarlyQueue() {
		// Start ads
		window.AdEngine_trackStartEarlyAds();
		log('work on window.adslots2 according to AdConfig2', 1, module);
		tracker.track({
			eventName: 'liftium.init',
			ga_category: 'init2/init',
			ga_action: 'init',
			ga_label: 'adengine2',
			trackingMethod: 'ad'
		});
		window.adslots2 = window.adslots2 || [];
		adEngine.run(adConfig, window.adslots2, 'queue.early');
	}

	if (adsInHead) {
		setTimeout(startEarlyQueue, 0);
	} else {
		window.wgAfterContentAndJS.push(startEarlyQueue);
	}

	if (adContext.getContext().opts.disableLateQueue) {
		log('Skipping late queue - wgAdEngineDisableLateQueue set to true', 1, module);
	} else {
		if (instantGlobals.wgSitewideDisableLiftium) {
			log('Liftium disabled by wgSitewideDisableLiftium - running AdEngine_loadLateAds now', 1, module);
			window.AdEngine_loadLateAds();
		}
	}
});

// Load late ads now
window.AdEngine_loadLateAds = function () {
	'use strict';

	function loadLateFn() {
		require([
			'ext.wikia.adEngine.adConfigLate', 'ext.wikia.adEngine.adEngine', 'ext.wikia.adEngine.lateAdsQueue', 'wikia.tracker', 'wikia.log'
		], function (adConfigLate, adEngine, lateAdsQueue, tracker, log) {
			var module = 'AdEngine_loadLateAds';
			window.AdEngine_trackStartLateAds();
			log('launching late ads now', 1, module);
			log('work on lateAdsQueue according to AdConfig2Late', 1, module);
			tracker.track({
				eventName: 'liftium.init',
				ga_category: 'init2/init',
				ga_action: 'init',
				ga_label: 'adengine2 late',
				trackingMethod: 'ad'
			});
			adEngine.run(adConfigLate, lateAdsQueue, 'queue.late');
		});
	}

	require(['ext.wikia.adEngine.adContext', require.optional('wikia.abTest')], function (adContext, abTest) {
		var adsAfterPageLoad = adContext.getContext().lateAdsAfterPageLoad && abTest && abTest.inGroup('ADS_AFTER_PAGE_LOAD', 'YES');

		if (adsAfterPageLoad) {
			if (document.readyState === 'complete') {
				setTimeout(loadLateFn, 4);
			} else {
				window.addEventListener('load', loadLateFn, false);
			}
		} else {
			window.wgAfterContentAndJS.push(loadLateFn);
		}
	});


};

// Tracking functions for ads in head metrics
(function (window) {
	'use strict';

	function trackTime(timeTo) {
		var wgNowBased,
			performanceBased,
			adsInHead = window.wgLoadAdsInHead,
			lateAdsAfterPageLoad = window.wgLoadLateAdsAfterPageLoad;

		if (window.ads && window.ads.context && window.ads.context.opts) {
			adsInHead = ads.context.adsInHead;
			lateAdsAfterPageLoad = ads.context.lateAdsAfterPageLoad;
		}

		if (!adsInHead && !lateAdsAfterPageLoad) {
			return;
		}

		wgNowBased = Math.round(new Date().getTime() - window.wgNow.getTime());
		performanceBased = window.performance && window.performance.now && Math.round(window.performance.now());

		require([
			'wikia.log',
			'wikia.tracker',
			'ext.wikia.adEngine.slotTracker',
			require.optional('wikia.abTest')
		], function (log, tracker, slotTracker, abTest) {
			var adsInHead = abTest && abTest.getGroup('ADS_IN_HEAD'),
				adsAfterPageLoad = abTest && abTest.getGroup('ADS_AFTER_PAGE_LOAD'),
				experimentName = [];

			if (!adsInHead && !adsAfterPageLoad) {
				return;
			}

			if (adsInHead) {
				experimentName.push('adsinhead=' + adsInHead);
			}

			if (adsAfterPageLoad) {
				experimentName.push('lateadsafterload=' + adsAfterPageLoad);
			}

			log([
				'time to: ' + timeTo,
				experimentName.join(';'),
				'wgNowBased: ' + wgNowBased,
				'performanceBased: ' + performanceBased
			], 'info', 'AdEngine_track');

			tracker.track({
				ga_category: 'ad/performance/' + timeTo + '/wgNow',
				ga_action: experimentName.join(';'),
				ga_label: slotTracker.getTimeBucket(wgNowBased / 1000),
				ga_value: wgNowBased,
				trackingMethod: 'ad'
			});

			if (performanceBased) {
				tracker.track({
					ga_category: 'ad/performance/' + timeTo + '/performance',
					ga_action: experimentName.join(';'),
					ga_label: slotTracker.getTimeBucket(performanceBased / 1000),
					ga_value: performanceBased,
					trackingMethod: 'ad'
				});
			}
		});
	}

	// Measure time to page interactive
	window.AdEngine_trackPageInteractive = function () {
		trackTime('interactivePage');
	};

	// Measure time to load early queue
	window.AdEngine_trackStartEarlyAds = function () {
		trackTime('startEarlyAds');
	};

	// Measure time to load late queue
	window.AdEngine_trackStartLateAds = function () {
		trackTime('startLateAds');
	};

}(window));

//Rubicon
(function(window, performance, valuation){
	'use strict';

	function trackRubicon(event, valuation) {
		require(['wikia.tracker'], function (tracker) {
			var e = '(unknown)',
				estimate = valuation && valuation.estimate,
				pmp = valuation && valuation.pmp,
				action = valuation ? [
					'size=' + (estimate.size || e),
					'pmp.eligible=' + ((pmp && pmp.eligible) || e),
					'tier=' + (estimate.tier || e)
				] : [];

			action.push('cache=' + !!window.wgAdDriverRubiconCachedOnly);

			if (estimate) {
				tracker.track({
					ga_category: 'ad/lookup' + event + '/rubicon',
					ga_action: action.join(';') ,
					ga_label: 'deals=' + ((pmp && pmp.deals && pmp.deals.join && pmp.deals.join(',')) || e),
					ga_value: parseInt(estimate.tier, 10),
					trackingMethod: 'ad'
				});
			} else {
				tracker.track({
					ga_category: 'ad/lookupError/rubicon',
					ga_action: action.join(';') ,
					ga_value: 0,
					trackingMethod: 'ad'
				});
			}
		});
	}

	// No rubicon call made on page;
	if (!performance) {
		return;
	}

	var tier = valuation && valuation.estimate && valuation.estimate.tier;

	trackRubicon('Success', valuation);

	if (tier) {
		require(['ext.wikia.adEngine.gptSlotConfig'], function(gptSlotConfig) {
			var i, slots = ['HOME_TOP_RIGHT_BOXAD', 'TOP_RIGHT_BOXAD', 'TOP_INCONTENT_BOXAD', 'CORP_TOP_RIGHT_BOXAD'];
			for (i = 0; i < slots.length; i = i + 1) {
				gptSlotConfig.extendSlotParams('gpt', slots[i], { rp_tier: tier });
			}
		});
	}

	// Measure time to load rubicon queue
	window.AdEngine_trackRubicon = function () {
		trackRubicon.apply(this, arguments);
	};

})(window, window.rp_performance, window.rp_valuation);