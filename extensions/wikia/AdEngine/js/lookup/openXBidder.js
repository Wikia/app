/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openXBidder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, factory, adSlot, adLogicZoneParams, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.openXBidder',
		priceTimeout = 't',
		config = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: ['728x90', '970x250']
				},
				TOP_RIGHT_BOXAD: {
					sizes: ['300x250', '300x600']
				},
				LEFT_SKYSCRAPER_2: {
					sizes: ['160x600', '300x600']
				},
				LEFT_SKYSCRAPER_3: {
					sizes: ['160x600', '300x600']
				},
				INCONTENT_BOXAD_1: {
					sizes: ['300x250', '300x600', '160x600']
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: ['300x250']
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: ['300x250']
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: ['300x250', '320x50']
				},
				MOBILE_PREFOOTER: {
					sizes: ['300x250', '320x50']
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: ['300x250', '320x50']
				}
			}
		},
		priceMap = {},
		slots = [];

	function configureHomePageSlots() {
		var slotName;
		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
				slots['HOME_' + slotName] = slots[slotName];
				delete slots[slotName];
			}
		}
		slots.PREFOOTER_MIDDLE_BOXAD = {sizes: ['300x250']};
	}

	function getSlots(skin) {
		var context = adContext.getContext(),
			pageType = context.targeting.pageType;

		slots = config[skin];
		if (skin === 'oasis' && pageType === 'home') {
			configureHomePageSlots();
		}

		return slots;
	}

	function getAds() {
		var ads = [],
			sizes,
			slotName,
			slotPath = [
				'/5441',
				'wka.' + adLogicZoneParams.getSite(),
				adLogicZoneParams.getName(),
				'',
				adLogicZoneParams.getPageType()
			].join('/');

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				sizes = slots[slotName].sizes;
				ads.push([
					slotPath,
					sizes,
					'wikia_gpt' + slotPath + '/gpt/' + slotName
				]);
			}
		}

		return ads;
	}

	function getSlotParams(slotName) {
		var dfpParams = {},
			dfpKey,
			price,
			size;

		if (!priceMap[slotName]) {
			log(['getSlotParams', 'No response for the slot', slotName], 'debug', logGroup);
			return {};
		}

		price = priceMap[slotName].price;
		size = priceMap[slotName].size;

		if (!price) {
			log(['getSlotParams', 'No price for the slot', slotName], 'debug', logGroup);
			return {};
		}

		dfpKey = 'ox' + size;
		dfpParams[dfpKey] = price;
		log(['getSlotParams', dfpKey, price], 'debug', logGroup);

		return dfpParams;
	}

	function encodeParamsForTracking(params) {
		var key,
			encoded = [];

		for (key in params) {
			if (params.hasOwnProperty(key)) {
				encoded.push(key + '=' + params[key]);
			}
		}

		return encoded.join(';');
	}

	function calculatePrices() {
		var prices = win.OX.dfp_bidder.getPriceMap(),
			slotName,
			shortSlotName;

		for (slotName in prices) {
			if (prices.hasOwnProperty(slotName) && prices[slotName].price !== priceTimeout) {
				shortSlotName = adSlot.getShortSlotName(slotName);
				priceMap[shortSlotName] = prices[slotName];
			}
		}
	}

	function call(skin, onResponse) {
		var openx = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		slots = getSlots(skin);
		win.OX_dfp_ads = getAds();

		win.OX_dfp_options = {
			callback: onResponse
		};

		openx.async = true;
		openx.type = 'text/javascript';
		openx.src = '//ox-d.wikia.servedbyopenx.com/w/1.0/jstag?nc=5441-Wikia';

		node.parentNode.insertBefore(openx, node);
	}

	function getPrices() {
		var prices = {};
		for (var slotName in priceMap) {
			if (priceMap.hasOwnProperty(slotName)) {
				prices[slotName] = priceMap[slotName].price;
			}
		}
		return prices;
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'ox_bidder',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
