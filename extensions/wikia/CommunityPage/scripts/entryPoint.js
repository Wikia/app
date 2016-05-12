require([
	'jquery',
	'wikia.tracker',
], function ($, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'community-page-entry-point',
		trackingMethod: 'analytics'
	});

	function initTracking() {
		// Track clicks in contribution module
		$('.community-page-entry-point-module').on('mousedown touchstart', 'a', function () {
			track({
				label: 'enter-button-click',
			});
		});
	}

	$(initTracking);
});
