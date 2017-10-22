require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'page-header',
		trackingMethod: 'analytics'
	});

	$(function () {
		$('#PageHeader').find('[data-tracking]').on('click', function () {
			var label = $(this).data('tracking');

			if (label) {
				track({
					action: tracker.ACTIONS.CLICK,
					label: label
				});
			}
		});
	});
});
