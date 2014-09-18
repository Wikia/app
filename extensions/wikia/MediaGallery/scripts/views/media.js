define('mediaGallery.views.media', [
	'mediaGallery.views.caption',
    'mediaGallery.templates.mustache'
], function (Caption, templates) {
	'use strict';

	// workaround for nirvana template naming conventions and JSHint conflict
	var templateName = 'MediaGallery_media';

	function Media(options) {
		this.el = options.el;
		this.$el = $(this.el);
		this.model = options.model;

		this.$caption = this.$el.find('.caption');
		this.init();
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
		this.el.innerHTML = Mustache.render(templates[templateName], this.model);
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

	return Media;
});
