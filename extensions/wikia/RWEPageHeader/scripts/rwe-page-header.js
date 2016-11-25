require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var track = function (data) {
		tracker.track(window.Object.assign({
			action: tracker.ACTIONS.CLICK,
			category: 'rwe-page-header',
			trackingMethod: 'analytics'
		}, data));
	};

	$(function () {
		$('.rwe-page-header--dropdown').hover(function () {
			$(this).addClass('rwe-page-header--active');
		}, function () {
			$(this).removeClass('rwe-page-header--active');
		});

		$('.rwe-page-header-nav__link').on('click', function () {
			track({
				label: $(this).data().tracking
			});
		});
	});
});
