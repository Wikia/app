define('mediaGallery.controllers.galleries', [
	'mediaGallery.views.gallery',
	'mediaGallery.controllers.lightbox',
	'sloth'
], function (Gallery, LightboxController, sloth) {
	'use strict';

	/**
	 * Define primary gallery container element. Must be called after DOM ready
	 * @param {Object} [options] Options for initialization:
	 *  lightbox: bool - whether to pass gallery data to Lightbox
	 *  lazyLoad: bool - whether to lazy load gallery initialization. Note: this makes gallery generation async
	 * @constructor
	 */
	var GalleriesController = function (options) {
		options = options || {};
		this.lightbox = options.lightbox;
		this.lazyLoad = options.lazyLoad;
		// cache DOM objects
		this.$galleries = $('.media-gallery-wrapper');
		// cache instances
		this.galleries = [];
	};

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $wrapper Wrapper element for gallery. Contains data attributes with info for gallery
	 * @param {int} idx Index of wrapper DOM element in gallery array
	 * @param {Object} model All the data needed for instantiating a gallery
	 */
	GalleriesController.prototype.createGallery = function ($wrapper, idx, model) {
		var gallery,
			galleryOptions = {
				$el: $('<div></div>'),
				$wrapper: $wrapper,
				model: { media: model },
				index: idx,
				// if set, pass the value, otherwise, defaults will be used.
				origVisibleCount: $wrapper.data('visible-count'),
				interval: $wrapper.data('expanded')
			};

		// Instantiate gallery view
		gallery = new Gallery(galleryOptions);
		gallery.init();

		// Append gallery HTML to DOM and trigger event
		$wrapper.append(gallery.render().$el);
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
				model = $this.data('model'),
				lightboxController;

			// Send gallery images to Lightbox
			if (self.lightbox) {
				lightboxController = new LightboxController({
					model: model
				});
				lightboxController.init();
			}

			if (self.lazyLoad) {
				// Load galleries on demand
				sloth({
					on: $this,
					threshold: 200,
					callback: function () {
						self.createGallery($this, idx, model);
					}
				});
			} else {
				// Load galleries immediately
				self.createGallery($this, idx, model);
			}
		});
	};

	return GalleriesController;
});
