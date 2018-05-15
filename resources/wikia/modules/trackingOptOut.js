/*global define*/
/**
 * AMD module checking tracking opt-out
 */
define('wikia.trackingOptOut', [
	'wikia.querystring', 'wikia.window'
], function(Querystring, context) {
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
	 * @deprecated use async API
	 * @param tracker
	 * @returns {*|boolean}
	 */
	function isOptedOut(tracker) {
		return isBlacklisted(tracker) && !isNotOptedOut();
	}

	function ifTrackerNotOptedOut(tracker, thenCall) {
		if (!isBlacklisted(tracker) || isNotOptedOut()) {
			thenCall();
		}
	}

	function ifNotOptedOut(thenCall) {
		if (isNotOptedOut()) {
			thenCall();
		}
	}

	return {
		isOptedOut: isOptedOut,
		ifTrackerNotOptedOut: ifTrackerNotOptedOut,
		ifNotOptedOut: ifNotOptedOut
	};
});
