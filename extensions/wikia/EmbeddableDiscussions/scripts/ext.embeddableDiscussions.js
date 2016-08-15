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

		$('.upvote').click(function(event) {
			var upvoteUrl = event.currentTarget.getAttribute('data-url'),
				svg = $( event.currentTarget ).children()[0];

			$(svg).attr('class', 'embeddable-discussions-upvote-icon-active');

			$.ajax({
				type: 'POST',
				url: upvoteUrl,
				xhrFields: {
					withCredentials: true
				},
			}).fail(function() {
				$(svg).attr('class', 'embeddable-discussions-upvote-icon');
			});

			event.preventDefault();
		});

		$('.share').click(function(event) {
			var label = event.currentTarget.getAttribute('data-id');

			// fixme: show share icons

			event.preventDefault();
		});
	});
});
