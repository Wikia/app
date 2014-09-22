define('mediaGallery.views.gallery', [
    'mediaGallery.views.media',
    'mediaGallery.templates.mustache',
    'wikia.tracker'
], function (Media, templates, Tracker) {
	'use strict';

	var track,
		togglerTemplateName = 'MediaGallery_showMore';

	track = Tracker.buildTrackingFunction({
		category: 'media-gallery',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.CLICK
	});

	function Gallery(options) {
		this.$el = options.$el;
		this.$wrapper = options.$wrapper;
		this.model = options.model;

		this.rendered = false;
		this.visibleCount = this.$wrapper.data('visible-count') || 8;
		this.oVisibleCount = this.visibleCount;
		this.interval = options.interval || 12;
		this.media = [];

		this.init();
	}

	Gallery.prototype.init = function () {
		// Set up tracking
		this.$wrapper.on('click', '.media > a', function () {
			var index = $(this).parent().index();
			track({
				label: 'gallery-tiem',
				value: index
			});
		});
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

	Gallery.prototype.renderMedia = function (data) {
		var media = new Media({
			$el: $('<div></div>'),
			model: data,
			gallery: this
		});
		this.media.push(media);
		media.render();
		media.show();
		this.$el.append(media.$el);

		// fire event when media is actually rendered into DOM
		if (this.rendered) {
			media.$el.trigger('mediaInserted');
		} else {
			this.$el.on('galleryInserted', function () {
				media.$el.trigger('mediaInserted');
			});
		}
	};

	/**
	 * Incrementally show more media
	 */
	Gallery.prototype.showMore = function () {
		var self = this,
			data = this.model.slice(this.visibleCount, this.visibleCount + this.interval);

		// If rendered, show it, otherwise, add to render stack.
		$.each(data, function (idx, mediaData) {
			if (mediaData.media) {
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

		this.track({
			label: 'show-more-items',
			value: this.visibleCount
		});
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

		// scroll to the top of the gallery
		$('body, html').animate({
			scrollTop: this.$wrapper.offset().top - 80
		}, 500);
	};

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
