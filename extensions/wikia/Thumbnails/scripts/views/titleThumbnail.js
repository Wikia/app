define('thumbnails.views.titleThumbnail', [
	'thumbnails.templates.mustache',
	'wikia.mustache'
], function (templates, Mustache) {
	'use strict';

	// TODO: Alias this template to a property that follows jscs's settings (camelCase)
	var THUMBNAIL_TEMPLATE_NAME = 'Thumbnail_title';

	function TitleView(options) {
		this.model = options.model;
		this.el = document.createElement(options.el || 'div');
		this.isFluid = (typeof options.isFluid === 'undefined') ? true : options.isFluid;
		this.initialize();
	}

	TitleView.prototype.render = function () {
		this.el.className += ' title-thumbnail';
		this.el.innerHTML = Mustache.render(templates[THUMBNAIL_TEMPLATE_NAME], this.model); /* jshint ignore:line */
		this.$el = $(this.el);
		return this;
	};

	TitleView.prototype.initialize = function () {
		var self = this;
		if (this.isFluid) {
			$(window).resize(function () {
				self.applyEllipses();
			});
		}
	};

	TitleView.prototype.applyEllipses = function (config) {
		this.$el.find('.title a').ellipses(config);
	};

	return TitleView;
});
