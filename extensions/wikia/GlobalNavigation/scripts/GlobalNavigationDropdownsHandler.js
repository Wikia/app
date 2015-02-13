define('wikia.globalNavigationDropdowns', ['wikia.window', 'jquery'], function(win, $) {
	'use strict';

	var entryPointIds = ['hubsEntryPoint', 'AccountNavigation', 'notificationsEntryPoint'],
		options = {
			onOpen: Function.prototype,
			onClose: Function.prototype,
			onClick: Function.prototype
		},
		$activeEntryPoint;

	function openDropdown() {
		win.transparentOut.show();
		$activeEntryPoint.addClass('active');
		Function.prototype.call(options.onOpen);
	}

	function closeDropdown() {
		win.transparentOut.hide();
		$activeEntryPoint.removeClass('active');
		Function.prototype.call(options.onClose);
	}

	function toggleDropdown($entryPoint) {

	}

	function attachDropdown($entryPoint, dropdownOpts) {
		$.extend(options, dropdownOpts);
		debugger;
		$activeEntryPoint = $entryPoint;
		win.transparentOut.bindClick(closeDropdown);
		$entryPoint.on('click', options.onClick);
	}

	return {
		openDropdown: openDropdown,
		closeDropdown: closeDropdown,
		toggleDropdown: toggleDropdown,
		attachDropdown: attachDropdown
	};
});
