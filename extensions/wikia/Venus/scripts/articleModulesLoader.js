(function(lightboxLoader) {
	'use strict';

	var venusLightboxLoader;

	// Initialize lightbox with custom settings for Venus
	venusLightboxLoader = (function() {
		var init, lightboxSettings;

		lightboxSettings = {
			appendToBody: true,
			className: 'LightboxModal lightbox-venus',
			suppressDefaultStyles: true,
			resizeModal: false,
			tabsOutsideContent: true
		};

		init = function() {
			lightboxLoader.init(lightboxSettings);
		};

		return {
			init: init
		};
	})();

	venusLightboxLoader.init();
})(window.LightboxLoader);
