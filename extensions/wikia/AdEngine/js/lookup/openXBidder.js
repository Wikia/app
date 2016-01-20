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
				TOP_LEADERBOARD: '728x90',
				TOP_RIGHT_BOXAD: '300x250',
				LEFT_SKYSCRAPER_2: '160x600',
				PREFOOTER_LEFT_BOXAD: '300x250',
				PREFOOTER_RIGHT_BOXAD: '300x250'
			},
			mercury: {
				MOBILE_IN_CONTENT: '300x250',
				MOBILE_PREFOOTER: '300x250',
				MOBILE_TOP_LEADERBOARD: '320x50'
			}
		},
		priceMap = {},
		slots = [];

	function getSlots(skin) {
		var context = adContext.getContext(),
			pageType = context.targeting.pageType,
			slotName;

		slots = config[skin];
		if (skin === 'oasis' && pageType === 'home') {
			for (slotName in slots) {
				if (slots.hasOwnProperty(slotName) && slotName.indexOf('TOP') > -1) {
					slots['HOME_' + slotName] = slots[slotName];
					delete slots[slotName];
				}
			}
		}

		return slots;
	}

	function getAds(skin) {
		var ads = [],
			size,
			slotName,
			slotPath = [
				'/5441',
				'wka.' + adLogicZoneParams.getSite(),
				adLogicZoneParams.getMappedVertical(),
				'',
				adLogicZoneParams.getPageType()
			].join('/');

		slots = getSlots(skin);
		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				size = slots[slotName];
				ads.push([
					slotPath,
					[size],
					'wikia_gpt' + slotPath + '/gpt/' + slotName
				]);
			}
		}

		return ads;
	}

	function getSlotParams(slotName) {
		var dfpParams = {},
			dfpKey,
			price;

		price = priceMap[slotName];

		if (!price) {
			log(['getSlotParams', 'No price for the slot', slotName], 'debug', logGroup);
			return {};
		}

		dfpKey = 'ox' + slots[slotName];
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
				priceMap[shortSlotName] = prices[slotName].price;
			}
		}
	}

	function call(skin, onResponse) {
		var openx = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		win.OX_dfp_ads = getAds(skin);

		win.OX_dfp_options = {
			callback: onResponse
		};

		openx.async = true;
		openx.type = 'text/javascript';
		openx.src = '//ox-d.wikia.servedbyopenx.com/w/1.0/jstag?nc=5441-Wikia';

		node.parentNode.insertBefore(openx, node);
	}

	function isEnabled() {
		return adLogicZoneParams.getSite() === 'life';
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'ox_bidder',
		isEnabled: isEnabled,
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
