define('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.wrappers.prebid'
], function (adTracker, prebid) {
	'use strict';

	function getSlotBestPrice(slotName) {
		var prebidCmd = prebid.get(),
			slotBids = [] || prebidCmd.getBidResponsesForAdUnitCode(slotName).bids,
			bestPrices = {};

		slotBids.forEach(function(bid) {
			bestPrices[bid.bidderCode] = Math.max(bestPrices[bid.bidderCode], bid.pbMg);
		});

		return slotBids;
	}

	return {
		getSlotBestPrice: getSlotBestPrice
	}
});
