define('ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.lookup.prebid.bidHelper',
	'ext.wikia.adEngine.utils.timeBuckets',
	'ext.wikia.adEngine.wrappers.prebid'
], function (adTracker, adaptersRegistry, bidHelper, timeBuckets, prebid) {
	'use strict';

	var buckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.0],
		emptyResponseMsg = 'EMPTY_RESPONSE',
		notRespondedMsg = 'NO_RESPONSE';

	function setupPerformanceMap(skin) {
		var biddersPerformanceMap = {},
			adapters = adaptersRegistry.getAdapters();

		adapters.forEach(function (adapter) {
			var slots = adapter.getSlots(skin),
				adapterName = adapter.getName();

			if (adapter.isEnabled()) {
				biddersPerformanceMap[adapterName] = {};
				Object.keys(slots).forEach(function (slotName) {
					biddersPerformanceMap[adapterName][slotName] = notRespondedMsg;
				});
			}
		});

		return biddersPerformanceMap;
	}

	function updatePerformanceMap(performanceMap) {
		var allBids;

		if (typeof prebid.get().getBidResponses === 'function') {
			allBids = prebid.get().getBidResponses();

			Object.keys(allBids).forEach(function (slotName) {
				var slotBids = allBids[slotName].bids;

				slotBids.forEach(function (bid) {
					performanceMap[bid.bidder][slotName] = getParamsFromBidForTracking(bid);
				});
			});
		}

		return performanceMap;
	}

	function trackBidderSlotState(adapter, slotName, providerName, performanceMap) {
		var bidderName = adapter.getName(), category;

		if (!adapter.isEnabled()) {
			return;
		}

		//Don't track if slot not supported by adapter
		if (!performanceMap[bidderName][slotName]) {
			return;
		}

		if (performanceMap[bidderName][slotName] !== notRespondedMsg) {
			category = bidderName + '/lookup_success/' + providerName;
			adTracker.track(category, slotName, 0, performanceMap[bidderName][slotName]);
		} else {
			category = bidderName + '/lookup_error/' + providerName;
			adTracker.track(category, slotName, 0, 'nodata');
		}
	}

	function trackBidderOnLookupEnd(adapter, performanceMap) {
		var bidderName = adapter.getName();

		if (adapter.isEnabled()) {
			adTracker.track(bidderName + '/lookup_end', performanceMap[bidderName], 0, 'nodata');
		}
	}

	function getParamsFromBidForTracking(bid) {
		var bucket = timeBuckets.getTimeBucket(buckets, bid.timeToRespond / 1000);

		if (bid.getStatusCode() === prebid.errorResponseStatusCode) {
			return [emptyResponseMsg, bucket].join(';');
		}

		return [
			bid.getSize(),
			bidHelper.transformPriceFromBid(bid),
			bucket
		].join(';');
	}


	return {
		setupPerformanceMap: setupPerformanceMap,
		trackBidderOnLookupEnd: trackBidderOnLookupEnd,
		trackBidderSlotState: trackBidderSlotState,
		updatePerformanceMap: updatePerformanceMap
	};
});
