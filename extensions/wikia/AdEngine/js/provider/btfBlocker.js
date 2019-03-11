/*global define*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.messageListener',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, messageListener, lazyQueue, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.btfBlocker',
		unblockedSlots = [];

	win.ads = win.ads || {};
	win.ads.runtime = win.ads.runtime || {};
	win.ads.runtime.disableBtf = false;
	win.ads.runtime.disableSecondCall = false;
	win.ads.runtime.unblockHighlyViewableSlots = false;

	var secondCallQueue = [],
		secondCallQueueStarted = false,
		firstCallSlots = []; // first call slots pending for response
	var fillInSlotCallbacks = {};

	function disableBtfByMessage(msg) {
		win.ads.runtime.disableBtf = Boolean(msg.disableBtf);
	}

	function disableSecondCallByMessage(msg) {
		win.ads.runtime.disableSecondCall = Boolean(msg.disableSecondCall);
	}

	function unblock(slotName) {
		log(['unblocking', slotName], log.levels.info, logGroup);
		unblockedSlots.push(slotName);
	}

	function isBtfEnabled() {
		return !win.ads.runtime.disableBtf;
	}

	function isSecondCallEnabled() {
		return !win.ads.runtime.disableSecondCall;
	}

	function decorate(fillInSlot, config) {

		// Update state on each pv on Mercury
		adContext.addCallback(function () {
			secondCallQueue = [];
			secondCallQueueStarted = false;
			firstCallSlots = [];
			win.ads.runtime.disableBtf = false;
			win.ads.runtime.disableSecondCall = false;
			win.ads.runtime.unblockHighlyViewableSlots = false;
			unblockedSlots = [];

			messageListener.register({dataKey: 'disableBtf', infinite: true}, disableBtfByMessage);
			messageListener.register({dataKey: 'disableSecondCall', infinite: true}, disableSecondCallByMessage);
		});

		// as soon as we know that user has adblock, unblock BTF slots
		win.addEventListener('wikia.blocking', startSecondCallSlots);

		function processSecondCallSlots(slot) {
			if ((unblockedSlots.indexOf(slot.name) > -1 || isBtfEnabled()) && isSecondCallEnabled()) {
				log(['Filling slot', slot.name], log.levels.info, logGroup);
				fillInSlotCallbacks[slot.name](slot);
				return;
			}

			log(['Collapsing slot', slot.name], log.levels.info, logGroup);
			if (slot.collapse) {
				slot.collapse({adType: 'blocked'});
			}
		}

		function startSecondCallSlots() {
			log('startSecondCallSlots', log.levels.info.debug, logGroup);

			if (secondCallQueueStarted) {
				return;
			}

			// highly viewable slots can be unblocked in second call
			if (win.ads.runtime.unblockHighlyViewableSlots && config.highlyViewableSlots) {
				config.highlyViewableSlots.forEach(function(slotName) {
					log(['Unblocking HiVi slots', slotName], log.levels.info, logGroup);
					unblock(slotName);
				});
			}

			// ATF slots are always called in second call if not called in first
			if (config.atfSlots && isSecondCallEnabled()) {
				config.atfSlots
				// remove slot already called in first call
				.filter(function(slotName) {
					return config.firstCallSlots.indexOf(slotName) === -1;
				})
				// unblock slot
				.forEach(function(slotName) {
					log(['Filling ATF slot in second call', slotName], log.levels.info, logGroup);
					unblock(slotName);
				});
			}

			lazyQueue.makeQueue(secondCallQueue, processSecondCallSlots);

			secondCallQueue.start();

			secondCallQueueStarted = true;
		}

		function onSlotResponse(slotName) {
			log(['onSlotResponse', slotName], log.levels.info.debug, logGroup);

			// Remove slot from firstCallSlots
			var index = firstCallSlots.indexOf(slotName);
			if (index > -1) {
				firstCallSlots.splice(index, 1);

				// If firstCallSlots is empty, start BTF slots
				log(['remove from firstCallSlots', firstCallSlots, slotName], log.levels.debug, logGroup);
				if (firstCallSlots.length === 0) {
					startSecondCallSlots();
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

			// For the first call slot:
			if (config && config.firstCallSlots && config.firstCallSlots.indexOf(slot.name) > -1) {
				firstCallSlots.push(slot.name);

				slot.post('renderEnded', fillInSlotOnResponse);
				slot.post('collapse', fillInSlotOnResponse);
				slot.post('hop', fillInSlotOnResponse);
				slot.post('success', fillInSlotOnResponse);

				fillInSlot(slot);
				return;
			}

			// For the second call slots:
			fillInSlotCallbacks[slot.name] = fillInSlot;
			secondCallQueue.push(slot);
		}

		return fillInSlotWithDelay;
	}

	messageListener.register({dataKey: 'disableBtf', infinite: true}, disableBtfByMessage);
	messageListener.register({dataKey: 'disableSecondCall', infinite: true}, disableSecondCallByMessage);

	return {
		decorate: decorate,
		unblock: unblock
	};
});
