define('mediaGallery.views.gallery', [
	'mediaGallery.views.media',
	'mediaGallery.views.toggler',
	'wikia.tracker',
	'bucky'
], function (Media, Toggler, tracker, bucky) {
	'use strict';

	var Gallery;

	/**
	 * Instantiate gallery view
	 * Events bound to $el:
	 *  'galleryInserted' when gallery HTML is appended to DOM. Once per gallery instance
	 *  'mediaLoaded' when batches of images are fully loaded.
	 * @constructor
	 * @param {object} options
	 * @returns {Gallery} Gallery instance
	 */
	Gallery = function (options) {
		// required options
		this.$el = options.$el.addClass('media-gallery-inner');
		this.$wrapper = options.$wrapper;
		this.model = options.model;

		// optional settings with defaults
		this.origVisibleCount = options.origVisibleCount || 8;
		this.interval = options.interval || 12;
		this.throttleVal = options.throttleVal || 200;

		// performance profiling
		this.bucky = bucky('mediaGallery.views.gallery.' + options.index);

		// flags and state tracking
		this.rendered = false;
		this.visibleCount = 0;
		this.media = [];

		return this;
	};

	/**
	 * Set up gallery view and toggle buttons
	 * @returns {Gallery}
	 */
	Gallery.prototype.init = function () {
		this.createMedia();
		this.bindEvents();

		if (this.model.media.length > this.origVisibleCount) {
			this.toggler = new Toggler();
			this.togglerAdded = false;
		}

		this.track({
			action: tracker.ACTIONS.IMPRESSION,
			value: this.model.media.length
		});

		return this;
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

		$.each(throttled, function (idx, model) {
			var media = new Media({
				$el: $('<div></div>'),
				model: model,
				gallery: this
			});
			self.media.push(media);
		});

		this.bucky.timer.stop('createMedia');
	};

	/**
	 * Bind any events related to this view
	 */
	Gallery.prototype.bindEvents = function () {
		var self = this;

		// handle event when gallery inserted into DOM
		this.$el.on('galleryInserted', function () {
			self.rendered = true;
			$.each(self.media, function (idx, media) {
				if (media.rendered) {
					// trigger event when media inserted into DOM
					media.$el.trigger('mediaInserted');
				}
			});
		});

		// Set up tracking
		this.$wrapper.on('click', '.media > a', function () {
			var index = $(this).parent().index();
			self.track({
				label: 'gallery-item',
				value: index
			});
		});
	};

	/**
	 * Render sets of media.
	 * @param {int} [count] Number to be rendered. If not set, original visible count will be used.
	 * @returns {Gallery}
	 */
	Gallery.prototype.render = function (count) {
		var self = this,
			media,
			mediaCount,
			deferredImages = [];

		this.beforeRender();

		// if count isn't set, assume we're starting a new gallery
		if (typeof count !== 'number') {
			count = this.origVisibleCount;
		}

		media = this.media.slice(this.visibleCount, this.visibleCount + count);
		mediaCount = media.length;
		this.bucky.timer.start('render.' + mediaCount);

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
			$.each(media, function (idx, item) {
				item.show();
			});
			self.bucky.timer.stop('render.' + mediaCount);
			self.afterRender();
		});

		return this;
	};

	Gallery.prototype.beforeRender = function () {
		// handle loading graphic
		if (this.$showMore) {
			this.$showMore.startThrobbing();
		}
	};

	/**
	 * Called after rendering the gallery and all images are loaded,
	 */
	Gallery.prototype.afterRender = function () {
		if (this.$showMore) {
			this.$showMore.stopThrobbing();
		}
		this.updateToggler(true);

		// Emit event when DOM settles into place
		this.$el.trigger('mediaLoaded');
	};

	/**
	 * Handle showing and hiding of toggler buttons. Best called after images are loaded / hidden
	 * @param {bool} show If we just showed more images or hid more images
	 */
	Gallery.prototype.updateToggler = function (show) {
		// make sure we have items to load and we haven't added the toggle buttons already
		if (!this.toggler) {
			return;
		}

		// make sure toggler's already in the DOM
		this.appendToggler();

		// hide and show appropriate buttons
		if (show) {
			// called after showing more images
			this.$showLess.removeClass('hidden');
			if (this.visibleCount >= this.model.media.length) {
				this.$showMore.addClass('hidden');
			}
		} else {
			// called after hiding overflow images
			this.$showLess.addClass('hidden');
			this.$showMore.removeClass('hidden');
		}
	};

	/**
	 * Insert toggle buttons into DOM if we haven't done it already
	 */
	Gallery.prototype.appendToggler = function () {
		if (this.toggler && this.togglerAdded === false) {
			this.$wrapper.append(this.toggler.render().$el);

			this.$showMore = this.toggler.$more
				.on('click', $.proxy(this.showMore, this));
			this.$showLess = this.toggler.$less
				.on('click', $.proxy(this.showLess, this));
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

		// If it's already been rendered, show it, otherwise, add to render stack.
		$.each(media, function (idx, item) {
			if (item.rendered) {
				item.show();
				self.visibleCount += 1;
			} else {
				toRender += 1;
			}
		});

		this.render(toRender);

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
		this.updateToggler(false);

		this.scrollToTop();
	};

	/**
	 * Scroll to the top of the gallery. Good for after "show fewer" button is clicked.
	 */
	Gallery.prototype.scrollToTop = function () {
		$('body, html').animate({
			scrollTop: this.$wrapper.offset().top - 50
		}, 500);
	};

	/**
	 * Common tracking function for this view
	 * @type {*}
	 */
	Gallery.prototype.track = tracker.buildTrackingFunction({
		category: 'media-gallery',
		label: 'gallery',
		trackingMethod: 'analytics',
		action: tracker.ACTIONS.CLICK,
		value: 0
	});

	return Gallery;
});
