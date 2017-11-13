/*global define*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker',
	'ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker',
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.lookup.prebid.prebidHelper',
	'ext.wikia.adEngine.lookup.prebid.prebidSettings',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.window'
], function (
	adContext,
	performanceTracker,
	pricesTracker,
	adaptersRegistry,
	helper,
	settings,
	factory,
	doc,
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
		var prebid, node;

		if (!prebidLoaded) {
			prebid = doc.createElement('script');
			node = doc.getElementsByTagName('script')[0];

			adaptersRegistry.setupCustomAdapters();
			adaptersRegistry.registerAliases();

			prebid.async = true;
			prebid.type = 'text/javascript';
			prebid.src = adContext.getContext().opts.prebidBidderUrl || '//acdn.adnxs.com/prebid/prebid.js';
			node.parentNode.insertBefore(prebid, node);
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
		var params;

		if (win.pbjs && typeof win.pbjs.getAdserverTargetingForAdUnitCode === 'function') {
			params = win.pbjs.getAdserverTargetingForAdUnitCode(slotName) || {};
		}

		return params || {};
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
