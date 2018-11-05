/*global define*/
define('wikia.trackingOptIn', [
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window',
], function (lazyQueue, log, win) {
	var optIn,
		logGroup = 'wikia.trackingOptIn - proxy',
		queue;

	init();

	function init() {
		queue = doesMobileWikiQueueExist() ? initProxyQueue() : initFakeQueue();
	}

	function doesMobileWikiQueueExist() {
		return typeof win.M !== 'undefined' && typeof win.M.trackingQueue !== 'undefined';
	}

	function initFakeQueue() {
		log('Init fake queue', log.levels.debug, logGroup);

		var fakeConsentQueue = [];
		lazyQueue.makeQueue(fakeConsentQueue, function (callback) {
			callback(optIn);
		});
		optIn = true;
		fakeConsentQueue.start();

		return fakeConsentQueue;
	}

	function initProxyQueue() {
		log('Init proxy queue', log.levels.debug, logGroup);

		win.M.trackingQueue.push(function (isOptedIn) {
			optIn = isOptedIn;
			log('User opted ' + (optIn ? 'in' : 'out'), log.levels.debug, logGroup);
		});

		return win.M.trackingQueue;
	}

	function isOptedIn() {
		log(['isOptedIn - proxy', optIn], log.levels.info, logGroup);
		return optIn;
	}

	function pushToUserConsentQueue(callback) {
		queue.push(callback);
	}

	function geoRequiresTrackingConsent() {
		if (win.M === 'undefined') {
			return true;
		}

		if (typeof win.M.geoRequiresConsent !== 'undefined') {
			return win.M.geoRequiresConsent;
		}

		if (typeof win.M.continent !== 'undefined') {
			return win.M.continent === 'EU';
		}

		return true;
	}

	function reset() {
		if (win.M.resetTrackingOptIn) {
			win.M.resetTrackingOptIn();
		}
	}

	return {
		init: function () {
			log(['Placeholder for init', optIn], log.levels.info, logGroup);
		},
		isOptedIn: isOptedIn,
		pushToUserConsentQueue: pushToUserConsentQueue,
		geoRequiresTrackingConsent: geoRequiresTrackingConsent,
		reset: reset
	}
});
