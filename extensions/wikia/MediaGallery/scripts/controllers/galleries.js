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
		var gallery,
			galleryOptions = {
				$el: $('<div></div>'),
				$wrapper: $elem,
				model: { media: data },
				index: idx,
				// if set, pass the value, otherwise, defaults will be used.
				origVisibleCount: $elem.data('visible-count'),
				interval: $elem.data('expanded')
			};

		// Instantiate gallery view
		gallery = new Gallery(galleryOptions);
		gallery.init();

		// Append gallery HTML to DOM
		$elem.append(gallery.render().$el);

		// After rendering the gallery and all images are loaded, append the show more/less buttons
		if (gallery.$toggler) {
			gallery.$el.on('mediaLoaded', function () {
				gallery.appendToggler($elem);
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
});
