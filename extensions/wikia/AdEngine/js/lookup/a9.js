/*global define*/
define('ext.wikia.adEngine.lookup.a9', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.lookup.lookupFactory',
	'wikia.document',
	'wikia.log',
	'wikia.trackingOptIn',
	'wikia.window'
], function (adContext, slotsContext, factory, doc, log, trackingOptIn, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.a9',
		config = {
			oasis: {
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				},
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				},
				FEATURED: {
					type: 'video'
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250]
					]
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[320, 50],
						[300, 250]
					]
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					]
				},
				FEATURED: {
					type: 'video'
				}
			}
		},
		amazonId = '3115',
		bids = {},
		loaded = false,
		priceMap = {},
		slots = {};

	function insertScript() {
		var a9Script = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		a9Script.type = 'text/javascript';
		a9Script.async = true;
		a9Script.src = '//c.amazon-adsystem.com/aax2/apstag.js';

		node.parentNode.insertBefore(a9Script, node);
	}

	function isVideoBidderEnabled() {
		return adContext.get('bidders.a9Video') && adContext.get('targeting.hasFeaturedVideo');
	}

	function call(skin, onResponse) {
		function init(optIn, consentData) {
			var apsConfig = {
				pubID: amazonId,
				videoAdServer: 'DFP',
				deals: !!adContext.get('bidders.a9Deals')
			};

			log('User opt-' + (optIn ? 'in' : 'out') + ' for A9', log.levels.info, logGroup);

			// Cleanup in ADEN-7500
			if (!optIn && !adContext.get('bidders.a9OptOut')) {
				return;
			}

			if (consentData) {
				apsConfig.gdpr = {
					enabled: consentData.gdprApplies,
					consent: consentData.consentData,
					cmpTimeout: 5000
				};
			}

			if (!loaded) {
				log(['call - load', skin], 'debug', logGroup);

				insertScript();
				configureApstag();

				win.apstag.init(apsConfig);

				loaded = true;
			}

			bids = {};
			priceMap = {};

			slots = slotsContext.filterSlotMap(config[skin]);

			var a9Slots = Object
				.keys(slots)
				.map(createSlotDefinition)
				.filter(function (slot) {
					return slot !== null
				});

			if (a9Slots.length === 0) {
				onResponse();
				return;
			}

			log(['call - fetchBids', a9Slots], 'debug', logGroup);

			win.apstag.fetchBids({
				slots: a9Slots,
				timeout: 2000
			}, function (currentBids) {
				log(['call - fetchBids response', currentBids], 'debug', logGroup);

				currentBids.forEach(function (bid) {
					var bidTargeting = bid,
						keys = win.apstag.targetingKeys();

					if (apsConfig.deals) {
						bidTargeting = bid.targeting;
						keys = bid.helpers.targetingKeys;
					}

					bids[bid.slotID] = {};
					keys.forEach(function (key) {
						bids[bid.slotID][key] = bidTargeting[key];
					});
				});

				onResponse();
			});
		}

		trackingOptIn.pushToUserConsentQueue(function (optIn) {
			if (win.__cmp) {
				win.__cmp('getConsentData', null, function (consentData) {
					init(optIn, consentData);
				});
			} else {
				init(optIn, undefined);
			}
		});
	}


	function createSlotDefinition(slotName) {
		var config = slots[slotName],
			definition = {
				slotID: slotName,
				slotName: slotName
			};

		if (!isVideoBidderEnabled() && config.type === 'video') {
			return null;
		} else if (config.type === 'video') {
			definition.mediaType = 'video';
		} else {
			definition.sizes = config.sizes;
		}

		return definition;
	}

	function configureApstagCommand(command, args) {
		win.apstag._Q.push([command, args]);
	}

	function configureApstag() {
		win.apstag = win.apstag || {};
		win.apstag._Q = win.apstag._Q || [];

		if (typeof win.apstag.init === 'undefined') {
			win.apstag.init = function () {
				configureApstagCommand('i', arguments);
			};
		}

		if (typeof win.apstag.fetchBids === 'undefined') {
			win.apstag.fetchBids = function () {
				configureApstagCommand('f', arguments);
			};
		}
	}

	function calculatePrices() {
		log(['calculatePrices', bids], 'debug', logGroup);

		Object.keys(bids).forEach(function (slotName) {
			priceMap[slotName] = bids[slotName].amznbid;
		});
	}

	function encodeParamsForTracking(params) {
		return params.amznsz + ';' + params.amznbid;
	}

	function getSlotParams(slotName) {
		log(['getSlotParams', slotName], 'debug', logGroup);

		return bids[slotName] || {};
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return !!slots[slotName];
	}

	function getBestSlotPrice(slotName) {
		return priceMap[slotName] ? {a9: priceMap[slotName]} : {};
	}

	return factory.create({
		logGroup: logGroup,
		name: 'a9',
		call: call,
		calculatePrices: calculatePrices,
		getPrices: getPrices,
		isSlotSupported: isSlotSupported,
		encodeParamsForTracking: encodeParamsForTracking,
		getSlotParams: getSlotParams,
		getBestSlotPrice: getBestSlotPrice
	});
});
