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
		this.model.media = this;
		this.model.rendered = false;
		this.visible = false;

		this.$caption = this.$el.find('.caption');
	}

	Media.prototype.init = function () {
		this.render();
		this.$el.on('click', $.proxy(this.track, this));

		this.caption = new Caption({
			$el: this.$el.find('.caption'),
			$media: this.$el
		});
	};

	Media.prototype.render = function () {
		this.$el.addClass('media');
		this.$el.html(Mustache.render(templates[templateName], this.model));
		this.model.rendered = true;
		return this;
	};

	Media.prototype.track = function () {
		Wikia.Tracker.track({
			category: 'article',
			action: Wikia.Tracker.ACTIONS.click,
			label: 'show-new-gallery-lightbox',
			trackingMethod: 'both',
			value: 0
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
