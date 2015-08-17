/**
 * AMD module wrapper around menu aim library.
 * Provides unified way of attaching menu aim to element.
 */
define('wikia.menuaim', ['wikia.window'], function(win) {
	'use strict';

	function attach(entryPoint, options) {
		win.menuAim(entryPoint, options);
	}

	return {
		attach: attach
	};
});
