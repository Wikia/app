/*global define*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.messageListener',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, bridge, messageListener, lazyQueue, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.btfBlocker',
		unblockedSlots = [];

	win.ads = win.ads || {};
	win.ads.runtime = win.ads.runtime || {};
	win.ads.runtime.disableBtf = false;
	win.ads.runtime.unblockHighlyViewableSlots = false;

	messageListener.register({dataKey: 'disableBtf', infinite: true}, function (msg) {
		win.ads.runtime.disableBtf = Boolean(msg.disableBtf);
	});

	function unblock(slotName) {
		log(['unblocking', slotName], log.levels.info, logGroup);
		unblockedSlots.push(slotName);
	}

	function isBTFDisabledByCreative() {
		return win.ads.runtime.disableBtf;
	}

	var btfQueue = [],
		btfQueueStarted = false,
		pendingAtfSlots = []; // ATF slots pending for response
	var fillInSlotCallbacks = {};

	function decorate(fillInSlot, config) {

		// Update state on each pv on Mercury
		adContext.addCallback(function () {
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

			if (bridge.universalAdPackage.isFanTakeoverLoaded() && slot.name === 'INVISIBLE_HIGH_IMPACT_2') {
				log(['IHI2 disabled when UAP on page'], log.levels.info, logGroup);
				return;
			}

			if (win.ads.runtime.unblockHighlyViewableSlots && config.highlyViewableSlots) {
				log(['Unblocking HiVi slots', slot.name], log.levels.info, logGroup);
				config.highlyViewableSlots.map(unblock);
			}

			if (unblockedSlots.indexOf(slot.name) > -1 || !isBTFDisabledByCreative()) {
				log(['Filling slot', slot.name], log.levels.info, logGroup);
				fillInSlotCallbacks[slot.name](slot);
				return;
			}

			log(['Collapsing slot', slot.name], log.levels.info, logGroup);
			if (slot.collapse) {
				slot.collapse({adType: 'blocked'});
			}
		}

		function startBtfQueue() {
			log('startBtfQueue', log.levels.info.debug, logGroup);

			if (btfQueueStarted) {
				return;
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
					startBtfQueue();
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
			if (config && config.atfSlots && config.atfSlots.indexOf(slot.name) > -1) {
				pendingAtfSlots.push(slot.name);

				slot.pre('renderEnded', fillInSlotOnResponse);
				slot.pre('collapse', fillInSlotOnResponse);
				slot.pre('hop', fillInSlotOnResponse);
				slot.pre('success', fillInSlotOnResponse);

				fillInSlot(slot);
				return;
			}

			// For the below the fold slot:
			fillInSlotCallbacks[slot.name] = fillInSlot;
			btfQueue.push(slot);
		}

		return fillInSlotWithDelay;
	}

	return {
		decorate: decorate,
		unblock: unblock
	};
});
