require(['wikia.window', 'jquery', 'wikia.tracker', 'wikia.abTest'], function (window, $, tracker, abTest) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'page-header-test-group',
		trackingMethod: 'analytics'
	});

	$(function () {
		if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'PREMIUM') || window.wgUserName) {
			$('.pph-article-header-tracking a, .pph-article-header-tracking .pph-track').on('click', function () {
				var data = $(this).data('tracking');
				if (data) {
					track({
						action: tracker.ACTIONS.CLICK,
						label: data
					});
				}
			});
		}
	});
});
