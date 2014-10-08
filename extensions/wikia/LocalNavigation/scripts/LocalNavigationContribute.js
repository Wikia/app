(function(window, document, wikia) {
	'use strict';

	document.addEventListener('DOMContentLoaded', function() {
		var openMenu, closeMenu, entryPoint = document.getElementById('contributeEntryPoint');

		if (entryPoint) {
			openMenu = function() {
				this.classList.add('active');
			};

			closeMenu = function() {
				this.classList.remove('active');
			};

			if (!wikia.isTouchScreen()) {
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
		}
	});
})(window, document, window.Wikia);
