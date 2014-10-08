(function(window) {
	'use strict';

	window.addEventListener('load', function() {
		var openMenu, closeMenu, entryPoint = window.document.getElementById('contributeEntryPoint');

		openMenu = function() {
			this.classList.add('active');
		};

		closeMenu = function() {
			this.classList.remove('active');
		};

		if (!window.Wikia.isTouchScreen()) {
			window.delayedHover(
				entryPoint,
				{
					onActivate: openMenu,
					onDeactivate: closeMenu
				}
			);
		} else {
			entryPoint.addEventListener('click', openMenu);
		}
	});
})(window);
