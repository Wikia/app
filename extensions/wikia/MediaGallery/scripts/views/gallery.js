define('mediaGallery.views.gallery', [
    'mediaGallery.views.media',
    'mediaGallery.templates.mustache'
], function (Media, templates) {
	'use strict';

	var togglerTemplateName = 'MediaGallery_showMore';

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
		this.$el.on('click', '.media > a', $.proxy(this.track, this));
	};

	/**
	 * Render initial set of media
	 */
	Gallery.prototype.render = function () {
		var self = this,
			data = this.model.slice(0, this.oVisibleCount);

		$.each(data, function () {
			$.proxy(self.renderMedia(this), self);
		});

		if (this.model.length > this.visibleCount) {
			this.renderToggler();
		}

		return this;
	};

	Gallery.prototype.renderMedia = function (data) {
		var media = new Media({
			$el: $('<div></div>'),
			model: data
		});
		this.media.push(media);
		media.render();
		media.show();
		this.$el.append(media.$el);
	};

	Gallery.prototype.renderToggler = function () {
		var $html, data;

		data = {
			showMore: $.msg('mediagallery-show-more'),
			showLess: $.msg('mediagallery-show-less')
		};

		$html = $(Mustache.render(templates[togglerTemplateName], data));
		this.$showMore = $html.find('.show');
		this.$showLess = $html.find('.hide');

		this.$showMore.on('click', $.proxy(this.showMore, this));
		this.$showLess.on('click', $.proxy(this.showLess, this));

		this.$toggler = $html;
	};

	/**
	 * Incrementally show more media
	 */
	Gallery.prototype.showMore = function () {
		var self = this,
			data = this.model.slice(this.visibleCount, this.visibleCount + this.interval);

		// If rendered, show it, otherwise, add to render stack.
		$.each(data, function (idx, mediaData) {
			if (mediaData.rendered) {
				mediaData.media.show();
			} else {
				$.proxy(self.renderMedia(mediaData), self);
			}
		});

		this.visibleCount += data.length;
		this.$showLess.removeClass('hidden');

		if (this.visibleCount >= this.model.length) {
			this.$showMore.addClass('hidden');
		}
	};

	/**
	 * Hide all but original media
	 */
	Gallery.prototype.showLess = function () {
		var data = this.model.slice(this.oVisibleCount);

		$.each(data, function (idx, mediaData) {
			if (mediaData.media) {
				mediaData.media.hide();
			} else {
				return false;
			}
			return true;
		});
		this.visibleCount = this.oVisibleCount;
		this.$showLess.addClass('hidden');
		this.$showMore.removeClass('hidden');
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

	// TODO: hook tracking back up
	Gallery.prototype.trackToggler = function (label, count) {
		Wikia.Tracker.track({
			category: 'media-lightbox',
			action: Wikia.Tracker.ACTIONS.CLICK,
			label: label,
			trackingMethod: 'both',
			value: count || 0
		});
	};

	return Gallery;
});
