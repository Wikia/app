/*global define*/
define('ext.wikia.adEngine.lookup.prebid', [
	'ext.wikia.adEngine.lookup.adapter.appnexus',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.window'
], function (appnexus, factory, doc, win) {
	'use strict';

	var adapters = [
			appnexus
		],
		adUnits = [],
		priceMap = {},
		bidderKey = 'hb_bidder',
		bidKey = 'hb_pb',
		sizeKey = 'hb_size',
		url = '//acdn.adnxs.com/prebid/prebid.js';

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
		var prebid = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		setupAdUnits(skin);

		if (adUnits.length > 0) {
			win.pbjs = win.pbjs || {};
			win.pbjs.que = win.pbjs.que || [];

			prebid.async = true;
			prebid.type = 'text/javascript';
			prebid.src = url;

			node.parentNode.insertBefore(prebid, node);

			win.pbjs.que.push(function () {
				win.pbjs.addAdUnits(adUnits);

				win.pbjs.requestBids({
					bidsBackHandler: onResponse
				});
			});
		}
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
		getSlotParams: getSlotParams
	});
});
