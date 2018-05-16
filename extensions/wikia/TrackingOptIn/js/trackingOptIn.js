define('ext.wikia.trackingOptIn', [
	'trackingOptIn',
	'wikia.lazyqueue'
], function (trackingOptIn, lazyQueue) {
	var optIn = false,
		userConsentQueue = [];

	lazyQueue.makeQueue(userConsentQueue, function (callback) {
		callback(optIn);
	});

	function init() {
		trackingOptIn.main({
			countriesRequiringPrompt: ['us'], // TODO provide full list of countries
			country: 'us', // TODO provide geo from cookie
			onAcceptTracking: function () {
				optIn = true;
				userConsentQueue.start();
			},
			onRejectTracking: function () {
				userConsentQueue.start();
			}
		});
	}

	function pushToUserConsentQueue(callback) {
		userConsentQueue.push(callback);
	}

	return {
		init: init,
		pushToUserConsentQueue: pushToUserConsentQueue
	}
});
