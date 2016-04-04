/*global define*/
define('ext.wikia.adEngine.lookup.amazonMatch', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.amazonMatch',
		config = {
			oasis: {
				HOME_TOP_LEADERBOARD: ['7x9', '9x2'],
				HOME_TOP_RIGHT_BOXAD: ['3x2', '3x6'],
				HUB_TOP_LEADERBOARD: ['7x9', '9x2'],
				HUB_TOP_RIGHT_BOXAD: ['3x2', '3x6'],
				INCONTENT_BOXAD_1: ['3x2', '1x6', '3x6'],
				LEFT_SKYSCRAPER_2: ['1x6', '3x2', '3x6'],
				LEFT_SKYSCRAPER_3: ['1x6', '3x2', '3x6'],
				TOP_LEADERBOARD: ['7x9', '9x2'],
				TOP_RIGHT_BOXAD: ['3x2', '3x6']
			},
			mercury: {
				MOBILE_IN_CONTENT: ['3x2'],
				MOBILE_PREFOOTER: ['3x2'],
				MOBILE_TOP_LEADERBOARD: ['3x5']
			}
		},
		rendered = false,
		paramPattern = /^a([0-9]x[0-9])p([0-9]+)$/,
		amazonId = '3115',
		priceMap = {},
		slots = [];

	function call(skin, onResponse) {
		var amznMatch = doc.createElement('script'),
			context = adContext.getContext(),
			node = doc.getElementsByTagName('script')[0];

		slots = config[skin];

		if (context.opts.overridePrefootersSizes) {
			slots.PREFOOTER_LEFT_BOXAD = ['3x2', '7x9'];
		}

		if (context.slots.incontentLeaderboard) {
			slots.INCONTENT_LEADERBOARD = ['7x9','3x2'];
		}

		amznMatch.type = 'text/javascript';
		amznMatch.src = 'http://c.amazon-adsystem.com/aax2/amzn_ads.js';
		amznMatch.addEventListener('load', function () {
			var renderAd = win.amznads.renderAd;
			if (!win.amznads.getAdsCallback || !renderAd) {
				return;
			}
			win.amznads.getAdsCallback(amazonId, onResponse);
			win.amznads.renderAd = function (doc, adId) {
				renderAd(doc, adId);
				rendered = true;
			};
		});

		node.parentNode.insertBefore(amznMatch, node);
	}

	function calculatePrices() {
		var size,
			tier,
			tokens,
			m;

		tokens = win.amznads.getTokens();
		log(['calculatePrices', tokens], 'debug', logGroup);

		tokens.forEach(function (param) {
			m = param.match(paramPattern);
			if (m) {
				size = m[1];
				tier = parseInt(m[2], 10);

				if (!priceMap[size] || tier < priceMap[size]) {
					priceMap[size] = tier;
				}
			}
		});
	}

	function encodeParamsForTracking(params) {
		if (!params.amznslots) {
			return;
		}

		return params.amznslots.join(';');
	}

	function getSlotParams(slotName) {
		var params = [];

		if (rendered) {
			log(['getSlotParams', 'No params since ad has been already displayed', slotName], 'debug', logGroup);
			return {};
		}

		slots[slotName].forEach(function (size) {
			if (priceMap[size]) {
				params.push('a' + size + 'p' + priceMap[size]);
			}
		});

		return params.length > 0 ? {amznslots: params} : {};
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'amazon',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
