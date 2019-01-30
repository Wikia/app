/*global define*/
define('wikia.trackingOptIn', [
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.trackingOptInModal'
], function (instantGlobals, lazyQueue, log, trackingOptInModal) {
	var modalInstance,
		optIn = false,
		geoRequiresConsent = true,
		logGroup = 'wikia.trackingOptIn';

	window.Wikia.consentQueue = window.Wikia.consentQueue || [];

	lazyQueue.makeQueue(window.Wikia.consentQueue, function (callback) {
		callback(optIn, geoRequiresConsent);
	});

	function init() {
		if (instantGlobals.wgEnableTrackingOptInModal) {
			log('Using tracking opt in modal', log.levels.info, logGroup);
			var instance = trackingOptInModal.init({
				onAcceptTracking: function () {
					optIn = true;
					window.Wikia.consentQueue.start();
					log('User opted in', log.levels.debug, logGroup);
				},
				onRejectTracking: function () {
					window.Wikia.consentQueue.start();
					log('User opted out', log.levels.debug, logGroup);
				},
				zIndex: 9999999
			});
			geoRequiresConsent = instance.geoRequiresTrackingConsent();
			modalInstance = instance;
		} else {
			optIn = true;
			geoRequiresConsent = false;
			window.Wikia.consentQueue.start();
			log('Running queue without tracking opt in modal', log.levels.info, logGroup);
		}
	}

	function isOptedIn() {
		log(['isOptedIn', optIn], log.levels.info, logGroup);
		return optIn;
	}

	function pushToUserConsentQueue(callback) {
		window.Wikia.consentQueue.push(callback);
	}

	function geoRequiresTrackingConsent() {
		return geoRequiresConsent;
	}

	function reset() {
		if (instantGlobals.wgEnableTrackingOptInModal) {
			modalInstance.reset();
		}
	}

	return {
		init: init,
		isOptedIn: isOptedIn,
		pushToUserConsentQueue: pushToUserConsentQueue,
		geoRequiresTrackingConsent: geoRequiresTrackingConsent,
		reset: reset
	};
});
