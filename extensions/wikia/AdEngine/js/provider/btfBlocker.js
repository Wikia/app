/*global define*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, recoveryHelper, lazyQueue, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.btfBlocker',
		unblockedSlots = [];

	win.ads = win.ads || {};
	win.ads.runtime = win.ads.runtime || {};
	win.ads.runtime.disableBtf = false;
	win.ads.runtime.unblockHighlyViewableSlots = false;

	function unblock(slotName) {
		unblockedSlots.push(slotName);
	}

	function decorate(fillInSlot, config) {
		var btfQueue = [],
			btfQueueStarted = false,
			pendingAtfSlots = []; // ATF slots pending for response

		// Update state on each pv on Mercury
		adContext.addCallback(function() {
			btfQueue = [];
			btfQueueStarted = false;
			pendingAtfSlots = [];
			win.ads.runtime.disableBtf = false;
			win.ads.runtime.unblockHighlyViewableSlots = false;
			unblockedSlots = [];
		});

		function processBtfSlot(slot) {
			log(['processBtfSlot', slot.name], 'debug', logGroup);

			if (win.ads.runtime.unblockHighlyViewableSlots && config.highlyViewableSlots) {
				config.highlyViewableSlots.map(unblock);
			}

			if (unblockedSlots.indexOf(slot.name) > -1 || !win.ads.runtime.disableBtf) {
				fillInSlot(slot);
				return;
			}

			slot.collapse({adType: 'blocked'});
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

		function fillInSlotWithDelay(slot) {
			log(['fillInSlotWithDelay', slot.name], 'debug', logGroup);

			function fillInSlotOnResponse() {
				onSlotResponse(slot.name);
			}

			if (!adContext.getContext().opts.delayBtf) {
				fillInSlot(slot);
				return;
			}

			// For the above the fold slot:
			if (config.atfSlots.indexOf(slot.name) > -1) {
				pendingAtfSlots.push(slot.name);

				slot.pre('success', fillInSlotOnResponse);
				slot.pre('collapse', fillInSlotOnResponse);
				slot.pre('hop', fillInSlotOnResponse);

				fillInSlot(slot);
				return;
			}

			// For the below the fold slot:
			btfQueue.push(slot);
		}

		return fillInSlotWithDelay;
	}

	return {
		decorate: decorate,
		unblock: unblock
	};
});
