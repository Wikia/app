define('ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.utils.timeBuckets',
	'ext.wikia.adEngine.wrappers.prebid'
], function (adTracker, timeBuckets, prebid) {
	'use strict';

	var buckets = [0.5, 1.0, 1.5, 2.0, 2.5, 3.0],
		emptyResponseMsg = 'EMPTY_RESPONSE',
		notRespondedMsg = 'NO_RESPONSE',
		responseErrorCode = 2,
		usedMsg = 'USED';

	function setupPerformanceMap(skin, adapters) {
		var biddersPerformanceMap = {};

		adapters.forEach(function (adapter) {
			var slots = adapter.getSlots(skin),
				adapterName = adapter.getName();

			if (adapter.isEnabled()) {
				Object.keys(slots).forEach(function (slotName) {
					biddersPerformanceMap[adapterName] = biddersPerformanceMap[adapterName] || {};
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

		if (performanceMap[bidderName]) {
			if (performanceMap[bidderName][slotName] !== notRespondedMsg) {
				category = bidderName + '/lookup_success/' + providerName;
				adTracker.track(category, slotName, 0, performanceMap[bidderName][slotName]);
			} else {
				category = bidderName + '/lookup_error/' + providerName;
				adTracker.track(category, slotName, 0, 'nodata');
			}
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

		if (bid.getStatusCode() === responseErrorCode) {
			return [emptyResponseMsg, bucket].join(';');
		} if (bid.complete) {
			return [usedMsg, bucket].join(';');
		} else {
			return [bid.getSize(), bid.pbMg, bucket].join(';');
		}
	}


	return {
		setupPerformanceMap: setupPerformanceMap,
		trackBidderOnLookupEnd: trackBidderOnLookupEnd,
		trackBidderSlotState: trackBidderSlotState,
		updatePerformanceMap: updatePerformanceMap
	}
});
