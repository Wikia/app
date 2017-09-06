require(['jquery', 'wikia.tracker'], function ($, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'community-header',
		trackingMethod: 'analytics',
		action: tracker.ACTIONS.CLICK
	});

	$(function () {
		$('.wds-community-header').on('click', '[data-tracking]', function () {
			track({label: this.dataset.tracking});
		});
	});
});
