require([
	'mediaGallery.controllers.galleries'
], function (GalleriesController) {
	'use strict';

	/**
	 * Convenience function for initializing the gallery elements.
	 */
	function newGallery() {
		var controller = new GalleriesController({
			lightbox: true,
			lazyLoad: true
		});
		controller.init();
	}

	// Galleries must be initialized on page-load and on preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	$(newGallery);
});
