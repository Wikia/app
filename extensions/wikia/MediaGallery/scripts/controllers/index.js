require(['mediaGallery.views.gallery'], function (Gallery) {
	'use strict';
	$(function () {
		var galleries = [],
			$galleries = $('.media-gallery-wrapper'),
			data = Wikia.mediaGalleryData || [];

		// If there's no galleries on the page, we're done.
		if (!data.length) {
			return;
		}

		$.each($galleries, function (idx) {
			var $this = $(this),
				model, gallery;

			model = data[idx];

			gallery = new Gallery({
				$el: $this.find('.media-gallery-inner'),
				model: model,
				visible: $this.data('visible-count')
			});

			galleries.push(gallery);
		});

	});
});
