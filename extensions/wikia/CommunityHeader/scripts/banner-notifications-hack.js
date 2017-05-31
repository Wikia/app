require(['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	function moveBannerNotifications() {
		var $bannerPlaceholder = $('.banner-notifications-placeholder');

		$('.banner-notifications-wrapper').appendTo($bannerPlaceholder);

		window.BannerNotification.prototype.onShow = window.BannerNotification.prototype.show;
		window.BannerNotification.prototype.show = function () {
			this.onShow();
			$('.banner-notifications-wrapper').appendTo($bannerPlaceholder);

			return this;
		};
	}

	$(function () {
		moveBannerNotifications();
	});
});