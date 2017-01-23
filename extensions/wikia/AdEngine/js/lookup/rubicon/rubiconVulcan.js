/*global define*/
define('ext.wikia.adEngine.lookup.rubicon.rubiconVulcan', [
	'ext.wikia.adEngine.lookup.lookupFactory',
	'ext.wikia.adEngine.lookup.rubicon.rubiconTargeting',
	'ext.wikia.adEngine.lookup.rubicon.rubiconTier',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (factory, rubiconTargeting, rubiconTier, doc, log, win) {
	'use strict';

	var accountId = 7450,
		bidder,
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
				},
				TOP_LEADERBOARD: {
					siteId: 55412,
					size: [640, 480],
					sizeId: 203,
					targeting: {
						loc: 'top'
					},
					zoneId: 519058
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					siteId: 55412,
					size: [640, 480],
					sizeId: 203,
					targeting: {
						loc: 'hivi'
					},
					zoneId: 563110
				}
			}
		},
		libraryUrl = '//ads.aws.rubiconproject.com/video/vulcan.min.js',
		logGroup = 'ext.wikia.adEngine.lookup.rubicon.rubiconVulcan',
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

	function getSlotParams(slotName) {
		var parameters = {};

		parameters[rubiconVideoTierKey] = slots[slotName].sizeId + '_tierNONE';

		log(['getSlotParams', slotName, parameters], 'debug', logGroup);
		if (priceMap[slotName]) {
			parameters[rubiconVideoTierKey] = priceMap[slotName];
		}

		return parameters;
	}

	function getBestSlotPrice(slotName) {
		var cpm,
			price;

		if (priceMap[slotName]) {
			cpm = rubiconTier.parseOpenMarketPrice(priceMap[slotName]) / 100;
			price = cpm.toFixed(2).toString();
		}

		return {
			vulcan: price
		};
	}

	function getSingleResponse(slotName) {
		var bestResponse = {},
			allSlots = win.rubiconVulcan.getAllSlots() || [];

		allSlots.forEach(function (slot) {
			if (slot.id === slotName) {
				bestResponse = slot.getBestCpm();
			}
		});

		return bestResponse;
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
				sizeId = slots[slotName].sizeId,
				cpm,
				tier,
				vastUrl;

			log(['onResponse', slotName, ad.status, ad], 'debug', logGroup);
			if (ad.status === 'ok' && ad.type === 'vast') {
				cpm = ad[vulcanCpmKey] || 0;
				tier = rubiconTier.create(sizeId, cpm * 100);
				vastUrl = ad[vulcanUrlKey];

				log(['VAST ad', slotName, cpm, tier, vastUrl], 'debug', logGroup);
				priceMap[slotName] = tier;
			} else {
				priceMap[slotName] = slots[slotName].sizeId + '_tier0000';
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

	bidder = factory.create({
		logGroup: logGroup,
		name: 'rubicon_vulcan',
		call: call,
		calculatePrices: calculatePrices,
		getBestSlotPrice: getBestSlotPrice,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams
	});

	bidder.getSingleResponse = getSingleResponse;

	return bidder;
});
