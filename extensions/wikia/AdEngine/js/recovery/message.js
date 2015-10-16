/*global define*/
define('ext.wikia.adEngine.recovery.message', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'jquery',
	'wikia.document',
	'wikia.loader',
	'wikia.localStorage',
	'wikia.location',
	'wikia.log',
	'wikia.mustache',
	'wikia.window'
], function (
	adTracker,
	recoveryHelper,
	$,
	doc,
	loader,
	localStorage,
	location,
	log,
	mustache,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.recovery.message',
		localStorageKey = 'rejectedRecoveredMessage',
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
		messageContainer.hide();
		localStorage.setItem(localStorageKey, true);
	}

	function isRejected() {
		return !!localStorage.getItem(localStorageKey);
	}

	function getTemplate() {
		var templatePath = 'extensions/wikia/AdEngine/templates/recovered_message.mustache';

		return $.when(
			loader({
				type: loader.MULTI,
				resources: {
					mustache: templatePath
				}
			})
		).then(function (response) {
			return response.mustache[0];
		}).fail(function () {
			log(['recoveredAdsMessage.getTemplate', 'Unable to load template', templatePath], 'debug', logGroup);
		});
	}

	function createMessage(uniqueClassName) {
		return getTemplate().then(function (template) {
			var params = {
					positionClass: 'recovered-message-' + uniqueClassName,
					header: headerText,
					text: messageText
				};

			return $(mustache.render(template, params));
		}).then(function (messageContainer) {
			messageContainer.find('.icon,.action-accept').on('click', accept);
			messageContainer.find('.close-button').on('click', function () {
				reject(messageContainer);
			});

			return messageContainer;
		});
	}

	function injectTopMessage() {
		log('recoveredAdsMessage.recover - injecting top message', 'debug', logGroup);
		createMessage('top').done(function (messageContainer) {
			$('#WikiaTopAds').before(messageContainer);
		});
	}

	function injectRightRailMessage() {
		log('recoveredAdsMessage.recover - injecting right rail message', 'debug', logGroup);
		createMessage('right-rail').done(function (messageContainer) {
			$('#WikiaRail').prepend(messageContainer);
		});
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
