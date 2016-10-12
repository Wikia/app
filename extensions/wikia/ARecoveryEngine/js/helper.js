/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.helper', [
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

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.helper',
		context = adContext.getContext(),
		customLogEndpoint = '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
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
		log(['isBlocking', !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking)], 'debug', logGroup);
		return !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking);
	}

	function isRecoverable(slotName, recoverableSlots) {
		return isRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
	}

	function track(type) {
		if (win._sp_ && !win._sp_.trackingSent) {
			if (Wikia && Wikia.Tracker) {
				Wikia.Tracker.track({
					eventName: 'ads.recovery',
					ga_category: 'ads-recovery-blocked',
					ga_action: Wikia.Tracker.ACTIONS.IMPRESSION,
					ga_label: type,
					trackingMethod: 'analytics'
				});
			}
			if (instantGlobals.wgARecoveryEngineCustomLog) {
				try {
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open('GET', customLogEndpoint+type, true);
					xmlHttp.send();
				} catch (e) {}
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
		return win._sp_.getSafeUri(url);
	}

	function isSourcePointResultDefined() {
		return win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking !== undefined;
	}

	function runAfterDetection(callback) {
		if (isSourcePointResultDefined()) {
			callback();
		} else {
			doc.addEventListener('sp.blocking', callback);
			doc.addEventListener('sp.not_blocking', callback);
		}
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		getSafeUri: getSafeUri,
		initEventQueue: initEventQueue,
		isBlocking: isBlocking,
		isRecoverable: isRecoverable,
		isRecoveryEnabled: isRecoveryEnabled,
		runAfterDetection: runAfterDetection,
		track: track,
		verifyContent: verifyContent
	};
});
