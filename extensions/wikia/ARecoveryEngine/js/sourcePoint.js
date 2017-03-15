/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePoint', [
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

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
		context = adContext.getContext(),
		customLogEndpoint = '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
		cb = function (callback) {
			callback();
		},
		onBlockingEventsQueue = lazyQueue.makeQueue([], cb),
		onNotBlockingEventsQueue = lazyQueue.makeQueue([], cb),
		recoverableSlots = [
			'TOP_LEADERBOARD',
			'TOP_RIGHT_BOXAD',
			'LEFT_SKYSCRAPER_2',
			'LEFT_SKYSCRAPER_3',
			'INCONTENT_BOXAD_1',
			'BOTTOM_LEADERBOARD',
			'GPT_FLUSH'
		];

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
		var isBlocking = !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking);

		log(['isBlocking', isBlocking], 'debug', logGroup);
		return isBlocking;
	}

	function isSlotRecoverable(slotName) {
		var result = isSourcePointRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;

		log(['isSlotRecoverable', result], log.levels.info, logGroup);
		return result;
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
		isSlotRecoverable: isSlotRecoverable,
		isSourcePointRecoveryEnabled: isSourcePointRecoveryEnabled,
		track: track,
		verifyContent: verifyContent
	};
});
