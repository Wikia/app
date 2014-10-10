require([
	'mediaGallery.controllers.galleries'
], function (GalleryController) {
	'use strict';

	/**
	 * Convenience function for initializing the gallery elements
	 */
	function newGallery() {
		var gallery = new GalleryController();
		gallery.init();
	}

	// Galleries must be initialized on page-load and on preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	$(newGallery);
});
