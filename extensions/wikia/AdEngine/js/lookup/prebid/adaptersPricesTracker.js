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
			var priceFromBidder = parseFloat(bid.pbMg);

			console.log('*****BOGNA pbMg', bid.pbMg);
			console.log('*****BOGNA floated', parseFloat(bid.pbMg));

			log(['getSlotBestPrices bidder', bid.bidderCode, slotName], 'debug', logGroup);
			log(['getSlotBestPrices price', priceFromBidder, slotName], 'debug', logGroup);
			log(['getSlotBestPrices current price', bestPrices[bid.bidderCode], slotName], 'debug', logGroup);

			bestPrices[bid.bidderCode] = Math.max(bestPrices[bid.bidderCode],priceFromBidder) || 0;

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
