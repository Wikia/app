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
				placeholderName: 'outstream-desktop',
				siteId: 55412,
				size: [640, 480],
				sizeId: 203,
				targeting: {
					loc: 'top'
				},
				zoneId: 519058
			},
			mercury: {
				placeholderName: 'outstream-mobile',
				siteId: 55412,
				size: [640, 480],
				sizeId: 203,
				targeting: {
					loc: 'hivi'
				},
				zoneId: 563110
			}
		},
		libraryUrl = '//ads.aws.rubiconproject.com/video/vulcan.min.js',
		logGroup = 'ext.wikia.adEngine.lookup.rubicon.rubiconVulcan',
		placeholder = {},
		priceMap = {},
		rubiconVideoTierKey = 'rpfl_video',
		slotMapping = {
			'INCONTENT_LEADERBOARD': 'outstream-desktop',
			'INCONTENT_PLAYER': 'outstream-desktop',
			'TOP_LEADERBOARD': 'outstream-desktop',
			'MOBILE_IN_CONTENT': 'outstream-mobile'
		},
		vulcanCpmKey = 'cpm',
		vulcanUrlKey = 'depot_url';

	function setupTargeting(skin) {
		var targeting = rubiconTargeting.getTargeting(placeholder.placeholderName, skin, 'vulcan');

		Object.keys(targeting).forEach(function (key) {
			placeholder.targeting[key] = targeting[key];
		});
	}

	function defineSingleSlot() {
		var vulcanSlotDefinition = {
				'account_id': accountId,
				'site_id': placeholder.siteId,
				'size_id': placeholder.sizeId,
				'zone_id': placeholder.zoneId,
				'width': placeholder.size[0],
				'height': placeholder.size[1],
				'rand': Math.round(1000000000 * Math.random())
			};

		Object.keys(placeholder.targeting).forEach(function (key) {
			vulcanSlotDefinition['tg_i.' + key] = placeholder.targeting[key];
		});

		log(['defineSlot', placeholder.placeholderName, vulcanSlotDefinition], 'debug', logGroup);
		win.rubiconVulcan.defineSlot(placeholder.placeholderName, vulcanSlotDefinition);
	}

	function defineSlots(skin, onResponse) {
		setupTargeting(skin);
		defineSingleSlot();

		win.rubiconVulcan.run(onResponse);
	}

	function getSlotParams(slotName) {
		var parameters = {};

		slotName = slotMapping[slotName] || slotName;
		parameters[rubiconVideoTierKey] = placeholder.sizeId + '_tierNONE';

		log(['getSlotParams', slotName, parameters], 'debug', logGroup);
		if (priceMap[slotName]) {
			parameters[rubiconVideoTierKey] = priceMap[slotName];
		}

		return parameters;
	}

	function getBestSlotPrice(slotName) {
		var cpm,
			price;

		slotName = slotMapping[slotName] || slotName;

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

		slotName = slotMapping[slotName] || slotName;

		allSlots.forEach(function (slot) {
			if (slot.id === slotName) {
				bestResponse = slot.getBestCpm();
			}
		});

		return bestResponse;
	}

	function deleteBid(slotName) {
		var response;

		slotName = slotMapping[slotName] || slotName;
		response = getSingleResponse(slotName);
		response.used = true;

		delete priceMap[slotName];
	}

	function encodeParamsForTracking(params) {
		if (!params[rubiconVideoTierKey]) {
			return;
		}

		return params[rubiconVideoTierKey];
	}

	function calculatePrices() {
		var allSlots = win.rubiconVulcan.getAllSlots();

		allSlots.forEach(function (vulcanSlot) {
			var ad = vulcanSlot.getBestCpm(),
				slotName = vulcanSlot.id,
				sizeId = vulcanSlot.sizeId,
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
				priceMap[slotName] = placeholder.sizeId + '_tier0000';
			}
		});
	}

	function call(skin, onResponse) {
		var script = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		script.type = 'text/javascript';
		script.src = libraryUrl;

		placeholder = config[skin];
		script.addEventListener('load', function () {
			// TODO ADEN-4637 Remove win.rubiconVulcan reference
			win.rubiconVulcan = win.rubicontag.video;
			win.ads.rubiconVulcan = {
				getSingleResponse: getSingleResponse,
				deleteBid: deleteBid
			};
			defineSlots(skin, onResponse);
		});

		node.parentNode.insertBefore(script, node);
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slotMapping[slotName];
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
