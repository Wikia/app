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
				BOTTOM_LEADERBOARD: [[728, 90], [970, 250]],
				INCONTENT_BOXAD_1: [[300, 250], [300, 600]],
				TOP_LEADERBOARD: [[728, 90], [970, 250]],
				TOP_RIGHT_BOXAD: [[300, 250], [300, 600]]
			},
			mercury: {
				MOBILE_IN_CONTENT: [[300, 250], [320, 480]],
				BOTTOM_LEADERBOARD: [[320, 50], [300, 250]],
				MOBILE_TOP_LEADERBOARD: [[320, 50]]
			}
		},
		VIDEO_SLOTS = ['FEATURED'],
		amazonId = '3115',
		bids = {},
		loaded = false,
		priceMap = {},
		slots = [];

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
					videoAdServer: 'DFP'
				},
				a9Slots;

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
			a9Slots = Object.keys(slots).map(createSlotDefinition);

			if (isVideoBidderEnabled()) {
				a9Slots = a9Slots.concat(VIDEO_SLOTS.map(createVideoSlotDefinition));
			}

			log(['call - fetchBids', a9Slots], 'debug', logGroup);

			win.apstag.fetchBids({
				slots: a9Slots,
				timeout: 2000
			}, function (currentBids) {
				log(['call - fetchBids response', currentBids], 'debug', logGroup);

				currentBids.forEach(function (bid) {
					bids[bid.slotID] = bid;
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
		return {
			sizes: slots[slotName],
			slotID: slotName,
			slotName: slotName
		};
	}

	function createVideoSlotDefinition(videoSlotName) {
		return {
			slotID: videoSlotName,
			mediaType: 'video'
		};
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
		var bid = bids[slotName];

		log(['getSlotParams', slotName], 'debug', logGroup);

		if (!bid) {
			return {};
		}

		return {
			amznbid: bid.amznbid,
			amzniid: bid.amzniid,
			amznsz: bid.amznsz,
			amznp: bid.amznp
		};
	}

	function getPrices() {
		return priceMap;
	}

	function isSlotSupported(slotName) {
		return slots[slotName] || VIDEO_SLOTS.indexOf(slotName) >= 0;
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
