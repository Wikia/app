define('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', [
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.wrappers.prebid'
], function (adaptersRegistry, prebid) {
	'use strict';

	function getSlotBestPrice(slotName) {
		var prebidCmd = prebid.get(),
			slotBids = prebidCmd.getBidResponsesForAdUnitCode(slotName).bids || [],
			bestPrices = {};

		adaptersRegistry.getAdapters().forEach(function(adapter) {
			bestPrices[adapter.getName()] = undefined;
		});

		slotBids.forEach(function(bid) {
			bestPrices[bid.bidderCode] = Math.max(bestPrices[bid.bidderCode], bid.pbMg) || 0;

			if (typeof bestPrices[bid.bidderCode] !== 'undefined') {
				bestPrices[bid.bidderCode] = (bestPrices[bid.bidderCode] / 100).toFixed(2).toString();
			}
		});

		return bestPrices;
	}

	return {
		getSlotBestPrice: getSlotBestPrice
	}
});
