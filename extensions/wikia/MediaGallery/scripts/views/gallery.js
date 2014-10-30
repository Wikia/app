define('mediaGallery.views.gallery', [
	'mediaGallery.views.media',
	'mediaGallery.templates.mustache',
	'wikia.tracker',
	'bucky'
], function (Media, templates, tracker, bucky) {
	'use strict';

	var Gallery,
		togglerTemplateName = 'MediaGallery_showMore';

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

		if (typeof options.model === 'string'){
			options.model = JSON.parse(options.model);
		}
		this.model = options.model;

		// optional settings with defaults
		this.origVisibleCount = options.origVisibleCount || 8;
		this.interval = options.interval || 12;
		this.throttleVal = options.throttleVal || 200;

		// performance profiling - send bucky a unique-ish id
		this.bucky = bucky('mediaGallery.views.gallery.' + Math.floor(Math.random() * 1000));

		// flags and state tracking
		this.rendered = false;
		this.visibleCount = 0;
		this.media = [];

		this.$wrapper.data('gallery', this);

		return this;
	};

	/**
	 * Set up gallery view and toggle buttons
	 * @returns {Gallery}
	 */
	Gallery.prototype.init = function () {
		this.createMedia();
		this.bindEvents();

		// set up toggle buttons
		if (this.model.media.length > this.origVisibleCount) {
			this.renderToggler();
			// set element to indicate when things are loading
			this.$loadingElement = this.$showMore;
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
	 * Render the toggle buttons. Does not include DOM insertion.
	 */
	Gallery.prototype.renderToggler = function () {
		var $html, data;

		data = {
			showMore: $.msg('mediagallery-show-more'),
			showLess: $.msg('mediagallery-show-less')
		};

		$html = $(Mustache.render(templates[togglerTemplateName], data));
		this.$showMore = $html.find('.show')
			.on('click', $.proxy(this.showMore, this));
		this.$showLess = $html.find('.hide')
			.on('click', $.proxy(this.showLess, this));

		this.$toggler = $html;
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
		if (this.$loadingElement) {
			this.$loadingElement.startThrobbing();
		}
	};

	Gallery.prototype.afterRender = function () {
		// Emit event when DOM settles into place
		this.$el.trigger('mediaLoaded');

		// After rendering the gallery and all images are loaded,
		// append the show more/less buttons (only happens once)
		this.appendToggler();

		// handle loading graphic
		if (this.$loadingElement) {
			this.$loadingElement.stopThrobbing();
		}
	};

	/**
	 * Insert toggle buttons into DOM
	 */
	Gallery.prototype.appendToggler = function () {
		if (this.$toggler && !this.togglerAdded) {
			this.$wrapper.append(this.$toggler);
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
		trackingMethod: 'both',
		action: tracker.ACTIONS.CLICK,
		value: 0
	});

	return Gallery;
});
