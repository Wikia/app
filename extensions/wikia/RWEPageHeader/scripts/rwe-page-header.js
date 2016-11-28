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
		$('.rwe-page-header-nav__link, #searchInputWrapperRWE').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});

		$('.rwe-page-header-nav__element-dropdown').click(function(event) {
			event.preventDefault();
		});

		$('.rwe-page-header-nav__dropdown-first-level-item:not(:first-child)')
			.children('.rwe-page-header-nav__dropdown-second-level').hide();

		$('.rwe-page-header-nav__dropdown-second-level-item:not(:first-child)')
			.children('.rwe-page-header-nav__dropdown-third-level').hide();

		$('.rwe-page-header-nav__dropdown-first-level-item').hover(function() {
			$(this).children('.rwe-page-header-nav__dropdown-second-level').show();
			$(this).siblings().children('.rwe-page-header-nav__dropdown-second-level').hide();
		});

		$('.rwe-page-header-nav__dropdown-second-level-item').hover(function() {
			$(this).children('.rwe-page-header-nav__dropdown-third-level').show();
			$(this).siblings().children('.rwe-page-header-nav__dropdown-third-level').hide();
		});
	});
});
