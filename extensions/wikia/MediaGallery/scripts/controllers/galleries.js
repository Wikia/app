define('mediaGallery.controllers.galleries', [
	'mediaGallery.views.gallery',
	'mediaGallery.controllers.lightbox',
	'sloth'
], function (Gallery, LightboxController, sloth) {
	'use strict';

	/**
	 * Define primary gallery container element. Must be called after DOM ready
	 * @param {Object} options Options for initialization:
	 *  lightbox: bool - whether to pass gallery data to Lightbox
	 *  lazyLoad: bool - whether to lazy load gallery initialization
	 * @constructor
	 */
	var GalleriesController = function (options) {
		this.lightbox = options.lightbox;
		this.lazyLoad = options.lazyLoad;
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

			// Send gallery images to Lightbox
			if (self.lightbox) {
				lightboxController = new LightboxController({
					model: data
				});
				lightboxController.init();
			}

			if (self.lazyLoad) {
				// Load galleries on demand
				sloth({
					on: $this,
					threshold: 200,
					callback: function () {
						self.createGallery($this, idx, data);
					}
				});
			} else {
				// Load galleries immediately
				self.createGallery($this, idx, data);
			}
		});
	};

	return GalleriesController;
});
