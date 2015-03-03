/*global define*/
/*jshint camelcase:false*/
/*jshint maxdepth:5*/
define('ext.wikia.adEngine.amazonMatch', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.amazonMatch',
		amazonId = '3115',
		amazonResponse,
		amazonTiming,
		amazonCalled = false,
		amazonParamPattern = /^a([0-9]x[0-9])(p([0-9]+))$/,
		slotMapping = {
			'LEADERBOARD': 'a7x9',
			'BOXAD': 'a3x2',
			'SKYSCRAPER': 'a1x6'
		},
		slotTiers = {};

	function trackState(trackEnd) {
		log(['trackState', amazonResponse], 'debug', logGroup);

		var eventName,
			key,
			data = {};

		if (amazonResponse) {
			eventName = 'lookupSuccess';
			for (key in slotMapping) {
				if (slotMapping.hasOwnProperty(key) && slotTiers[key]) {
					data[slotMapping[key]] = 'p' + slotTiers[key];
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

		if (response.status === 'ok') {
			amazonResponse = response.ads;
		}

		if (amazonResponse && Object.keys) {
			var targetingParams = Object.keys(amazonResponse);
			Object.keys(slotMapping).forEach(function (slotNamePattern) {
				var i, len, points = [], m, param, amazonSize = slotMapping[slotNamePattern];

				for (i = 0, len = targetingParams.length; i < len; i += 1) {
					param = targetingParams[i];
					m = param.match(amazonParamPattern);
					if (m && param.search(amazonSize) === 0) {
						points.push(parseInt(m[3], 10));
					}
				}

				if (points.length) {
					slotTiers[slotNamePattern] = Math.min.apply(Math, points);
				}
			});
		}

		trackState(true);
	}

	function renderAd(doc, adId) {
		log(['getPageParams', doc, adId, 'available: ' + !!amazonResponse[adId]], 'debug', logGroup);
		doc.write(amazonResponse[adId]);
	}

	function call() {
		log('call', 'debug', logGroup);

		amazonCalled = true;
		amazonTiming = adTracker.measureTime('amazon', {}, 'start');
		amazonTiming.track();

		// Mocking amazon "lib"
		win.amznads = {
			updateAds: onAmazonResponse,
			renderAd: renderAd
		};

		var url = encodeURIComponent(doc.location),
			s = doc.createElement('script'),
			cb = Math.round(Math.random() * 10000000);

		try {
			url = encodeURIComponent(win.top.location.href);
		} catch (ignore) {}

		s.id = logGroup;
		s.async = true;
		s.src = '//aax.amazon-adsystem.com/e/dtb/bid?src=' + amazonId + '&u=' + url + '&cb=' + cb;
		doc.body.appendChild(s);

	}

	function wasCalled() {
		log(['wasCalled', amazonCalled], 'debug', logGroup);
		return amazonCalled;
	}

	function getSlotParams(slotName) {
		log(['getSlotParams'], 'debug', logGroup);

		var ret = {};

		// No Object.keys on IE8
		if (!Object.keys) {
			log(['filterSlots()', 'no Object.keys (IE8?)'], 'error', logGroup);
			return {};
		}

		Object.keys(slotMapping).forEach(function (slotNamePattern) {
			var amazonSize = slotMapping[slotNamePattern],
				amazonTier = slotTiers[slotNamePattern];

			if (slotName.search(slotNamePattern) > -1 && amazonTier) {
				ret = {
					amznslots: amazonSize + 'p' + amazonTier
				};
			}
		});

		return ret;
	}

	return {
		call: call,
		getSlotParams: getSlotParams,
		trackState: function () { trackState(); },
		wasCalled: wasCalled
	};
});
