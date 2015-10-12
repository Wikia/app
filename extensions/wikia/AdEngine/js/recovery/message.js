/*global define*/
define('ext.wikia.adEngine.recovery.message', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'wikia.document',
	'wikia.localStorage',
	'wikia.location',
	'wikia.log',
	'wikia.window'
], function (
	adTracker,
	recoveryHelper,
	doc,
	localStorage,
	location,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.recovery.message',
		wikiaTopAdsId = 'WikiaTopAds',
		wikiaRailId = 'WikiaRail',
		localstorageKey = 'rejectedRecoveredMessage',
		headerText = 'Hey! It looks like you\'re using ad blocking software!',
		messageText = 'Wikia runs ads so we can keep the lights on and so Wikia will always be free to use. ' +
			'We can bring you fun, free, fan-oriented content until my glorious return to Earh if you ' +
			'<strong>add us to your adblock whitelist</strong>. ' +
			'<a class="action-accept">Click</a> my face to refresh after you\'re done!';

	function accept() {
		adTracker.track('recovery/message', 'accept');
		location.reload();
	}

	function reject(messageContainer) {
		adTracker.track('recovery/message', 'reject');
		messageContainer.style.display = 'none';
		localStorage.setItem(localstorageKey, true);
	}

	function isRejected() {
		return !!localStorage.getItem(localstorageKey);
	}

	function createMessage(uniqueClassName) {
		var className = 'recovered-message',
			container = doc.createElement('div'),
			icon = doc.createElement('img'),
			message = doc.createElement('div'),
			closeButton = doc.createElement('div');

		icon.src = '/skins/oasis/images/recovered_message_icon.png';
		icon.classList.add('icon');
		icon.addEventListener('click', accept);

		closeButton.classList.add('close-button');
		closeButton.addEventListener('click', function () {
			reject(container);
		});

		message.innerHTML = '<div class="dialog-pointer"></div><h3>' + headerText + '</h3><p>' + messageText + '</p>';
		message.classList.add('message');
		message.querySelector('.action-accept').addEventListener('click', accept);
		message.appendChild(closeButton);

		container.classList.add(className, className + '-' + uniqueClassName);
		container.appendChild(icon);
		container.appendChild(message);

		return container;
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
		if (isRejected()) {
			log('recoveredAdsMessage.recover - message already rejected', 'debug', logGroup);
			return;
		}

		recoveryHelper.addOnBlockingCallback(function () {
			recover();
		});
	}

	return {
		addRecoveryCallback: addRecoveryCallback
	};
});
