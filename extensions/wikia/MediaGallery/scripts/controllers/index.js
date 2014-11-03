require([
	'mediaGallery.controllers.galleries'
], function (GalleriesController) {
	'use strict';

	/**
	 * Convenience function for initializing the gallery elements.
	 */
	function newGallery() {
		new GalleriesController().init();
	}

	// Galleries must be initialized:
	// In preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	// After VisualEditor
	mw.hook('postEdit').add(newGallery);
	// On page load
	$(newGallery);
});
