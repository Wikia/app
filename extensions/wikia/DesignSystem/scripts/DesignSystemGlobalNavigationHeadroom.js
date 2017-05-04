$(function() {
	'use strict';

	if (window.wgUserName) {
		require(['headroom'], function(Headroom) {
			var numberOfOpenDropwns = 0,
				globalNavigation = $('#globalNavigation'),
				globalNavigationHeight = globalNavigation.outerHeight(true),
				headroomConfig = {
					offset: globalNavigationHeight,
					onPin: function() {
						// Don't cache selector because notifications can appear after page load
						$('.banner-notifications-wrapper').css('top', globalNavigationHeight);
					},
					onUnpin: function() {
						if (
							numberOfOpenDropwns > 0 ||
							globalNavigation.hasClass('wds-search-is-active')
						) {
							// don't allow to unpin global nav when dropdown is open or search is active
							$(this.elem).addClass(this.classes.pinned).removeClass(this.classes.unpinned);
						} else {
							$('.banner-notifications-wrapper').css('top', 0);
						}

					}
				},
				headroom = new Headroom(
					globalNavigation.get(0),
					headroomConfig
				),
				globalNavMutationObserver = new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						if (
							mutation.type === 'attributes' && mutation.attributeName === 'class' &&
							mutation.target.classList.contains('bfaa-pinned')
						) {
							headroom.offset = globalNavigation.get(0).offsetTop + globalNavigationHeight;
							globalNavMutationObserver.disconnect();
						}
					});
				});

			globalNavigation.on('wdsDropdownOpen', function () {
				numberOfOpenDropwns++;
			}).on('wdsDropdownClose', function () {
				numberOfOpenDropwns--;
			});

			headroom.init();

			globalNavMutationObserver.observe(globalNavigation.get(0), { attributes: true });
		});
	}
});
