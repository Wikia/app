/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.openXBidder', [
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.lookup.openx.openXBidderHelper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (factory, adSlot, openXHelper, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.openXBidder',
		priceTimeout = 't',
		priceMap = {};

	function getAds() {
		var ads = [],
			sizes,
			slotName,
			slots = openXHelper.getSlots(),
			pagePath = openXHelper.getPagePath();

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				sizes = slots[slotName].sizes;
				ads.push([
					pagePath,
					sizes,
					openXHelper.getSlotPath(slotName, 'gpt')
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

		openXHelper.setupSlots(skin);
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

	return factory.create({
		logGroup: logGroup,
		name: 'ox_bidder',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams,
		isSlotSupported: openXHelper.isSlotSupported
	});
});
