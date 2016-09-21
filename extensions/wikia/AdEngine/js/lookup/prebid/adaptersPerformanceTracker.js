define('ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker', [
	'ext.wikia.adEngine.adTracker',
	'wikia.window'
], function(adTracker, win) {
	'use strict';

	var emptyResponseMsg = 'EMPTY',
		notRespondedMsg = 'NOT_RESPONDED';

	function setupPerformanceMap(skin, adapters) {
		var biddersPerformanceMap = {};

		adapters.forEach(function (adapter) {
			var slots = adapter.getSlots(skin),
				adapterName = adapter.getName();

			Object.keys(slots).forEach(function (slotName) {
				biddersPerformanceMap[adapterName] = biddersPerformanceMap[adapterName] || {};
				biddersPerformanceMap[adapterName][slotName] = notRespondedMsg;
			})
		});

		return biddersPerformanceMap;
	}

	function updatePerformanceMap(performanceMap) {
		var allBids;

		if (typeof win.pbjs.getBidResponses === 'function') {
			allBids = win.pbjs.getBidResponses();

			Object.keys(allBids).forEach(function (slotName) {
				var slotBids = allBids[slotName].bids;

				slotBids.forEach(function (bid) {
					performanceMap[bid.bidder][slotName] = getParamsFromBidForTracking(bid);
				});
			});
		}

		return performanceMap;
	}

	function trackBidderSlotState(bidderName, slotName, providerName, performanceMap) {
		var category;

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

	function trackBidderOnLookupEnd(adapterName, performanceMap) {
		adTracker.track(adapterName + '/lookup_end', performanceMap[adapterName], 0, 'nodata');
	}

	function getParamsFromBidForTracking(bid) {
		if (bid.getStatusCode() === 2) {
			return emptyResponseMsg;
		} else {
			return [bid.getSize(), bid.pbMg].join(';');
		}
	}



	return {
		setupPerformanceMap: setupPerformanceMap,
		trackBidderOnLookupEnd: trackBidderOnLookupEnd,
		trackBidderSlotState: trackBidderSlotState,
		updatePerformanceMap: updatePerformanceMap
	}
});
