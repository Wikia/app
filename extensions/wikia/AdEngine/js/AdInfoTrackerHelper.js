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
			slotPrices = lookupServices.getSlotPrices(slot.name),
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
			'bidder_won': '',
			'bidder_1': slotPrices.indexExchange || '',
			'bidder_2': slotPrices.appnexus || '',
			'bidder_3': slotPrices.fastlane || '',
			'bidder_4': slotPrices.vulcan || '',
			'bidder_5': slotPrices.fastlane_private || '',
			'bidder_6': slotPrices.aol || '',
			'bidder_7': slotPrices.audienceNetwork || '',
			'bidder_8': slotPrices.veles || '',
			'bidder_9': slotPrices.openx || '',
			'product_chosen': '',
			'product_lineitem_id': slotFirstChildData.gptLineItemId || '',
			'product_label': ''
		};

		return data;
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
