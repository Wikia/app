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

	$('.community-page-entry-point-module').on('mousedown touchstart', 'a', function () {
		track({
			label: 'enter-button-click',
		});
	});

	// Track impression
	track({
		action: tracker.ACTIONS.IMPRESSION,
		label: 'entry-point-loaded',
	});
});
