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
		adUnits = [];

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

	function calculatePrices() {
		// TODO
	}

	function getPrices() {
		// TODO
		return {};
	}

	function encodeParamsForTracking(params) {
		// TODO
		return '';
	}

	function isSlotSupported(slotName) {
		return adapters.some(function (adapter) {
			return adapter && adapter.isEnabled() && adapters.isSlotSupported(slotName);
		});
	}

	function getSlotParams(slotName) {
		// TODO
		return {};
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
