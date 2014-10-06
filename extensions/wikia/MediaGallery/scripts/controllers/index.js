require([
	'mediaGallery.views.gallery',
	'mediaGallery.controllers.lightbox',
	'sloth'
], function (Gallery, LightboxController, sloth) {
	'use strict';

	/**
	 * Define primary gallery container element
	 * @constructor
	 */

	var GalleryController = function () {
		this.$galleries = $('.media-gallery-wrapper');
	};

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $elem
	 * @param {int} idx
	 */
	GalleryController.prototype.createGallery = function ($elem, idx, data) {
		var origVisibleCount = $elem.data('visible-count') || 8,
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

		// Flags and events for other modules
		gallery.rendered = true;
		gallery.$el.trigger('galleryInserted');
	};

	/**
	 * Initialize and populate gallery elements
	 */
	GalleryController.prototype.init = function () {
		var self = this;

		$.each(this.$galleries, function (idx) {
			var $this = $(this),
				data = $this.data('model'),
				lightboxController;

			// pass gallery data to lightbox
			lightboxController = new LightboxController({
				model: data
			});
			lightboxController.init();

			sloth({
				on: $this,
				threshold: 200,
				callback: function () {
					self.createGallery($this, idx, data);
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
