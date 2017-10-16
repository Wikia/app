/*global define, require*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, uapContext, adBlockDetection, lazyQueue, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.btfBlocker',
		unblockedSlots = [];

	win.ads = win.ads || {};
	win.ads.runtime = win.ads.runtime || {};
	win.ads.runtime.disableBtf = false;
	win.ads.runtime.unblockHighlyViewableSlots = false;

	function unblock(slotName) {
		log(['unblocking', slotName], log.levels.info, logGroup);
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

		// as soon as we know that user has adblock, unblock BTF slots
		win.addEventListener('wikia.blocking', startBtfQueue);

		function processBtfSlot(slot) {
			var context = adContext.getContext();

			if (uapContext.isUapLoaded() && slot.name === 'INVISIBLE_HIGH_IMPACT_2') {
				log(['IHI2 disabled when UAP on page'], log.levels.info, logGroup);
				return;
			}

			if (context.opts.premiumAdLayoutEnabled && !uapContext.isUapLoaded()) {
				if (unblockedSlots.indexOf(slot.name) > -1) {
					log(['PAL enabled, filling slot', slot.name], log.levels.info, logGroup);
					fillInSlot(slot);
					return;
				}
			} else {
				if (win.ads.runtime.unblockHighlyViewableSlots && config.highlyViewableSlots) {
					log(['Unblocking HiVi slots', slot.name], log.levels.info, logGroup);
					config.highlyViewableSlots.map(unblock);
				}

				if (unblockedSlots.indexOf(slot.name) > -1 || !win.ads.runtime.disableBtf) {
					log(['Filling slot', slot.name], log.levels.info, logGroup);
					fillInSlot(slot);
					return;
				}
			}

			slot.collapse({adType: 'blocked'});
		}

		function startBtfQueue() {
			var context = adContext.getContext(),
				roadblockBlocksBtf = uapContext.isRoadblockLoaded() && win.ads.runtime.disableBtf;

			log('startBtfQueue', log.levels.info.debug, logGroup);

			if (btfQueueStarted) {
				return;
			}

			if (context.opts.premiumAdLayoutEnabled && !roadblockBlocksBtf) {
				win.ads.runtime.disableBtf = true;
				context.slots.premiumAdLayoutSlotsToUnblock.map(unblock);
			}

			lazyQueue.makeQueue(btfQueue, processBtfSlot);
			btfQueue.start();

			btfQueueStarted = true;
		}

		function onSlotResponse(slotName) {
			log(['onSlotResponse', slotName], log.levels.info.debug, logGroup);

			// Remove slot from pendingAtfSlots
			var index = pendingAtfSlots.indexOf(slotName);

			if (index > -1) {
				pendingAtfSlots.splice(index, 1);

				// If pendingAtfSlots is empty, start BTF slots
				log(['remove from pendingAtfSlots', pendingAtfSlots, slotName], log.levels.debug, logGroup);
				if (pendingAtfSlots.length === 0) {
					/*
					mobil require is asynchronous.
					We need to wait for code that is executed by require (UAP) before we start executing BTF queue
					 */
					win.setTimeout(startBtfQueue, 0);
				}
			}
		}

		function shouldDelaySlotFillIn(slotName) {
			var shouldDelay = adContext.getContext().opts.delayBtf;

			log(['shouldDelaySlotFillIn', shouldDelay, slotName], log.levels.debug, logGroup);

			return shouldDelay;
		}

		function fillInSlotWithDelay(slot) {
			log(['fillInSlotWithDelay', slot.name], log.levels.info.debug, logGroup);

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
