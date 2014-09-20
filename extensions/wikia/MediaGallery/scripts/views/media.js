define('mediaGallery.views.media', [
	'mediaGallery.views.caption',
    'mediaGallery.templates.mustache'
], function (Caption, templates) {
	'use strict';

	// workaround for nirvana template naming conventions and JSHint conflict
	var templateName = 'MediaGallery_media';

	function Media(options) {
		this.$el = options.$el;
		this.model = options.model;
		this.gallery = options.gallery;

		this.model.media = this;
		this.visible = false;

		this.$el.on('mediaInserted', $.proxy(this.initCaption, this));
	}

	Media.prototype.render = function () {
		this.$el.addClass('media');
		this.$el.html(Mustache.render(templates[templateName], this.model));

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
		this.visible = true;
	};

	Media.prototype.hide = function () {
		this.$el.hide(); // todo: add animations and such
		this.visible = false;
	};

	return Media;
});
