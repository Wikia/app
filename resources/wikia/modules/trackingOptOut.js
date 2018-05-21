/*global define*/
/**
 * AMD module checking tracking opt-out
 */
define('wikia.trackingOptOut', [
	'wikia.querystring',
	'wikia.trackingOptIn',
	'wikia.window'
], function(Querystring, trackingOptIn, context) {
	'use strict';

	var qs = new Querystring(),
		notOptedOut = null,
		trackingBlacklist = null;

	function isUrlParameterNotSet(parameter) {
		return !parseInt(qs.getVal(parameter, '0'), 10);
	}

	function isNotOptedOut() {
		if (notOptedOut === null) {
			notOptedOut = isUrlParameterNotSet('trackingoptout');
		}

		return notOptedOut;
	}

	function isBlacklisted(tracking) {
		if (trackingBlacklist === null && context.Wikia && context.Wikia.TrackingOptOut) {
			trackingBlacklist = context.Wikia.TrackingOptOut;
		}

		return trackingBlacklist && trackingBlacklist.hasOwnProperty(tracking) && trackingBlacklist[tracking];
	}

	/**
	 * @deprecated use wikia.trackingOptIn
	 * @param tracker
	 * @returns {*|boolean}
	 */
	function isOptedOut(tracker) {
		return isBlacklisted(tracker) && !isNotOptedOut();
	}

	/**
	 * @deprecated use wikia.trackingOptIn
	 * @param tracker
	 * @param thenCall
	 */
	function ifTrackerNotOptedOut(tracker, thenCall) {
		if (!isBlacklisted(tracker) || isNotOptedOut()) {
			thenCall();
		}
	}

	/**
	 * @deprecated use wikia.trackingOptIn
	 * @param thenCall
	 */
	function ifNotOptedOut(thenCall) {
		if (isNotOptedOut()) {
			thenCall();
		}
	}

	trackingOptIn.pushToUserConsentQueue(function (optIn) {
		notOptedOut = optIn;
	});

	return {
		isOptedOut: isOptedOut,
		ifTrackerNotOptedOut: ifTrackerNotOptedOut,
		ifNotOptedOut: ifNotOptedOut
	};
});
