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
			$(this).parent('.rwe-page-header__nav-element')
				.addClass('rwe-page-header__nav-element--active');
		}, function () {
			$(this).parent('.rwe-page-header__nav-element')
				.removeClass('rwe-page-header__nav-element--active');
		});

		$('.rwe-page-header__nav-link').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});
	});
});
