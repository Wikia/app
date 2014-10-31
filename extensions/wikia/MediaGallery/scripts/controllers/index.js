require([
	'mediaGallery.controllers.galleries'
], function (GalleriesController) {
	'use strict';

	/**
	 * Convenience function for initializing the gallery elements.
	 */
	function newGallery( options ) {
		var controller,
			settings = {
				lightbox: true,
				lazyLoad: true
			};

		$.extend( settings, options );

		controller = new GalleriesController( settings );
		controller.init();
	}

	// Galleries must be initialized:
	// In preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	// After VisualEditor
	mw.hook('postEdit').add(function() {
		newGallery({ lazyLoad: false });
	});
	// On page load
	$(newGallery);
});
