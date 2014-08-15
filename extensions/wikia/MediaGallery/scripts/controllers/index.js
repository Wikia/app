require(['mediaGallery.toggler'], function (Toggler) {
	'use strict';
	$(function () {
		var maxImagesShown = 8,
			$galleries = $('.media-gallery-wrapper'),
			togglers = [];

		$galleries.each(function () {
			var toggler = new Toggler({
				$el: $(this)
			});
			if (toggler.$media.length > maxImagesShown) {
				toggler.init();
				togglers.push(toggler);
			}
		});
	});
});
