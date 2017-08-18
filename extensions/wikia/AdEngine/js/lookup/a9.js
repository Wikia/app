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

		console.log(getA9Slots(slots));

		win.apstag.fetchBids({
			slots: getA9Slots(slots),
			timeout: 2000
		}, function(bids) {
			console.log(bids);
		});
	}

	function getA9Slots(slots) {
		var a9Slots = [];

		Object.keys(slots).forEach(function(slotName) {
			a9Slots.push({
				slotId: slotName,
				sizes: slots[slotName]
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
	}

	function encodeParamsForTracking(params) {
	}

	function getSlotParams(slotName) {
	}

	function getPrices() {
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
