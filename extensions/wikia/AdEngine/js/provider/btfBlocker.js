/*global define*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.instartLogic.recovery')
], function (adContext, uapContext, adBlockDetection, lazyQueue, log, win, instartLogic) {
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
			var context = adContext.getContext();
			log(['processBtfSlot', slot.name], 'debug', logGroup);

			if (context.opts.premiumAdLayoutEnabled && !uapContext.isUapLoaded()) {
				if (context.slots.premiumAdLayoutSlotsToUnblock.indexOf(slot.name) !== -1) {
					fillInSlot(slot);
					return;
				}
			} else {
				if (win.ads.runtime.unblockHighlyViewableSlots && config.highlyViewableSlots) {
					config.highlyViewableSlots.map(unblock);
				}

				if (unblockedSlots.indexOf(slot.name) > -1 || !win.ads.runtime.disableBtf) {
					fillInSlot(slot);
					return;
				}
			}

			slot.collapse({adType: 'blocked'});
		}

		function startBtfQueue() {
			var context = adContext.getContext();
			log('startBtfQueue', 'debug', logGroup);

			if (btfQueueStarted) {
				return;
			}

			if (context.opts.premiumAdLayoutEnabled) {
				win.ads.runtime.disableBtf = true;
				context.slots.premiumAdLayoutSlotsToUnblock.map(unblock);
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
				log(['remove from pendingAtfSlots', pendingAtfSlots, slotName], log.levels.debug, logGroup);
				if (pendingAtfSlots.length === 0) {
					startBtfQueue();
				}
			}
		}

		function shouldDelaySlotFillIn(slotName) {
			var isBlocking = adBlockDetection.isBlocking() || instartLogic.isBlocking(),
				shouldDelay = adContext.getContext().opts.delayBtf;// && !isBlocking;
			log(['shouldDelaySlotFillIn', shouldDelay, slotName], log.levels.debug, logGroup);

			return shouldDelay;
		}

		function fillInSlotWithDelay(slot) {
			log(['fillInSlotWithDelay', slot.name], 'debug', logGroup);

			function fillInSlotOnResponse() {
				onSlotResponse(slot.name);
			}

			if (!shouldDelaySlotFillIn(slot.name)) {
				fillInSlot(slot);
				return;
			}

			// For the above the fold slot:
			if (config.atfSlots.indexOf(slot.name) > -1) {
				pendingAtfSlots.push(slot.name);

				slot.pre('renderEnded', fillInSlotOnResponse);
				slot.pre('collapse', fillInSlotOnResponse);
				slot.pre('hop', fillInSlotOnResponse);
				slot.pre('success', fillInSlotOnResponse);

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
