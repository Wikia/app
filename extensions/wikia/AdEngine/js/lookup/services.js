/**
 * Module for getting information from "lookup" services such as Amazon A9
 *
 * It exposes only a single method called extendSlotTargeting that given a slot name and
 * slot targeting object will consult the lookup services and update the slot targeting object
 * with the targeting information from them (e.g. amznbid from A9).
 *
 * This module also causes the lookup services to track their state when they are consulted
 * (but only once).
 */
/*global define, require*/
define('ext.wikia.adEngine.lookup.services', [
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.prebid'),
	require.optional('ext.wikia.adEngine.lookup.a9')
], function (log, prebid, a9) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.lookup.services',
		bidders = [
			a9,
			prebid
		],
		bidIndex = {
			a9: {
				pos: 2,
				char: '9'
			},
			prebid: {
				pos: 4,
				char: 'P'
			}
		},
		bidMarker = ['x', 'x', 'x', 'x', 'x'],
		realSlotPrices = {};


	function addParameters(providerName, slotName, slotTargeting) {
		var params = {},
			floorPrice = 0,
			prebidPrices;

		if (prebid && prebid.wasCalled()) {
			prebidPrices = prebid.getBestSlotPrice(slotName);
			// promote prebid on a tie
			floorPrice = Math.max.apply(
				null,
				Object.keys(prebidPrices).filter(function(key) {
					return !isNaN(parseFloat(prebidPrices[key])) && parseFloat(prebidPrices[key]) > 0;
				}).map(function (key) { return parseFloat(prebidPrices[key]); })
			);
		}

		if (!Object.keys) {
			return;
		}

		bidders.forEach(function (bidder) {
			if (bidder && bidder.wasCalled()) {
				params = bidder.getSlotParams(slotName, floorPrice);
				bidder.trackState(providerName, slotName, params);
				Object.keys(params).forEach(function (key) {
					slotTargeting[key] = params[key];
				});
				if (bidder.hasResponse()) {
					bidMarker = updateBidderMarker(bidder.getName(), bidMarker);
				}
			}
		});
		slotTargeting.bid = bidMarker.join('');
	}

	function updateBidderMarker(bidderName, bidMarker) {
		var bidder;
		if (!bidIndex[bidderName]) {
			return bidMarker;
		}
		bidder = bidIndex[bidderName];
		bidMarker[bidder.pos] = bidder.char;
		return bidMarker;
	}

	function extendSlotTargeting(slotName, slotTargeting, providerName) {
		log(['extendSlotTargeting', slotName, slotTargeting], 'debug', logGroup);
		providerName = providerName.toLowerCase().replace('gpt', '');
		addParameters(providerName, slotName, slotTargeting);
	}

	function getCurrentSlotPrices(slotName) {
		var slotPrices = {};

		bidders.forEach(function (bidder) {
			if (bidder && bidder.isSlotSupported(slotName)) {
				var priceFromBidder = bidder.getBestSlotPrice(slotName);

				Object.keys(priceFromBidder).forEach(function(bidderName) {
					slotPrices[bidderName] = priceFromBidder[bidderName];
				});
			}
		});

		return slotPrices;
	}

	function storeRealSlotPrices(slotName) {
		realSlotPrices[slotName] = getCurrentSlotPrices(slotName);
	}

	function getDfpSlotPrices(slotName) {
		return realSlotPrices[slotName] || {};
	}

	return {
		extendSlotTargeting: extendSlotTargeting,
		getCurrentSlotPrices: getCurrentSlotPrices,
		storeRealSlotPrices: storeRealSlotPrices,
		getDfpSlotPrices: getDfpSlotPrices
	};
});
