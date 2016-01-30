define('ext.wikia.adEngine.recovery.helper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log',
	require.optional('ext.wikia.adEngine.provider.gpt.sourcePointTag')
], function (
	adContext,
	doc,
	lazyQueue,
	log,
	SourcePointTag
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.recovery.helper',
		context = adContext.getContext(),
		slotsToRecover = [],
		onBlockingEventsQueue = [];

	function initEventQueue() {
		lazyQueue.makeQueue(onBlockingEventsQueue, function (callback) {
			callback();
		});

		doc.addEventListener('sp.blocking', function () {
			onBlockingEventsQueue.start();
		});
	}

	function addSlotToRecover(slotName) {
		slotsToRecover.push(slotName);
	}

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function createSourcePointTag() {
		return new SourcePointTag();
	}

	function isRecoveryEnabled() {
		return !!(context.opts.sourcePoint && SourcePointTag);
	}

	function isBlocking() {
		return !!(window.ads && window.ads.runtime.sp.blocking);
	}

	function isRecoverable(slotName, recoverableSlots) {
		return isRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
	}

	function recoverSlots() {
		if (!isBlocking() || !isRecoveryEnabled()) {
			return;
		}

		log(['Starting recovery', slotsToRecover], 'debug', logGroup);
		while (slotsToRecover.length) {
			window.ads.runtime.sp.slots.push([slotsToRecover.shift()]);
		}
	}

	return {
		addSlotToRecover: addSlotToRecover,
		addOnBlockingCallback: addOnBlockingCallback,
		createSourcePointTag: createSourcePointTag,
		initEventQueue: initEventQueue,
		isRecoveryEnabled: isRecoveryEnabled,
		isBlocking: isBlocking,
		isRecoverable: isRecoverable,
		recoverSlots: recoverSlots
	};
});
