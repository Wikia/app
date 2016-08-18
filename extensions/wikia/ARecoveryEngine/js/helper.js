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
		onBlockingEventsQueue = [],
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'LEFT_SKYSCRAPER_2',
			'LEFT_SKYSCRAPER_3'
		];

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

	function isRecoverable(slotName) {
		return isRecoveryEnabled() && isBlocking() && recoverableSlots.indexOf(slotName) !== -1;
	}

	function removeSlotFromList(slotName) {
		var index = recoverableSlots.indexOf(slotName);

		if (index !== -1) {
			recoverableSlots.splice(index, 1);
		}
	}

	function track(type) {
		if (win._sp_ && !win._sp_.trackingSent) {
			if (win.Wikia && win.Wikia.Tracker) {
				win.Wikia.Tracker.track({
					'eventName': 'ads.recovery',
					'ga_category': 'ads-recovery-blocked',
					'ga_action': win.Wikia.Tracker.ACTIONS.IMPRESSION,
					'ga_label': type,
					'trackingMethod': 'analytics'
				});
			}
			if (instantGlobals.wgARecoveryEngineCustomLog) {
				try {
					var xmlHttp = new win.XMLHttpRequest();
					xmlHttp.open('GET', customLogEndpoint+type, true);
					xmlHttp.send();
				} catch (ignore) {}
			}
			win._sp_.trackingSent = true;
		}
	}

	function verifyContent() {
		var wikiaArticle = doc.getElementById('WikiaArticle'),
			display = wikiaArticle.currentStyle ?
				wikiaArticle.currentStyle.display : win.getComputedStyle(wikiaArticle, null).display;

		if (display === 'none') {
			track('css-display-none');
		}
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		initEventQueue: initEventQueue,
		isBlocking: isBlocking,
		isRecoverable: isRecoverable,
		removeSlotFromList: removeSlotFromList,
		track: track,
		verifyContent: verifyContent
	};
});
