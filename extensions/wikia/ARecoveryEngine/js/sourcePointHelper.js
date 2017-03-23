/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePointHelper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	doc,
	instantGlobals,
	lazyQueue,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.sourcePointHelper',
		context = adContext.getContext(),
		customLogEndpoint = '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
		cb = function (callback) {
			callback();
		},
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
	 * SourcePoint can be enabled only if PF recovery is disabled
	 *
	 * @returns {boolean}
	 */
	function isSourcePointRecoveryEnabled() {
		var enabled = !!context.opts.sourcePointRecovery && !context.opts.pageFairRecovery;

		log(['isSourcePointRecoveryEnabled', enabled, 'debug', logGroup]);
		return enabled;
	}

	function isBlocking() {
		log(['isBlocking', !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking)], 'debug', logGroup);
		return isSourcePointRecoveryEnabled() && !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking);
	}

	function isSourcePointRecoverable(slotName, recoverableSlots) {
		return isSourcePointRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
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
					xmlHttp.open('GET', customLogEndpoint+type, true);
					xmlHttp.send();
				} catch (e) {
					log(['track', e], 'error', logGroup);
				}
			}
			win._sp_.trackingSent = true;
		}
	}

	function verifyContent() {
		var wikiaArticle = doc.getElementById('WikiaArticle'),
			display = wikiaArticle.currentStyle ?
						wikiaArticle.currentStyle.display : getComputedStyle(wikiaArticle, null).display;

		if (display === 'none') {
			track('css-display-none');
		}
	}

	function getSafeUri(url) {
		if (isBlocking()) {
			url = win._sp_.getSafeUri(url);
		}

		return url;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		addOnNotBlockingCallback: addOnNotBlockingCallback,
		getSafeUri: getSafeUri,
		initEventQueues: initEventQueues,
		isBlocking: isBlocking,
		isSourcePointRecoverable: isSourcePointRecoverable,
		isSourcePointRecoveryEnabled: isSourcePointRecoveryEnabled,
		track: track,
		verifyContent: verifyContent
	};
});
