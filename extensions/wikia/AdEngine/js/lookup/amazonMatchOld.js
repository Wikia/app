/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.amazonMatchOld', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, doc, log, w) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.amazonMatchOld',
		amazonId = '3006',
		amazonTargs,
		amazonTiming,
		amazonCalled = false;

	function trackState(trackEnd) {
		log(['trackState', amazonTargs], 'debug', logGroup);

		var eventName,
			i,
			j,
			data,
			matches;

		if (amazonTargs) {
			eventName = 'lookupSuccess';
			matches = amazonTargs.replace('amzn_', '').match(/[\dx]+_tier\d/g);
			if (matches) {
				data = {};

				for (i = matches.length - 1; i > -1; i -= 1) {
					j = matches[i].split('_');
					data[j[1]] = data[j[1]] || [];
					data[j[1]].push(j[0]);
				}
			}
		} else {
			eventName = 'lookupError';
		}

		if (trackEnd) {
			eventName = 'lookupEnd';
		}

		adTracker.track(eventName + '/amazon', data || '(unknown)', 0);
	}

	function onAmazonResponse(response) {
		amazonTiming.measureDiff({}, 'end').track();
		log(['onAmazonResponse', response], 'debug', logGroup);
		amazonTargs = w.amzn_targs;
		trackState(true);
	}

	function call(ac, geoCountryCode) {
		if (ac && ac.indexOf && ac.indexOf(geoCountryCode) > -1) {
			log('call', 'debug', logGroup);

			amazonCalled = true;
			amazonTiming = adTracker.measureTime('amazon', {}, 'start');
			amazonTiming.track();

			var url = encodeURIComponent(doc.location),
				s = doc.createElement('script');

			try {
				url = encodeURIComponent(w.top.location.href);
			} catch (e) {
			}

			s.id = logGroup;
			s.async = true;
			s.onload = onAmazonResponse;
			s.src = '//aax.amazon-adsystem.com/e/dtb/bid?src=' + amazonId + '&u=' + url + "&cb=" + Math.round(Math.random() * 10000000);
			doc.body.appendChild(s);
		} else {
			log('call - skipped: wrong geo', 'debug', logGroup);
		}
	}

	function wasCalled() {
		log(['wasCalled', amazonCalled], 'debug', logGroup);
		return amazonCalled;
	}

	return {
		call: call,
		trackState: function () { trackState(); },
		wasCalled: wasCalled
	};
});

define('ext.wikia.adEngine.amazonMatchOld', [
	'ext.wikia.adEngine.lookup.amazonMatchOld'
], function (amazonMatchOld) {
	'use strict';
	return amazonMatchOld;
});
