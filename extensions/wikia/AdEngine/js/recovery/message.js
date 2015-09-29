define('ext.wikia.adEngine.recovery.message', [
	'ext.wikia.adEngine.recovery.helper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (
	recoveryHelper,
	doc,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.recovery.message',
		wikiaRailId = 'WikiaRail';

	function addRecoveryCallback() {
		recoveryHelper.addOnBlockingCallback(function () {
			recover();
		});
	}

	function injectRightRailRecoveredAd() {
		var rail = doc.getElementById(wikiaRailId),
			p = doc.createElement('p');

		log('recoveredAdsMessage.recover - injecting right rail recovery', 'debug', logGroup);
		p.textContent = 'Hello world!';
		rail.insertBefore(p, rail.firstChild);
	}

	function recover() {
		log('recoveredAdsMessage - ad blockers found', 'debug', logGroup);

		if (doc.readyState === 'complete') {
			log('recoveredAdsMessage.recover - executing inject functions', 'debug', logGroup);
			injectRightRailRecoveredAd();
		} else {
			log('recoveredAdsMessage.recover - registering onLoad', 'debug', logGroup);
			win.addEventListener('load', injectRightRailRecoveredAd);
		}
	}

	return {
		addRecoveryCallback: addRecoveryCallback
	};
});
