require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'page-header-test-group',
		trackingMethod: 'analytics'
	});

	$(function () {
		$('.pph-article-header-tracking a, .pph-article-header-tracking .pph-track').on('click', function () {
			var data = $(this).data('tracking');
			if (data) {
				track({
					action: tracker.ACTIONS.CLICK,
					label: data
				});
			}
		});
	});
});
