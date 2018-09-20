/*global define, setTimeout, clearTimeout*/
define('ext.wikia.adEngine.lookup.bidders', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bidders',
	'wikia.lazyqueue',
	'wikia.log'
], function (adContext, adEngineBidders, lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.bidders',
		timeout,
		biddingCompleted = false,
		onResponseCallbacks = [];

	function getName() {
		return 'bidders';
	}

	function isEnabled() {
		return adContext.get('bidders.prebidAE3');
	}

	function addResponseListener(callback) {
		onResponseCallbacks.push(callback);
	}

	function markAsReady(timeOut) {
		if (timeOut || (!biddingCompleted && adEngineBidders.bidders.hasAllResponses())) {
			if (timeout) {
				clearTimeout(timeout);
			}

			biddingCompleted = true;
			onResponseCallbacks.start();
		}
	}

	function resetState() {
		biddingCompleted = false;
		onResponseCallbacks = [];
		lazyQueue.makeQueue(onResponseCallbacks, function (callback) {
			callback();
		});
	}

	function runBidding(maxTimeout) {
		log('A9 and Prebid bidding started:', 'debug', logGroup);

		timeout = setTimeout(function () {
			markAsReady(true);
		}, maxTimeout);

		adEngineBidders.bidders.requestBids({
			responseListener: markAsReady
		});
	}

	resetState();

	return {
		addResponseListener: addResponseListener,
		getBidByAdId: adEngineBidders.bidders.prebidHelper.getBidByAdId,
		getCurrentSlotPrices: adEngineBidders.bidders.getCurrentSlotPrices,
		getDfpSlotPrices: adEngineBidders.bidders.getDfpSlotPrices,
		getName: getName,
		getPrebid: adEngineBidders.bidders.prebidHelper.getPrebid,
		getWinningVideoBidBySlotName: adEngineBidders.bidders.prebidHelper.getWinningVideoBidBySlotName,
		isEnabled: isEnabled,
		runBidding: runBidding,
		updateSlotTargeting: adEngineBidders.bidders.updateSlotTargeting,
		wasCalled: isEnabled
	};
});
