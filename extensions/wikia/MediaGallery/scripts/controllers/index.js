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
		var $galleries = $('.media-gallery-wrapper');

		$.each($galleries, function (idx) {
			var $this = $(this),
				data = $this.data('model');

			sloth({
				on: $this,
				threshold: 400,
				callback: function () {
					createGallery($this, idx, data);
				}
			});
		});
	});
});
