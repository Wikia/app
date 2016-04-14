/*global define, require*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.adapter.appnexus')
], function (factory, win, appnexus) {
	'use strict';

	var adapters = [
			appnexus
		],
		adUnits = [],
		priceMap = {},
		bidderKey = 'hb_bidder',
		bidKey = 'hb_pb',
		sizeKey = 'hb_size';

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			adUnits.push(adUnit);
		});
	}

	function setupAdUnits(skin) {
		adapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				addAdUnits(adapter.getAdUnits(skin));
			}
		});
	}

	function call(skin, onResponse) {
		setupAdUnits(skin);

		win.pbjs.que.push(function () {
			win.pbjs.addAdUnits(adUnits);

			win.pbjs.requestBids({
				bidsBackHandler: onResponse
			});
		});
	}

	function encodeParamsForTracking(params) {
		if (params[bidderKey] && params[sizeKey] && params[bidKey]) {
			return [params[bidderKey], params[sizeKey], params[bidKey]].join(';');
		}

		return '';
	}

	function calculatePrices() {
		var slotName,
			slots = {};
		if (win.pbjs && typeof win.pbjs.getAdserverTargeting === 'function') {
			slots = win.pbjs.getAdserverTargeting();
		}

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				priceMap[slotName] = encodeParamsForTracking(slots[slotName]);
			}
		}
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
		var params = {};
		if (win.pbjs && typeof win.pbjs.getAdserverTargetingForAdUnitCode === 'function') {
			params = win.pbjs.getAdserverTargetingForAdUnitCode(slotName) || {};
		}

		return params;
	}

	return factory.create({
		logGroup: 'ext.wikia.adEngine.lookup.prebid',
		name: 'prebid',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
