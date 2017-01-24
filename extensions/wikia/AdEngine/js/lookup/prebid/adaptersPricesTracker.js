define('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', [
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.log'
], function (adaptersRegistry, prebid, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker',
		validResponseStatusCode = 1;

	function getSlotBestPrice(slotName) {
		var prebidCmd = prebid.get(),
			slotBids = prebidCmd.getBidResponsesForAdUnitCode(slotName).bids || [],
			bestPrices = {};

		adaptersRegistry.getAdapters().forEach(function(adapter) {
			bestPrices[adapter.getName()] = '';
		});

		log(['getSlotBestPrices slotBids', slotName, slotBids], 'debug', logGroup);

		slotBids.forEach(function(bid) {
			if (isValidPrice(bid)) {
				var bidderCode = bid.bidderCode;

				bestPrices[bidderCode] = Math.max(bestPrices[bidderCode] || 0, parseFloat(bid.pbAg)).toFixed(2).toString();
				log(['getSlotBestPrices best price for slot', slotName, bidderCode, bestPrices[bidderCode]], 'debug', logGroup);
			}

		});

		return bestPrices;
	}

	/**
	 * Checks if bidder has correct status code (is available) and the price is a number.
	 * getStatusCode check is needed because even in case of error bid.pbAg value is 0.00
	 * @param bid object
	 * @returns {boolean}
	 */
	function isValidPrice(bid) {
		var priceFromBidder = bid.pbAg;

		return priceFromBidder !== '' &&
			!isNaN(priceFromBidder) &&
			typeof(priceFromBidder) !== 'boolean' &&
			bid.getStatusCode() === validResponseStatusCode;
	}

	return {
		getSlotBestPrice: getSlotBestPrice,
		_isValidPrice: isValidPrice //for testing only
	}
});
