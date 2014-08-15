require(['mediaGallery.toggler'], function (Toggler) {
	'use strict';
	$(function () {
		var maxImagesShown = 8,
			toggler = new Toggler({
				$el: $('.media-gallery-wrapper')
			});
		if (toggler.$media.length > maxImagesShown) {
			toggler.init();
		}
	});
});
