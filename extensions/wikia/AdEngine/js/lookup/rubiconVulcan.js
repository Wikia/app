/*global define*/
define('ext.wikia.adEngine.lookup.rubiconVulcan', [
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (factory, doc, log, win) {
	'use strict';

	var accountId = 7780,
		config = {
			oasis: {
				INCONTENT_BOXAD_1: {
					size: [640, 480],
					siteId: 85282,
					zoneId: 404144
				}
			},
			mercury: {}
		},
		libraryUrl = '//ads.aws.rubiconproject.com/video/vulcan.min.js',
		logGroup = 'ext.wikia.adEngine.lookup.rubiconVulcan',
		priceMap = {},
		sizeMap = {
			'480x320': 101,
			'640x480': 201
		},
		slots = {},
		vulcanCpmKey = 'cpm',
		vulcanUrlKey = 'depot_url';

	function defineSingleSlot(slotName, slot) {
		var size = slot.size[0] + 'x' + slot.size[1],
			slotDefinition = {
				'accountId': accountId,
				'site_id': slot.siteId,
				'size_id': sizeMap[size],
				'zone_id': slot.zoneId,
				'width': slot.size[0],
				'height': slot.size[1],
				'rand': Math.round(1000000000 * Math.random()),
				'key1': 'value1'
			};

		log(['defineSlot', slotName, slotDefinition], 'debug', logGroup);
		win.rubicontag.video.defineSlot(slotName, slotDefinition);
	}

	function defineSlots(onResponse) {
		Object.keys(slots).forEach(function (slotName) {
			defineSingleSlot(slotName, slots[slotName]);
		});

		win.rubicontag.video.run(onResponse);
	}

	function getSlotParams(slotName) {
		// TODO: implement me
		var parameters = {};

		log(['getSlotParams', slotName, parameters], 'debug', logGroup);
		return parameters;
	}

	function encodeParamsForTracking(params) {
		// TODO: implement me
		return '';
	}

	function calculatePrices() {
		var allSlots = win.rubicontag.video.getAllSlots();

		allSlots.forEach(function (slot) {
			var ad = slot.getBestCpm(),
				slotName = slot.id,

				cpm,
				vastUrl;

			log(['onResponse', slotName, ad.status, ad], 'debug', logGroup);
			if (ad.status === 'ok' && ad.type === 'vast') {
				cpm = ad[vulcanCpmKey];
				vastUrl = ad[vulcanUrlKey];

				log(['VAST ad', slotName, cpm, vastUrl], 'debug', logGroup);
				// TODO: implement me - add cpm and ad_id to priceMap/targeting
			}
		});
	}

	function call(skin, onResponse) {
		var vulcan = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		vulcan.type = 'text/javascript';
		vulcan.src = libraryUrl;

		slots = config[skin];
		vulcan.addEventListener('load', function () {
			defineSlots(onResponse);
		});

		node.parentNode.insertBefore(vulcan, node);
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return !!slots[slotName];
	}

	return factory.create({
		logGroup: logGroup,
		name: 'rubicon_vulcan',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});
});
