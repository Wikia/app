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
				oVisible = $this.data('visible-count') || 8,
				gallery;

			gallery = new Gallery({
				$el: $('<div></div>').addClass('media-gallery-inner'),
				$wrapper: $this,
				model: data[idx],
				oVisible: oVisible
			});
			gallery.render(oVisible);

			$this.append(gallery.$el);
			if (gallery.$toggler) {
				$this.append(gallery.$toggler);
			}
			gallery.rendered = true;
			gallery.$el.trigger('galleryInserted');

			galleries.push(gallery);
		});
	});
});
