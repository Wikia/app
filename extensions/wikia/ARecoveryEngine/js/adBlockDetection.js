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
		customLogEndpoint = '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
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
		addOnBlockingCallback(callback);
		addOnNotBlockingCallback(callback);
	}

	function getName() {
		return 'adBlockDetection';
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

	/**
	 * If recovery is not enabled, we don't need to wait for adBlockDetection results
	 * and we can immediately assume that the module wasCalled.
	 *
	 * @returns {bool}
	 */
	function isEnabled() {
		var context = adContext.getContext(),
			enabled = context.opts.sourcePointRecovery || context.opts.pageFairRecovery;

		log(['isEnabled', enabled], log.levels.debug, logGroup);
		return enabled;
	}

	function track(type) {
		if (win._sp_ && !win._sp_.trackingSent) {
			if (Wikia && Wikia.Tracker) {
				Wikia.Tracker.track({
					eventName: 'ads.recovery',
					category: 'ads-recovery-blocked',
					action: Wikia.Tracker.ACTIONS.IMPRESSION,
					label: type,
					trackingMethod: 'analytics'
				});
			}
			if (instantGlobals.wgARecoveryEngineCustomLog) {
				try {
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open('GET', customLogEndpoint + type, true);
					xmlHttp.send();
				} catch (e) {
					log(['track', e], log.levels.error, logGroup);
				}
			}
			win._sp_.trackingSent = true;
		}
	}

	function verifyContent() {
		var wikiaArticle = doc.getElementById('WikiaArticle'),
			display = wikiaArticle.currentStyle ?
				wikiaArticle.currentStyle.display :
				getComputedStyle(wikiaArticle, null).display;

		if (display === 'none') {
			track('css-display-none');
		}
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
		track: track,
		verifyContent: verifyContent,
		wasCalled: isEnabled
	};
});
