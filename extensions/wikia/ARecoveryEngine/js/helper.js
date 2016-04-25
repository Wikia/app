/*global define, require*/
define('ext.wikia.aRecoveryEngine.recovery.helper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	doc,
	lazyQueue,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.helper',
		context = adContext.getContext(),
		onBlockingEventsQueue = [];

	function initEventQueue() {
		lazyQueue.makeQueue(onBlockingEventsQueue, function (callback) {
			callback();
		});

		doc.addEventListener('sp.blocking', function () {
			onBlockingEventsQueue.start();
		});
	}

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function isRecoveryEnabled() {
		log(['isRecoveryEnabled', !!context.opts.sourcePointRecovery], 'debug', logGroup);
		return !!context.opts.sourcePointRecovery;
	}

	function isBlocking() {
		log(['isBlocking', !!(win.ads && win.ads.runtime.sp.blocking)], 'debug', logGroup);
		return !!(win.ads && win.ads.runtime.sp.blocking);
	}

	function isRecoverable(slotName, recoverableSlots) {
		return isRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		initEventQueue: initEventQueue,
		isRecoveryEnabled: isRecoveryEnabled,
		isBlocking: isBlocking,
		isRecoverable: isRecoverable
	};
});
