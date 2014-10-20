/**
 * Loads Lightbox in Venus skin.
 */
define('venus.lightboxLoader', ['wikia.window'], function (win) {
	'use strict';
	var lightboxSettings;

	lightboxSettings = {
		appendToBody: true,
		className: 'LightboxModal lightbox-venus',
		suppressDefaultStyles: true,
		resizeModal: false,
		tabsOutsideContent: true
	};

	function init() {
		win.LightboxLoader.init(lightboxSettings);
	}

	return {
		init: init
	};
});
