/*global define*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',
	'ext.wikia.adEngine.lookup.prebid.adapters.wikia',
	'ext.wikia.adEngine.lookup.prebid.prebidHelper',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (adContext, adaptersTracker, appnexus, index, wikiaAdapter, helper, factory, doc, win, mercuryListener) {
	'use strict';

	var adapters = [
			appnexus,
			index
		],
		adUnits = [],
		biddersPerformanceMap = {},
		autoPriceGranularity = 'auto',
		prebidLoaded = false;

	function call(skin, onResponse) {
		var prebid, node;

		biddersPerformanceMap = adaptersTracker.setupPerformanceMap(skin, adapters);
		adUnits = helper.setupAdUnits(adapters, skin);

		if (!prebidLoaded) {
			prebid = doc.createElement('script');
			node = doc.getElementsByTagName('script')[0];

			if (wikiaAdapter.isEnabled()) {
				adapters.push(wikiaAdapter);
				win.pbjs.que.push(function () {
					win.pbjs.registerBidAdapter(wikiaAdapter.create, 'wikia');
				});
			}

			prebid.async = true;
			prebid.type = 'text/javascript';
			prebid.src = adContext.getContext().opts.prebidBidderUrl || '//acdn.adnxs.com/prebid/prebid.js';
			node.parentNode.insertBefore(prebid, node);
		}

		if (adUnits.length > 0) {
			if (!prebidLoaded) {
				win.pbjs.que.push(function () {
					win.pbjs.setPriceGranularity(autoPriceGranularity);
					win.pbjs.addAdUnits(adUnits);
				});
			}

			win.pbjs.que.push(function() {
				console.log('bogna', 'requesting bids');
				win.pbjs.requestBids({
					bidsBackHandler: onResponse
				});
			});
		}

		prebidLoaded = true;
	}

	function calculatePrices() {
		biddersPerformanceMap = adaptersTracker.updatePerformanceMap(biddersPerformanceMap);
	}

	function trackAdaptersOnLookupEnd() {
		biddersPerformanceMap = adaptersTracker.updatePerformanceMap(biddersPerformanceMap);

		adapters.forEach(function (adapter) {
			adaptersTracker.trackBidderOnLookupEnd(adapter, biddersPerformanceMap);
		});
	}

	function trackAdaptersSlotState(providerName, slotName) {
		biddersPerformanceMap = adaptersTracker.updatePerformanceMap(biddersPerformanceMap);

		adapters.forEach(function (adapter) {
			adaptersTracker.trackBidderSlotState(adapter, slotName, providerName, biddersPerformanceMap);
		});
	}

	function isSlotSupported(slotName) {
		return adUnits.some(function (adUnit) {
			return adUnit.code === slotName;
		});
	}

	function getSlotParams(slotName) {
		var bidResponses,
			params,
			winner;

		if (win.pbjs && typeof win.pbjs.getAdserverTargetingForAdUnitCode === 'function') {
			params = win.pbjs.getAdserverTargetingForAdUnitCode(slotName) || {};

			if (params.hb_adid) {
				bidResponses = win.pbjs.getBidResponsesForAdUnitCode(slotName);
				winner = bidResponses.bids.find(function (bid) {
					return bid.adId === params.hb_adid;
				});

				if (winner && winner.complete) {
					return {};
				}
			}

		}

		return params || {};
	}

	return factory.create({
		logGroup: 'ext.wikia.adEngine.lookup.prebid',
		name: 'prebid',
		call: call,
		calculatePrices: calculatePrices,
		isSlotSupported: isSlotSupported,
		getSlotParams: getSlotParams,
		trackAdaptersOnLookupEnd: trackAdaptersOnLookupEnd,
		trackAdaptersSlotState: trackAdaptersSlotState
	});
});
