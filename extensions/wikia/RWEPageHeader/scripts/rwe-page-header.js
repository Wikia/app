require(['wikia.window', 'jquery', 'wikia.tracker', 'wikia.onScroll'], function (window, $, tracker, onScroll) {
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



		var $globalNav = $('.wds-global-navigation-wrapper');
		var $notificationsWrapper = $('.banner-notifications-wrapper');

		$notificationsWrapper.detach();
		$notificationsWrapper.insertAfter($globalNav);

		window.BannerNotification.prototype.onShow = window.BannerNotification.prototype.show;


		window.BannerNotification.prototype.show = function() {
			this.onShow();

			var $notificationsWrapper = $('.banner-notifications-wrapper');

			$notificationsWrapper.detach();
			$notificationsWrapper.insertAfter($globalNav);

			return this;
		};
	});
});
