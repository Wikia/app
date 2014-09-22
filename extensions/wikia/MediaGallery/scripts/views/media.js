define('mediaGallery.views.media', [
	'mediaGallery.views.caption',
    'mediaGallery.templates.mustache'
], function (Caption, templates) {
	'use strict';

	var Media,
		templateName = 'MediaGallery_media'; // workaround for nirvana template naming conventions and JSHint conflict

	Media = function (options) {
		this.$el = options.$el;
		this.model = options.model;
		this.gallery = options.gallery;

		this.model.media = this;
		this.rendered = false;

		this.$el.on('mediaInserted', $.proxy(this.initCaption, this));
	};

	Media.prototype.render = function () {
		this.$el.addClass('media hidden fade');
		this.$el.html(Mustache.render(templates[templateName], this.model));
		this.rendered = true;

		return this;
	};

	Media.prototype.initCaption = function () {
		this.caption = new Caption({
			$el: this.$el.find('.caption'),
			media: this
		});
	};

	Media.prototype.show = function () {
		var self = this;

		this.$el.removeClass('hidden');
		// wait till after display:block before starting transition
		setTimeout(function () {
			self.$el.removeClass('fade');
		}, 0);
	};

	Media.prototype.hide = function () {
		var self = this;

		if (!this.fadeDuration) {
			this.fadeDuration = parseInt(this.$el.css('transition-duration')) * 500;
		}

		this.$el.addClass('fade');
		setTimeout(function () {
			self.$el.addClass('hidden');
		}, this.fadeDuration);
	};

	return Media;
});
