define('mediaGallery.controllers.galleries', [
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
	 * @param {Object} data
	 */
	GalleryController.prototype.createGallery = function ($elem, idx, data) {
		var origVisibleCount = $elem.data('visible-count') || 8,
			gallery,
			galleryOptions = {
				$el: $('<div></div>'),
				$wrapper: $elem,
				model: {
					media: data
				},
				origVisibleCount: origVisibleCount,
				index: idx,
				interval: $elem.data('expanded') // if set, pass the value, otherwise, default will be used.
			};

		// Instantiate gallery view
		gallery = new Gallery(galleryOptions);

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

	return GalleryController;
	//t est
});
