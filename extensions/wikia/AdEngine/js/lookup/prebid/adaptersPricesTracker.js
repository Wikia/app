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
			bestPrices[adapter.getName()] = undefined;
		});

		log(['getSlotBestPrices slotBids', slotName, slotBids], 'debug', logGroup);

		slotBids.forEach(function(bid) {

			log(['getSlotBestPrices bidder', bid.bidderCode, slotName], 'debug', logGroup);
			log(['getSlotBestPrices price', bid.pbMg, slotName], 'debug', logGroup);
			log(['getSlotBestPrices current price', bestPrices[bid.bidderCode], slotName], 'debug', logGroup);

			bestPrices[bid.bidderCode] = Math.max(bestPrices[bid.bidderCode], parseFloat(bid.pbMg)) || 0;

			if (typeof bestPrices[bid.bidderCode] !== 'undefined') {
				log(['getSlotBestPrices best price defined', (bestPrices[bid.bidderCode] / 100).toFixed(2).toString(), slotName], 'debug', logGroup);
				bestPrices[bid.bidderCode] = (bestPrices[bid.bidderCode] / 100).toFixed(2).toString();
			}
		});

		return bestPrices;
	}

	return {
		getSlotBestPrice: getSlotBestPrice
	}
});
