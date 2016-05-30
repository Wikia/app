/*global define*/
define('ext.wikia.adEngine.provider.btfBlocker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (adContext, slotTweaker, lazyQueue, log, win) {
	'use strict';

	win.ads = win.ads || {};
	win.ads.runtime = win.ads.runtime || {};
	win.ads.runtime.disableBtf = false;

	function decorate(atfSlots, fillInSlot) {
		var btfQueue = [],
			btfQueueStarted = false,
			logGroup = 'ext.wikia.adEngine.provider.btfBlocker',
			pendingAtfSlots = []; // ATF slots pending for response

		function processBtfSlot(slot) {
			log(['processBtfSlot', slot.name], 'debug', logGroup);

			if (!win.ads.runtime.disableBtf) {
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

			if (!adContext.getContext().opts.delayBtf) {
				fillInSlot(slot);
				return;
			}

			// For the above the fold slot:
			if (atfSlots.indexOf(slot.name) > -1) {
				pendingAtfSlots.push(slot.name);

				slot.pre('success', function () { onSlotResponse(slot.name, fillInSlot); });
				slot.pre('collapse', function () { onSlotResponse(slot.name, fillInSlot); });
				slot.pre('hop', function () { onSlotResponse(slot.name, fillInSlot); });

				fillInSlot(slot);
				return;
			}

			// For the below the fold slot:
			btfQueue.push(slot);
		}

		return fillInSlotWithDelay;
	}

	return {
		decorate: decorate
	};
});
