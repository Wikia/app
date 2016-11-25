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
		$('.rwe-page-header-nav__element-dropdown').hover(function () {
			$(this).addClass('rwe-page-header-nav__element--active');
			$('.rwe-page-header-nav__dropdown[data-category=' +
				$(this).children('.rwe-page-header-nav__link').data('tracking') + ']').show();
		}, function () {
			$(this).removeClass('rwe-page-header-nav__element--active');
			$('.rwe-page-header-nav__dropdown[data-category=' +
				$(this).children('.rwe-page-header-nav__link').data('tracking') + ']').hide();
		});

		$('.rwe-page-header-nav__dropdown').hover(function () {
			$('*[data-tracking=' + $(this).data('category') + ']').parent('.rwe-page-header-nav__element')
				.addClass('rwe-page-header-nav__element--active');
			$(this).show();
		}, function () {
			$('*[data-tracking=' + $(this).data('category') + ']').parent('.rwe-page-header-nav__element')
				.removeClass('rwe-page-header-nav__element--active');
			$(this).hide();
		});

		$('.rwe-page-header-nav__link').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});
	});
});
