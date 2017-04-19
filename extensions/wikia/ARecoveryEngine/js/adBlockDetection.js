/*global define*/
define('ext.wikia.aRecoveryEngine.adBlockDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.pageFair')
], function (
	adContext,
	sourcePoint,
	doc,
	instantGlobals,
	lazyQueue,
	log,
	win,
	pageFair
) {
	'use strict';

	var cb = function (callback) {
			callback();
		},
		logGroup = 'ext.wikia.aRecoveryEngine.adBlockDetection',
		onBlockingEventsQueue = lazyQueue.makeQueue([], cb),
		onNotBlockingEventsQueue = lazyQueue.makeQueue([], cb);

	function initEventQueues() {
		doc.addEventListener('sp.not_blocking', onNotBlockingEventsQueue.start);
		doc.addEventListener('sp.blocking', onBlockingEventsQueue.start);
	}

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function addOnNotBlockingCallback(callback) {
		onNotBlockingEventsQueue.push(callback);
	}

	function isBlocking() {
		return isDetectionEnabled() &&
			(sourcePoint.isBlocking() || (pageFair && pageFair.isBlocking()));
	}

	function isDetectionEnabled() {
		var context = adContext.getContext();

		log(['isDetectionEnabled', context.opts.sourcePointDetection], log.levels.debug, logGroup);
		return context.opts.sourcePointDetection;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		addOnNotBlockingCallback: addOnNotBlockingCallback,
		initEventQueues: initEventQueues,
		isBlocking: isBlocking,
		isEnabled: isDetectionEnabled
	};
});
