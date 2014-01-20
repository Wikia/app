/*jslint newcap:true */
/*jshint camelcase:false, maxlen:150 */
/*global require*/
/*global AdEngine2, WikiaFullGptHelper, AdProviderGpt, AdProviderNull, AdConfigMobile*/

require(
	[
		'wikia.adlogicpageparams', 'wikia.document',
		'wikia.lazyqueue', 'wikia.log', 'ext.wikia.adengine.slottracker',
		'ext.wikia.adengine.slottweaker', 'wikia.window'
	],
	function (adLogicPageLevelParams, document, lazyQueue, log, slotTracker, slotTweaker, window) {
		'use strict';

		var logGroup = 'AdEngineMobile',
			adEngine = AdEngine2(log, lazyQueue, slotTracker),
			wikiaFullGpt = WikiaFullGptHelper(log, window, document, adLogicPageLevelParams),
			adProviderGpt = AdProviderGptMobile(log, window, slotTweaker, wikiaFullGpt),
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
