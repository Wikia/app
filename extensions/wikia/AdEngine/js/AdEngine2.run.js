/*
 * This file is used as initializer for ad-related modules and dependency injector.
 * Once AMD is available, this file will be almost no longer needed.
 */

/*global document, window */
/*global require*/
/*jslint newcap:true */
/*jshint camelcase:false */
/*jshint maxlen:200*/
require([
	'wikia.log',
	'wikia.window',
	'wikia.tracker',
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adConfig',
	'ext.wikia.adEngine.evolveSlotConfig',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.lateAdsQueue',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.slotTweaker'
], function (log, window, tracker, adEngine, adConfig, evolveSlotConfig, adLogicPageParams, wikiaDart, slotTracker, lateAdsQueue, adLogicHighValueCountry, slotTweaker) {
	'use strict';

	var module = 'AdEngine2.run',
		params,
		param,
		value;

	// Don't show ads when Sony requests the page
	window.wgShowAds = window.wgShowAds && !window.navigator.userAgent.match(/sony_tvs/);

	// Use PostScribe for ScriptWriter implementation when SevenOne Media ads are enabled
	window.wgUsePostScribe = window.wgUsePostScribe || window.wgAdDriverUseSevenOneMedia;

	window.wgAfterContentAndJS.push(function () {
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
	});

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

	// Register Evolve hop
	window.evolve_hop = function (slotname) {
		evolveSlotConfig.hop(slotname);
	};

	if (window.wgEnableRHonDesktop) {
		window.wgAfterContentAndJS.push(window.AdEngine_loadLateAds);
	}

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

});

// Load late ads now
window.AdEngine_loadLateAds = function () {
	'use strict';

	window.wgAfterContentAndJS.push(function() {
		require([
			'ext.wikia.adEngine.adConfigLate', 'ext.wikia.adEngine.adEngine', 'ext.wikia.adEngine.lateAdsQueue', 'wikia.tracker', 'wikia.log'
		], function (adConfigLate, adEngine, lateAdsQueue, tracker, log) {
			var module = 'AdEngine_loadLateAds';
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
	});
};
