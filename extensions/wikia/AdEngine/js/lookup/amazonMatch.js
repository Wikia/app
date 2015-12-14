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
			'3x6': [
				'TOP_RIGHT_BOXAD',
				'HOME_TOP_RIGHT_BOXAD',
				'HUB_TOP_RIGHT_BOXAD',
				'LEFT_SKYSCRAPER_2',
				'LEFT_SKYSCRAPER_3'
			],
			'7x9': ['TOP_LEADERBOARD', 'HOME_TOP_LEADERBOARD', 'HUB_TOP_LEADERBOARD'],
			'9x2': ['TOP_LEADERBOARD', 'HOME_TOP_LEADERBOARD', 'HUB_TOP_LEADERBOARD']
		},
		bestPricePointForSize = {
			'1x6': null,
			'3x2': null,
			'3x5': null,
			'3x6': null,
			'7x9': null,
			'9x2': null
		},
		module,
		name = 'amazon';

	function isSlotSupported(slotName) {
		var key;
		for (key in sizeMapping) {
			if (sizeMapping.hasOwnProperty(key) && sizeMapping[key].indexOf(slotName) !== -1) {
				return true;
			}
		}

		return false;
	}

	function trackState(providerName, slotName, params) {
		log(['trackState', amazonResponse, providerName, slotName], 'debug', logGroup);
		var category,
			eventName = 'lookup_error',
			prices;

		if (!isSlotSupported(slotName)) {
			log(['trackState', 'Not supported slot', slotName], 'debug', logGroup);
			return;
		}
		if (amazonResponse) {
			eventName = 'lookup_success';
		}
		category = name + '/' + eventName + '/' + providerName;
		if (params.amznslots) {
			prices = params.amznslots.join(';');
		}
		adTracker.track(category, slotName, 0, prices || 'nodata');
	}

	function trackLookupEnd() {
		var data = {};
		Object.keys(sizeMapping).forEach(function (amazonSize) {
			var pricePoint = bestPricePointForSize[amazonSize];
			if (pricePoint) {
				data['a' + amazonSize] = 'p' + pricePoint;
			}
		});
		adTracker.track(name + '/lookup_end', data || 'nodata', 0);
	}

	function onAmazonResponse() {
		var allPricePointsForSize = {},
			i,
			len,
			param,
			m,
			amazonSize,
			amazonTier,
			tokens;

		amazonTiming.measureDiff({}, 'end').track();
		tokens = win.amznads.getTokens();
		log(['onAmazonResponse', tokens], 'debug', logGroup);
		amazonResponse = true;

		// First identify all correct amazon price points and record them in allPricePointsForSize
		for (i = 0, len = tokens.length; i < len; i += 1) {
			param = tokens[i];
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

		log(['onAmazonResponse - end', bestPricePointForSize], 'debug', logGroup);
		trackLookupEnd();
	}

	function call() {
		log('call', 'debug', logGroup);

		var amznMatch = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		amazonTiming = adTracker.measureTime('amazon', {}, 'start');
		amazonTiming.track();

		amznMatch.type = 'text/javascript';
		amznMatch.src = 'http://c.amazon-adsystem.com/aax2/amzn_ads.js';
		amznMatch.addEventListener('load', function () {
			var renderAd = win.amznads.renderAd;
			if (!win.amznads.getAdsCallback || !renderAd) {
				return;
			}
			win.amznads.getAdsCallback(amazonId, onAmazonResponse);
			win.amznads.renderAd = function (doc, adId) {
				log(['renderAd', doc, adId, 'available: ' + !!amazonResponse[adId]], 'debug', logGroup);
				amazonRendered = true;
				renderAd(doc, adId);
			};
		});

		node.parentNode.insertBefore(amznMatch, node);
		amazonCalled = true;
	}

	function wasCalled() {
		log(['wasCalled', amazonCalled], 'debug', logGroup);
		return amazonCalled;
	}

	function hasResponse() {
		log(['hasResponse', amazonResponse], 'debug', logGroup);
		return amazonResponse ? true : false;
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
	}

	module.call = call;
	module.getSlotParams = getSlotParams;
	module.trackState = trackState;
	return module;
});

define('ext.wikia.adEngine.amazonMatch', [
	'ext.wikia.adEngine.lookup.amazonMatch'
], function (amazonMatch) {
	'use strict';
	return amazonMatch;
});
