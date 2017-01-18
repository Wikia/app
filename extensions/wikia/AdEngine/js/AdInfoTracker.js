/*global define*/
define('ext.wikia.adEngine.adInfoTracker',  [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.services',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (adTracker, adContext, lookupServices, recoveryHelper, log, win, mercuryListener) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adInfoTracker',
		enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true,
			PREFOOTER_LEFT_BOXAD: true,
			PREFOOTER_MIDDLE_BOXAD: true,
			PREFOOTER_RIGHT_BOXAD: true,
			LEFT_SKYSCRAPER_2: true,
			LEFT_SKYSCRAPER_3: true,
			INCONTENT_BOXAD_1: true,
			BOTTOM_LEADERBOARD: true,
			MOBILE_TOP_LEADERBOARD: true,
			MOBILE_BOTTOM_LEADERBOARD: true,
			MOBILE_IN_CONTENT: true,
			MOBILE_PREFOOTER: true
		};

	function shouldHandleSlot(slot) {
		if (!enabledSlots[slot.name] ||
			!slot.container.firstChild ||
			!slot.container.firstChild.dataset.gptPageParams) {
			return false;
		}
		return true;
	}

	function prepareData(slot, status) {
		if (!shouldHandleSlot(slot)) {
			return;
		}
		log(['prepareData', slot, status], 'debug', logGroup);
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
			'bidder_6': '',
			'bidder_7': '',
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

	function logSlotInfo(data) {
		log(['logSlotInfo', data], 'debug', logGroup);
		adTracker.trackDW(data, 'adengadinfo');
	}

	function isEnabled() {
		if (!adContext.getContext().opts.enableAdInfoLog || recoveryHelper.isBlocking()) {
			return false;
		}
		return true;
	}

	function setAdEnginePvUID() {
		win.adEnginePvUID = win.adEnginePvUID || generateUUID();
	}

	function run() {
		setAdEnginePvUID();
		if (mercuryListener) {
			mercuryListener.onEveryPageChange(function() {
				win.adEnginePvUID = generateUUID();
			});
		}

		if (isEnabled()) {
			log('run', 'debug', logGroup);

			win.addEventListener('adengine.slot.status', function (e) {
				log(['adengine.slot.status', e], 'debug', logGroup);
				var data = prepareData(e.detail.slot, e.detail.status);
				if (data) {
					logSlotInfo(data);
				}
			});
		}
	}

	return {
		run: run
	};

});
