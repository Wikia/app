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

	var GalleriesController = function () {
		// cache DOM objects
		this.$galleries = $('.media-gallery-wrapper');
		// cache instances
		this.galleries = [];
	};

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $elem
	 * @param {int} idx
	 * @param {Object} data
	 */
	GalleriesController.prototype.createGallery = function ($elem, idx, data) {
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

		// Append gallery HTML to DOM and trigger event
		$elem.append(gallery.render().$el);
		gallery.$el.trigger('galleryInserted');

		// expose gallery instances publicly
		this.galleries.push(gallery);
	};

	/**
	 * Initialize and populate gallery elements
	 */
	GalleriesController.prototype.init = function () {
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

	return GalleriesController;
});
