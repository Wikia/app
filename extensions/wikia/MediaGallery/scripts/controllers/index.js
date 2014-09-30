require([
	'mediaGallery.views.gallery',
    'sloth'
], function (Gallery, sloth) {
	'use strict';

	function createGallery($elem, idx, data) {
		var origVisibleCount = $elem.data('visible-count') || 8,
			gallery;

		gallery = new Gallery({
			$el: $('<div></div>'),
			$wrapper: $elem,
			model: {
				media: data
			},
			origVisibleCount: origVisibleCount,
			index: idx
		});
		$elem.append(gallery.render(origVisibleCount).$el);

		if (gallery.$toggler) {
			$elem.append(gallery.$toggler);
		}

		gallery.rendered = true;
		gallery.$el.trigger('galleryInserted');

	}

	$(function () {
		var $galleries = $('.media-gallery-wrapper'),
			// get data from script tag in DOM
			data = Wikia.mediaGalleryData || [];

		// If there's no galleries on the page, we're done.
		if (!data.length) {
			return;
		}

		$.each($galleries, function (idx) {
			var $this = $(this);

			sloth({
				on: $this,
				threshold: 400,
				callback: function () {
					createGallery($this, idx, data[idx]);
				}
			});
		});
	});
});
