/*global define, JSON*/
define('ext.wikia.adEngine.adInfoTrackerHelper',  [
	'ext.wikia.adEngine.lookup.services',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window'
], function (lookupServices, slotRegistry, adBlockDetection, browserDetect, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInfoTrackerHelper';

	function shouldHandleSlot(slot, enabledSlots) {
		var dataGptDiv = slot.container.firstChild;

		return (
			enabledSlots[slot.name] &&
			dataGptDiv &&
			dataGptDiv.dataset.gptPageParams &&
			!adBlockDetection.isBlocking()
		);
	}

	function prepareData(slot, status) {
		log(['prepareData', slot, status], log.levels.debug, logGroup);

		var data,
			slotFirstChildData = slot.container.firstChild.dataset,
			pageParams = JSON.parse(slotFirstChildData.gptPageParams),
			slotParams = JSON.parse(slotFirstChildData.gptSlotParams),
			slotPricesIgnoringTimeout = lookupServices.getCurrentSlotPrices(slot.name),
			realSlotPrices = lookupServices.getDfpSlotPrices(slot.name),
			slotSize = JSON.parse(slotFirstChildData.gptCreativeSize),
			bidderWon = getBidderWon(slotParams, realSlotPrices);

		data = {
			'pv': pageParams.pv || '',
			'pv_unique_id': win.adEnginePvUID,
			'browser': [ browserDetect.getOS(), browserDetect.getBrowser() ].join(' '),
			'country': pageParams.geo || '',
			'time_bucket': (new Date()).getHours(),
			'slot_size': slotSize && slotSize.length ? slotSize.join('x') : '',
			'kv_s0': pageParams.s0 || '',
			'kv_s1': pageParams.s1 || '',
			'kv_s2': pageParams.s2 || '',
			'kv_s0v': pageParams.s0v || '',
			'kv_pos': slotParams.pos || '',
			'kv_rv': slotParams.rv || '',
			'kv_wsi': slotParams.wsi || '',
			'kv_lang': pageParams.lang || '',
			'kv_skin': pageParams.skin || '',
			'kv_esrb': pageParams.esrb || '',
			'kv_ref': pageParams.ref || '',
			'kv_top': pageParams.top || '',
			'kv_ah': pageParams.ah || '',
			'kv_abi': slotParams.abi || '',
			'bidder_won': bidderWon,
			'bidder_won_price': bidderWon ? realSlotPrices[bidderWon] : '',
			'bidder_1': transformBidderPrice('indexExchange', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_2': transformBidderPrice('appnexus', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_3': transformBidderPrice('fastlane', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_4': transformBidderPrice('rubicon', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_5': transformBidderPrice('fastlane_private', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_6': transformBidderPrice('aol', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_7': transformBidderPrice('audienceNetwork', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_8': transformBidderPrice('veles', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_9': transformBidderPrice('openx', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_10': transformBidderPrice('appnexusAst', realSlotPrices, slotPricesIgnoringTimeout),
			'product_chosen': '',
			'product_lineitem_id': slotFirstChildData.gptLineItemId || '',
			'creative_id': slotFirstChildData.gptCreativeId || '',
			'creative_size': (slotFirstChildData.gptCreativeSize || '')
				.replace('[', '').replace(']', '').replace(',', 'x'),
			'viewport_height': win.innerHeight || 0,
			'product_label': '',
			'ad_status': status || 'unknown',
			'scrollY': slotRegistry.getScrollY(slot.name) || 0
		};

		return data;
	}

	function transformBidderPrice(bidderName, realSlotPrices, slotPricesIgnoringTimeout) {
		if (realSlotPrices[bidderName]) {
			return realSlotPrices[bidderName];
		}

		if (slotPricesIgnoringTimeout[bidderName]) {
			return slotPricesIgnoringTimeout[bidderName] + 'not_used';
		}

		return '';
	}

	function getBidderWon(slotParams, realSlotPrices) {
		var slotPricesKeys = Object.keys(realSlotPrices).filter(function(key) {
				return parseFloat(realSlotPrices[key]) > 0;
			}),
			highestPrice = Math.max.apply(
				null,
				slotPricesKeys.map(function(key) { return parseFloat(realSlotPrices[key]); })
			),
			highestPriceBidders = [];

		slotPricesKeys.forEach(function(key) {
			if (parseFloat(realSlotPrices[key]) === highestPrice) {
				highestPriceBidders.push(key);
			}
		});

		// In case of a tie in prebid bidders prebid.js picks the fastest bidder.
		// In case of a tie with prebid and rubiconFastlane we promote prebid
		if (slotParams.hb_bidder && highestPriceBidders.indexOf(slotParams.hb_bidder) >= 0) {
			return slotParams.hb_bidder;
		}

		if (slotParams.rpfl_7450) {
			if (highestPriceBidders.indexOf('fastlane') >= 0) {
				return 'fastlane';
			}

			if (highestPriceBidders.indexOf('fastlane_private') >= 0) {
				return 'fastlane_private';
			}
		}

		return '';
	}

	function generateUUID() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	}

	return {
		generateUUID: generateUUID,
		prepareData: prepareData,
		shouldHandleSlot: shouldHandleSlot
	};
});
