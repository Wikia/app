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
		$('.rwe-page-header-nav__link, .rwe-page-header-wordmark_wrapper').on('click', function (e) {
			track({
				label: $(this).data().tracking
			});
		});

		$('.rwe-page-header-nav__element-dropdown > .rwe-page-header-nav__link').on('click', function (e) {
			e.preventDefault();
		});

		$('.rwe-chat').on('click', function (e) {
			e.preventDefault();
			window.ChatWidget.onClickChatButton($(this).attr('href'));
		});
	});
});
