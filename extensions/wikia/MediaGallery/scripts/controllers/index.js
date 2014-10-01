require(['mediaGallery.views.gallery'], function (Gallery) {
	'use strict';
	$(function () {
		var $galleries = $('.media-gallery-wrapper'),
			// get data from script tag in DOM
			data = Wikia.mediaGalleryData || [];

		// If there's no galleries on the page, we're done.
		if (!data.length) {
			return;
		}

		$.each($galleries, function (idx) {
			var $this = $(this),
				origVisibleCount = $this.data('visible-count') || 8,
				gallery;

			// Instantiate gallery view
			gallery = new Gallery({
				$el: $('<div></div>'),
				$wrapper: $this,
				model: {
					media: data[idx]
				},
				origVisibleCount: origVisibleCount
			});

			// Append gallery HTML to the DOM
			$this.append(gallery.render(origVisibleCount).$el);

			// After rendering the gallery and all images are loaded, append the show more/less buttons
			if (gallery.$toggler) {
				gallery.$el.on('mediaLoaded', function () {
					$.proxy(gallery.appendToggler($this), gallery);
				});
			}

			gallery.rendered = true;
			gallery.$el.trigger('galleryInserted');
		});
	});
});
