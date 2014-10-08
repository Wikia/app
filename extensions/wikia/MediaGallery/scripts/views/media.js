define('mediaGallery.views.media', [
	'mediaGallery.views.caption',
	'mediaGallery.templates.mustache'
], function (Caption, templates) {
	'use strict';

	var Media,
		templateName = 'MediaGallery_media'; // workaround for nirvana template naming conventions and JSHint conflict

	/**
	 * Handle rendering and bindings for media items in galleries
	 * @param {Object} options
	 * @constructor
	 */
	Media = function (options) {
		this.$el = options.$el;
		this.model = options.model;
		this.gallery = options.gallery;

		this.model.media = this;
		this.rendered = false;
		this.$loaded = $.Deferred();

		// Wait till element is inserted into DOM before binding caption events
		this.$el.on('mediaInserted', $.proxy(this.onInsert, this));
	};

	/**
	 * Create media html
	 * @returns {Media}
	 */
	Media.prototype.render = function () {
		this.$el.addClass('media hidden fade');
		this.$el.html(Mustache.render(templates[templateName], this.model));
		this.rendered = true;

		return this;
	};

	Media.prototype.onInsert = function () {
		var self = this;

		this.$el.find('img').on('load error', function () {
			self.$loaded.resolve();
		});

		this.initCaption();
	};

	/**
	 * Create caption instance
	 */
	Media.prototype.initCaption = function () {
		var $caption = this.$el.find('.media-gallery-caption');

		if ($caption.length) {
			this.caption = new Caption({
				$el: $caption,
				media: this
			});
		}
	};

	/**
	 * Use CSS transitions to show element
	 */
	Media.prototype.show = function () {
		var self = this;

		this.$el.removeClass('hidden');
		// wait till after display:block before starting transition
		setTimeout(function () {
			self.$el.removeClass('fade');
		}, 0);
	};

	/**
	 * Use CSS transitions to hide element
	 */
	Media.prototype.hide = function () {
		var self = this;

		if (!this.fadeDuration) {
			// get duration of css fade and cut it in half
			this.fadeDuration = parseInt(this.$el.css('transition-duration')) * 500;
		}

		this.$el.addClass('fade');
		setTimeout(function () {
			self.$el.addClass('hidden');
		}, this.fadeDuration);
	};

	return Media;
});
