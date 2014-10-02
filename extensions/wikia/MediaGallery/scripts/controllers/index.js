require([
	'mediaGallery.views.gallery',
	'sloth'
], function (Gallery, sloth) {
	'use strict';

	/**
	 * Define primary gallery container element
	 * @constructor
	 */
	var GalleryController = function() {
		this.$galleries = $('.media-gallery-wrapper');
	};

	/**
	 * Create gallery elements
	 * @param $elem
	 * @param idx
	 * @param data
	 */
	GalleryController.prototype.createGallery = function($elem, idx, data) {
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

	};

	/**
	 * Initialize and populate gallery elements
	 */
	GalleryController.prototype.init = function () {
		// get data from script tag in DOM
		var self = this,
			data = Wikia.mediaGalleryData || [];

		// If there's no galleries on the page, we're done.
		if (!data.length) {
			return;
		}

		$.each(this.$galleries, function (idx) {
			var $this = $(this);

			sloth({
				on: $this,
				threshold: 400,
				callback: function () {
					self.createGallery($this, idx, data[idx]);
				}
			});
		});
	};

	/**
	 * Convenience function for initializing the gallery elements
	 */
	function newGallery() {
		var gallery = new GalleryController();
		gallery.init();
	}

	// Galleries must be initialized on page-load and on preview dialog
	$(window).on('EditPageAfterRenderPreview', newGallery);
	$(newGallery);
});
