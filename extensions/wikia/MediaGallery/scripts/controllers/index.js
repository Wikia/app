require([
	'mediaGallery.controllers.galleries'
], function (GalleriesController) {
	'use strict';

	// Galleries must be initialized whenerver article content is loaded
	mw.hook('wikipage.content').add(GalleriesController().init);
});
