define('mediaGallery.views.toggler', [
	'mediaGallery.templates.mustache'
], function (templates) {
	'use strict';

	var Toggler = function () {
		this.templateName = 'MediaGallery_showMore';
		this.$el = $('<div></div>')
			.addClass('toggler');

		return this;
	};


	/**
	 * Render the toggle buttons. Does not include DOM insertion.
	 */
	Toggler.prototype.render = function () {
		var $html, data;

		data = {
			showMore: $.msg('mediagallery-show-more'),
			showLess: $.msg('mediagallery-show-less')
		};

		// creates an array of button elements from mustache template
		$html = $(Mustache.render(templates[this.templateName], data));
		this.$more = $html.first();
		this.$less = $html.last();

		this.$el.html($html);

		return this;
	};

	return Toggler;
});