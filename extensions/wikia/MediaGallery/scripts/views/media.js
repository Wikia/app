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
		this.$el.addClass('media');
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
		this.$el.show(); // todo: add animations and such
	};

	Media.prototype.hide = function () {
		this.$el.hide(); // todo: add animations and such
	};

	return Media;
});
