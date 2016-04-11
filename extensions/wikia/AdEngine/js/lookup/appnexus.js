/*global define, window*/
define('ext.wikia.adEngine.lookup.appnexus', [
	'ext.wikia.adEngine.lookup.lookupFactory'
], function (factory) {
	'use strict';

	var placementId = '123',
		slots = {
			TOP_LEADERBOARD: [
				[728, 90]
			]
		};

	function getAdUnits() {
		var adUnits = [],
			slotName;

		for (slotName in slots) {
			if (slots.hasOwnProperty(slotName)) {
				adUnits.push({
					code: slotName,
					sizes: slots[slotName],
					bids: [
						{
							bidder: 'appnexus',
							placementId: placementId
						}
					]
				});
			}
		}
		console.log(JSON.stringify(adUnits));

		return adUnits;
	}

	function call(skin, onResponse) {
		window.pbjs.que.push(function () {
			var adUnits = getAdUnits();

			window.pbjs.addAdUnits(adUnits);
			window.pbjs.requestBids({
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
		return !!slots[slotName];
	}

	function getSlotParams(slotName) {
		// TODO
		return {};
	}

	return factory.create({
		logGroup: 'ext.wikia.adEngine.lookup.aok,ppnexus',
		name: 'appnexus',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
