define('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', [
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.log'
], function (adaptersRegistry, prebid, log) {
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
			var priceFromBidder = bid.pbAg;

			if (priceFromBidder !== '' && !isNaN(priceFromBidder)) {
				bestPrices[bid.bidderCode] = Math.max(bestPrices[bid.bidderCode] || 0, parseFloat(priceFromBidder)).toFixed(2).toString();
				log(['getSlotBestPrices best price for slot', slotName, bid.bidderCode, bestPrices[bid.bidderCode]], 'debug', logGroup);
			}

		});

		return bestPrices;
	}

	return {
		getSlotBestPrice: getSlotBestPrice
	}
});
