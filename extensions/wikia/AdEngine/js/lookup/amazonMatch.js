/*global define*/
/*jshint camelcase:false*/
/*jshint maxdepth:5*/
define('ext.wikia.adEngine.lookup.amazonMatch', [
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adTracker, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.amazonMatch',
		amazonId = '3115',
		amazonResponse,
		amazonTiming,
		amazonCalled = false,
		amazonRendered = false,
		amazonParamPattern = /^a([0-9]x[0-9])p([0-9]+)$/,
		sizeMapping = {
			'1x6': ['LEFT_SKYSCRAPER_2', 'LEFT_SKYSCRAPER_3'],
			'3x2': [
				'TOP_RIGHT_BOXAD',
				'HOME_TOP_RIGHT_BOXAD',
				'HUB_TOP_RIGHT_BOXAD',
				'MOBILE_IN_CONTENT',
				'MOBILE_PREFOOTER'
			],
			'3x5': ['MOBILE_TOP_LEADERBOARD'],
			'3x6': ['TOP_RIGHT_BOXAD', 'HOME_TOP_RIGHT_BOXAD', 'HUB_TOP_RIGHT_BOXAD'],
			'7x9': ['TOP_LEADERBOARD', 'HOME_TOP_LEADERBOARD', 'HUB_TOP_LEADERBOARD']
		},
		bestPricePointForSize = {
			'1x6': null,
			'3x2': null,
			'3x5': null,
			'3x6': null,
			'7x9': null
		},
		module;

	function trackState(trackEnd) {
		log(['trackState', amazonResponse], 'debug', logGroup);

		var eventName,
			data = {};

		if (amazonResponse) {
			eventName = 'lookupSuccess';
			Object.keys(sizeMapping).forEach(function (amazonSize) {
				var pricePoint = bestPricePointForSize[amazonSize];
				if (pricePoint) {
					data['a' + amazonSize] = 'p' + pricePoint;
				}
			});
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

		if (amazonResponse) {
			var targetingParams = Object.keys(amazonResponse),
				allPricePointsForSize = {},
				i,
				len,
				param,
				m,
				amazonSize,
				amazonTier;

			// First identify all correct amazon price points and record them in allPricePointsForSize
			for (i = 0, len = targetingParams.length; i < len; i += 1) {
				param = targetingParams[i];
				m = param.match(amazonParamPattern);
				if (m) {
					amazonSize = m[1];
					amazonTier = parseInt(m[2], 10);
					if (!allPricePointsForSize[amazonSize]) {
						allPricePointsForSize[amazonSize] = [];
					}
					allPricePointsForSize[amazonSize].push(amazonTier);
				}
			}

			// Now select the minimal price point for each size we are interested in
			Object.keys(bestPricePointForSize).forEach(function (amazonSize) {
				var pricePoints = allPricePointsForSize[amazonSize];
				if (pricePoints) {
					bestPricePointForSize[amazonSize] = Math.min.apply(Math, pricePoints);
				}
			});
		}

		log(['onAmazonResponse - end', bestPricePointForSize], 'debug', logGroup);

		trackState(true);
	}

	function renderAd(doc, adId) {
		log(['renderAd', doc, adId, 'available: ' + !!amazonResponse[adId]], 'debug', logGroup);
		amazonRendered = true;
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

	function hasResponse() {
		log(['hasResponse', amazonResponse], 'debug', logGroup);
		return (amazonResponse) ? true : false;
	}

	function getSlotParams(slotName) {
		log(['getSlotParams', slotName], 'debug', logGroup);

		var amznSlots = [];

		if (!amazonRendered) {
			Object.keys(sizeMapping).forEach(function (amazonSize) {
				var validSlotNames = sizeMapping[amazonSize],
					amazonPricePoint = bestPricePointForSize[amazonSize];

				if (validSlotNames.indexOf(slotName) !== -1 && amazonPricePoint) {
					amznSlots.push('a' + amazonSize + 'p' + amazonPricePoint);
				}
			});

			log(['getSlotParams - amznSlots: ', amznSlots], 'debug', logGroup);
		} else {
			log(['getSlotParams - no amznSlots since ads has been already displayed', slotName], 'debug', logGroup);
		}

		if (amznSlots.length) {
			return {
				amznslots: amznSlots
			};
		}

		return {};
	}

	module = {
		call: function () {
			log('fake call - module is not supported in IE8', 'debug', logGroup);
		},
		getSlotParams: function () {
			log('fake getSlotParams - module is not supported in IE8', 'debug', logGroup);
			return {};
		},
		trackState: function () {
			log('fake trackState - module is not supported in IE8', 'debug', logGroup);
		},
		wasCalled: wasCalled,
		hasResponse: hasResponse
	};

	if (!Object.keys) {
		return module;
	} else {
		module.call = call;
		module.getSlotParams = getSlotParams;
		module.trackState = trackState;
		return module;
	}
});

define('ext.wikia.adEngine.amazonMatch', [
	'ext.wikia.adEngine.lookup.amazonMatch'
], function (amazonMatch) {
	'use strict';
	return amazonMatch;
});
