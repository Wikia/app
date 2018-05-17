define('wikia.trackingOptIn', [
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.trackingOptInModal'
], function (instantGlobals, lazyQueue, log, trackingOptInModal) {
	var optIn = false,
		logGroup = 'wikia.trackingOptIn',
		userConsentQueue = [];

	lazyQueue.makeQueue(userConsentQueue, function (callback) {
		callback(optIn);
	});

	function init() {
		if (instantGlobals.wgEnableTrackingOptInModal) {
			log('Using tracking opt in modal', log.levels.info, logGroup);
			trackingOptInModal.render({
				countriesRequiringPrompt: ['us'], // TODO provide full list of countries
				country: 'us', // TODO provide geo from cookie
				onAcceptTracking: function () {
					optIn = true;
					userConsentQueue.start();
					log('User opted in', log.levels.debug, logGroup);
				},
				onRejectTracking: function () {
					userConsentQueue.start();
					log('User opted out', log.levels.debug, logGroup);
				},
				zIndex: 9999999
			});
		} else {
			optIn = true;
			userConsentQueue.start();
			log('Running queue without tracking opt in modal', log.levels.info, logGroup);
		}
	}

	function isOptedIn() {
		log(['isOptedIn', optIn], log.levels.info, logGroup);
		return optIn;
	}

	function pushToUserConsentQueue(callback) {
		userConsentQueue.push(callback);
	}

	return {
		init: init,
		isOptedIn: isOptedIn,
		pushToUserConsentQueue: pushToUserConsentQueue
	};
});
