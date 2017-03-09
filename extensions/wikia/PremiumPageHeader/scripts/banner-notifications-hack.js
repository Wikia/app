require(['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	function moveBannerNotifications() {
		var $globalNav = $('.wds-global-navigation-wrapper'),
			$notificationsWrapper = $('.banner-notifications-wrapper');

		$notificationsWrapper.detach();
		$notificationsWrapper.insertAfter($globalNav);

		window.BannerNotification.prototype.onShow = window.BannerNotification.prototype.show;

		window.BannerNotification.prototype.show = function () {
			this.onShow();

			var $notificationsWrapper = $('.banner-notifications-wrapper');

			$notificationsWrapper.detach();
			$notificationsWrapper.insertAfter($globalNav);

			return this;
		};
	}

	$(function () {
		// FIXME: run it only if experiment is active
		moveBannerNotifications();
	});
});
