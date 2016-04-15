/*global define, require*/
define('ext.wikia.aRecoveryEngine.recovery.helper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.provider.gpt.sourcePointTag')
], function (
	adContext,
	doc,
	lazyQueue,
	log,
	win,
	SourcePointTag
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.helper',
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
		log(['addSlotToRecover', slotName], 'debug', logGroup);
		slotsToRecover.push(slotName);
	}

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function createSourcePointTag() {
		return new SourcePointTag();
	}

	function isRecoveryEnabled() {
		log(['isRecoveryEnabled', !!(context.opts.sourcePointRecovery && SourcePointTag)], 'debug', logGroup);
		return !!(context.opts.sourcePointRecovery && SourcePointTag);
	}

	function isBlocking() {
		log(['isBlocking', !!(win.ads && win.ads.runtime.sp.blocking)], 'debug', logGroup);
		return !!(win.ads && win.ads.runtime.sp.blocking);
	}

	function isRecoverable(slotName, recoverableSlots) {
		return isRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
	}

	return {
		addSlotToRecover: addSlotToRecover,
		addOnBlockingCallback: addOnBlockingCallback,
		createSourcePointTag: createSourcePointTag,
		initEventQueue: initEventQueue,
		isRecoveryEnabled: isRecoveryEnabled,
		isBlocking: isBlocking,
		isRecoverable: isRecoverable
	};
});
