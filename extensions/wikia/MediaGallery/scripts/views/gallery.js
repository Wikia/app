define('mediaGallery.views.gallery', [
	'mediaGallery.views.toggler',
    'mediaGallery.views.media'
], function (Toggler, Media) {
	'use strict';

	function Gallery(options) {
		this.$el = options.$el;
		this.model = options.model;
		this.visibleCount = options.visiblie || 8;
		this.media = [];

		this.init();
	}

	Gallery.prototype.init = function () {
		this.render();

		if (this.media.length > this.visibleCount) {
			this.toggler = new Toggler({
				$el: this.$el
			});
			this.toggler.init();
		}

		this.$el.on('click', '.media > a', $.proxy(this.track, this));
	};

	Gallery.prototype.render = function () {
		var html = '';

		// create new views for each media item
		$.each(this.model, function () {
			var media = new Media({
				el: document.createElement('div'),
				model: this
			});

			media.render();
			html += media.el.outerHTML;
		});

		this.$el.append(html);
	};

	// TODO: test to make sure it works as is and/or move to media view; might be more performant this way b/c
	// binding to wrapper instead of each gallery anchor.
	Gallery.prototype.track = function (e) {
		// get index of media item in gallery
		var index = $(e.target).parent().index();

		Wikia.Tracker.track({
			category: 'media-gallery',
			action: Wikia.Tracker.ACTIONS.CLICK,
			label: 'gallery-item',
			trackingMethod: 'both',
			value: index
		});
	};

	return Gallery;
});
