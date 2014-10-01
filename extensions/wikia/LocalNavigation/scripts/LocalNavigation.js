(function(window) {
	'use strict';

	var entryPoint = window.document.getElementById('contributeEntryPoint'),
		dropdown = window.document.getElementById('contributeDropdown'),
		openMenu,
		closeMenu;

	openMenu = function() {
		dropdown.classList.add('active');
	};

	closeMenu = function() {
		dropdown.classList.remove('active');
	};

	if ( !window.ontouchstart ) {
		window.delayedHover(
			entryPoint,
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu,
				activateOnClick: true
			}
		);
	} else {
		entryPoint.click(openMenu);
	}

})(window);
