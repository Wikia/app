require(['mediaGallery.views.gallery'], function (Gallery) {
	'use strict';

	/**
	 * Define primary gallery container element. Must be called after DOM ready
	 * @constructor
	 */
	var GalleriesController = function (options) {
		// cache DOM objects
		this.$container = options.$container;
		this.$galleries = this.$container.find('.media-gallery-wrapper');

		// cache instances
		this.galleries = [];

		return this;
	};

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $wrapper Wrapper element for gallery. Contains data attributes with info for gallery
	 * @param {int} idx Index of wrapper DOM element in gallery array
	 */
	GalleriesController.prototype.createGallery = function ($wrapper, idx) {
		var gallery,
			model = $wrapper.data('model'),
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
		gallery = new Gallery(galleryOptions).init();

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
			var $this = $(this);

			self.createGallery($this, idx);
		});
		return this;
	};

	mw.hook('wikipage.content').add(function ($content) {
		new GalleriesController({$container: $content}).init();
	});
});