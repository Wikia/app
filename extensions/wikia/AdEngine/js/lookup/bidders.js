/*global define*/
define('ext.wikia.adEngine.lookup.bidders', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bidders',
	'wikia.lazyqueue',
	'wikia.log'
], function (adContext, adEngineBidders, lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.bidders',
		biddingCompleted = false,
		onResponseCallbacks = [];

	function getName() {
		return 'bidders';
	}

	function isEnabled() {
		return adContext.get('bidders.prebid') && adContext.get('opts.showAds');
	}

	function addResponseListener(callback) {
		onResponseCallbacks.push(callback);
	}

	function markAsReady() {
		if (!biddingCompleted && adEngineBidders.bidders.hasAllResponses()) {
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

		adEngineBidders.bidders.requestBids({
			responseListener: markAsReady
		});
	}

	resetState();

	return {
		addResponseListener: addResponseListener,
		getBidByAdId: adEngineBidders.bidders.prebidHelper.getBidByAdId,
		getBidParameters: adEngineBidders.bidders.getBidParameters,
		getCurrentSlotPrices: adEngineBidders.bidders.getCurrentSlotPrices,
		getDfpSlotPrices: adEngineBidders.bidders.getDfpSlotPrices,
		getName: getName,
		getPrebid: adEngineBidders.bidders.prebidHelper.getPrebid,
		getWinningVideoBidBySlotName: adEngineBidders.bidders.prebidHelper.getWinningVideoBidBySlotName,
		isEnabled: isEnabled,
		runBidding: runBidding,
		transformPriceFromBid: adEngineBidders.bidders.transformPriceFromBid,
		updateSlotTargeting: adEngineBidders.bidders.updateSlotTargeting,
		wasCalled: isEnabled
	};
});
