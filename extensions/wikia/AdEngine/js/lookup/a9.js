/*global define*/
define('ext.wikia.adEngine.lookup.a9', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, slotsContext, factory, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.a9',
		config = {
			oasis: {
				BOTTOM_LEADERBOARD: [[728, 90], [970, 250]],
				INCONTENT_BOXAD_1: [[300, 250], [300, 600]],
				TOP_LEADERBOARD: [[728, 90], [970, 250]],
				TOP_RIGHT_BOXAD: [[300, 250], [300, 600]]
			},
			mercury: {
				MOBILE_IN_CONTENT: [[300, 250], [320, 480]],
				MOBILE_PREFOOTER: [[320, 50], [300, 250]],
				MOBILE_TOP_LEADERBOARD: [[320, 50]]
			}
		},
		amazonId = '3115',
		bids = {},
		priceMap = {},
		slots = [];

	function call(skin, onResponse) {
		var a9Script = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		slots = slotsContext.filterSlotMap(config[skin]);

		a9Script.type = 'text/javascript';
		a9Script.async = true;
		a9Script.src = '//c.amazon-adsystem.com/aax2/apstag.js';

		node.parentNode.insertBefore(a9Script, node);

		configureApstag();

		win.apstag.init({
			pubID: amazonId
		});

		// TODO remove debugging
		console.log(getA9Slots(slots));

		win.apstag.fetchBids({
			slots: getA9Slots(slots),
			timeout: 2000
		}, function(currentBids) {
			// TODO remove debugging
			console.log(currentBids);

			currentBids.forEach(function (bid) {
				bids[bid.slotId] = bid;
			});

			onResponse();
		});
	}

	function getA9Slots(slots) {
		var a9Slots = [];

		Object.keys(slots).forEach(function(slotName) {
			a9Slots.push({
				sizes: slots[slotName],
				slotId: slotName,
				slotName: slotName
			});
		});

		return a9Slots;
	}

	function configureApstagCommand(command, args) {
		win.apstag._Q.push([command, args]);
	}

	function configureApstag() {
		win.apstag = {
			init: function() {
				configureApstagCommand('i', arguments);
			},
			fetchBids: function() {
				configureApstagCommand('f', arguments);
			},
			_Q: []
		};
	}

	function calculatePrices() {
		Object.keys(bids).forEach(function(slotName) {
			// TODO convert bidId into $
			priceMap[slotName] = bids[slotName].amznbid;
		});
	}

	function encodeParamsForTracking(params) {
		return params.amznsz + ';' + params.amznbid;
	}

	function getSlotParams(slotName) {
		var bid = bids[slotName];

		if (!bid) {
			return {};
		}

		return {
			amznbid: bid.amznbid,
			amzniid: bid.amzniid,
			amznsz: bid.amznsz
		};
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'a9',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
