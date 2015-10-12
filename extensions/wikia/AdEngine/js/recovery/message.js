/*global define*/
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
		wikiaTopAdsId = 'WikiaTopAds',
		wikiaRailId = 'WikiaRail';

	function createMessage(uniqueClassName) {
		var className = 'recovered-message',
			div = doc.createElement('div');

		div.textContent = 'Hello world!';
		div.classList.add(className, className + '-' + uniqueClassName);
		return div;
	}

	function injectTopMessage() {
		var topAds = doc.getElementById(wikiaTopAdsId),
			message = createMessage('top');

		log('recoveredAdsMessage.recover - injecting top message', 'debug', logGroup);
		topAds.parentNode.insertBefore(message, topAds);
	}

	function injectRightRailMessage() {
		var rail = doc.getElementById(wikiaRailId),
			message = createMessage('right-rail');

		log('recoveredAdsMessage.recover - injecting right rail message', 'debug', logGroup);
		rail.insertBefore(message, rail.firstChild);
	}

	function injectMessage() {
		injectTopMessage();
		injectRightRailMessage();
	}

	function recover() {
		log('recoveredAdsMessage - ad blockers found', 'debug', logGroup);

		if (doc.readyState === 'complete') {
			log('recoveredAdsMessage.recover - executing inject functions', 'debug', logGroup);
			injectMessage();
		} else {
			log('recoveredAdsMessage.recover - registering onLoad', 'debug', logGroup);
			win.addEventListener('load', injectMessage);
		}
	}

	function addRecoveryCallback() {
		recoveryHelper.addOnBlockingCallback(function () {
			recover();
		});
	}

	return {
		addRecoveryCallback: addRecoveryCallback
	};
});
