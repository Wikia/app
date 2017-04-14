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
		context = adContext.getContext(),
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

	/**
	 * Mark module as responded not matter if adblock is blocking
	 * @param callback
	 */
	function addResponseListener(callback) {
		sourcePoint.addOnBlockingCallback(callback);
		sourcePoint.addOnNotBlockingCallback(callback);

		//in the future maybe add here pagefair - it sometimes can be faster that sp
	}

	function getName() {
		return 'adBlockDetection';
	}

	/**
	 * If recovery is not enabled, we don't need to wait for adBlockDetection results
	 * and we can immediately assume that the module wasCalled.
	 *
	 * @returns {bool}
	 */
	function isRecoveryEnabled() {
		return sourcePoint.isEnabled() || (pageFair && pageFair.isEnabled());
	}

	function getSafeUri(url) {
		if (isBlocking()) {
			url = win._sp_.getSafeUri(url);
		}

		return url;
	}

	function isBlocking() {
		return sourcePoint.isBlocking() || (pageFair && pageFair.isBlocking());
	}

	function isEnabled() {
		var enabled = context.opts.sourcePointRecovery || context.opts.pageFairRecovery;

		log(['isEnabled', enabled], log.levels.debug, logGroup);
		return enabled;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		addOnNotBlockingCallback: addOnNotBlockingCallback,
		addResponseListener: addResponseListener,
		initEventQueues: initEventQueues,
		isBlocking: isBlocking,
		isEnabled: isEnabled,
		getName: getName,
		getSafeUri: getSafeUri,
		wasCalled: isRecoveryEnabled
	};
});
