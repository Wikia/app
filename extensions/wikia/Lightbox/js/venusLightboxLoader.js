/* global define */
define('venus.lightboxLoader', ['wikia.window'], function(window){
	'use strict';
	var init, lightboxSettings;

	lightboxSettings = {
		appendToBody: true,
		className: 'LightboxModal lightbox-venus',
		suppressDefaultStyles: true,
		resizeModal: false,
		tabsOutsideContent: true
	};

	init = function() {
		window.LightboxLoader.init(lightboxSettings);
	};

	return {
		init: init
	};
});
