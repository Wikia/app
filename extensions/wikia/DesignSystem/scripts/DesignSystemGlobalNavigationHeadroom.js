$(function() {
	'use strict';

	if (window.wgUserName) {
		require(['headroom'], function(Headroom) {
			var globalNavigation = document.getElementById('globalNavigation'),
				headroom = new Headroom(
					globalNavigation,
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

			var observer = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
					if (mutation.type === 'attributes' && mutation.attributeName === 'class' && globalNavigation.classList.contains('bfaa-pinned')) {
						console.log('bfAAAA');
					}
				});
			});

			observer.observe(globalNavigation, { attributes: true });

		});
	}
});
