require([
	'jquery',
	'wikia.tracker',
], function ($, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'embeddable-discussions',
		trackingMethod: 'analytics'
	});

	$(function() {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-loaded',
		});

		$('.embeddable-discussions-upvote-area').click(function(event) {
			// fixme: Call upvote API and change to active upvote icon
		});
	});
});
