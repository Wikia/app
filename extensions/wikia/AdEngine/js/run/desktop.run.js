/*global require*/
/*jslint newcap:true*/
/*jshint camelcase:false*/
/*jshint maxlen:200*/
require([
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adLogicHighValueCountry',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.config.desktop',
	'ext.wikia.adEngine.customAdsLoader',
	'ext.wikia.adEngine.dartHelper',
	'ext.wikia.adEngine.messageListener',
	'ext.wikia.adEngine.provider.evolve',
	'ext.wikia.adEngine.slot.adInContentPlayer',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.krux',
	'wikia.window',
	require.optional('ext.wikia.adEngine.slot.exitstitial'),
	require.optional('ext.wikia.adEngine.slot.inContentDesktop')
], function (
	adEngine,
	adLogicHighValueCountry,
	adTracker,
	adConfigDesktop,
	customAdsLoader,
	dartHelper,
	messageListener,
	providerEvolve,
	adInContentPlayer,
	slotTracker,
	slotTweaker,
	krux,
	window,
	exitstitial,
	inContentDesktop
) {
	'use strict';

	var kruxSiteId = 'JU3_GW1b';

	window.AdEngine_getTrackerStats = slotTracker.getStats;

	// DART API for Liftium
	window.LiftiumDART = {
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
	window.evolve_hop = providerEvolve.hop;

	// Register window.wikiaDartHelper so jwplayer can use it
	window.wikiaDartHelper = dartHelper;

	// Register adLogicHighValueCountry as so Liftium can use it
	window.adLogicHighValueCountry = adLogicHighValueCountry;

	// Register adSlotTweaker so DART creatives can use it
	// https://www.google.com/dfp/5441#delivery/CreateCreativeTemplate/creativeTemplateId=10017012
	window.adSlotTweaker = slotTweaker;

	// Custom ads (skins, footer, etc)
	window.loadCustomAd = customAdsLoader.loadCustomAd;

	adInContentPlayer.init();

	// Everything starts after content and JS
	window.wgAfterContentAndJS.push(function () {
		// Ads
		adTracker.measureTime('adengine.init', 'queue.desktop').track();
		window.adslots2 = window.adslots2 || [];
		adEngine.run(adConfigDesktop, window.adslots2, 'queue.desktop');

		// Krux
		krux.load(kruxSiteId);
	});

	// Start loading in content slots
	if (inContentDesktop) {
		window.addEventListener('load', inContentDesktop.init);
	}

	// Start loading in content slots
	if (exitstitial) {
		window.addEventListener('load', exitstitial.init);
	}
});

require(['ext.wikia.adEngine.adContext', 'wikia.abTest', 'wikia.document'], function (adContext, abTest, doc) {
	'use strict';

	var group = abTest.getGroup('ADS_VIEWABILITY_MEDREC'),
		medrec = doc.getElementById('TOP_RIGHT_BOXAD');

	if (group && medrec && !adContext.getContext().providers.sevenOneMedia) {
		medrec.className += ' ads-viewability-test ' + group;
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
