/*global define*/
/**
 * AMD module checking tracking opt-out
 */
define('wikia.trackingOptOut', [
	'wikia.querystring'
], function(Querystring) {
	'use strict';

	var qs = new Querystring(),
		trackingBlacklist = null;

	function isOptOutEnabled() {
		return isUrlParameterSet('trackingoptout');
	}

	function isUrlParameterSet(parameter) {
		return !!parseInt(qs.getVal(parameter, '0'), 10);
	}

	function filterBlacklist(variables) {
		if (window.Wikia && window.Wikia.TrackingOptOut) {
			trackingBlacklist = window.Wikia.TrackingOptOut;

			for (var name in variables) {
				if (trackingBlacklist.hasOwnProperty(name) && variables.hasOwnProperty(name)) {
					variables[name] = trackingBlacklist[name];
				}
			}
		}

		return variables;
	}

	function checkOptOut(variables) {
		if (isOptOutEnabled()) {
			return filterBlacklist(variables);
		}

		return variables;
	}

	return {
		checkOptOut: checkOptOut
	};
});
