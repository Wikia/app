/*global define, setTimeout*/
define('ext.wikia.adEngine.recovery.message', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'jquery',
	'mw',
	'wikia.abTest',
	'wikia.document',
	'wikia.loader',
	'wikia.localStorage',
	'wikia.location',
	'wikia.log',
	'wikia.mustache',
	'wikia.tracker',
	'wikia.window'
], function (
	adTracker,
	recoveryHelper,
	$,
	mw,
	abTest,
	doc,
	loader,
	localStorage,
	location,
	log,
	mustache,
	tracker,
	win
) {
	'use strict';

	var abTestConfig = {
			'experimentName': 'PROJECT_43',
			'topGroupNames': {
				'GROUP_1': 'a',
				'GROUP_2': 'b'
			},
			'rightRailGroupNames': {
				'GROUP_3': 'a',
				'GROUP_4': 'b'
			}
		},
		logGroup = 'ext.wikia.adEngine.recovery.message',
		localStorageKey = 'rejectedRecoveredMessage';

	function track(action, trackerAction) {
		tracker.track({
			category: 'ads-recovery-message',
			action: trackerAction,
			label: action,
			value: 0,
			trackingMethod: 'analytics'
		});
		adTracker.track('recovery/message', action);
	}

	function accept() {
		track('accept', win.Wikia.Tracker.ACTIONS.CLICK);
		setTimeout(function () {
			location.reload();
		}, 200);
	}

	function reject(messageContainer) {
		track('reject', win.Wikia.Tracker.ACTIONS.CLICK);
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

	function createMessage(uniqueClassName, messageVariant) {
		return getAssets().then(function (assets) {
			var template = assets.mustache[0],
				//adengine-recovery-message-blocking-message-a
				//adengine-recovery-message-blocking-message-b
				text = mw.message('adengine-recovery-message-blocking-message-' + messageVariant).rawParams([
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

	function injectTopMessage(messageVariant) {
		log('recoveredAdsMessage.recover - injecting top message', 'debug', logGroup);
		createMessage('top', messageVariant).done(function (messageContainer) {
			track('impression', win.Wikia.Tracker.ACTIONS.IMPRESSION);
			$('#WikiaPageHeader').append(messageContainer);
		});
	}

	function injectRightRailMessage(messageVariant) {
		log('recoveredAdsMessage.recover - injecting right rail message', 'debug', logGroup);
		createMessage('right-rail', messageVariant).done(function (messageContainer) {
			track('impression', win.Wikia.Tracker.ACTIONS.IMPRESSION);
			$('#WikiaPageHeader').append(messageContainer);
		});
	}

	function injectMessage() {
		var group = abTest.getGroup(abTestConfig.experimentName);

		if (group && abTestConfig.topGroupNames.hasOwnProperty(group)) {
			injectTopMessage(abTestConfig.topGroupNames[group]);
		}

		if (group && abTestConfig.rightRailGroupNames.hasOwnProperty(group)) {
			injectRightRailMessage(abTestConfig.rightRailGroupNames[group]);
		}

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
