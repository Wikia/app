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
		var firstLevelItems = $('.rwe-page-header-nav__dropdown-first-level-item'),
			secondLevelItems = $('.rwe-page-header-nav__dropdown-second-level-item'),
			thirdLevelNotFirst = $('.rwe-page-header-nav__dropdown-second-level-item:not(:first-child)');

		$('.rwe-page-header-nav__link, .rwe-page-header-wordmark_wrapper').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});

		$('.rwe-page-header-nav__element-dropdown > .rwe-page-header-nav__link').on('click', function (e) {
			e.preventDefault();
		});

		$('.rwe-page-header-nav__dropdown-first-level-item:first-child').addClass('item-selected');
		$('.rwe-page-header-nav__dropdown-second-level-item:first-child').addClass('item-selected');

		$('.rwe-page-header-nav__dropdown-first-level-item:not(:first-child)')
			.children('.rwe-page-header-nav__dropdown-second-level').hide();
		thirdLevelNotFirst.children('.rwe-page-header-nav__dropdown-third-level').hide();

		firstLevelItems.hover(function () {
			var self = $(this),
				secondLevel = self.find('.rwe-page-header-nav__dropdown-second-level-item:first-child');

			firstLevelItems.removeClass('item-selected');
			secondLevelItems.removeClass('item-selected');
			self.addClass('item-selected');

			self.siblings().children('.rwe-page-header-nav__dropdown-second-level').hide();
			thirdLevelNotFirst.children('.rwe-page-header-nav__dropdown-third-level').hide();

			self.children('.rwe-page-header-nav__dropdown-second-level').show();
			secondLevel.addClass('item-selected');
			secondLevel.find('.rwe-page-header-nav__dropdown-third-level').show();
		});

		secondLevelItems.hover(function () {
			var self = $(this);

			secondLevelItems.removeClass('item-selected');
			self.addClass('item-selected');
			self.children('.rwe-page-header-nav__dropdown-third-level').show();
			self.siblings().children('.rwe-page-header-nav__dropdown-third-level').hide();
		});
	});
});
