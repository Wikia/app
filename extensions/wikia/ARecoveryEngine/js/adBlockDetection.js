/*global define*/
define('ext.wikia.aRecoveryEngine.adBlockDetection', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	require.optional('ext.wikia.aRecoveryEngine.pageFair.recovery')
], function (
	adContext,
	doc,
	instantGlobals,
	lazyQueue,
	log,
	pageFair
) {
	'use strict';

	var cb = function (callback) {
			callback();
		},
		logGroup = 'ext.wikia.aRecoveryEngine.adBlockDetection',
		onBlockingEventsQueue = lazyQueue.makeQueue([], cb),
		onNotBlockingEventsQueue = lazyQueue.makeQueue([], cb);

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function addOnNotBlockingCallback(callback) {
		onNotBlockingEventsQueue.push(callback);
	}

	function isBlocking() {
		return isEnabled() && pageFair && pageFair.isBlocking();
	}

	function isEnabled() {
		var context = adContext.getContext();

		log(['isEnabled', context.opts.pageFairRecovery], log.levels.debug, logGroup);
		return context.opts.pageFairRecovery;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		addOnNotBlockingCallback: addOnNotBlockingCallback,
		isBlocking: isBlocking,
		isEnabled: isEnabled
	};
});
