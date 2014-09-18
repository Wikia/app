define('mediaGallery.views.gallery', [
	'mediaGallery.views.toggler',
    'mediaGallery.views.media'
], function (Toggler, Media) {
	'use strict';

	function Gallery(options) {
		this.$el = options.$el;
		this.$wrapper = options.$wrapper;
		this.model = options.model;

		this.visibleCount = this.$wrapper.data('visible-count') || 8;
		this.oVisibleCount = this.visibleCount;
		this.interval = options.interval || 12;
		this.media = [];

		this.init();
	}

	Gallery.prototype.init = function () {
		this.renderMedia(this.model.slice(0, this.oVisibleCount));

		if (this.model.length > this.visibleCount) {
			this.toggler = new Toggler({
				$el: this.$el,
				gallery: this
			});
			this.toggler.init();
		}

		this.$el.on('click', '.media > a', $.proxy(this.track, this));
	};

	/**
	 * Render and insert media items with only one DOM insertion per batch
	 */
	Gallery.prototype.renderMedia = function (data) {
		var self = this,
			html = '';

		$.each(data, function () {
			var media = new Media({
				el: document.createElement('div'),
				model: this
			});
			self.media.push(media);
			media.render();
			media.show();
			html += media.el.outerHTML;
		});

		this.$el.append(html);
	};

	/**
	 * Incrementally show more media
	 */
	Gallery.prototype.showMore = function () {
		var data = this.model.slice(this.visibleCount, this.visibleCount + this.interval),
			toRender = [];

		// If rendered, show it, otherwise, add to render stack.
		$.each(data, function (idx, mediaData) {
			if (mediaData.rendered) {
				mediaData.media.show();
			} else {
				toRender.push(mediaData);
			}
		});

		this.renderMedia(toRender);
		this.visibleCount += data.length;
	};

	/**
	 * Hide all but original media
	 */
	Gallery.prototype.showLess = function () {
		var data = this.model.slice(0, this.oVisibleCount);
		$.each(data, function () {
			data.media.hide();
			this.visibleCount -= 1;
		});
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
