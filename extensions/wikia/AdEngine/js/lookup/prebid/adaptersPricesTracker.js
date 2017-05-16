define('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', [
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.lookup.prebid.priceGranularityHelper',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.log'
], function (adaptersRegistry, priceGranularityHelper, prebid, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker';

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
				var bidderCode = bid.bidderCode,
					cpmPrice = priceGranularityHelper.transformPriceFromCpm(bid.cpm);

				bestPrices[bidderCode] = Math.max(bestPrices[bidderCode] || 0, parseFloat(cpmPrice)).toFixed(2).toString();

				if (bid.notInvolved) {
					bestPrices[bidderCode] = 'NOT_INVOLVED';
				} else if (bid.used) {
					bestPrices[bidderCode] = 'USED';
				}

				log(['getSlotBestPrices best price for slot', slotName, bidderCode, bestPrices[bidderCode]], 'debug', logGroup);
			}
		});

		return bestPrices;
	}

	/**
	 * Checks if bidder has correct status code (is available).
	 * @param bid object
	 * @returns {boolean}
	 */
	function isValidPrice(bid) {
		return bid.getStatusCode && bid.getStatusCode() === prebid.validResponseStatusCode;
	}

	return {
		getSlotBestPrice: getSlotBestPrice,
		_isValidPrice: isValidPrice //for testing only
	}
});
