$(function() {
	'use strict';

	if (window.wgUserName) {
		require(['headroom'], function(Headroom) {
			var headroom = new Headroom(
				document.getElementById('globalNavigation'),
				{
					offset: 55,
					onPin: function() {
						// Don't cache selector because notifications can appear after page load
						$('.banner-notifications-wrapper').css('top', 55);
					},
					onUnpin: function() {
						$('.banner-notifications-wrapper').css('top', 0);
					}
				}
			);

			headroom.init();
		});
	}
});
