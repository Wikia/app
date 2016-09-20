/*global define*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',
	'ext.wikia.adEngine.lookup.prebid.prebidHelper',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.window'
], function (adContext, adTracker, appnexus, index, helper, factory, doc, win) {
	'use strict';

	var adapters = [
			appnexus,
			index
		],
		adUnits = [],
		biddersPerformance = {},
		priceMap = {},
		bidKey = 'hb_pb',
		sizeKey = 'hb_size';

	function call(skin, onResponse) {
		var prebid = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		adUnits = helper.setupAdUnits(adapters, skin);

		if (adUnits.length > 0) {
			win.pbjs = win.pbjs || {};
			win.pbjs.que = win.pbjs.que || [];

			prebid.async = true;
			prebid.type = 'text/javascript';
			prebid.src = adContext.getContext().opts.prebidBidderUrl || '//acdn.adnxs.com/prebid/prebid.js';

			node.parentNode.insertBefore(prebid, node);

			win.pbjs.que.push(function () {

				win.pbjs.addAdUnits(adUnits);

				win.pbjs.requestBids({
					bidsBackHandler: onResponse
				});
			});
		}
	}

	function updateBiddersPerformance() {
		var allBids;

		if (typeof win.pbjs.getBidResponses === 'function') {
			allBids = win.pbjs.getBidResponses();

			Object.keys(allBids).forEach(function (slotName) {
				var slotBids = allBids[slotName].bids;

				slotBids.forEach(function (bid) {
					biddersPerformance[bid.bidder] = biddersPerformance[bid.bidder] || {};
					biddersPerformance[bid.bidder][slotName] = encodeParamsForTracking({
						hb_bidder: bid.bidder,
						hb_pb: (bid.getStatusCode() === 2 || !bid.pbMg) ? 'NONE' : bid.pbMg,
						hb_size: bid.getSize()
					});
				});
			});
		}
	}

	function encodeParamsForTracking(params) {
		if (params[sizeKey] && params[bidKey]) {
			return [params[sizeKey], params[bidKey]].join(';');
		}

		return '';
	}

	function calculatePrices(allBids) {
		var slotName,
			slots = {};

		updateBiddersPerformance(allBids);

		if (win.pbjs && typeof win.pbjs.getAdserverTargeting === 'function') {
			slots = win.pbjs.getAdserverTargeting();
		}

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName) && Object.keys(slots[slotName]).length !== 0) {
				priceMap[slotName] = encodeParamsForTracking(slots[slotName]);
			}
		}
	}

	function trackOnLookupEnd() {
		Object.keys(biddersPerformance).forEach(function (bidder) {
			adTracker.track(bidder + '/lookup_end', biddersPerformance[bidder], 0, 'nodata');
		});
	}

	function trackSlotState(providerName, slotName) {
		var category;

		updateBiddersPerformance();

		adapters.forEach(function (adapter) {
			var bidderName = adapter.getName();

			if (adapter.isEnabled()) {
				if (biddersPerformance[bidderName]) {
					if (biddersPerformance[bidderName][slotName]) {
						category = bidderName + '/lookup_success/' + providerName;
						adTracker.track(category, slotName, 0, biddersPerformance[bidderName][slotName]);
					} else {
						category = bidderName + '/lookup_error/' + providerName;
						adTracker.track(category, slotName, 0, 'nodata');
					}
				} else {
					category = bidderName + '/lookup_error/' + providerName;
					adTracker.track(category, slotName, 0, 'nodata');
				}
			}
		});
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return adUnits.some(function (adUnit) {
			return adUnit.code === slotName;
		});
	}

	function getSlotParams(slotName) {
		var params;

		if (win.pbjs && typeof win.pbjs.getAdserverTargetingForAdUnitCode === 'function') {
			params = win.pbjs.getAdserverTargetingForAdUnitCode(slotName) || {};
		}

		return params || {};
	}

	return factory.create({
		logGroup: 'ext.wikia.adEngine.lookup.prebid',
		name: 'prebid',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams,
		trackOnLookupEnd: trackOnLookupEnd,
		trackSlotState: trackSlotState
	});
});
