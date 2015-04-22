'use strict';

(function($, vignette) {
	var infoboxImages = $('.portable-infobox-image');

	/**
	 * @desc loads infobox image image
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

	infoboxImages.each(loadImage);
})(jQuery, Vignette);
