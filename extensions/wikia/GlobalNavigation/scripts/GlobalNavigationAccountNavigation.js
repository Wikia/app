require(['jquery', 'wikia.window'], function ($, win) {
	'use strict';
	var $accountNavigation = $('#AccountNavigation'),
		$globalNavigation = $('#globalNavigation');

	$(function () {
		$(win).on('resize', $.throttle(100, function() {
			win.WallNotifications.setNotificationsHeight();
		}));
		$globalNavigation.on('user-login-menu-opened', function() {
			win.WallNotifications.setNotificationsHeight();
		});


	});
});
