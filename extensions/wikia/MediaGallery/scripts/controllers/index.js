require([
	'mediaGallery.views.gallery',
	'sloth'
], function (Gallery, sloth) {
	'use strict';

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $elem
	 * @param {int} idx
	 */
	function createGallery($elem, idx) {
		var origVisibleCount = $elem.data('visible-count') || 8,
			data = $elem.data('model'),
			gallery;

		// Instantiate gallery view
		gallery = new Gallery({
			$el: $('<div></div>'),
			$wrapper: $elem,
			model: {
				media: data
			},
			origVisibleCount: origVisibleCount,
			index: idx
		});

		// Append gallery HTML to DOM
		$elem.append(gallery.render(origVisibleCount).$el);

		// After rendering the gallery and all images are loaded, append the show more/less buttons
		if (gallery.$toggler) {
			gallery.$el.on('mediaLoaded', function () {
				$.proxy(gallery.appendToggler($elem), gallery);
			});
		}

		gallery.rendered = true;
		gallery.$el.trigger('galleryInserted');
	}

	$(function () {
		var $galleries = $('.media-gallery-wrapper');

		$.each($galleries, function (idx) {
			var $this = $(this);

			sloth({
				on: $this,
				threshold: 400,
				callback: function () {
					createGallery($this, idx);
				}
			});
		});
	});
});
