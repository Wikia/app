/*global define*/
define('ext.wikia.adEngine.utils.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, slotTweaker, lazyQueue, log, win) {
	'use strict';

	var atfSlots = {
			oasis: [
				'CORP_TOP_LEADERBOARD',
				'CORP_TOP_RIGHT_BOXAD',
				'HOME_TOP_LEADERBOARD',
				'HOME_TOP_RIGHT_BOXAD',
				'HUB_TOP_LEADERBOARD',
				'INVISIBLE_SKIN',
				'TOP_LEADERBOARD',
				'TOP_RIGHT_BOXAD',
				'GPT_FLUSH'
			],
			mercury: [
				'MOBILE_TOP_LEADERBOARD',
				'INVISIBLE_HIGH_IMPACT'
			]
		},
		btfQueue = [],
		btfQueueStarted = false,
		fillInSlot,
		logGroup = 'ext.wikia.adEngine.utils.btfBlocker',
		pendingAtfSlots = []; // ATF slots pending for response

	function init(skin, fillInSlotCallback) {
		log(['init', skin], 'debug', logGroup);

		fillInSlot = fillInSlotCallback;
		atfSlots = atfSlots[skin];

		// There is no win.ads in Mercury and we already use win.ads.runtime.disableBtf variable on Oasis.
		// Let's make it easy for AdOps - let's make the one way to disabling BTF on both skins.
		// The following code sets the variable to false by default.
		if (skin === 'mercury') {
			win.ads = {
				runtime: {
					disableBtf: false
				}
			};
		}
	}

	function fillInSlotWithDelay(slot) {
		log(['fillInSlotWithDelay', slot.name], 'debug', logGroup);

		if (!adContext.getContext().opts.delayBtf) {
			fillInSlot(slot);
			return;
		}

		// For the above the fold slot:
		if (atfSlots.indexOf(slot.name) > -1) {
			pendingAtfSlots.push(slot.name);
			fillInSlot(slot);
			return;
		}

		// For the below the fold slot:
		btfQueue.push(slot);
	}

	function processBtfSlot(slot) {
		log(['processBtfSlot', slot.name], 'debug', logGroup);

		if (!win.ads.runtime.disableBtf) {
			fillInSlot(slot);
			return;
		}

		slot.success({adType: 'blocked'});
		slotTweaker.hide(slot.name);
	}

	function startBtfQueue() {
		log('startBtfQueue', 'debug', logGroup);

		if (btfQueueStarted) {
			return;
		}

		lazyQueue.makeQueue(btfQueue, processBtfSlot);
		btfQueue.start();

		btfQueueStarted = true;
	}

	function onSlotResponse(slotName) {
		log(['onSlotResponse', slotName], 'debug', logGroup);

		// Remove slot from pendingAtfSlots
		var index = pendingAtfSlots.indexOf(slotName);
		if (index > -1) {
			pendingAtfSlots.splice(index, 1);

			// If pendingAtfSlots is empty, start BTF slots
			if (pendingAtfSlots.length === 0) {
				startBtfQueue();
			}
		}
	}

	return {
		init: init,
		fillInSlotWithDelay: fillInSlotWithDelay,
		onSlotResponse: onSlotResponse
	};
});
