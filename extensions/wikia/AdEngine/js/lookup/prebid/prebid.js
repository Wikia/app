/*global define*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker',
	'ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker',
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.lookup.prebid.prebidHelper',
	'ext.wikia.adEngine.lookup.prebid.prebidSettings',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.window'
], function (
	performanceTracker,
	pricesTracker,
	adaptersRegistry,
	helper,
	settings,
	factory,
	win
) {
	'use strict';
	var adUnits = [],
		biddersPerformanceMap = {},
		prebidLoaded = false;

	function removeAdUnits() {
		(win.pbjs.adUnits || []).forEach(function (adUnit) {
			win.pbjs.removeAdUnit(adUnit.code);
		});
	}

	function call(skin, onResponse) {
		if (!prebidLoaded) {
			adaptersRegistry.setupCustomAdapters();
			adaptersRegistry.registerAliases();
		}

		biddersPerformanceMap = performanceTracker.setupPerformanceMap(skin);
		adUnits = helper.setupAdUnits(skin);

		if (win.pbjs) {
			win.pbjs._bidsReceived = [];
		}

		if (adUnits.length > 0) {

			if (!prebidLoaded) {
				win.pbjs.que.push(function () {
					win.pbjs.bidderSettings = settings.create();
				});
			}

			win.pbjs.que.push(function () {
				removeAdUnits();
				win.pbjs.requestBids({
					adUnits: adUnits,
					bidsBackHandler: onResponse
				});
			});
		}

		prebidLoaded = true;
	}

	function calculatePrices() {
		biddersPerformanceMap = performanceTracker.updatePerformanceMap(biddersPerformanceMap);
	}

	function trackAdaptersOnLookupEnd() {
		var adapters = adaptersRegistry.getAdapters();

		biddersPerformanceMap = performanceTracker.updatePerformanceMap(biddersPerformanceMap);

		adapters.forEach(function (adapter) {
			performanceTracker.trackBidderOnLookupEnd(adapter, biddersPerformanceMap);
		});
	}

	function trackAdaptersSlotState(providerName, slotName) {
		var adapters = adaptersRegistry.getAdapters();

		biddersPerformanceMap = performanceTracker.updatePerformanceMap(biddersPerformanceMap);

		adapters.forEach(function (adapter) {
			performanceTracker.trackBidderSlotState(adapter, slotName, providerName, biddersPerformanceMap);
		});
	}

	function isSlotSupported(slotName) {
		return adUnits.some(function (adUnit) {
			return adUnit.code === slotName;
		});
	}

	function getSlotParams(slotName) {
		var slotParams;

		if (win.pbjs && typeof win.pbjs.getBidResponses === 'function') {
			var params = win.pbjs.getBidResponses(slotName) || {};

			if (params && params[slotName] && params[slotName].bids && params[slotName].bids.length) {
				var bidParams,
					priorities = adaptersRegistry.getPriorities();

				params[slotName].bids.forEach(function (param) {
					if (!bidParams) {
						bidParams = param;
					} else {
						if (bidParams.cpm === param.cpm) {
							if (priorities[bidParams.bidder] === priorities[param.bidder]) {
								bidParams = bidParams.timeToRespond > param.timeToRespond ? param : bidParams;
							} else {
								bidParams = priorities[bidParams.bidder] < priorities[param.bidder] ? param : bidParams;
							}
						} else {
							bidParams = bidParams.cpm < param.cpm ? param : bidParams;
						}
					}
				});

				slotParams = bidParams.adserverTargeting;
			}
		}

		return slotParams || {};
	}

	function getBestSlotPrice(slotName) {
		return pricesTracker.getSlotBestPrice(slotName);
	}

	return factory.create({
		logGroup: 'ext.wikia.adEngine.lookup.prebid',
		name: 'prebid',
		call: call,
		calculatePrices: calculatePrices,
		isSlotSupported: isSlotSupported,
		getSlotParams: getSlotParams,
		getBestSlotPrice: getBestSlotPrice,
		trackAdaptersOnLookupEnd: trackAdaptersOnLookupEnd,
		trackAdaptersSlotState: trackAdaptersSlotState
	});
});
