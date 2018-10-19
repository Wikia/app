/*global require*/
require(['wikia.trackingOptIn'], function (trackingOptIn) {
	'use strict';

	function resetTrackingSettings() {
		trackingOptIn.reset();
	}

	if (document.readyState !== 'loading') {
		resetTrackingSettings();
	} else {
		document.addEventListener('DOMContentLoaded', resetTrackingSettings);
	}
});
