/*jslint newcap:true */
/*jshint camelcase:false, maxlen:150 */
/*global require*/
/*global AdEngine2, WikiaFullGptHelper, AdProviderGpt, AdProviderNull, AdConfigMobile*/

require(
	[
		'wikia.adlogicpageparams', 'ext.wikia.adengine.adtracker', 'wikia.document',
		'wikia.geo', 'wikia.lazyqueue', 'wikia.log', 'ext.wikia.adengine.slottracker',
		'ext.wikia.adengine.slottweaker', 'wikia.window',
		'wikia.adslots'
	],
	function (adLogicPageLevelParams, adTracker, document, geo, lazyQueue, log, slotTracker, slotTweaker, window, adSlots) {
		'use strict';

		var logGroup = 'AdEngineMobile',
			adEngine = AdEngine2(log, lazyQueue, slotTracker),
			wikiaFullGpt = WikiaFullGptHelper(log, window, document, adLogicPageLevelParams),
			adLogicHighValueCountry = { // nice hack
				getMaxCallsToDART: function () { return 1e16; },
				isHighValueCountry: function () { return true; }
			},
			cache = {
				get: function () {},
				set: function () {},
				del: function () {}
			},
			adProviderGpt = AdProviderGpt(adTracker, log, window, geo, slotTweaker, cache, adLogicHighValueCountry, wikiaFullGpt, adSlots),
			adProviderNull = AdProviderNull(log, slotTweaker),
			adConfigMobile = AdConfigMobile(
				// AdProviders:
				adProviderGpt,
				adProviderNull
			);

		window.adslots2 = window.adslots2 || [];

		window.addEventListener('load', function () {
			log('Running mobile queue', 'info', logGroup);
			adEngine.run(adConfigMobile, window.adslots2, 'queue.mobile');
		});
	}
);
