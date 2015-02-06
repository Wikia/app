require(['jquery', 'wikia.window'], function ($, win) {
	'use strict';
	var $accountNavigation = $('#AccountNavigation'),
		$globalNavigation = $('#globalNavigation');

	$(function () {
		$(win).on('resize', $.throttle(50, function() {
			$accountNavigation.removeClass('active');
		}));
		$globalNavigation.on('user-login-menu-opened', function() {
			win.WallNotifications.setNotificationsHeight();
		});


	});
});
