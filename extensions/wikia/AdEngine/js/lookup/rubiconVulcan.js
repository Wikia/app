/*global define*/
define('ext.wikia.adEngine.lookup.rubiconVulcan', [
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.lookup.rubiconTargeting',
	'ext.wikia.adEngine.utils.math',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (factory, rubiconTargeting, math, doc, log, win) {
	'use strict';

	var accountId = 7450,
		config = {
			oasis: {
				INCONTENT_LEADERBOARD: {
					siteId: 55412,
					size: [640, 480],
					sizeId: 203,
					targeting: {
						loc: 'hivi'
					},
					zoneId: 260296
				}
			},
			mercury: {
			}
		},
		cpmBuckets = [
			{
				maxValue: 4,
				bucket: 1
			},
			{
				maxValue: 99,
				bucket: 5
			},
			{
				maxValue: 499,
				bucket: 10
			},
			{
				maxValue: 1999,
				bucket: 50
			}
		],
		libraryUrl = '//ads.aws.rubiconproject.com/video/vulcan.min.js',
		logGroup = 'ext.wikia.adEngine.lookup.rubiconVulcan',
		priceMap = {},
		rubiconVideoTierKey = 'rpfl_video',
		slots = {},
		vulcanCpmKey = 'cpm',
		vulcanUrlKey = 'depot_url';

	function setupTargeting(slotName, slot, skin) {
		var targeting = rubiconTargeting.getTargeting(slotName, skin, 'vulcan');

		Object.keys(targeting).forEach(function (key) {
			slot.targeting[key] = targeting[key];
		});
	}

	function defineSingleSlot(slotName, slot) {
		var slotDefinition = {
				'account_id': accountId,
				'site_id': slot.siteId,
				'size_id': slot.sizeId,
				'zone_id': slot.zoneId,
				'width': slot.size[0],
				'height': slot.size[1],
				'rand': Math.round(1000000000 * Math.random())
			};

		Object.keys(slot.targeting).forEach(function (key) {
			slotDefinition['tg_i.' + key] = slot.targeting[key];
		});

		log(['defineSlot', slotName, slotDefinition], 'debug', logGroup);
		win.rubiconVulcan.defineSlot(slotName, slotDefinition);
	}

	function defineSlots(skin, onResponse) {
		Object.keys(slots).forEach(function (slotName) {
			setupTargeting(slotName, slots[slotName], skin);
			defineSingleSlot(slotName, slots[slotName]);
		});

		win.rubiconVulcan.run(onResponse);
	}

	function getTier(slotName, cpm) {
		var index = 0,
			sizeId = slots[slotName].sizeId,
			tier = 2000;

		while (cpmBuckets[index] && cpm > cpmBuckets[index].maxValue) {
			index += 1;
		}
		if (cpmBuckets[index]) {
			tier = math.getBucket(cpm, cpmBuckets[index].bucket);
		}
		tier = parseInt(tier, 10);

		return sizeId + '_tier' + math.leftPad(tier, 4);
	}

	function getSlotParams(slotName) {
		var parameters = {};

		log(['getSlotParams', slotName, parameters], 'debug', logGroup);
		if (priceMap[slotName]) {
			parameters[rubiconVideoTierKey] = priceMap[slotName];
		}

		return parameters;
	}

	function encodeParamsForTracking(params) {
		if (!params[rubiconVideoTierKey]) {
			return;
		}

		return params[rubiconVideoTierKey];
	}

	function calculatePrices() {
		var allSlots = win.rubiconVulcan.getAllSlots();

		allSlots.forEach(function (slot) {
			var ad = slot.getBestCpm(),
				slotName = slot.id,

				cpm,
				tier,
				vastUrl;

			log(['onResponse', slotName, ad.status, ad], 'debug', logGroup);
			if (ad.status === 'ok' && ad.type === 'vast') {
				cpm = ad[vulcanCpmKey] || 0;
				tier = getTier(slotName, cpm * 100);
				vastUrl = ad[vulcanUrlKey];

				log(['VAST ad', slotName, cpm, tier, vastUrl], 'debug', logGroup);
				priceMap[slotName] = tier;
			}
		});
	}

	function call(skin, onResponse) {
		var script = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		script.type = 'text/javascript';
		script.src = libraryUrl;

		slots = config[skin];
		script.addEventListener('load', function () {
			win.rubiconVulcan = win.rubicontag.video;
			defineSlots(skin, onResponse);
		});

		node.parentNode.insertBefore(script, node);
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
