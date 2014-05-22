(function (window) {
	'use strict';

	window.Wikia = window.Wikia || {};

	// https://github.com/Modernizr/Modernizr/issues/84
	Wikia.isTouchScreen = function () {
		return ('ontouchstart' in window);
	};

	if (Wikia.isTouchScreen()) {
		$.getResources([
			$.getSassCommonURL('/skins/oasis/css/touchScreen.scss'),
			window.stylepath + '/oasis/js/touchScreen.js'
		]);
	}
})(window);
