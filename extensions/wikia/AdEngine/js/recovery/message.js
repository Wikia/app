/*global define*/
define('ext.wikia.adEngine.recovery.message', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'jquery',
	'mw',
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
	mw,
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
		localStorageKey = 'rejectedRecoveredMessage';

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

	function getAssets() {
		var templatePath = 'extensions/wikia/AdEngine/templates/recovered_message.mustache',
			messagePackage = 'AdEngineRecoveryMessage';

		return $.when(
			loader({
				type: loader.MULTI,
				resources: {
					messages: messagePackage,
					mustache: templatePath
				}
			})
		).then(function (assets) {
			mw.messages.set(assets.messages);
			return assets;
		}).fail(function () {
			log([
				'recoveredAdsMessage.getAssets', 'Unable to load template or messages',
				templatePath,
				messagePackage
			], 'debug', logGroup);
		});
	}

	function createMessage(uniqueClassName) {
		return getAssets().then(function (assets) {
			var template = assets.mustache[0],
				text = mw.message('adengine-recovery-message-blocking-message-a').rawParams([
					'<a class="action-accept">' +
						mw.message('adengine-recovery-message-blocking-click').escaped() +
					'</a>'
				]).escaped(),
				params = {
					positionClass: 'recovered-message-' + uniqueClassName,
					header: mw.message('adengine-recovery-message-blocking-welcome').text(),
					text: text
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
