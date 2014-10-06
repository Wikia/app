define('mediaGallery.views.gallery', [
	'mediaGallery.views.media',
	'mediaGallery.templates.mustache',
	'wikia.tracker',
	'bucky'
], function (Media, templates, tracker, bucky) {
	'use strict';

	var Gallery,
		togglerTemplateName = 'MediaGallery_showMore';

	Gallery = function (options) {
		this.$el = options.$el.addClass('media-gallery-inner');
		this.$wrapper = options.$wrapper;
		this.model = options.model;
		this.origVisibleCount = options.origVisibleCount;
		this.interval = options.interval || 12;
		this.throttleVal = options.throttleVal || 200;
		// performance profiling
		this.bucky = bucky('mediaGallery.views.gallery.' + options.index);

		this.rendered = false;
		this.visibleCount = 0;
		this.media = [];

		this.init();
	};

	Gallery.prototype.init = function () {
		this.createMedia();
		this.bindEvents();

		// set up toggle buttons
		if (this.model.media.length > this.origVisibleCount) {
			this.renderToggler();
		}
	};

	/**
	 * Create media instances. Throttle based on user interaction, but always stay well ahead of what's visible.
	 */
	Gallery.prototype.createMedia = function () {
		var self = this,
			// get the next bunch of media to instantiate
			throttled = this.model.media.slice(this.media.length, this.media.length + this.throttleVal);

		if (!throttled.length) {
			return;
		}

		this.bucky.timer.start('createMedia');

		$.each(throttled, function (idx, data) {
			var media = new Media({
				$el: $('<div></div>'),
				model: data,
				gallery: this
			});
			self.media.push(media);
		});

		this.bucky.timer.stop('createMedia');
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
			self.track({
				label: 'gallery-tiem',
				value: index
			});
		});
	};

	/**
	 * Render sets of media.
	 * @param {int} count Number to be rendered
	 * @param {jQuery} $el Element to apply loading graphic
	 * @returns {Gallery}
	 */
	Gallery.prototype.render = function (count, $el) {
		var self = this,
			media,
			mediaCount,
			deferredImages = [];

		media = this.media.slice(this.visibleCount, this.visibleCount + count);
		mediaCount = media.length;
		this.bucky.timer.start('render.' + mediaCount);

		if ($el) {
			$el.startThrobbing();
		}

		$.each(media, function (idx, item) {
			item.render();
			self.$el.append(item.$el);

			// trigger event when media inserted into DOM
			if (self.rendered) {
				item.$el.trigger('mediaInserted');
			}

			self.visibleCount += 1;
			deferredImages.push(item.$loaded);
		});

		// wait till all images are loaded before showing any
		$.when.apply(this, deferredImages).done(function () {
			if ($el) {
				$el.stopThrobbing();
			}
			$.each(media, function (idx, item) {
				item.show();
			});
			self.bucky.timer.stop('render.' + mediaCount);
			self.$el.trigger('mediaLoaded');
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

	Gallery.prototype.appendToggler = function ($elem) {
		if (!this.togglerAdded) {
			$elem.append(this.$toggler);
			this.togglerAdded = true;
		}
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

		this.render(toRender, this.$showMore);

		// hide and show appropriate buttons
		this.$showLess.removeClass('hidden');
		if (this.visibleCount >= this.model.media.length) {
			this.$showMore.addClass('hidden');
		}

		this.track({
			label: 'show-more-items',
			value: this.visibleCount
		});

		// user has expressed interest, so let's instatiate more media.
		this.createMedia();
	};

	/**
	 * Hide all but original media
	 */
	Gallery.prototype.showLess = function () {
		var media = this.media.slice(this.origVisibleCount, this.visibleCount);

		$.each(media, function (idx, item) {
			item.hide();
		});

		this.track({
			label: 'show-less-items',
			value: this.visibleCount
		});

		this.visibleCount = this.origVisibleCount;
		this.$showLess.addClass('hidden');
		this.$showMore.removeClass('hidden');

		this.scrollToTop();
	};

	Gallery.prototype.scrollToTop = function () {
		// scroll to the top of the gallery
		$('body, html').animate({
			scrollTop: this.$wrapper.offset().top - 50
		}, 500);
	};

	Gallery.prototype.track = function () {
		return tracker.buildTrackingFunction({
			category: 'media-gallery',
			trackingMethod: 'both',
			action: tracker.ACTIONS.CLICK
		});
	};

	return Gallery;
});