define('mediaGallery.views.toggler', ['mediaGallery.templates.mustache'], function (templates) {
	'use strict';

	// workaround for nirvana template naming conventions and JSHint conflict
	var templateName = 'MediaGallery_showMore';

	/**
	 * Toggle number of images shown in a gallery
	 * @param {Object} options
	 * @constructor
	 */
	function Toggler(options) {
		this.$el = options.$el;
		this.gallery = options.gallery;
		this.media = this.gallery.media;
	}

	Toggler.prototype.init = function () {
		this.render();
		this.bindEvents();
	};

	Toggler.prototype.render = function () {
		var $html, data;

		data = {
			showMore: $.msg('mediagallery-show-more'),
			showLess: $.msg('mediagallery-show-less')
		};

		$html = $(Mustache.render(templates[templateName], data));
		this.$more = $html.find('.show');
		this.$less = $html.find('.hide');

		this.$el.after($html);
	};

	Toggler.prototype.bindEvents = function () {
		this.$more.on('click', $.proxy(this.gallery.showMore, this.gallery));
		this.$less.on('click', $.proxy(this.gallery.showLess, this.gallery));
	};

	// TODO: hook tracking back up
	Toggler.prototype.track = function (label, count) {
		Wikia.Tracker.track({
			category: 'media-lightbox',
			action: Wikia.Tracker.ACTIONS.CLICK,
			label: label,
			trackingMethod: 'both',
			value: count || 0
		});
	};

	return Toggler;
});
