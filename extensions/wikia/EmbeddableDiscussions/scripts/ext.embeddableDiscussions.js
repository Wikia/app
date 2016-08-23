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
			  hasUpvoted = event.currentTarget.getAttribute('data-hasUpvoted') === '1',
			  $svg = $($(event.currentTarget).children()[0]),
			  verb = hasUpvoted ? 'DELETE' : 'POST';

			if (!mw.user.anonymous()) {
				if (hasUpvoted) {
					$svg.attr('class', 'embeddable-discussions-upvote-icon');
					event.currentTarget.setAttribute('data-hasUpvoted', '0');
				}
				else {
					$svg.attr('class', 'embeddable-discussions-upvote-icon-active');
					event.currentTarget.setAttribute('data-hasUpvoted', '1');
				}

				$.ajax({
					type: verb,
					url: upvoteUrl,
					xhrFields: {
						withCredentials: true
					},
				});
			}

			event.preventDefault();
		});
	});
});
