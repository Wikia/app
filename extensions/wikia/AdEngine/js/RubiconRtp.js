/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.rubiconRtp', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, document, log, w) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.rubiconRtp',
		timingEventData = {},
		rtpTiming,
		rubiconCalled = false,
		rtpResponse,
		rtpTier,
		rtpConfig;

	function trackState(trackEnd) {
		log(['trackState', rtpResponse], 'debug', logGroup);

		var e = '(unknown)',
			eventName,
			data = {},
			label;

		data.ozCachedOnly = !!rtpConfig.oz_cached_only;
		data.response = !!rtpResponse;
		data.size = (rtpResponse && rtpResponse.estimate && rtpResponse.estimate.size) || e;
		data.pmpEligible = (rtpResponse && rtpResponse.pmp && rtpResponse.pmp.eligible) || e;
		data.tier = rtpTier || e;

		if (trackEnd) {
			eventName = 'lookupEnd';
		} else if (rtpTier) {
			eventName = 'lookupSuccess';
		} else {
			eventName = 'lookupError';
		}

		if (rtpResponse && rtpResponse.pmp && rtpResponse.pmp.deals) {
			label = 'pmpDeals=' + rtpResponse.pmp.deals.join(',');
		} else {
			label = 'noPmpDeals';
		}

		adTracker.track(eventName + '/rubicon', data, 0, label);
	}

	function onRubiconResponse(response) {
		// Track the start, end times
		rtpTiming.measureDiff(timingEventData, 'end').track();

		log(['onRubiconResponse', response], 'debug', logGroup);

		rtpResponse = response;
		rtpTier = response && response.estimate && response.estimate.tier;

		trackState(true);
	}

	function call(config) {
		log('call', 'debug', logGroup);

		rtpConfig = config;

		// Configuration through globals:
		w.oz_async = true;
		w.oz_cached_only = config.oz_cached_only;
		w.oz_api = config.oz_api || "valuation";
		w.oz_ad_server = config.oz_ad_server || "dart";
		w.oz_site = config.oz_site;
		w.oz_zone = config.oz_zone;
		w.oz_ad_slot_size = config.oz_ad_slot_size;

		rubiconCalled = true;
		rtpTiming = adTracker.measureTime('rubicon', timingEventData, 'start');
		rtpTiming.track();

		w.oz_callback = onRubiconResponse;

		var s = document.createElement('script');
		s.src = '//tap-cdn.rubiconproject.com/partner/scripts/rubicon/dorothy.js?pc=' + w.oz_site;
		s.async = true;
		document.body.appendChild(s);
	}

	function wasCalled() {
		log(['wasCalled', rubiconCalled], 'debug', logGroup);
		return rubiconCalled;
	}

	function getTier() {
		log(['getTier', rtpTier], 'debug', logGroup);
		return rtpTier;
	}

	return {
		call: call,
		getConfig: function () { return rtpConfig; },
		getTier: getTier,
		trackState: function () { trackState(); },
		wasCalled: wasCalled
	};
});
