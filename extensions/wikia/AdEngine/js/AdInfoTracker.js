/*global define*/
define('ext.wikia.adEngine.adInfoTracker',  [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.window'
], function (adTracker, adContext, log, window) {
	'use strict';

	var	logGroup = 'ext.wikia.adEngine.adInfoTracker';

	function prepareData(slot, status) {
		if (!slot.container.firstChild || !slot.container.firstChild.dataset.gptPageParams) {
			return;
		}
		log(['prepareData', slot, status], 'debug', logGroup);
		var data,
			slotFirstChildData = slot.container.firstChild.dataset,
			pageParams = JSON.parse(slotFirstChildData.gptPageParams),
			slotParams = JSON.parse(slotFirstChildData.gptSlotParams);

		data = {
			'pv': pageParams.pv,
			'country': pageParams.geo,
			'slot_size': JSON.parse(slotFirstChildData.gptCreativeSize).join('x'),
			'kv_s0': pageParams.s0,
			'kv_s1': pageParams.s1,
			'kv_s2': pageParams.s2,
			'kv_s0v': pageParams.s0v,
			'kv_pos': slotParams.pos,
			'kv_wsi': slotParams.wsi,
			'kv_lang': pageParams.lang,
			'bidder_won': '',
			'bidder_1': '',
			'bidder_2': '',
			'bidder_3': '',
			'bidder_4': '',
			'bidder_5': '',
			'bidder_6': '',
			'bidder_7': '',
			'product_chosen': '',
			'product_lineitem_id': slotFirstChildData.gptLineItemId,
			'product_label': ''
		};
		return data;
	}

	function logSlotInfo(data) {
		log(['logSlotInfo', data], 'debug', logGroup);
		if (adContext.getContext().opts.enableAdInfoLog) {
			adTracker.trackDW(data, 'adengadinfo');
		}
	}

	function run() {
		log('run', 'debug', logGroup);
		window.addEventListener('adengine.slot.status', function (e) {
			log(['adengine.slot.status', e], 'debug', logGroup);
			var data = prepareData(e.detail.slot, e.detail.status);
			if (data) {
				logSlotInfo(data);
			}
		});
	}

	return {
		run: run
	};

});
