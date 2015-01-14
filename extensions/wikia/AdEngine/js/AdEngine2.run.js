/*global window, document, require, setTimeout*/
/*jslint newcap:true */
/*jshint camelcase:false */
/*jshint maxlen:200*/
require([
	'wikia.log',
	'wikia.window',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adConfig',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.messageListener',
	require.optional('wikia.abTest')
], function (
	log,
	window,
	instantGlobals,
	adContext,
	adEngine,
	adConfig,
	adLogicPageParams,
	adTracker,
	wikiaDart,
	slotTracker,
	adLogicHighValueCountry,
	slotTweaker,
	messageListener,
	abTest
) {
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
		require(['ext.wikia.adEngine.provider.evolve'], function (adProviderEvolve) {
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
		log('work on window.adslots2 according to AdConfig2', 1, module);
		adTracker.measureTime('adengine.init', 'queue.early').track();
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
			'ext.wikia.adEngine.adConfigLate', 'ext.wikia.adEngine.adEngine', 'ext.wikia.adEngine.lateAdsQueue', 'ext.wikia.adEngine.adTracker', 'wikia.log'
		], function (adConfigLate, adEngine, lateAdsQueue, adTracker, log) {
			var module = 'AdEngine_loadLateAds';
			log('launching late ads now', 1, module);
			log('work on lateAdsQueue according to AdConfig2Late', 1, module);
			adTracker.measureTime('adengine.init', 'queue.late').track();
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

// FPS meter
require(['wikia.querystring', 'wikia.document'], function (qs, doc) {
	'use strict';
	if (qs().getVal('fps')) {
		var s = doc.createElement('script');
		s.src = 'https://raw.githubusercontent.com/Wikia/fps-meter/master/fps-meter.js';
		doc.body.appendChild(s);
	}
});
