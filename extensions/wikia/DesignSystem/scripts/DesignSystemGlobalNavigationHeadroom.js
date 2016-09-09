$(function() {
	'use strict';

	if (window.wgUserName) {
		require(['headroom'], function(Headroom) {
			var globalNavigation = $('#globalNavigation'),
				globalNavigationHeight = globalNavigation.outerHeight(true),
				headroomConfig = {
					offset: globalNavigationHeight,
					onPin: function() {
						// Don't cache selector because notifications can appear after page load
						$('.banner-notifications-wrapper').css('top', globalNavigationHeight);
					},
					onUnpin: function() {
						$('.banner-notifications-wrapper').css('top', 0);
					}
				},
				headroom = new Headroom(
					globalNavigation.get(0),
					headroomConfig
				),
				globalNavMutationObserver = new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						if (mutation.type === 'attributes' && mutation.attributeName === 'class' && mutation.target.classList.contains('bfaa-pinned')) {
							headroom.offset = globalNavigation.get(0).offsetTop + globalNavigationHeight;
							globalNavMutationObserver.disconnect();
						}
					});
				});

			headroom.init();

			globalNavMutationObserver.observe(globalNavigation.get(0), { attributes: true });
		});
	}
});
