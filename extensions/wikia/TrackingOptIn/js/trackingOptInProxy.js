define('wikia.trackingOptIn', [
	'wikia.log',
	'wikia.window',
], function (log, win) {
	var optIn,
		logGroup = 'wikia.trackingOptIn - proxy';

	win.M.trackingQueue.push(function (isOptedIn) {
		optIn = isOptedIn;
		log('User opted ' + (optIn ? 'in' : 'out'), log.levels.debug, logGroup);
	});

	function init() {}

	function pushToUserConsentQueue(callback) {
		win.M.trackingQueue.push(callback);
	}

	function isOptedIn() {
		log(['isOptedIn - proxy', optIn], log.levels.info, logGroup);
		return optIn;
	}

	return {
		init: init,
		isOptedIn: isOptedIn,
		pushToUserConsentQueue: pushToUserConsentQueue
	}
});
