'use strict';

(function($, vignette) {
	var images = $('.collection-view-item-image');

	/**
	 * @desc loads image
	 * @param {number} index - array index
	 * @param {string} img - img html
	 */
	function loadImage(index, img) {
		var $img = $(img),
			url = $img.data('url'),
			options = {
				mode: vignette.mode.scaleToWidth,
				width: $img.parent().width()
			};

		$img.attr('src', vignette.getThumbURL(url, options));
	}

	images.each(loadImage);
})(jQuery, Vignette);
