/*global define, JSON*/
define('ext.wikia.adEngine.adInfoTrackerHelper',  [
	'ext.wikia.adEngine.lookup.services',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.log',
	'wikia.window'
], function (lookupServices, adBlockDetection, log, win) {
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
			slotSize = JSON.parse(slotFirstChildData.gptCreativeSize);

		data = {
			'pv': pageParams.pv || '',
			'pv_unique_id': win.adEnginePvUID,
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
			'bidder_won': getBidderWon(slotParams, realSlotPrices),
			'bidder_1': transformBidderPrice('indexExchange', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_2': transformBidderPrice('appnexus', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_3': transformBidderPrice('fastlane', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_4': transformBidderPrice('rubicon', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_5': transformBidderPrice('fastlane_private', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_6': transformBidderPrice('aol', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_7': transformBidderPrice('audienceNetwork', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_8': transformBidderPrice('veles', realSlotPrices, slotPricesIgnoringTimeout),
			'bidder_9': transformBidderPrice('openx', realSlotPrices, slotPricesIgnoringTimeout),
			'product_chosen': '',
			'product_lineitem_id': slotFirstChildData.gptLineItemId || '',
			'product_label': ''
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
		var realSlotPricesKeys = Object.keys(realSlotPrices),
			highestPriceBidder = realSlotPricesKeys.length === 0 ? null : realSlotPricesKeys.reduce(function(a, b) {
				return parseFloat(realSlotPrices[a]) > parseFloat(realSlotPrices[b]) ? a : b;
		});

		// We need to check targeting because it's possible that bids won't be used for targeting
		if (slotParams.hb_bidder && highestPriceBidder === slotParams.hb_bidder) {
			return slotParams.hb_bidder;
		}

		if (slotParams.rpfl_7450 && ['fastlane', 'fastlane_private'].indexOf(highestPriceBidder) >= 0) {
			return highestPriceBidder;
		}

		return '';
	}

	function generateUUID() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	}

	return {
		generateUUID: generateUUID,
		prepareData: prepareData,
		shouldHandleSlot: shouldHandleSlot
	};
});
