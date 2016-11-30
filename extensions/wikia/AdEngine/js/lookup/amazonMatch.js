/*global define*/
define('ext.wikia.adEngine.lookup.amazonMatch', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, slotsContext, factory, doc, log, win) {
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
				TOP_RIGHT_BOXAD: ['3x2', '3x6'],
				INCONTENT_LEADERBOARD: ['7x9','3x2']
			},
			mercury: {
				MOBILE_IN_CONTENT: ['3x2'],
				MOBILE_PREFOOTER: ['3x2'],
				MOBILE_TOP_LEADERBOARD: ['3x5']
			}
		},
		rendered = false,
		paramPattern = /([0-9]x[0-9])/,
		amazonId = '3115',
		pointMap = {
			p1: 7,
			p2: 6.5,
			p3: 6,
			p4: 5.5,
			p5: 5,
			p6: 4.5,
			p7: 4,
			p8: 3.5,
			p9: 3,
			p10: 2.5,
			p11: 2,
			p12: 1.5,
			p13: 1,
			p14: 0.5
		},
		priceMap = {},
		slots = [];

	function call(skin, onResponse) {
		var amznMatch = doc.createElement('script'),
			context = adContext.getContext(),
			node = doc.getElementsByTagName('script')[0];

		slots = slotsContext.filterSlotMap(config[skin]);

		if (context.opts.overridePrefootersSizes) {
			slots.PREFOOTER_LEFT_BOXAD = ['3x2', '7x9'];
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
			tokens,
			m;

		tokens = win.amznads.getTokens();
		log(['calculatePrices', tokens], 'debug', logGroup);

		tokens.forEach(function (param) {
			m = param.match(paramPattern);
			if (m) {
				size = m[1];
				if (!priceMap[size]) {
					priceMap[size] = [];
				}
				priceMap[size].push(param);
			}
		});
	}

	function mapPricePoint(pricePoint) {
		var matches = /^a\d+x\d+(p\d+)/g.exec(pricePoint),
			price = 0;

		if (matches && matches[1]) {
			price = pointMap[matches[1]];
		}

		return price;
	}

	function findBestPrice(pricePoints) {
		var price;

		pricePoints.forEach(function (pricePoint) {
			price = Math.max(mapPricePoint(pricePoint), price || 0);
		});

		return price;
	}

	function getBestSlotPrice(slotName) {
		var price;

		if (slots[slotName]) {
			slots[slotName].forEach(function (size) {
				if (priceMap[size] && priceMap[size].length) {
					price = findBestPrice(priceMap[size]).toFixed(2).toString();
				}
			});
		}

		return {
			amazon: price
		};
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
				priceMap[size].forEach(function (price) {
					params.push(price);
				});
			}
		});

		return params.length > 0 ? { amznslots: params.sort() } : {};
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
		getBestSlotPrice: getBestSlotPrice,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
