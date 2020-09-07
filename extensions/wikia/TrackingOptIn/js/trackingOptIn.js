/*global define*/
define('wikia.trackingOptIn', [
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.trackingOptInModal'
], function (lazyQueue, log, trackingOptInModal) {
	var gdprInstance,
		ccpaInstance,
		optIn = false,
		saleOptOut = false,
		geoRequiresConsent = true,
		geoRequiresSignal = true,
		logGroup = 'wikia.trackingOptIn';

	window.Wikia.consentQueue = window.Wikia.consentQueue || [];

	lazyQueue.makeQueue(window.Wikia.consentQueue, function (callback) {
		callback(optIn, geoRequiresConsent, saleOptOut, geoRequiresSignal);
	});

	function init() {
		log('Using tracking opt in modal', log.levels.info, logGroup);

		var instances = trackingOptInModal.init({
			isSubjectToCcpa: !!window.wgUserIsSubjectToCcpa,
			enableCCPAinit: true,
			onAcceptTracking: function () {
				optIn = true;
				window.Wikia.consentQueue.start();
				log('User opted in', log.levels.debug, logGroup);
			},
			onRejectTracking: function () {
				optIn = false;
				window.Wikia.consentQueue.start();
				log('User opted out', log.levels.debug, logGroup);
			},
			zIndex: 9999999
		});
		gdprInstance = instances.gdpr;
		geoRequiresConsent = gdprInstance.geoRequiresTrackingConsent();

		ccpaInstance = instances.ccpa;
		saleOptOut = !!ccpaInstance.hasUserProvidedSignal();
		geoRequiresSignal = ccpaInstance.geoRequiresUserSignal();
	}

	function isOptedIn() {
		log(['isOptedIn', optIn], log.levels.info, logGroup);
		return optIn;
	}

	function isOptOutSale() {
		log(['isOptOutSale', saleOptOut], log.levels.info, logGroup);
		return saleOptOut;
	}

	function pushToUserConsentQueue(callback) {
		window.Wikia.consentQueue.push(callback);
	}

	function geoRequiresTrackingConsent() {
		return geoRequiresConsent;
	}

	function geoRequiresUserSignal() {
		return geoRequiresSignal;
	}

	function reset() {
		gdprInstance.reset();
	}

	return {
		init: init,
		isOptedIn: isOptedIn,
		isOptOutSale: isOptOutSale,
		pushToUserConsentQueue: pushToUserConsentQueue,
		geoRequiresTrackingConsent: geoRequiresTrackingConsent,
		geoRequiresUserSignal: geoRequiresUserSignal,
		reset: reset
	};
});
