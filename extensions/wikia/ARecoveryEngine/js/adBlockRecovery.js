/*global define, Wikia*/
define('ext.wikia.aRecoveryEngine.adBlockRecovery', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	adBlockDetection,
	doc,
	instantGlobals,
	log,
	win
) {
	'use strict';

	var customLogEndpoint = win.wgScriptPath + '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
		logGroup = 'ext.wikia.aRecoveryEngine.adBlockRecovery';

	function getName() {
		return 'adBlockRecovery';
	}

	/**
	 * Mark module as responded not matter if adblock is blocking
	 * @param callback
	 */
	function addResponseListener(callback) {
		adBlockDetection.addOnBlockingCallback(callback);
		adBlockDetection.addOnNotBlockingCallback(callback);
	}

	function isEnabled() {
		var context = adContext.getContext(),
			enabled = context.opts.pageFairRecovery ||
				context.opts.instartLogicRecovery;

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
				sendCustomLog(type);
			}
			win._sp_.trackingSent = true;
		}
	}

	function sendCustomLog(type) {
		var xmlHttp = new XMLHttpRequest();

		try {
			xmlHttp.open('GET', customLogEndpoint + type, true);
			xmlHttp.send();
		} catch (e) {
			log(['track', e], log.levels.error, logGroup);
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
		addResponseListener: addResponseListener,
		isEnabled: isEnabled,
		getName: getName,
		track: track,
		verifyContent: verifyContent,
		wasCalled: isEnabled
	};
});
