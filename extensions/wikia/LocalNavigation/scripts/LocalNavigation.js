(function(window) {
	'use strict';

	var entryPoint = window.document.getElementById('contributeEntryPoint'), openMenu, closeMenu;

	openMenu = function() {
		entryPoint.classList.add('active');
	};

	closeMenu = function() {
		entryPoint.classList.remove('active');
	};

	if ( !window.ontouchstart ) {
		window.delayedHover(
			entryPoint,
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu
			}
		);
	} else {
		entryPoint.click(openMenu);
	}

})(window);
