define('mediaGallery.views.gallery', [
    'mediaGallery.views.media',
    'mediaGallery.templates.mustache',
    'wikia.tracker'
], function (Media, templates, tracker) {
	'use strict';

	var Gallery,
		track,
		togglerTemplateName = 'MediaGallery_showMore';

	track = tracker.buildTrackingFunction({
		category: 'media-gallery',
		trackingMethod: 'both',
		action: tracker.ACTIONS.CLICK
	});

	Gallery = function (options) {
		this.$el = options.$el;
		this.$wrapper = options.$wrapper;
		this.model = options.model;
		this.oVisibleCount = options.oVisible;
		this.interval = options.interval || 12;

		this.rendered = false;
		this.visibleCount = 0;
		this.media = [];

		this.init();
	};

	Gallery.prototype.init = function () {
		this.createMedia();
		this.bindEvents();

		// set up toggle buttons
		if (this.media.length > this.oVisibleCount) {
			this.renderToggler();
		}
	};

	/**
	 * create all media instances
	 */
	Gallery.prototype.createMedia = function () {
		var self = this;

		$.each(this.model, function (idx, data) {
			var media = new Media({
				$el: $('<div></div>'),
				model: data,
				gallery: this
			});
			self.media.push(media);
		});
	};

	Gallery.prototype.bindEvents = function () {
		var self = this;

		// trigger event when media inserted into DOM
		this.$el.on('galleryInserted', function () {
			$.each(self.media, function (idx, media) {
				if (media.rendered) {
					media.$el.trigger('mediaInserted');
				}
			});
		});

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
	Gallery.prototype.render = function (count) {
		var self = this,
			media;

		if (count === 0) {
			return this;
		}

		count = count || this.interval;
		media = this.media.slice(this.visibleCount, this.visibleCount + count);

		$.each(media, function (idx, item) {
			item.render()
				.show();
			self.$el.append(item.$el);

			// trigger event when media inserted into DOM
			if (self.rendered) {
				item.$el.trigger('mediaInserted');
			}

			self.visibleCount += 1;
		});

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

	/**
	 * Incrementally show more media
	 */
	Gallery.prototype.showMore = function () {
		var self = this,
			media = this.media.slice(this.visibleCount, this.visibleCount + this.interval),
			toRender = 0;

		// If rendered, show it, otherwise, add to render stack.
		$.each(media, function (idx, item) {
			if (item.rendered) {
				item.show();
				self.visibleCount += 1;
			} else {
				toRender += 1;
			}
		});

		this.render(toRender);

		// hide and show appropriate buttons
		this.$showLess.removeClass('hidden');
		if (this.visibleCount >= this.media.length) {
			this.$showMore.addClass('hidden');
		}

		track({
			label: 'show-more-items',
			value: this.visibleCount
		});
	};

	/**
	 * Hide all but original media
	 */
	Gallery.prototype.showLess = function () {
		var media = this.media.slice(this.oVisibleCount, this.visibleCount);

		$.each(media, function (idx, item) {
			item.hide();
		});

		track({
			label: 'show-less-items',
			value: this.visibleCount
		});

		this.visibleCount = this.oVisibleCount;
		this.$showLess.addClass('hidden');
		this.$showMore.removeClass('hidden');

		// scroll to the top of the gallery
		$('body, html').animate({
			scrollTop: this.$wrapper.offset().top - 80
		}, 500);
	};

	return Gallery;
});
