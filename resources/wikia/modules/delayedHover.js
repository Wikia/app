define('wikia.delayedhover', ['wikia.window'], function(win) {
	'use strict';

	function attach(entryPoint, options) {
		win.delayedHover(entryPoint, options);
	}

	return {
		attach: attach
	};
});
