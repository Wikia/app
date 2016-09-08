$(function() {
	'use strict';

	if (window.wgUserName) {
		require(['headroom'], function(Headroom) {
			var headroom = new Headroom(
				document.getElementById('globalNavigation'),
				{
					offset: 55
				}
			);

			headroom.init();
		});
	}
});
