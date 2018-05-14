/*global define*/
/**
 * AMD module checking tracking opt-out
 */
define('wikia.trackingOptOut', [
	'wikia.querystring'
], function(Querystring) {
	'use strict';

	var qs = new Querystring(),
		optOutEnabled = null,
		trackingBlacklist = null;

	function isUrlParameterSet(parameter) {
		return !!parseInt(qs.getVal(parameter, '0'), 10);
	}

	function isOptOutEnabled() {
		if (optOutEnabled === null) {
			optOutEnabled = isUrlParameterSet('trackingoptout');
		}

		return optOutEnabled;
	}

	function isBlacklisted(tracking) {
		if (trackingBlacklist === null && window.Wikia && window.Wikia.TrackingOptOut) {
			trackingBlacklist = window.Wikia.TrackingOptOut;
		}

		return trackingBlacklist && trackingBlacklist.hasOwnProperty(tracking) && trackingBlacklist[tracking];
	}

	function isOptedOut(tracking) {
		return isOptOutEnabled() && isBlacklisted(tracking);
	}

	return {
		isOptedOut: isOptedOut
	};
});
