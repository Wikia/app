define('wikia.trackingOptIn', [
	'trackingOptIn',
	'wikia.lazyqueue',
	'wikia.log'
], function (trackingOptIn, lazyQueue, log) {
	'use strict';

	var optIn = false,
		userConsentQueue = [],
		logGroup = 'ext.wikia.TrackingOptIn';

	lazyQueue.makeQueue(userConsentQueue, function (callback) {
		callback(optIn);
	});

	function init() {
		log('TrackingOptIn init', log.levels.info, logGroup);

		trackingOptIn.main({
			countriesRequiringPrompt: ['us'], // TODO provide full list of countries
			country: 'us', // TODO provide geo from cookie
			onAcceptTracking: function () {
				optIn = true;
				userConsentQueue.start();
				log(['TrackingOptIn:accept queue started', userConsentQueue], log.levels.info, logGroup);
			},
			onRejectTracking: function () {
				userConsentQueue.start();
				log(['TrackingOptIn:reject queue started', userConsentQueue], log.levels.info, logGroup);
			}
		});
	}

	function pushToUserConsentQueue(callback) {
		userConsentQueue.push(callback);
	}

	return {
		init: init,
		pushToUserConsentQueue: pushToUserConsentQueue
	};
});
