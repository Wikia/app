require([
	'mediaGallery.controllers.galleries'
], function (GalleriesController) {
	'use strict';

	/**
	 * Convenience function for initializing the gallery elements.
	 * Local var `controller` contains array of gallery instances.
	 */
	function newGallery() {
		var controller = new GalleriesController();
		controller.init();
	}

	// Galleries must be initialized on page-load and on preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	$(newGallery);
});
