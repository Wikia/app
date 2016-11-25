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
		$('.rwe-page-header__nav-element-dropdown').hover(function () {
			$(this).addClass('rwe-page-header__nav-element--active');
			$('.rwe-page-header__dropdown[data-category=' +
				$(this).children('.rwe-page-header__nav-link').data('tracking') + ']').show();
		}, function () {
			$(this).removeClass('rwe-page-header__nav-element--active');
			$('.rwe-page-header__dropdown[data-category=' +
				$(this).children('.rwe-page-header__nav-link').data('tracking') + ']').hide();
		});

		$('.rwe-page-header__dropdown').hover(function () {
			$('*[data-tracking=' + $(this).data('category') + ']').parent('.rwe-page-header__nav-element')
				.addClass('rwe-page-header__nav-element--active');
			$(this).show();
		}, function () {
			$('*[data-tracking=' + $(this).data('category') + ']').parent('.rwe-page-header__nav-element')
				.removeClass('rwe-page-header__nav-element--active');
			$(this).hide();
		});

		$('.rwe-page-header__nav-link').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});
	});
});
