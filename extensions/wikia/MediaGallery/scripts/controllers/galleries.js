/**
 * TODO: This is the legacy method of instantiating media galleries. After parse cache clears
 * (around Nov. 12 2014), JSSnippets will be fully available and we can remove this file.
 */
require(['mediaGallery.views.gallery'], function (Gallery) {
	'use strict';

	/**
	 * Define primary gallery container element. Must be called after DOM ready
	 * @constructor
	 */
	var GalleriesController = function () {
		// cache DOM objects
		this.$galleries = $('.media-gallery-wrapper');
		// cache instances
		this.galleries = [];
		return this;
	};

	/**
	 * Initialize galleries and add HTML to DOM.
	 * @param {jQuery} $wrapper Wrapper element for gallery. Contains data attributes with info for gallery
	 */
	GalleriesController.prototype.createGallery = function ($wrapper) {
		var gallery,
			model = $wrapper.data('model'),
			galleryOptions = {
				$el: $('<div></div>'),
				$wrapper: $wrapper,
				model: { media: model },
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

		$.each(this.$galleries, function () {
			var $this = $(this);

			// make sure we have old version of HTML before instantiating gallery.
			if ($this.data('model') && !$this.data('gallery')) {
				self.createGallery($this);
			}
		});
		return this;
	};

	$(function () {
		new GalleriesController().init();
	});
});