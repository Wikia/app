/*global require*/
require(['wikia.cmp', 'wikia.trackingOptInModal', 'mw'], function (cmp, trackingOptInModal, mw) {
	'use strict';

	function resetTrackingSettings() {
		cmp.reset();
		trackingOptInModal.init({ zIndex: 9999999 }).reset();
	}

	if (document.readyState !== 'loading') {
		resetTrackingSettings();
	} else {
		document.addEventListener('DOMContentLoaded', resetTrackingSettings);
	}
});
