/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.rubiconRtp', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, document, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.rubiconRtp',
		timingEventData = {ozCachedOnly: !!window.wgAdDriverRubiconCachedOnly},
		rtpStart,
		rtpEnd,
		rubiconCalled = false,
		rtpResponse,
		rtpTier;

	function trackState(trackEnd) {
		log(['trackState', rtpResponse], 'debug', logGroup);

		var e = '(unknown)',
			eventName,
			data = {},
			label;

		data.ozCachedOnly = !!window.wgAdDriverRubiconCachedOnly;
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
		rtpEnd = adTracker.measureTime('rubiconEnd', timingEventData);

		log(['onRubiconResponse', response], 'debug', logGroup);

		rtpStart.track();
		rtpEnd.track();

		rtpResponse = response;
		rtpTier = response && response.estimate && response.estimate.tier;

		trackState(true);
	}

	function call() {
		log('call', 'debug', logGroup);

		rubiconCalled = true;
		rtpStart = adTracker.measureTime('rubiconStart', timingEventData);

		window.oz_callback = onRubiconResponse;

		var s = document.createElement('script');
		s.src = '//tap-cdn.rubiconproject.com/partner/scripts/rubicon/dorothy.js?pc=' + window.oz_site;
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
		getTier: getTier,
		trackState: function () { trackState(); },
		wasCalled: wasCalled
	};
});
