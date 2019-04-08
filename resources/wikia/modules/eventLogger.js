/*global define*/
define('wikia.eventLogger', [
	'jquery',
	'wikia.window'
], function ($, win) {
	'use strict';

	function logEvent(host, resource, name, description) {
		var isProductionEnv = !win.wgGaStaging;

		if (isProductionEnv) {
			$.ajax({
				url: host + '/event-logger/' + resource,
				type: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				// sends cookie with request, allows for logging beaconId and sessionId
				xhrFields: {
					withCredentials: true
				},
				body: JSON.stringify({
					name: name,
					description: (description || {}),
					client: 'app'
				}),
			});
		}
	}

	function logDebug(host, name, description) {
		logEvent(host, 'debug', name, description);
	}

	function logError(host, name, description) {
		logEvent(host, 'error', name, description);
	}

	return {
		logDebug: logDebug,
		logError: logError
	};
});
