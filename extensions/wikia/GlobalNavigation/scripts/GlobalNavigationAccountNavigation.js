require(['jquery', 'wikia.window'], function ($, win) {
	'use strict';
	var $globalNavigation = $('#globalNavigation');

	$(function () {
		if (win.WallNotifications) {
			$(win).on('resize', $.throttle(50, function() {
				win.WallNotifications.setNotificationsHeight();
			}));
			$globalNavigation.on('user-login-menu-opened', function() {
				win.WallNotifications.setNotificationsHeight();
			});
		}
	});
});
