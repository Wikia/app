/*global define*/
define('ext.wikia.adEngine.lookup.bidders', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bridge',
	'wikia.lazyqueue',
	'wikia.log'
], function (adContext, adEngineBridge, lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.bidders',
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

	function markAsReady() {
		if (!biddingCompleted && adEngineBridge.bidders.hasAllResponses()) {
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

	function runBidding() {
		log('A9 and Prebid bidding started:', 'debug', logGroup);

		adEngineBridge.bidders.requestBids({
			responseListener: markAsReady
		});
	}

	resetState();

	return {
		addResponseListener: addResponseListener,
		getBidByAdId: adEngineBridge.bidders.prebidHelper.getBidByAdId,
		getCurrentSlotPrices: adEngineBridge.bidders.getCurrentSlotPrices,
		getDfpSlotPrices: adEngineBridge.bidders.getDfpSlotPrices,
		getName: getName,
		getPrebid: adEngineBridge.bidders.prebidHelper.getPrebid,
		getWinningVideoBidBySlotName: adEngineBridge.bidders.prebidHelper.getWinningVideoBidBySlotName,
		isEnabled: isEnabled,
		runBidding: runBidding,
		updateSlotTargeting: adEngineBridge.bidders.updateSlotTargeting,
		wasCalled: isEnabled
	};
});
